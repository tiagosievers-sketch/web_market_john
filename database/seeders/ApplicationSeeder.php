<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Application;
use App\Models\Contact;
use App\Models\Household;
use App\Models\HouseholdMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Application::factory()->create([
            'firstname' => "Firstname 1",
            'middlename' => "Middlename 1",
            'lastname' => "Lastname 1",
            'suffix' => 5,
            'birthdate' => '1992-04-15',
            'sex' => 8,
            'has_ssn' => true,
            'ssn' => "123456789",
            'has_perm_address' => true,
            'notices_mail_or_email' => false,
            'send_email' => true,
            'send_text' => true,
            'agent_id' => 1,
            'client_id' => 1,
            'created_by' => 1
        ]);

        $application = Application::where('ssn','123456789')->first();
        //Normal Address
        Address::factory()->create(
            [
                'application_id' => $application->id,
                'street_address' => 'Street Test',
                'apte_ste' => "Option test",
                'city' => "Test City",
                'state' => "estadoteste",
                'zipcode' => "12345",
                'county' => "testecounty",
                'mailing' => false,
                'created_by' => 1
            ]
        );
        //Mailing
        Address::factory()->create(
            [
                'application_id' => $application->id,
                'street_address' => 'Mail Street',
                'apte_ste' => "Mail Option test",
                'city' => "Mail City",
                'state' => "estadoteste",
                'zipcode' => "19123",
                'county' => "testecounty",
                'mailing' => true,
                'created_by' => 1
            ]
        );

        Contact::factory()->create(
            [
                'application_id' => $application->id,
                'email' => 'pedro.araujo2@merlion-si.com.br',
                'phone' => '(619) 999-9999',
                'extension' => '123',
                'type' => 30,
                'second_phone' => '(061) 999-9999',
                'second_extension' => '456',
                'second_type' => 31,
                'written_lang' => 32,
                'spoken_lang' => 32,
                'created_by' => 1
            ]
        );

        Household::factory()->create(
            [
                'application_id' => $application->id,
                'applying_coverage' => true,
                'eligible_cost_saving' => true,
                'married' => true,
                'fed_tax_income_return' => true,
                'jointly_taxed_spouse' => true,
                'is_dependent' => false,
                'created_by' => 1
            ]
        );

        $household = Household::where('application_id', $application->id)->first();

        HouseholdMember::factory()->create(
            [
                'household_id' => $household->id,
                'firstname' => 'Spouse 1',
                'middlename' => 'Middlename 2',
                'lastname' => 'Lastname 1',
                'suffix' => 6,
                'birthdate' => '2000-01-01',
                'sex' => 9,
                'relationship' => 10,
                'tax_form' => 0,
                'lives_with_you' => null,
                'tax_claimant' => null,
                'eligible_cost_saving' => null,
                'created_by' => 1
            ]
        );

        HouseholdMember::factory()->create(
            [
                'household_id' => $household->id,
                'firstname' => 'Spouse 1',
                'middlename' => 'Middlename 2',
                'lastname' => 'Lastname 1',
                'suffix' => 6,
                'birthdate' => '2000-01-01',
                'sex' => 9,
                'relationship' => 10,
                'tax_form' => 1,
                'lives_with_you' => true,
                'tax_claimant' => false,
                'eligible_cost_saving' => false,
                'created_by' => 1
            ]
        );

        HouseholdMember::factory()->create(
            [
                'household_id' => $household->id,
                'firstname' => 'Son 1',
                'middlename' => 'Middlename 2',
                'lastname' => 'Lastname 1',
                'suffix' => 3,
                'birthdate' => '2014-01-01',
                'sex' => 8,
                'relationship' => 11,
                'tax_form' => false,
                'lives_with_you' => null,
                'tax_claimant' => null,
                'eligible_cost_saving' => null,
                'created_by' => 1
            ]
        );

        HouseholdMember::factory()->create(
            [
                'household_id' => $household->id,
                'firstname' => 'Son 1',
                'middlename' => 'Middlename 2',
                'lastname' => 'Lastname 1',
                'suffix' => 3,
                'birthdate' => '2014-01-01',
                'sex' => 8,
                'relationship' => 11,
                'tax_form' => 1,
                'lives_with_you' => true,
                'tax_claimant' => false,
                'eligible_cost_saving' => false,
                'created_by' => 1
            ]
        );
    }
}
