<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Household extends AbstractModel
{
    use HasFactory;

    protected $fillable = [
        'applying_coverage',
        'eligible_cost_saving',
        'married',
        'fed_tax_income_return',
        'jointly_taxed_spouse',
        'is_dependent',
        'application_id',
        'created_by'
    ];

    protected $with = [
        'householdMembers',
        'taxHouseholdMembers',
        'createdByUser',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function householdMembers(): HasMany
    {
        return $this->hasMany(HouseholdMember::class)->where('tax_form','=',false);
    }

    public function taxHouseholdMembers(): HasMany
    {
        return $this->hasMany(HouseholdMember::class)->where('tax_form','=',true);
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
