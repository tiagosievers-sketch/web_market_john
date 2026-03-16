<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends AbstractModel
{
    use HasFactory;

    protected $fillable = [
        'street_address',
        'apte_ste',
        'city',
        'state',
        'zipcode',
        'county',
        'mailing',
        'household_member_id',
        'client_id',
        'agent_id',
        'created_by'
    ];

    protected $with = [
        'createdByUser'
    ];

    public function householdMember(): BelongsTo
    {
        return $this->belongsTo(HouseholdMember::class);
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
