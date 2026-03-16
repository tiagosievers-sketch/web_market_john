<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DomainValue extends AbstractModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
        'domain_id',
        'created_by'
    ];

    protected $with = [
        'createdByUser'
    ];

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(DomainValue::class);
    }

    public function applicationSuffix(): HasMany
    {
        return $this->hasMany(Application::class,'suffix');
    }

    public function applicationSex(): HasMany
    {
        return $this->hasMany(Application::class,'sex');
    }

    public function contactType(): HasMany
    {
        return $this->hasMany(Contact::class,'type');
    }

    public function contactSecondType(): HasMany
    {
        return $this->hasMany(Contact::class,'second_type');
    }

    public function contactWrittenLang(): HasMany
    {
        return $this->hasMany(Contact::class,'written_lang');
    }

    public function contactSpokenLang(): HasMany
    {
        return $this->hasMany(Contact::class,'spoken_lang');
    }

    public function householdMemberSuffix(): HasMany
    {
        return $this->hasMany(HouseholdMember::class,'suffix');
    }

    public function householdMemberRelationship(): HasMany
    {
        return $this->hasMany(HouseholdMember::class,'relationship');
    }

    public function householdMemberSex(): HasMany
    {
        return $this->hasMany(HouseholdMember::class,'sex');
    }

    public function userProfiles(): HasMany
    {
        return $this->hasMany(UserProfile::class,'domain_value_id');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_profiles','domain_value_id','user_id');
    }

    public function incomeDeductionType(): HasMany
    {
        return $this->hasMany(HouseholdMember::class,'income_deduction_type');
    }

    public function incomeDeductionFrequency(): HasMany
    {
        return $this->hasMany(HouseholdMember::class,'frequency');
    }
}
