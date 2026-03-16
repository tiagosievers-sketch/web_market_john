<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomeDeduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'income_deduction_type',
        'amount',
        'educational_amount',
        'frequency',
        'other_type',
        'employer_name',
        'employer_former_state',
        'employer_phone_number',
        'unemployment_date',
        'household_member_id',
        'created_by',
        'non_educational_amount'
    ];

    protected $casts = [
        'educational_amount' => 'float',
        'non_educational_amount' => 'float',
        'amount' => 'float'
    ];

    protected $with = [
        'typeOfIncomeDeduction',
        'frequency'
    ];

    protected $appends = [
        // 'type'
    ];

    public function typeOfIncomeDeduction(): BelongsTo
    {
        return $this->belongsTo(DomainValue::class,'income_deduction_type');
    }

    public function frequency(): BelongsTo
    {
        return $this->belongsTo(DomainValue::class,'frequency');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // public function getTypeAttribute() {
    //     return ((bool)$this->type)?'Income':'Deduction';
    // }

    public function householdMember(): BelongsTo
    {
        return $this->belongsTo(HouseholdMember::class,'household_member_id');
    }

}
