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

class RelationshipAndDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Relationships
        Domain::factory()->create([
            'name' => 'Relationship',
            'alias' => 'relationship'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Spouse',
            'alias' => 'relacaoEsposa'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Child (including adopted children)',
            'alias' => 'relacaoCrianca'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Stepchild',
            'alias' => 'relacaoEnteado'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Parent(including adoptive parents)',
            'alias' => 'relacaoPai'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Stepparent',
            'alias' => 'relacaoPadastro'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Domestic partner',
            'alias' => 'relacaoDomestico'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Parent\'s Domestics Partner',
            'alias' => 'relacionamentoDomesticoPais'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Child of Domestic Partner (including adopted children)',
            'alias' => 'relacionamentoDomesticoFilho'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Grandparent',
            'alias' => 'relacionamentoAvo'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Grandchild',
            'alias' => 'relacionamentoNeto'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Brother os Sister (including half and step-siblings)',
            'alias' => 'relacionamentoIrmaoIrma'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Uncle or Aunt',
            'alias' => 'relacionamentoTioTia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'First cousin',
            'alias' => 'relacionamentoPrimo'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Nephew or Nice',
            'alias' => 'relacionamentoSobrinho'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Brother-in-law os Sister-in-law',
            'alias' => 'relacionamentoCunhadoCunhada'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Son-in-law or Daughter-in-law',
            'alias' => 'relacionamentoGenroNora'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Mother-in-law or Father-in-law',
            'alias' => 'relacionamentoSograSogro'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Other Relative (including by marriage and adoption)',
            'alias' => 'relacionamentoParente'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationship')->first()->id,
            'name' => 'Other Unrelated',
            'alias' => 'relacionamentoOutros'
        ]);

        //Relationships Detail
        Domain::factory()->create([
            'name' => 'Relationship Detail',
            'alias' => 'relationshipDetail'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationshipDetail')->first()->id,
            'name' => 'No legal relationship',
            'alias' => 'noLegalRelationship'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationshipDetail')->first()->id,
            'name' => 'Collateral Dependent',
            'alias' => 'collateralDependent'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationshipDetail')->first()->id,
            'name' => 'Court Appointed Guardian',
            'alias' => 'courtAppointedGuardian'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationshipDetail')->first()->id,
            'name' => 'Guardian',
            'alias' => 'guardian'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationshipDetail')->first()->id,
            'name' => 'Ward',
            'alias' => 'ward'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationshipDetail')->first()->id,
            'name' => 'Sponsored dependent',
            'alias' => 'sponsoredDependent'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationshipDetail')->first()->id,
            'name' => 'Former spouse',
            'alias' => 'otherFormerSpouse'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'relationshipDetail')->first()->id,
            'name' => 'Foster Child',
            'alias' => 'otherFosterChild'
        ]);
    }
}
