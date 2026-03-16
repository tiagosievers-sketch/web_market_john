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

class DocumentOrStatusTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Domain::factory()->create([
            'name' => 'Document or Status Types',
            'alias' => 'documentOrStatusType'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentOrStatusType')->first()->id,
            'name' => 'Members Of A Federally Recognized Indian Tribe',
            'alias' => 'docOrStatMOAFRIT'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentOrStatusType')->first()->id,
            'name' => 'Certification from U.S. Department of Health and Human Services (HHS) Office of Refugee Resettlement (ORR)',
            'alias' => 'docOrStatCUSDHHSORR'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentOrStatusType')->first()->id,
            'name' => 'Office of Refugee Resettlement (ORR) eligibility letter (if under 18)',
            'alias' => 'docOrStatORRELUnder18'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentOrStatusType')->first()->id,
            'name' => 'Cuban/Haitian Entrant',
            'alias' => 'docOrStatCubanHaitianEntrant'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentOrStatusType')->first()->id,
            'name' => 'Non Citizen Who Is Lawfully Present In America Samoa',
            'alias' => 'docOrStatNCWILPIAS'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentOrStatusType')->first()->id,
            'name' => 'Battered spouse, child, or parent under the Violence Against Woman Act',
            'alias' => 'docOrStatBatteredSCPUnderVAWA'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentOrStatusType')->first()->id,
            'name' => 'Another document or alien number / I-94 number',
            'alias' => 'docOrStatAnotherDocAlienNumI94Num'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentOrStatusType')->first()->id,
            'name' => "None of these (Select this if this person doesn't gave a listed document. You can continue the application without selecting a document or status type.)",
            'alias' => 'docOrStatNoneOfThese'
        ]);
    }
}
