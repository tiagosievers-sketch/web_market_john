<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Relationship extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_from_id',
        'relationship',
        'relationship_detail',
        'member_to_id',
        'application_id',
        'created_by'
    ];

    protected $with = [
    ];

    public function memberFrom(): BelongsTo
    {
        return $this->belongsTo(HouseholdMember::class, 'member_from_id');
    }

    public function memberTo(): BelongsTo
    {
        return $this->belongsTo(HouseholdMember::class, 'member_to_id');
    }

    public function relationship(): BelongsTo
    {
        return $this->belongsTo(DomainValue::class,'relationship');
    }

    public function relationshipDetail(): BelongsTo
    {
        return $this->belongsTo(DomainValue::class,'relationship_detail');
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
