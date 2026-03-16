<?php


use App\Actions\TaxHouseholdActions;
use App\Models\Application;
use App\Models\DomainValue;
use App\Models\HouseholdMember;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApplicationFluxTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_application_store()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();
        $sexMasc = DomainValue::select('id')->where('alias', '=', 'masculino')->first();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->postJson(
                '/application/store',
                [
                    'firstname' => "Firstname 1",
                    'middlename' => "Middlename 1",
                    'lastname' => "Lastname 1",
                    'suffix' => 5,
                    'birthdate' => '04/15/1992',
                    'sex' => $sexMasc->id,
                    'has_ssn' => true,
                    'ssn' => "123456789",
                    'has_perm_address' => true,
                    'notices_mail_or_email' => false,
                    'send_email' => true,
                    'send_text' => true,
                    'field_type' => 0,
                    'street_address' => 'Test Street',
                    'apte_ste' => 'optional',
                    'city' => 'Test City',
                    'state' => 'Florida',
                    'zipcode' => '32827',
                    'county' => 'Orange County',
                    'mailing' => true,
                    'mail_street_address' => "Mail Street",
                    'mail_apte_ste' => "Mail Option test",
                    'mail_city' => "Mail City",
                    'mail_state' => 'Florida',
                    'mail_zipcode' => "32827",
                    'mail_county' => 'Orange County',
                    'email' => 'pedro.araujo@merlion-si.com.br',
                    'phone' => '(619) 999-9999',
                    'extension' => '123',
                    'type' => 10,
                    'second_phone' => '(061) 999-9999',
                    'second_extension' => '456',
                    'second_type' => 11,
                    'written_lang' => 3,
                    'spoken_lang' => 4,
                ]
            )
        ;

//        dd($response);
        $response->assertRedirectContains('household');
    }

    /**
     * A basic feature test example.
     * @depends test_application_store
     * @return void
     */
    public function test_household_store()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();
        $application = Application::query()->first();
        $spouseDomainValue = DomainValue::select('id')->where('alias', '=', 'relacaoEsposa')->first();
        $childDomainValue = DomainValue::select('id')->where('alias', '=', 'relacaoCrianca')->first();
        $sexMasc = DomainValue::select('id')->where('alias', '=', 'masculino')->first();
        $sexFem = DomainValue::select('id')->where('alias', '=', 'feminino')->first();
        $householdJson = [
            'application_id' => $application->id,
            'household_members' => [
                [
                    'applying_coverage' => 1,
                    'eligible_cost_saving' => 1,
                    'married' => 1,
                    'is_dependent' => 0,
                    'field_type' => 0,
                ],
                [
                    'firstname' => 'Spouse 1',
                    'middlename' => null,
                    'lastname' => 'LastName 1',
                    'suffix' => null,
                    'birthdate' => '01/01/2000',
                    'sex' => $sexFem->id,
                    'applying_coverage' => 1,
                    'eligible_cost_saving' => null,
                    'married' => 1,
                    'is_dependent' => 0,
                    'field_type' => 1,
                    'relationship' => $spouseDomainValue->id,
                    'relationship_detail' => null
                ],
                [
                    'firstname' =>  'Son 1',
                    'middlename' => null,
                    'lastname' => 'LastName 1',
                    'suffix' => 3,
                    'birthdate' => '01/01/2020',
                    'sex' => $sexMasc->id,
                    'applying_coverage' => 1,
                    'eligible_cost_saving' => null,
                    'married' => 0,
                    'is_dependent' => 1,
                    'field_type' => 2,
                    'relationship' => $childDomainValue->id,
                    'relationship_detail' => null
                ],
                [
                    'firstname' =>  'Daughter 1',
                    'middlename' => null,
                    'lastname' => 'LastName 1',
                    'suffix' => 3,
                    'birthdate' => '01/01/2022',
                    'sex' => $sexFem->id,
                    'applying_coverage' => 1,
                    'eligible_cost_saving' => null,
                    'married' => 0,
                    'is_dependent' => 1,
                    'field_type' => 2,
                    'relationship' => $childDomainValue->id,
                    'relationship_detail' => null
                ],
                [
                    'firstname' =>  'Daughter 2',
                    'middlename' => null,
                    'lastname' => 'LastName 1',
                    'suffix' => 3,
                    'birthdate' => '01/01/2022',
                    'sex' => $sexFem->id,
                    'applying_coverage' => 1,
                    'eligible_cost_saving' => null,
                    'married' => 0,
                    'is_dependent' => 1,
                    'field_type' => 2,
                    'relationship' => $childDomainValue->id,
                    'relationship_detail' => null
                ]
            ]
        ];
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->postJson(
                '/household/ajax/store',
                $householdJson
            )
        ;
        $response->assertStatus(200);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_relationship_list_store()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();
        $application = Application::query()->first();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->getJson(
                '/relationship/application/'.$application->id
            )
        ;
        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status','data'])->missing('message')
        );
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_relationship_store_update()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();
        $childDomainValue = DomainValue::select('id')->where('alias', '=', 'relacaoCrianca')->first();
        $irmaoDomainValue = DomainValue::select('id')->where('alias', '=', 'relacionamentoIrmaoIrma')->first();
        $application = Application::query()->first();
        $relationships = [
            "application_id" => $application->id,
            "household_relatioships" => [
                [
                    "name" => "Spouse 1 LastName 1",
                    "relationships" => [
                        [
                            "member_from_name" => "Spouse 1 LastName 1",
                            "member_from_id" => 2,
                            "relationship" => $childDomainValue->id,
                            "relationship_detail" => null,
                            "member_to_name" => "Son 1 LastName 1",
                            "member_to_id" => 3
                        ],
                        [
                            "member_from_name" => "Spouse 1 LastName 1",
                            "member_from_id" => 2,
                            "relationship" => $childDomainValue->id,
                            "relationship_detail" => null,
                            "member_to_name" => "Daughter 1 LastName 1",
                            "member_to_id" => 4
                        ],
                        [
                            "member_from_name" => "Spouse 1 LastName 1",
                            "member_from_id" => 2,
                            "relationship" => $childDomainValue->id,
                            "relationship_detail" => null,
                            "member_to_name" => "Daughter 2 LastName 1",
                            "member_to_id" => 5
                        ]
                    ]
                ],
                [
                    "name" => "Son 1 LastName 1",
                    "relationships" => [
                        [
                            "member_from_name" => "Son 1 LastName 1",
                            "member_from_id" => 3,
                            "relationship" => $irmaoDomainValue->id,
                            "relationship_detail" => null,
                            "member_to_name" => "Daughter 1 LastName 1",
                            "member_to_id" => 4
                        ],
                        [
                            "member_from_name" => "Son 1 LastName 1",
                            "member_from_id" => 3,
                            "relationship" => $irmaoDomainValue->id,
                            "relationship_detail" => null,
                            "member_to_name" => "Daughter 2 LastName 1",
                            "member_to_id" => 5
                        ]
                    ]
                ],
                [
                    "name" => "Daughter 1 LastName 1",
                    "relationships" => [
                        [
                            "member_from_name" => "Daughter 1 LastName 1",
                            "member_from_id" => 4,
                            "relationship" => $irmaoDomainValue->id,
                            "relationship_detail" => null,
                            "member_to_name" => "Daughter 2 LastName 1",
                            "member_to_id" => 5
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->postJson(
                '/relationship/store-or-update',
                $relationships
            )
        ;
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_recover_next_member()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();
        $application = Application::query()->first();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->getJson(
                'tax/member/'.$application->id
            )
        ;
//        $response->dd();
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status','data'])
                ->whereAll([
                    'data.id' => 1,
                    'data.application_id' => 1,
                    'data.tax_form' => 0
                ])
            )
        ;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_tax_information()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();
        $application = Application::query()->first();
        $mainMember = TaxHouseholdActions::recoverNextMember($application->id);
        $avoDomainValue = DomainValue::select('id')->where('alias', '=', 'relacionamentoAvo')->first();
        $avoDetailDomainValue = DomainValue::select('id')->where('alias', '=', 'sponsoredDependent')->first();
        $sexMasc = DomainValue::select('id')->where('alias', '=', 'masculino')->first();
        $spouseData = [];
        $spouseData[] = [
            'id' => $mainMember->spouse->id,
            'lives_with_you' => 1
        ];
        $dependentsData = [];
        foreach ($mainMember->otherMembers as $dependent) {
            $dependentsData[] = [
                'id' => $dependent->id,
                'lives_with_you' => 1
            ];
        }
        $newHouseholdMemberData = [];
        $newHouseholdMemberData[] = [
            'firstname' => 'Avo 1',
            'middlename' => 'Middle',
            'lastname' => 'Last',
            'suffix' => null,
            'birthdate' => '01/01/1960',
            'sex' => $sexMasc->id,
            'relationship' => $avoDomainValue->id,
            'relationship_detail' => $avoDetailDomainValue->id,
            'field_type' => 5,
            'lives_with_you' => 1,
            'is_dependent' => 1,
            'tax_filler' => 0,
            'tax_claimant' => $mainMember->id,
        ];

        $taxInformation = [
            'application_id' => $application->id,
            'this_household_member_id'=> $mainMember->id,
            'fed_tax_income_return' => 1,
            'married' => $mainMember->married,
            'jointly_taxed_spouse' => 1,
            'tax_filler' => 1,
            'tax_claimant' => $mainMember->id,
            'provide_tax_filler_information' => 1,
            'dependents' => $dependentsData,
            'spouse' => $spouseData,
            'new_household_members' => $newHouseholdMemberData
        ];

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->postJson(
                'tax/fill-first-tax/'.$application->id,
                $taxInformation
            )
        ;

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status','data'])->missing('message')
                ->whereAll([
                    'data.id' => 3,
                    'data.application_id' => 1,
                    'data.tax_form' => 0
                ])
            )
        ;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_tax_information_son()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();
        $application = Application::query()->first();
        $mainMember = TaxHouseholdActions::recoverNextMember($application->id);
        $taxInformation = [
            'application_id' => $application->id,
            'this_household_member_id'=> $mainMember->id,
            'fed_tax_income_return' => 1,
            'married' => 0,
            'jointly_taxed_spouse' => 0,
            'tax_filler' => 0,
            'provide_tax_filler_information' => 1,
            'dependents' => [],
            'spouse' => [],
            'new_household_members' => []
        ];

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->postJson(
                'tax/fill-first-tax/'.$application->id,
                $taxInformation
            )
        ;

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status','data'])->missing('message')
                ->whereAll([
                    'data.id' => 4,
                    'data.application_id' => 1,
                    'data.tax_form' => 0
                ])
            )
        ;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_tax_information_daughter1()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();
        $application = Application::query()->first();
        $mainMember = TaxHouseholdActions::recoverNextMember($application->id);
        $taxInformation = [
            'application_id' => $application->id,
            'this_household_member_id'=> $mainMember->id,
            'fed_tax_income_return' => 1,
            'married' => 0,
            'jointly_taxed_spouse' => 0,
            'tax_filler' => 0,
            'provide_tax_filler_information' => 1,
            'dependents' => [],
            'spouse' => [],
            'new_household_members' => []
        ];

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->postJson(
                'tax/fill-first-tax/'.$application->id,
                $taxInformation
            )
        ;

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status','data'])->missing('message')
                ->whereAll([
                    'data.id' => 5,
                    'data.application_id' => 1,
                    'data.tax_form' => 0
                ])
            )
        ;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_tax_information_daughter2()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();
        $application = Application::query()->first();
        $mainMember = TaxHouseholdActions::recoverNextMember($application->id);
        $taxInformation = [
            'application_id' => $application->id,
            'this_household_member_id'=> $mainMember->id,
            'fed_tax_income_return' => 1,
            'married' => 0,
            'jointly_taxed_spouse' => 0,
            'tax_filler' => 0,
            'provide_tax_filler_information' => 1,
            'dependents' => [],
            'spouse' => [],
            'new_household_members' => []
        ];

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->postJson(
                'tax/fill-first-tax/'.$application->id,
                $taxInformation
            )
        ;

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status','data'])->missing('message')
                ->whereAll([
                    'data.id' => 6,
                    'data.application_id' => 1,
                    'data.tax_form' => 0
                ])
            )
        ;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_tax_information_avo()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();
        $application = Application::query()->first();
        $mainMember = TaxHouseholdActions::recoverNextMember($application->id);
        $avoDomainValue = DomainValue::select('id')->where('alias', '=', 'relacaoEsposa')->first();
        $sexFem = DomainValue::select('id')->where('alias', '=', 'feminino')->first();
//        dd($mainMember->toArray());
        $spouseData = [];
        $dependentsData = [];
        $newHouseholdMemberData = [];
        $newHouseholdMemberData[] = [
            'firstname' => 'Avoh 1',
            'middlename' => 'Middle',
            'lastname' => 'Last',
            'suffix' => null,
            'birthdate' => '01/01/1961',
            'sex' => $sexFem->id,
            'relationship' => $avoDomainValue->id,
            'relationship_detail' => null,
            'field_type' => 3,
            'lives_with_you' => 0,
            'is_dependent' => 0,
            'tax_filler' => 1,
        ];

        $taxInformation = [
            'application_id' => $application->id,
            'this_household_member_id'=> $mainMember->id,
            'fed_tax_income_return' => 1,
            'married' => 1,
            'jointly_taxed_spouse' => 0,
            'tax_filler' => 0,
            'provide_tax_filler_information' => 1,
            'dependents' => $dependentsData,
            'spouse' => $spouseData,
            'new_household_members' => $newHouseholdMemberData
        ];

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->postJson(
                'tax/fill-first-tax/'.$application->id,
                $taxInformation
            )
        ;

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status','data'])->missing('message')
                ->whereAll([
                    'data.id' => 7,
                    'data.application_id' => 1,
                    'data.tax_form' => 0
                ])
            )
        ;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_tax_information_avoh()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();
        $application = Application::query()->first();
        /** @var HouseholdMember $mainMember */
        $mainMember = TaxHouseholdActions::recoverNextMember($application->id);
//        dd($mainMember->toArray());
        $spouseData = [];
        $spouseData[] = [
            'id' => $mainMember->spouse->id,
            'lives_with_you' => 0
        ];
        $dependentsData = [];
        $newHouseholdMemberData = [];

        $taxInformation = [
            'application_id' => $application->id,
            'this_household_member_id'=> $mainMember->id,
            'fed_tax_income_return' => 1,
            'married' => 1,
            'jointly_taxed_spouse' => 0,
            'tax_filler' => 1,
            'provide_tax_filler_information' => 1,
            'dependents' => $dependentsData,
            'spouse' => $spouseData,
            'new_household_members' => $newHouseholdMemberData
        ];

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->postJson(
                'tax/fill-first-tax/'.$application->id,
                $taxInformation
            )
        ;

        $response->assertStatus(204);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_additional_information()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();
        $application = Application::query()->first();
        $mainMember = $application->mainMember()->first();
        $sexMasc = DomainValue::select('id')->where('alias', '=', 'masculino')->first();
        $sexFem = DomainValue::select('id')->where('alias', '=', 'feminino')->first();
        $relSobrinho = DomainValue::select('id')->where('alias', '=', 'relacionamentoSobrinho')->first();
        $relDetSobrinho = DomainValue::select('id')->where('alias', '=', 'guardian')->first();
        $relChild = DomainValue::select('id')->where('alias', '=', 'relacaoCrianca')->first();
        $childTakingCareData[] = [
            'firstname' => 'Kid 1',
            'middlename' => null,
            'lastname' => 'Other Last',
            'suffix' => null,
            'birthdate' => '01/01/2010',
            'sex' => $sexFem->id,
            'relationship' => $relSobrinho->id,
            'relationship_detail' => $relDetSobrinho->id,
        ];
        $otherSonDaughterData[] = [
            'firstname' => 'Gemni 1',
            'middlename' => null,
            'lastname' => 'Last',
            'suffix' => null,
            'birthdate' => '07/01/2024',
            'sex' => $sexMasc->id,
            'relationship' => $relChild->id,
            'relationship_detail' => null,
        ];
        $otherSonDaughterData[] = [
            'firstname' => 'Gemni 2',
            'middlename' => null,
            'lastname' => 'Last',
            'suffix' => null,
            'birthdate' => '07/01/2024',
            'sex' => $sexFem->id,
            'relationship' => $relChild->id,
            'relationship_detail' => null,
        ];

        $additionalInformation = [
            'application_id' => $application->id,
            'this_household_member_id'=> $mainMember->id,
            'live_someone_under_nineteen' => 1,
            'taking_care_under_nineteen' => 1,
            'child_taking_care' => $childTakingCareData,
            'live_any_other_family' => 1,
            'live_son_daughter' => 1,
            'other_son_daughter' => $otherSonDaughterData,
        ];

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->postJson(
                'additionalinformation/fill/'.$application->id,
                $additionalInformation
            )
        ;

        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAll(['status','message'])
                    ->where('status','success')
                    ->where('message','Additional information registered with success.')
            )
        ;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fill_address_information()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();
        $application = Application::query()->first();
        $son = HouseholdMember::where('firstname','Son 1')
            ->where('lastname','LastName 1')
            ->first()
        ;
        $otherAddreses = [];
        $otherAddreses[] = [
            'household_member_id' => $son->id,
            'street_address' => 'Teste de outra rua 1',
            'apte_ste' => 'teste de outro apartamento 1',
            'city' => 'Teste de outra cidade 1',
            'state' => 'Florida',
            'zipcode' => '32827',
            'county' => 'Orange County'
        ];

        $addressInformation = [
            'application_id' => $application->id,
            'everyone_lives_main_member' => 0,
            'other_addresses' => $otherAddreses
        ];

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->postJson(
                'addinfo/fill/address/'.$application->id,
                $addressInformation
            )
        ;
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['status','message'])
                ->where('status','success')
                ->where('message','Successfully organized members addresses')
            )
        ;
    }
}


