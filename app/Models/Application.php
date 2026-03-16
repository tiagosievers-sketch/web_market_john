<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends AbstractModel
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
        'notices_mail_or_email',
        'send_email',
        'client_id',
        'agent_id',
        'send_text',
        'external_id',
        'additional_external_id',
        'external_agent',
        'fast_application',
        'override_household_number',
        'webhook',
        'created_by',
        'year',
        
    ];

    protected $with = [
        'createdByUser',
        'client',
        'agent',
        'plans'
    ];

    public function contact(): HasOne
    {
        return $this->hasOne(Contact::class);
    }

    public function mainMember(): HasOne
    {
        return $this->hasOne(HouseholdMember::class)->where('field_type', '=', self::FIELD_TYPES['applicant']);
    }

    public function householdMembers(): HasMany
    {
        return $this->hasMany(HouseholdMember::class);
    }

    public function householdChiefs(): HasMany
    {
        return $this->hasMany(HouseholdMember::class)->where('lives_with', '=', null);
    }

    public function householdApplicants(): HasMany
    {
        return $this->hasMany(HouseholdMember::class)->where('applying_coverage', '=', 1);
    }

    public function householdTaxMembers(): HasMany
    {
        return $this->hasMany(HouseholdMember::class)
            ->where('applying_coverage', '!=', 1)
            ->whereIn('field_type', [self::FIELD_TYPES['SpouseTax'], self::FIELD_TYPES['DependentTax'], self::FIELD_TYPES['OtherTax']])
        ;
    }

    public function householdAdditionalMembers(): HasMany
    {
        return $this->hasMany(HouseholdMember::class)
            ->where('applying_coverage', '!=', 1)
            ->whereIn('field_type', [self::FIELD_TYPES['OtherNonMember']])
        ;
    }

    public function householdRelationships(): HasMany
    {
        return $this->hasMany(Relationship::class, 'application_id');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }

    public function agentReferrals()
    {
        return $this->hasMany(AgentReferral::class, 'client_id', 'client_id');
    }

    public function getHouseholdNetIncomeAttribute()
    {
        $netIncome = 0;
        if (count($this->householdMembers) > 0) {
            foreach ($this->householdMembers  as $member) {
                if ((isset($member->lives_with_you) && $member->lives_with_you != 0) || $member->is_dependent || $member->field_type == 0) {
                    $netIncome += $member->netIncome;
                }
            }
        }

        return (float)$netIncome;
    }


    public function getCurrentPage()
    {
        if (!$this->contactIsComplete()) {
            return 'primary_contact';
        }

        if (!$this->householdIsComplete()) {
            return 'household';
        }

        if (!$this->relationshipsAreComplete()) {
            return 'relationships';
        }

        if (!$this->taxIsComplete()) {
            return 'tax';
        }

        if (!$this->additionalInformationIsComplete()) {
            return 'additionalInformation';
        }

        if (!$this->isFinalized()) {
            return 'finalize';
        }

        return 'completed';
    }

    protected function contactIsComplete()
    {
        return $this->contact && !empty($this->contact->firstname) && !empty($this->contact->phone);
    }

    protected function householdIsComplete()
    {
        if ($this->householdMembers->isEmpty()) {
            return $this->mainMember && !empty($this->mainMember->firstname);
        }

        foreach ($this->householdMembers as $member) {
            if (empty($member->firstname) || empty($member->lastname) || empty($member->birthdate)) {
                return false;
            }
        }

        return true;
    }

    protected function relationshipsAreComplete()
    {
        if ($this->householdMembers->count() <= 1) {
            // Não é necessário relacionamento se há apenas 1 membro
            return true;
        }

        return $this->householdRelationships->isNotEmpty();
    }

    protected function taxIsComplete()
    {
        foreach ($this->householdTaxMembers as $taxMember) {
            if (
                empty($taxMember->firstname) ||
                empty($taxMember->lastname) ||
                empty($taxMember->birthdate) ||
                empty($taxMember->relationship)
            ) {
                return false;
            }
        }

        return true;
    }

    protected function additionalInformationIsComplete()
    {
        return $this->additionalInformationField1 && $this->additionalInformationField2;
    }

    protected function isFinalized()
    {
        return $this->allowMarketplaceIncomeData ||
            $this->attestationStatement ||
            $this->penaltyOfPerjuryAgreement;
    }
}
