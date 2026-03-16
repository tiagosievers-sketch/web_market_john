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

class IncomeAndDeductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
