<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finalize extends Model
{
    use HasFactory;

    protected $table = 'judicial_messages';

    protected $fillable = [
        'application_id',
        'allow_marketplace_income_data',
        'years_renewal_of_eligibility',
        'attestation_statement',
        'marketplace_permission',
        'penalty_of_perjury_agreement',
        'full_name',
    ];
}
