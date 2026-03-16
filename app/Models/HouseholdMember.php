<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class HouseholdMember extends Model
{
    use HasFactory;

    const FIELD_TYPES = [
        //Applicant
        'applicant' => 0,
        //Household
        'Spouse' => 1,
        'OtherApplicant' => 2,
        'SpouseTax' => 3,
        'DependentTax' => 4,
        'OtherTax' => 5,
        //AdditionalInformation
        'OtherNonMember' => 6
    ];

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'suffix',
        'birthdate',
        'sex',
        'tax_form',
        'lives_with',
        'tax_filler',
        'tax_claimant',
        'field_type',
        'applying_coverage',
        'eligible_cost_saving',
        'married',
        'fed_tax_income_return',
        'is_dependent',
        'jointly_taxed_spouse',
        'has_ssn',
        'ssn',
        'has_perm_address',
        'application_id',
        'live_someone_under_nineteen',
        'taking_care_under_nineteen',
        'live_any_other_family',
        'live_son_daughter',
        'use_tobacco',
        'last_tobacco_usage',
        'is_us_citizen',
        'eligible_immigration_status',
        'document_type',
        'document_number',
        'document_number_type',
        'document_complement_number',
        'document_expiration_date',
        'document_country_issuance',
        'document_category_code',
        'has_sevis',
        'sevis_number',
        'is_federally_recognized_indian_tribe',
        'has_hhs_or_refugee_resettlement_cert',
        'has_orr_eligibility_letter',
        'is_cuban_haitian_entrant',
        'is_lawfully_present_american_samoa',
        'is_battered_spouse_child_parent_vawa',
        'has_another_document_or_alien_number',
        'none_of_these_document',
        'is_incarcerated',
        'is_ai_aln',
        'is_hip_lat_spanish',
        'hip_lat_spanish_specific',
        'race',
        'declined_race',
        'birth_sex',
        'gender_identity',
        'sexual_orientation',
        'same_document_name',
        'document_first_name',
        'document_middle_name',
        'document_last_name',
        'document_suffix',
        'is_pregnant',
        'babies_expected',
        'has_income',
        'has_deduction_current_year',
        'income_confirmed',
        'income_predictable',
        'income_predicted_amount',
        'taking_care_of',
        'information_form',
        'answer_member_information',
        'is_incarcerated_pending',
        'live_in_eua',
        'ineligible_full_coverage',
        'ineligible_for_medicaid_or_chip_last_90_days',
        'chip_coverage_ends_between',
        'needs_help_with_daily_activities',
        'has_disability_or_mental_condition',
        'change_income_or_household_size',
        'last_date_coverage',
        'coverage_between',
        'apply_marketplace_qualifying_life_event',
        'date_dented_coverage',
        'year'
        
    ];

    protected $with = [
        'createdByUser',
        'address',
        'mailAddress',
        'suffixModel',
        'sexModel',
        'household'
    ];

    protected $appends = [
        'netIncome',
        'otherMembers'
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function address(): hasOne
    {
        return $this->hasOne(Address::class)->where('mailing',false);
    }

    public function mailAddress(): hasOne
    {
        return $this->hasOne(Address::class)->where('mailing',true);
    }

    public function suffixModel(): BelongsTo
    {
        return $this->belongsTo(DomainValue::class,'suffix');
    }

    public function sexModel(): BelongsTo
    {
        return $this->belongsTo(DomainValue::class,'sex');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function relatedTo(): HasMany
    {
        return $this->hasMany(Relationship::class, 'member_from_id');
    }

    public function relatedFrom(): HasMany
    {
        return $this->hasMany(Relationship::class, 'member_to_id');
    }

    public function incomesAndDeductions(): HasMany
    {
        return $this->hasMany(IncomeDeduction::class, 'household_member_id');
    }

    public function getNetIncomeAttribute() {
        $query = DB::raw(
            "
                SELECT (IFNULL(income.sum,0) - IFNULL(deduction.sum,0)) as net_income
                FROM
                 household_members hm
                LEFT JOIN
                (SELECT
                    ii.household_member_id,
                    SUM(CASE
                        WHEN fi.alias = 'daily' THEN (ii.amount * 365)
                        WHEN fi.alias = 'monthly' THEN (ii.amount * 12)
                        ELSE (ii.amount * 1)
                    END) as sum
                FROM income_deductions ii
                INNER JOIN domain_values fi on ii.frequency = fi.id
                WHERE ii.type = 0
                GROUP BY ii.household_member_id) as income on hm.id = income.household_member_id
                LEFT JOIN  (SELECT
                     ii.household_member_id,
                     SUM(CASE
                             WHEN fi.alias = 'daily' THEN (ii.amount * 365)
                             WHEN fi.alias = 'monthly' THEN (ii.amount * 12)
                             ELSE (ii.amount * 1)
                         END) as sum
                 FROM income_deductions ii
                          INNER JOIN domain_values fi on ii.frequency = fi.id
                 WHERE ii.type = 1
                 GROUP BY ii.household_member_id) as deduction on hm.id = deduction.household_member_id
                WHERE hm.id = ".$this->id
        );
        $result = DB::select($query);
        if(count($result) > 0){
            return (float)($result[0]->net_income??0);
        }
        return 0;
    }

    public function getSpouseAttribute()
    {
        $domainValue = DomainValue::select('id')->where('alias', '=', 'relacaoEsposa')->first();
        if($domainValue) {
            if ($this->married) {
                $id = $this->id;
                $spouse = HouseholdMember::whereHas('relatedFrom', function ($query) use ($id, $domainValue) {
                    $query->where('member_from_id', '=', $id)
                        ->where('relationship', '=', $domainValue->id);
                    })
                    ->orderBy('id','desc')
                        ->first()
                ;
                if($spouse===null) {
                    $spouse = HouseholdMember::whereHas('relatedTo', function ($query) use ($id, $domainValue) {
                        $query->where('member_to_id', '=', $id)
                            ->where('relationship', '=', $domainValue->id);
                    })
                    ->orderBy('id','desc')
                    ->first()
                    ;
                }
                return $spouse;
            }
            return null;
        }
        return null;
    }

    public function getOtherMembersAttribute()
    {
        $domainValue = DomainValue::select('id')->where('alias', '=', 'relacaoEsposa')->first();
        if($domainValue) {
            if($this->field_type===self::FIELD_TYPES['applicant']){
                $id = $this->id;
                return HouseholdMember::select('id','firstname','lastname')->whereHas('relatedFrom', function ($query) use ($id,$domainValue) {
                        $query->where('member_from_id', '=', $id)
                            ->where('relationship','!=',$domainValue->id)
                        ;
                    })
                    ->get()
                ;
            }
            return null;
        }
        return null;
    }

    public function livingWith(): BelongsTo
    {
        return $this->belongsTo(HouseholdMember::class, 'lives_with','id');
    }

    public function household(): HasMany
    {
        return $this->hasMany(HouseholdMember::class, 'lives_with');
    }

    public function relationships()
    {
        return $this->hasMany(Relationship::class, 'member_to_id');
    }

    public function getLivesWithMainMemberAttribute(): bool
    {
        return !is_null($this->lives_with);
    }

}
