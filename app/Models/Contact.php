<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends AbstractModel
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone',
        'extension',
        'type',
        'second_phone',
        'second_extension',
        'second_type',
        'written_lang',
        'spoken_lang',
        'application_id',
        'created_by'
    ];

    protected $with = [
        'phoneType',
        'secondPhoneType',
        'writtenLang',
        'spokenLang',
        'createdByUser'
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function phoneType(): BelongsTo
    {
        return $this->belongsTo(DomainValue::class,'type');
    }

    public function secondPhoneType(): BelongsTo
    {
        return $this->belongsTo(DomainValue::class,'second_type');
    }

    public function writtenLang(): BelongsTo
    {
        return $this->belongsTo(DomainValue::class,'written_lang');
    }

    public function spokenLang(): BelongsTo
    {
        return $this->belongsTo(DomainValue::class,'spoken_lang');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
