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

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Domain::factory()->create([
            'name' => 'Document Types',
            'alias' => 'documentType'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'Permanent Resident Card (Green Card, I-551)',
            'alias' => 'documentPermanentResidentCard'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'Temporary I-551 Stamp (on passport or I94, I-94A)',
            'alias' => 'documentTemporaryI551Stamp'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'Reentry Permit (I-327)',
            'alias' => 'documentReentryPermit'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'Machine Readable Immigrant Visa (with temporary I-551 language)',
            'alias' => 'documentMRIVTempI551Lang'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'Employement Authorization Card (EAS,I-766)',
            'alias' => 'documentEASI766'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'Arrival/Departure Record (I-94, I94A)',
            'alias' => 'documentArrivalDepartureRecI94I94A'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'Arrival/Departure Record in a unexpired foreign passport (I-94)',
            'alias' => 'documentArrivalDepartureRecUFPI94'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'Refugee Travel Document (I-571)',
            'alias' => 'documentRTDI571'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'Certificate of Eligibility for Non Immigrant (F1) Student Status (I-20)',
            'alias' => 'documentCENIF1I20'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'Certificate of Eligibility for Exchange Visitor (J-1) Status (DS2019)',
            'alias' => 'documentCEEVJ1DS2019'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'Notice of Action (I-797)',
            'alias' => 'documentNAI797'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'Unexpired foreign passport',
            'alias' => 'documentUFPassport'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'Other document with an Alien Number ir I-94 Number',
            'alias' => 'documentOANI94N'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'documentType')->first()->id,
            'name' => 'None of these',
            'alias' => 'documentNoneOfThese'
        ]);
    }
}
