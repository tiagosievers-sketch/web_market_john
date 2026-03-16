<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domain extends AbstractModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
        'created_by'
    ];

    protected $with = [
        'createdByUser'
    ];

    public function values(): HasMany
    {
        return $this->hasMany(DomainValue::class);
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
