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

class TimeAndFrequencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Domain::factory()->create([
            'name' => 'Frequency',
            'alias' => 'frequency'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'frequency')->first()->id,
            'name' => 'Daily',
            'alias' => 'daily'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'frequency')->first()->id,
            'name' => 'Monthly',
            'alias' => 'monthly'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'frequency')->first()->id,
            'name' => 'Annually',
            'alias' => 'annually'
        ]);
    }
}
