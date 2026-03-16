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

class SexGenderOrientationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Biological Sex
        Domain::factory()->create([
            'name' => 'Sex',
            'alias' => 'sex'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'sex')->first()->id,
            'name' => 'Male',
            'alias' => 'masculino'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'sex')->first()->id,
            'name' => 'Female',
            'alias' => 'feminino'
        ]);

        //"Sex at birth"
        Domain::factory()->create([
            'name' => 'Sex at Birth',
            'alias' => 'sexAtBirth'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'sexAtBirth')->first()->id,
            'name' => 'Male',
            'alias' => 'masculino'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'sexAtBirth')->first()->id,
            'name' => 'Female',
            'alias' => 'feminino'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'sexAtBirth')->first()->id,
            'name' => "A sex that's not listed",
            'alias' => 'sexNotListed'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'sexAtBirth')->first()->id,
            'name' => 'Not sure',
            'alias' => 'notSure'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'sexAtBirth')->first()->id,
            'name' => 'Prefere not to answer',
            'alias' => 'prefereNotAnswer'
        ]);

        //"Gender Identity"
        Domain::factory()->create([
            'name' => 'Gender Identity',
            'alias' => 'genderIdentity'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'genderIdentity')->first()->id,
            'name' => 'Male',
            'alias' => 'masculino'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'genderIdentity')->first()->id,
            'name' => 'Female',
            'alias' => 'feminino'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'genderIdentity')->first()->id,
            'name' => 'Transgender Male',
            'alias' => 'transMale'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'genderIdentity')->first()->id,
            'name' => 'Transgender Female',
            'alias' => 'transFemale'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'genderIdentity')->first()->id,
            'name' => "A gender identity that's not listed",
            'alias' => 'genderIdentityNotListed'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'genderIdentity')->first()->id,
            'name' => 'Not sure',
            'alias' => 'notSure'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'genderIdentity')->first()->id,
            'name' => 'Prefere not to answer',
            'alias' => 'prefereNotAnswer'
        ]);

        //"Sexual Orientation"
        Domain::factory()->create([
            'name' => 'Sexual Orientation',
            'alias' => 'sexualOrientation'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'sexualOrientation')->first()->id,
            'name' => 'Straight',
            'alias' => 'straight'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'sexualOrientation')->first()->id,
            'name' => 'Lesbian or Gay',
            'alias' => 'lesbianGay'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'sexualOrientation')->first()->id,
            'name' => 'Bisexual',
            'alias' => 'bisexual'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'sexualOrientation')->first()->id,
            'name' => "A sexual orientation that's not listed",
            'alias' => 'sexualOrientationNotListed'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'sexualOrientation')->first()->id,
            'name' => 'Not sure',
            'alias' => 'notSure'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'sexualOrientation')->first()->id,
            'name' => 'Prefere not to answer',
            'alias' => 'prefereNotAnswer'
        ]);
    }
}
