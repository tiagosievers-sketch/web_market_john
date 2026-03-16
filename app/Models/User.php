<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
// use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    // use HasProfilePhoto;
    use Notifiable;
    // use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'facebook_id',
        'preferred_language',
        'easy_id',
        'is_admin',
        'idm_access_token',
        'idm_refresh_token',
        'idm_expires_in',
        'idm_id_token',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'idm_access_token',
        'idm_refresh_token',
        'idm_expires_in',
        'idm_id_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'has_idm_refresh_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $with = [
        'profiles'
    ];

    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(DomainValue::class, 'user_profiles', 'user_id', 'domain_value_id');
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Application::class, 'client_id');
    }

    public function agents(): HasMany
    {
        return $this->hasMany(Application::class, 'agent_id');
    }

    // A user (agent) has many referrals (as an agent)
    public function referredClients(): HasMany
    {
        return $this->hasMany(AgentReferral::class, 'agent_id');
    }

    public function agentReferrals()
    {
        return $this->hasMany(AgentReferral::class, 'agent_id');
    }
    
    public function referredByAgent()
    {
        return $this->hasMany(AgentReferral::class, 'client_id');
    }

    /**
     * Accessor for has_idm_refresh_token.
     *
     * @return bool
     */
    public function getHasIdmRefreshTokenAttribute(): bool
    {
        return !empty($this->idm_refresh_token);
    }
    
}
