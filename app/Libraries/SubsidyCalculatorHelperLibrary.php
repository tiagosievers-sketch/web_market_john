<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Log;

class SubsidyCalculatorHelperLibrary
{
    private $income_type;
    private $income;
    private $employer_coverage;
    private $adults;
    private $people;
    private $children;
    private $small;
    private $child_count;
    private $child_coverage;
    private $silver;
    private $bronze;
    private $state;
    private $state_has_no_data;
    private $no_bronze_plans;
    private $alternate_family_size;
    private $received_unemployment;

    // Premium calculation properties
    private $silver_premium_before_tobacco = 0;
    private $actual_silver_premium = 0;
    private $bronze_premium_before_tobacco = 0;
    private $actual_bronze_premium = 0;
    private $silver_tax_credit = 0;
    private $income_dollars = 0;
    private $income_fpl = 0;
    private $income_fpl_medicaid = 0;
    private $oop_max = 0;
    private $av = 0;
    private $any_smokers = false;
    private $total_people = 0;

    // General premium values and age factors
    private $weighted_avg_age_factor;
    private $silver_general_premium;
    private $bronze_general_premium;

    private $c; // Placeholder for predefined values (like avg_silver_premium)
    private $p; // Placeholder for predefined values (like avg_silver_premium)
    private $overrides;
    private $kff_sc;
    private $percent_income_silver;

    public function __construct($props, $formdata, $kff_sc_overrides = [])
    {
        // User inputs
        $this->c = $props;

        $this->initializeParameters();

        $this->income_type = $formdata['income_type'];
        $this->income = (float)preg_replace('/[^\d.]/', '', $formdata['income']);
        $this->employer_coverage = (int)$formdata['employer_coverage'];
        $this->adults = $this->parseAdults($formdata);
        $this->children = $this->parseChildren($formdata);
        $this->people = (float)preg_replace('/[^\d.]/', '', $formdata['people']);
        $this->small = isset($kff_sc_overrides['small_results']) ? $kff_sc_overrides['small_results'] : false;
        $this->child_count = (int)$formdata['child_count'];
        $this->child_coverage = (int)$formdata['child_coverage'];
        $this->silver = isset($kff_sc_overrides['silver']) ? $kff_sc_overrides['silver'] : false;
        $this->bronze = isset($kff_sc_overrides['bronze']) ? $kff_sc_overrides['bronze'] : false;
        $this->state = $formdata['state'];
        $this->state_has_no_data = isset($kff_sc_overrides['state_has_no_data']) ? $kff_sc_overrides['state_has_no_data'] : true;
        $this->no_bronze_plans = isset($kff_sc_overrides['no_bronze_plans']) ? $kff_sc_overrides['no_bronze_plans'] : false;
        $this->alternate_family_size = isset($formdata['alternate_plan_family']) ? $formdata['alternate_plan_family'] : null;
        $this->received_unemployment = (int)$formdata['received_unemployment'];

        $this->subsidyTable = [
            [1.00, 0.0000, 0.000],
            [1.33, 0.0000, 0.000],
            [1.50, 0.0000, 0.0400],
            [2.00, 0.02, 0.0400],
            [2.50, 0.04, 0.0400],
            [3.00, 0.06, 0.0250],
            [4.00, 0.085, 0.000],
            [999999999.00, 0.085, 0.000]
        ];

        $this->oopRange = [0, 1, 1.5, 2, 2.5, 3, 4];
        $this->oopSingle = [9200, 3050, 3050, 7350, 9200, 9200, 9200];
        $this->oopFam = [18400, 6100, 6100, 14700, 18400, 18400, 18400];
        $this->av = [0.7, 0.94, 0.87, 0.73, 0.70, 0.70, 0.70];

        // Initialize ageFactor, population, and overrides, similar to the JavaScript version

        $this->initializeOverrides();
        $this->wi_edge_case = false;

        // Additional setup code for family-specific premiums, subsidies, etc., can be added here.
    }

    public function initializeParameters()
    {
        $this->p = [
            'tobacco_factor' => 1.0,
            'avg_silver_premium' => 0,
            'child_factor' => 0.635,
            'poverty' => 15060, // Previous year poverty threshold
            'poverty_addition' => 5380, // Previous year poverty threshold addition
            'poverty_medicaid' => 15060, // Plan year poverty threshold
            'poverty_addition_medicaid' => 5380, // Plan year poverty threshold addition
            'medicaid_threshold' => 1.38,
            'unsubsidized_oop_max_single' => 9200, // Unsubsidized out-of-pocket max for single
            'unsubsidized_oop_max_fam' => 18400, // Unsubsidized out-of-pocket max for family
            'subsidy_min' => 1,
            'subsidy_max' => 999999999,
            'chip_threshold' => 2.55,
            'expanding_medicaid' => 1,
            'subsidy_table' => [
                [1.00, 0.0000, 0.000],
                [1.33, 0.0000, 0.000],
                [1.50, 0.0000, 0.0400],
                [2.00, 0.02, 0.0400],
                [2.50, 0.04, 0.0400],
                [3.00, 0.06, 0.0250],
                [4.00, 0.085, 0.000],
                [999999999.00, 0.085, 0.000]
            ],
            'oop_range' => [0, 1, 1.5, 2, 2.5, 3, 4],
            'oop_single' => [9200, 3050, 3050, 7350, 9200, 9200, 9200], // Subsidized OOP max for single
            'oop_fam' => [18400, 6100, 6100, 14700, 18400, 18400, 18400], // Subsidized OOP max for family
            'av' => [0.7, 0.94, 0.87, 0.73, 0.70, 0.70, 0.70],
            'population' => [
                0.007,
                0.005,
                0.008,
                0.011,
                0.010,
                0.011,
                0.010,
                0.010,
                0.012,
                0.012,
                0.011,
                0.011,
                0.013,
                0.010,
                0.012,
                0.008,
                0.010,
                0.013,
                0.013,
                0.012,
                0.015,
                0.010,
                0.017,
                0.018,
                0.018,
                0.020,
                0.023,
                0.026,
                0.024,
                0.023,
                0.017,
                0.020,
                0.018,
                0.014,
                0.016,
                0.015,
                0.016,
                0.017,
                0.015,
                0.013,
                0.018,
                0.017,
                0.020,
                0.016,
                0.018,
                0.019,
                0.020,
                0.021,
                0.019,
                0.020,
                0.020,
                0.018,
                0.022,
                0.018,
                0.017,
                0.016,
                0.018,
                0.016,
                0.017,
                0.014,
                0.015,
                0.012,
                0.014,
                0.014,
                0.016
            ],
            'age_factor' => [
                0.765,
                0.765,
                0.765,
                0.765,
                0.765,
                0.765,
                0.765,
                0.765,
                0.765,
                0.765,
                0.765,
                0.765,
                0.765,
                0.765,
                0.765,
                0.833,
                0.859,
                0.885,
                0.913,
                0.941,
                0.970,
                1.000,
                1.000,
                1.000,
                1.000,
                1.004,
                1.024,
                1.048,
                1.087,
                1.119,
                1.135,
                1.159,
                1.183,
                1.198,
                1.214,
                1.222,
                1.230,
                1.238,
                1.246,
                1.262,
                1.278,
                1.302,
                1.325,
                1.357,
                1.397,
                1.444,
                1.500,
                1.563,
                1.635,
                1.706,
                1.786,
                1.865,
                1.952,
                2.040,
                2.135,
                2.230,
                2.333,
                2.437,
                2.548,
                2.603,
                2.714,
                2.810,
                2.873,
                2.952,
                3.000
            ],
            'premium_factor' => 1.251365541,
            'alternate_factors' => false
        ];
    }

    private function parseAdults($formdata)
    {
        $adults = [];
        if ($formdata['adult_count'] > 0) {
            foreach ($formdata["adults"] as $value) {
                $adults[] = [
                    'age' => (int)$value['age'],
                    'tobacco' => (int)$value['tobacco']
                ];
            }
        }
        return $adults;
    }

    private function parseChildren($formdata)
    {
        $children = [];
        if ($formdata['child_count'] > 0) {
            foreach ($formdata["children"] as $value) {
                $children[] = [
                    'age' => (int)$value['age'],
                    'tobacco' => (int)$value['tobacco']
                ];
            }
        }
        return $children;
    }

    private function calculatePovertyLevel()
    {
        // Similar logic to calculate poverty level based on $this->c values
    }

    public function calculate_oop()
    {
        // Determine max out-of-pocket costs based on income FPL and household composition
        if (
            $this->income_fpl >= $this->p['oop_range'][6] &&
            (($this->c['adult_count'] + $this->c['child_count'] == 1) ||
                ($this->c['alternate_family_size'] === 'individual'))
        ) {
            // Max for individual
            $this->oop_max = $this->p['unsubsidized_oop_max_single'];
            $this->av = 0.7;
        } elseif (
            $this->income_fpl >= $this->p['oop_range'][6] &&
            (($this->c['adult_count'] + $this->c['child_count'] > 1) ||
                ($this->c['alternate_family_size'] !== 'individual'))
        ) {
            // Max for family
            $this->oop_max = $this->p['unsubsidized_oop_max_fam'];
            $this->av = 0.7;
        } else {
            // Determine the subsidy endpoint based on FPL
            $endpoint = 1;
            if ($this->income_fpl >= $this->p['oop_range'][1]) {
                for ($i = 2; $i <= 6; $i++) {
                    if ($this->income_fpl <= $this->p['oop_range'][$i]) {
                        $endpoint = $i;
                        break;
                    }
                }
            }
            // Set OOP max and actuarial value (AV) based on endpoint and household composition
            if ($this->c['adult_count'] + $this->c['child_count'] == 1 || $this->c['alternate_family_size'] === 'individual') {
                $this->oop_max = $this->p['oop_single'][$endpoint - 1];
            } else {
                $this->oop_max = $this->p['oop_fam'][$endpoint - 1];
            }
            $this->av = $this->p['av'][$endpoint - 1];
        }
    }

    public function get_weighted_avg_age_factor()
    {
        $total_factor = 0;
        $total_population = 0;

        // Loop through ages 21 to 64
        for ($age = 21; $age <= 64; $age++) {
            $total_factor += $this->p['population'][$age] * $this->p['age_factor'][$age];
            $total_population += $this->p['population'][$age];
        }

        // Return the weighted average age factor
        return $total_population > 0 ? ($total_factor / $total_population) : 0;
    }

    public function calculate_subsidies()
    {
        $household_poverty_level = $this->p['poverty'] + (($this->people - 1) * $this->p['poverty_addition']);
        $household_poverty_level_medicaid = $this->p['poverty_medicaid'] + (($this->people - 1) * $this->p['poverty_addition_medicaid']);

        // Determine income in terms of FPL (Federal Poverty Level)
        $this->income_fpl = $this->income_type === 'percent'
            ? $this->income / 100
            : $this->income / $household_poverty_level;

        $this->income_dollars = $this->income_type === 'dollars'
            ? $this->income
            : $this->income_fpl * $household_poverty_level;

        $this->income_fpl_medicaid = $this->income_type === 'percent'
            ? $this->income / 100
            : $this->income / $household_poverty_level_medicaid;

        $receivedUnemployment = $this->received_unemployment === 1;

        // Adjust income_fpl if unemployment has been received
        $this->income_fpl = ($receivedUnemployment && (
            $this->income_fpl > 1.38 || ($this->income_fpl <= 1.38 && $this->p['expanding_medicaid'] === 0)
        )) ? 1.39 : $this->income_fpl;

        // Check subsidy eligibility
        if ($this->income_fpl < $this->p['subsidy_min'] || $this->income_fpl > $this->p['subsidy_max']) {
            return;
        }

        // Initialize phaseout and subsidy range
        $phaseout = 0;
        $subsidy_range = 0;
        $considered_income = ($this->income_fpl == 4) ? 3.999 : $this->income_fpl;

        foreach ($this->p['subsidy_table'] as $index => $subsidy) {
            if ($considered_income < $subsidy[0]) {
                $subsidy_range = $index == 0 ? 0 : $this->p['subsidy_table'][$index - 1][0];
                $this->percent_income_silver = $index == 0 ? $subsidy[1] : $this->p['subsidy_table'][$index - 1][1];
                $phaseout = $index == 0 ? $subsidy[2] : $this->p['subsidy_table'][$index - 1][2];
                break;
            }
        }

        $this->percent_income_silver = $this->percent_income_silver + (($this->income_fpl - $subsidy_range) * $phaseout);
        $this->percent_income_silver = round($this->percent_income_silver, 4);

        // Calculate silver tax credit
        $this->silver_tax_credit = max(0, $this->silver_premium_before_tobacco - ($this->percent_income_silver * $this->income_dollars));
    }

    private function calculateOop()
    {
        // Logic for out-of-pocket cost calculation
    }

    // Additional methods like calculateSubsidies(), calculateOop(), renderResults(), etc., go here.

    private function initializeKffSc($overrides)
    {
        // Set default values for kff_sc with optional overrides
        $this->kff_sc = array_merge([
            'silver' => false,
            'bronze' => false,
            'state' => false,
            'state_has_no_data' => true,
            'subsidy_form_submitted' => false,
            'states_with_no_data' => [''],
            'states_with_alternate_plans' => ['ny', 'vt'],
            'state_has_alternate_plan' => false,
            'county_to_load' => null,
            'events' => [],
            'buckets' => [],
            'zips' => [],
            'small_results' => false,
            'process_results' => function () { /* Placeholder function */
            },
            'language' => getenv('SUBSIDY_CALCULATOR_LANGUAGE') ?: 'en',
            'environment' => getenv('SUBSIDY_CALCULATOR_ENVIRONMENT') ?: 'test',
            'version' => getenv('SUBSIDY_CALCULATOR_VERSION') ?: '2024'
        ], $overrides);
    }

    private function initializeOverrides()
    {
        $this->overrides = [
            'al' => [
                'age_factor' => [0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 1.000, 1.000, 1.000, 1.000, 1.004, 1.024, 1.048, 1.087, 1.119, 1.135, 1.159, 1.183, 1.198, 1.214, 1.222, 1.230, 1.238, 1.246, 1.262, 1.278, 1.302, 1.325, 1.357, 1.397, 1.444, 1.500, 1.563, 1.635, 1.706, 1.786, 1.865, 1.952, 2.040, 2.135, 2.230, 2.333, 2.437, 2.548, 2.603, 2.714, 2.810, 2.873, 2.952, 3.000],
                'chip_threshold' => 3.17,
                'expanding_medicaid' => 0
            ],
            'ak' => [
                'poverty' => 18810,
                'poverty_addition' => 6730,
                'poverty_medicaid' => 18810,
                'poverty_addition_medicaid' => 6730,
                'chip_threshold' => 2.08
            ],
            'az' => ['chip_threshold' => 2.30],
            'ar' => ['chip_threshold' => 2.16],
            'ca' => ['chip_threshold' => 2.66],
            'co' => ['chip_threshold' => 2.65],
            'ct' => ['chip_threshold' => 3.23],
            'de' => ['chip_threshold' => 2.17],
            'dc' => [
                'age_factor' => [0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.654, 0.727, 0.727, 0.727, 0.727, 0.727, 0.727, 0.727, 0.744, 0.76, 0.779, 0.799, 0.817, 0.836, 0.856, 0.876, 0.896, 0.916, 0.927, 0.938, 0.975, 1.013, 1.053, 1.094, 1.137, 1.181, 1.227, 1.275, 1.325, 1.377, 1.431, 1.487, 1.545, 1.605, 1.668, 1.733, 1.801, 1.871, 1.944, 2.02, 2.099, 2.181, 2.181, 2.181, 2.181],
                'child_factor' => 0.654,
                'premium_factor' => 1.246251778,
                'chip_threshold' => 3.24,
                'medicaid_threshold' => 2.15
            ],
            'fl' => ['chip_threshold' => 2.15, 'expanding_medicaid' => 0],
            'ga' => ['chip_threshold' => 2.52, 'expanding_medicaid' => 0],
            'hi' => [
                'poverty' => 17310,
                'poverty_addition' => 6190,
                'poverty_medicaid' => 17310,
                'poverty_addition_medicaid' => 6190,
                'chip_threshold' => 3.13
            ],
            'id' => ['chip_threshold' => 1.90, 'expanding_medicaid' => 1],
            'il' => ['chip_threshold' => 3.18],
            'in' => ['chip_threshold' => 2.55, 'expanding_medicaid' => 1],
            'ia' => ['chip_threshold' => 3.8],
            'ks' => ['chip_threshold' => 2.55, 'expanding_medicaid' => 0],
            'ky' => ['chip_threshold' => 2.18],
            'la' => ['chip_threshold' => 2.55],
            'me' => ['chip_threshold' => 3.05, 'expanding_medicaid' => 1],
            'md' => ['chip_threshold' => 3.22],
            'ma' => [
                'age_factor' => [0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 0.751, 1.183, 1.183, 1.183, 1.183, 1.183, 1.183, 1.22, 1.25, 1.275, 1.287, 1.305, 1.323, 1.334, 1.346, 1.352, 1.358, 1.363, 1.369, 1.381, 1.393, 1.41, 1.427, 1.45, 1.478, 1.511, 1.55, 1.593, 1.641, 1.688, 1.741, 1.792, 1.847, 1.902, 1.961, 2.019, 2.08, 2.142, 2.206, 2.28, 2.365, 2.365, 2.365, 2.365, 2.365],
                'child_factor' => 0.751,
                'premium_factor' => 1.143264711,
                'chip_threshold' => 3.05
            ],
            'mi' => ['chip_threshold' => 2.17],
            'mn' => [
                'age_factor' => [0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 0.89, 1, 1, 1, 1, 1.004, 1.024, 1.048, 1.087, 1.119, 1.135, 1.159, 1.183, 1.198, 1.214, 1.222, 1.23, 1.238, 1.246, 1.262, 1.278, 1.302, 1.325, 1.357, 1.397, 1.444, 1.5, 1.563, 1.635, 1.706, 1.786, 1.865, 1.952, 2.04, 2.135, 2.23, 2.333, 2.437, 2.548, 2.603, 2.714, 2.81, 2.873, 2.952, 3],
                'child_factor' => 0.89,
                'premium_factor' => 1.251365541,
                'chip_threshold' => 2.88
            ],
            'ms' => [
                'age_factor' => [0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 1.000, 1.000, 1.000, 1.000, 1.004, 1.024, 1.048, 1.087, 1.119, 1.135, 1.159, 1.183, 1.198, 1.214, 1.222, 1.230, 1.238, 1.246, 1.262, 1.278, 1.302, 1.325, 1.357, 1.397, 1.444, 1.500, 1.563, 1.635, 1.706, 1.786, 1.865, 1.952, 2.040, 2.135, 2.230, 2.333, 2.437, 2.548, 2.603, 2.714, 2.810, 2.873, 2.952, 3.000],
                'chip_threshold' => 2.14,
                'expanding_medicaid' => 0
            ],
            'mo' => ['chip_threshold' => 3.05, 'expanding_medicaid' => 1],
            'mt' => ['chip_threshold' => 2.66],
            'ne' => ['chip_threshold' => 2.18, 'expanding_medicaid' => 1],
            'nv' => ['chip_threshold' => 2.05],
            'nh' => ['chip_threshold' => 3.23],
            'nj' => ['chip_threshold' => 3.55],
            'nm' => ['chip_threshold' => 3.05],
            'ny' => [
                'alternate_factors' => [
                    'individual' => 1,
                    'couple' => 2,
                    'one_adult_children' => 1.7,
                    'two_adult_children' => 2.85
                ],
                'chip_threshold' => 4.05
            ],
            'nc' => ['chip_threshold' => 2.16, 'expanding_medicaid' => 1],
            'nd' => ['chip_threshold' => 2.05],
            'oh' => ['chip_threshold' => 2.11],
            'ok' => ['chip_threshold' => 2.10],
            'or' => [
                'age_factor' => [0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 0.635, 1.000, 1.000, 1.000, 1.000, 1.004, 1.024, 1.048, 1.087, 1.119, 1.135, 1.159, 1.183, 1.198, 1.214, 1.222, 1.230, 1.238, 1.246, 1.262, 1.278, 1.302, 1.325, 1.357, 1.397, 1.444, 1.500, 1.563, 1.635, 1.706, 1.786, 1.865, 1.952, 2.040, 2.135, 2.230, 2.333, 2.437, 2.548, 2.603, 2.714, 2.810, 2.873, 2.952, 3.000],
                'chip_threshold' => 3.05
            ],
            'pa' => ['chip_threshold' => 3.19],
            'ri' => ['chip_threshold' => 2.66],
            'sc' => ['chip_threshold' => 2.13, 'expanding_medicaid' => 0],
            'sd' => ['chip_threshold' => 2.09],
            'tn' => ['chip_threshold' => 2.55, 'expanding_medicaid' => 0],
            'tx' => ['chip_threshold' => 2.06, 'expanding_medicaid' => 0],
            'ut' => [
                'age_factor' => [0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 0.793, 1, 1.05, 1.113, 1.191, 1.298, 1.363, 1.39, 1.39, 1.39, 1.39, 1.39, 1.39, 1.39, 1.39, 1.39, 1.39, 1.404, 1.425, 1.45, 1.479, 1.516, 1.562, 1.616, 1.681, 1.748, 1.818, 1.891, 1.966, 2.045, 2.127, 2.212, 2.300, 2.392, 2.488, 2.588, 2.691, 2.799, 2.911, 3.000, 3.000, 3.000, 3.000, 3.000, 3.000],
                'child_factor' => 0.793,
                'premium_factor' => 1.254678619,
                'expanding_medicaid' => 1,
                'chip_threshold' => 2.05
            ],
            'vt' => [
                'alternate_factors' => [
                    'individual' => 1,
                    'couple' => 2,
                    'one_adult_children' => 1.93,
                    'two_adult_children' => 2.81
                ],
                'chip_threshold' => 3.17
            ],
            'va' => ['chip_threshold' => 2.05],
            'wa' => ['chip_threshold' => 3.17],
            'wv' => ['chip_threshold' => 3.05],
            'wi' => ['chip_threshold' => 3.06, 'expanding_medicaid' => 0],
            'wy' => ['chip_threshold' => 2.05, 'expanding_medicaid' => 0]
        ];
    }

    public function family_specific_premiums()
    {
        if (isset($this->p['alternate_factors']) && is_array($this->p['alternate_factors']) && isset($this->c['alternate_family_size'])) {
            // Using alternate framework for VT and NY
            $factor = $this->p['alternate_factors'][$this->c['alternate_family_size']];
            $this->actual_silver_premium = $this->c['silver'] * $factor;
            $this->silver_premium_before_tobacco = $this->actual_silver_premium;
            $this->actual_bronze_premium = $this->c['bronze'] * $factor;
            $this->bronze_premium_before_tobacco = $this->actual_bronze_premium;
        } else {
            // Calculate premium based on individual family members
            foreach ($this->c['adults'] as $adult) {
                $age = $adult['age'];
                $smoker = $adult['tobacco'];
                if ($smoker) $this->any_smokers = true;

                try {
                    if (!isset($this->p['age_factor'][$age])) {
                        throw new \Exception("Age factor not found for adult age: {$age}");
                    }

                    $this->silver_premium_before_tobacco += $this->p['age_factor'][$age] * $this->silver_general_premium;
                    $this->actual_silver_premium += $this->p['age_factor'][$age] * $this->silver_general_premium * ($smoker ? $this->p['tobacco_factor'] : 1);
                    $this->bronze_premium_before_tobacco += $this->p['age_factor'][$age] * $this->bronze_general_premium;
                    $this->actual_bronze_premium += $this->p['age_factor'][$age] * $this->bronze_general_premium * ($smoker ? $this->p['tobacco_factor'] : 1);
                } catch (\Exception $e) {
                    throw new \Exception("Error processing adult: " . $e->getMessage());
                }
            }

            foreach ($this->c['children'] as $child) {
                $age = $child['age'];
                $smoker = $child['tobacco'];
                if ($smoker) $this->any_smokers = true;

                try {
                    if (!isset($this->p['age_factor'][$age])) {
                        throw new \Exception("Age factor not found for child age: {$age}");
                    }

                    $this->silver_premium_before_tobacco += $this->p['age_factor'][$age] * $this->silver_general_premium;
                    $this->actual_silver_premium += $this->p['age_factor'][$age] * $this->silver_general_premium * ($smoker ? $this->p['tobacco_factor'] : 1);
                    $this->bronze_premium_before_tobacco += $this->p['age_factor'][$age] * $this->bronze_general_premium;
                    $this->actual_bronze_premium += $this->p['age_factor'][$age] * $this->bronze_general_premium * ($smoker ? $this->p['tobacco_factor'] : 1);
                } catch (\Exception $e) {
                    throw new \Exception("Error processing child: " . $e->getMessage());
                }
            }
        }
    }

    public function initialize_calculations()
    {
        // Handle alternate factors for family size
        if (isset($this->p['alternate_factors'])) {
            if (in_array($this->c['alternate_family_size'], ['one_adult_children', 'two_adult_children'])) {
                $this->c['child_count'] = 1;
            }
            if (in_array($this->c['alternate_family_size'], ['one_adult_children', 'individual'])) {
                $this->c['adult_count'] = 1;
            }
            if (in_array($this->c['alternate_family_size'], ['two_adult_children', 'couple'])) {
                $this->c['adult_count'] = 2;
            }
        } else {
            $this->c['adult_count'] = count($this->c['adults']);
        }

        // Apply state-specific overrides or set national averages
        if ($this->c['state'] !== false && isset($this->overrides[$this->c['state']])) {
            $this->p = array_merge($this->p, $this->overrides[$this->c['state']]);
            if ($this->c['silver'] !== false) {
                $this->p['avg_silver_premium'] = $this->c['silver'] * $this->p['premium_factor'];
            }
            if ($this->c['bronze'] !== false) {
                $this->avg_bronze_premium = $this->c['bronze'] * $this->p['premium_factor'];
            }
        } else {
            // Set national averages
            $this->p['avg_silver_premium'] = 5958 * $this->p['premium_factor'];
            $this->avg_bronze_premium = 4575 * $this->p['premium_factor'];
        }

        // Calculate general premiums based on weighted average age factor
        $this->weighted_avg_age_factor = $this->get_weighted_avg_age_factor();
        $this->silver_general_premium = $this->p['avg_silver_premium'] / $this->weighted_avg_age_factor;
        $this->bronze_general_premium = $this->avg_bronze_premium / $this->weighted_avg_age_factor;

        // Initialize premium, tax credit, and income values
        $this->silver_premium_before_tobacco = 0;
        $this->actual_silver_premium = 0;
        $this->bronze_premium_before_tobacco = 0;
        $this->actual_bronze_premium = 0;
        $this->silver_tax_credit = 0;
        $this->income_dollars = 0;
        $this->income_fpl = 0;
        $this->income_fpl_medicaid = 0;
        $this->oop_max = 0;
        $this->av = 0;
        $this->any_smokers = ($this->c['child_tobacco'] ?? 0) > 0;
        $this->total_people = $this->c['child_count'] + $this->c['adult_count'];

        // Execute additional calculations
        $this->family_specific_premiums();
        $this->calculate_subsidies();
        $this->calculate_oop();

        // Final premium calculations
        $this->percent_premium_paid = ($this->actual_silver_premium - $this->silver_tax_credit) / $this->actual_silver_premium;
        $this->bronze_tax_credit = min($this->silver_tax_credit, $this->bronze_premium_before_tobacco);
        $this->percent_income_bronze = ($this->actual_bronze_premium - $this->bronze_tax_credit) / $this->income_dollars;

        // Check if household has members under 30
        $this->house_under_30 = $this->c['child_count'] > 0;
        if (isset($this->c['adults'])) {
            foreach ($this->c['adults'] as $adult) {
                if ($adult['age'] < 30) {
                    $this->house_under_30 = true;
                    break;
                }
            }
        }

        // Medicaid eligibility and unsubsidized max OOP based on family size
        $this->medicaid_eligible = ($this->income_fpl_medicaid <= $this->p['medicaid_threshold']);
        $this->unsubsidized_max = $this->total_people > 1 ? $this->p['unsubsidized_oop_max_fam'] : $this->p['unsubsidized_oop_max_single'];
    }

    public function recoverTaxCredit(): array
    {
        return [
            'bronze_tax_credit' => $this->bronze_tax_credit ?? null,
            'silver_tax_credit' => $this->silver_tax_credit,
        ];
    }

    public function av(): array
    {
        return [
            'silver_av' => $this->av,
            'silver_tax_credit' => $this->silver_tax_credit
        ];
    }
}
