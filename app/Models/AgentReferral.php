<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AgentReferral extends Model
{
    use HasFactory;

    protected $table = 'agent_referrals';

    // Campos que podem ser preenchidos (mass assignable)
    protected $fillable = ['agent_id', 'client_id', 'referred_at'];

    // Define a relação de agente (um agente fez a recomendação)
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    // Define a relação de cliente (cliente convidado pelo agente)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
