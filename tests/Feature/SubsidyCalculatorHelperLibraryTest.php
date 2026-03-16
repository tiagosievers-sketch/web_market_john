<?php

use App\Libraries\KffCalculatorLibrary;
use Tests\TestCase;
use App\Libraries\SubsidyCalculatorHelperLibrary;

class SubsidyCalculatorHelperLibraryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_calculate_aptc()
    {
        $zipcode = '32827';
        $silverBronze = KffCalculatorLibrary::generateSilverAndBronze($zipcode);
        if($silverBronze!=[]){
            $formData = [
                "income_type" => "dollars",
                "income" => 50000,
                "employer_coverage" => 0,
                "adults" => [
                    [
                        "age" => 42,
                        "tobacco" => 0
                    ],
                    [
                        "age" => 40,
                        "tobacco" => 0
                    ]
                ],
                "people" => 3,
                "children" => [
                    [
                        "age" => 18,
                        "tobacco" => 0
                    ]
                ],
                "small" => false,
                "child_count" => 1,
                "child_coverage" => null,
                "silver" => 6279.36,
                "bronze" => 4821.96,
                "state" => "fl",
                "state_has_no_data" => false,
                "no_bronze_plans" => false,
                "alternate_family_size" => "",
                "received_unemployment" => null,
                "adult_count" => 2
            ];

            $object  = new SubsidyCalculatorHelperLibrary($formData,$formData);
            $object->initialize_calculations();

            $return = $object->recoverTaxCredit();
            self::assertArrayHasKey('silver_tax_credit',$return);
        }
    }
}
