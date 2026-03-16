<?php

namespace Tests\Feature;


use App\Models\Domain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_application_store()
    {
        $user = User::where('email','pedro.araujo@merlion-si.com.br')->first();

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
                    'sex' => 8,
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
                    'state' => 'California',
                    'zipcode' => '91028',
                    'county' => 'California County',
                    'mailing' => true,
                    'mail_street_address' => "Mail Street",
                    'mail_apte_ste' => "Mail Option test",
                    'mail_city' => "Mail City",
                    'mail_state' => 'Mail State',
                    'mail_zipcode' => "19123",
                    'mail_county' => 'Mail County',
                    'email' => 'pedro.araujo@merlion-si.com.br',
                    'phone' => '(619) 999-9999',
                    'extension' => '123',
                    'type' => 30,
                    'second_phone' => '(061) 999-9999',
                    'second_extension' => '456',
                    'second_type' => 31,
                    'written_lang' => 32,
                    'spoken_lang' => 32,
                ]
            )
        ;

//        dd($response);
        $response->assertRedirectContains('household');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_application_list()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/application/list')
        ;

//        dd($response);
        $response->assertStatus(200);
    }
}
