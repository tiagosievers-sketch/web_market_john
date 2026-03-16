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

class OriginAndEthnicitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Domain::factory()->create([
            'name' => 'Latino Origin',
            'alias' => 'originLatino'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'originLatino')->first()->id,
            'name' => 'Cuban',
            'alias' => 'originCuban'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'originLatino')->first()->id,
            'name' => 'Mexican, Mexican American, or Chicano/a',
            'alias' => 'originMexican'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'originLatino')->first()->id,
            'name' => 'Puerto Rican',
            'alias' => 'originPuertoRican'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'originLatino')->first()->id,
            'name' => 'Other Hispanic, Latino, or Spanish origin',
            'alias' => 'originOtherHispanic'
        ]);

        Domain::factory()->create([
            'name' => 'Race and Ethnicity',
            'alias' => 'raceEthnicity'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'American Indian or Alaskan Native',
            'alias' => 'ethnicityNative'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'Asian Indian',
            'alias' => 'ethnicityIndian'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'Black or African American',
            'alias' => 'ethnicityBlack'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'Chinese',
            'alias' => 'ethnicityChinese'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'Filipino',
            'alias' => 'ethnicityFilipino'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'Guamanian or Chamorro',
            'alias' => 'ethnicityGuamChamo'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'Japanese',
            'alias' => 'ethnicityJapanese'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'Korean',
            'alias' => 'ethnicityKorean'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'Native Hawaiian',
            'alias' => 'ethnicityHawaiian'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'Samoan',
            'alias' => 'ethnicitySamoan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'Vietnamese',
            'alias' => 'ethnicityVietnamese'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'White',
            'alias' => 'ethnicityWhite'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'Asian race not listed above',
            'alias' => 'ethnicityAsianNotListed'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'Pacific Islander race not listed above',
            'alias' => 'ethnicityPacificIslanderNotListed'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'raceEthnicity')->first()->id,
            'name' => 'Race not listed above',
            'alias' => 'ethnicityRaceNotListed'
        ]);
    }
}
