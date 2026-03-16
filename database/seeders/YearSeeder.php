<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\DomainValue;
use Illuminate\Database\Seeder;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Domain::factory()->create([
            'name' => 'Year',
            'alias' => 'year'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'year')->first()->id,
            'name' => '1 year',
            'alias' => '1 year'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'year')->first()->id,
            'name' => '2 years',
            'alias' => '2 years'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'year')->first()->id,
            'name' => '3 years',
            'alias' => '3 years'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'year')->first()->id,
            'name' => '4 years',
            'alias' => '4 years'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'year')->first()->id,
            'name' => '5 years',
            'alias' => '5 years'
        ]);
        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'year')->first()->id,
            'name' => 'Don\'t renew',
            'alias' => 'don\'t renew'
        ]);
    }
}
