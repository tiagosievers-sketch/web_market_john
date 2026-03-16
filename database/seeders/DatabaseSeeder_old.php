<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Domain;
use App\Models\DomainValue;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use App\Models\AgentReferral;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         \App\Models\User::factory(10)->create();
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

        Domain::factory()->create([
            'name' => 'Type',
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

        Domain::factory()->create([
            'name' => 'Language',
            'alias' => 'language'
        ]);

        // DomainValue::factory()->create([
        //     'domain_id' => Domain::where('alias', 'language')->first()->id,
        //     'name' => 'Spanish',
        //     'alias' => 'spanish'
        // ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'language')->first()->id,
            'name' => 'Portuguese',
            'alias' => 'portuguese'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'language')->first()->id,
            'name' => 'English',
            'alias' => 'english'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'language')->first()->id,
            'name' => 'Spanish',
            'alias' => 'spanish'
        ]);

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

        Domain::factory()->create([
            'name' => 'Income Type',
            'alias' => 'incomeType'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Job',
            'alias' => 'job'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Self-Employment',
            'alias' => 'selfEmployment'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Unemployment',
            'alias' => 'unemployment'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Alimony',
            'alias' => 'alimony'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Social Security',
            'alias' => 'socialSecurity'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Retirement',
            'alias' => 'retirement'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Pension',
            'alias' => 'pension'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Cash support',
            'alias' => 'cashSupport'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Capital Gains',
            'alias' => 'capitalGains'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Investment',
            'alias' => 'investment'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Rental or royalty',
            'alias' => 'rentalRoyalty'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Scholarship',
            'alias' => 'scholarship'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Prize, award, or gambling',
            'alias' => 'prizeAwardGambling'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Court awards',
            'alias' => 'courtAwards'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Jury duty pay',
            'alias' => 'juryDutyPay'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Canceled Debt',
            'alias' => 'canceledDebt'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Farming or fishing',
            'alias' => 'farmingFishing'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'incomeType')->first()->id,
            'name' => 'Other income',
            'alias' => 'otherIncome'
        ]);

        Domain::factory()->create([
            'name' => 'Deduction Type',
            'alias' => 'deductionType'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'deductionType')->first()->id,
            'name' => 'Alimony',
            'alias' => 'alimony'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'deductionType')->first()->id,
            'name' => 'Student load interest',
            'alias' => 'studentLoadInterest'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'deductionType')->first()->id,
            'name' => 'Other',
            'alias' => 'other'
        ]);
        //Collateral Dependent, Court Appointed Guardian, Guardian, Ward, Sponsored dependent

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

//        $this->call([
//            ApplicationSeeder::class
//        ]);
    }
}
