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

class SuffixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Domain::factory()->create([
            'name' => 'Suffix',
            'alias' => 'suffix'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'suffix')->first()->id,
            'name' => 'Jr.',
            'alias' => 'jr'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'suffix')->first()->id,
            'name' => 'Sr.',
            'alias' => 'sr'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'suffix')->first()->id,
            'name' => 'III',
            'alias' => 'iii'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'suffix')->first()->id,
            'name' => 'IV',
            'alias' => 'iv'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'suffix')->first()->id,
            'name' => 'V',
            'alias' => 'v'
        ]);
    }
}
