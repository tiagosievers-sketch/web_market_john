<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\AgentReferral;
use App\Models\Application;
use App\Models\Contact;
use App\Models\Domain;
use App\Models\DomainValue;
use App\Models\Household;
use App\Models\HouseholdMember;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserAndProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'pedro.araujo@merlion-si.com.br',
            'password' => Hash::make('123456'),
            'email_verified_at' => Carbon::now(),
            'is_admin' => true
        ]);

        User::factory()->create([
            'name' => 'Test Agent',
            'email' => 'agent@test.com.br',
            'password' => Hash::make('123456'),
            'email_verified_at' => Carbon::now(),
            'easy_id' => Str::uuid(),
            'is_admin' => false
        ]);

        User::factory()->create([
            'name' => 'Test Client',
            'email' => 'client@test.com.br',
            'password' => Hash::make('123456'),
            'email_verified_at' => Carbon::now(),
            'is_admin' => false
        ]);

        AgentReferral::create([
            'agent_id' => User::where('email', 'agent@test.com.br')->first()->id,
            'client_id' => User::where('email', 'client@test.com.br')->first()->id,
            'referred_at' => now(),
        ]);

        Domain::factory()->create([
            'name' => 'Profile',
            'alias' => 'profile'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'profile')->first()->id,
            'name' => 'Agent',
            'alias' => 'agent'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'profile')->first()->id,
            'name' => 'Client',
            'alias' => 'client'
        ]);

        UserProfile::factory()->create([
            'user_id' => User::where('email', 'pedro.araujo@merlion-si.com.br')->first()->id,
            'domain_value_id' => DomainValue::where('alias', 'agent')->first()->id,
        ]);

        UserProfile::factory()->create([
            'user_id' => User::where('email', 'agent@test.com.br')->first()->id,
            'domain_value_id' => DomainValue::where('alias', 'agent')->first()->id,
        ]);

        UserProfile::factory()->create([
            'user_id' => User::where('email', 'client@test.com.br')->first()->id,
            'domain_value_id' => DomainValue::where('alias', 'client')->first()->id,
        ]);
    }
}
