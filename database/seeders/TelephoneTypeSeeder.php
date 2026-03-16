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

class TelephoneTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Domain::factory()->create([
            'name' => 'Phone Type',
            'alias' => 'type'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'type')->first()->id,
            'name' => 'Home',
            'alias' => 'campoHome'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'type')->first()->id,
            'name' => 'Work',
            'alias' => 'campoWork'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'type')->first()->id,
            'name' => 'Cell',
            'alias' => 'campoCell'
        ]);
    }
}
