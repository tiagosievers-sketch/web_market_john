<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserAndProfileSeeder::class,
            LanguageSeeder::class,
            SuffixSeeder::class,
            TelephoneTypeSeeder::class,
            SexGenderOrientationSeeder::class,
            TimeAndFrequencySeeder::class,
            RelationshipAndDetailSeeder::class,
            OriginAndEthnicitySeeder::class,
            IncomeAndDeductionSeeder::class,
            DocumentTypeSeeder::class,
            DocumentOrStatusTypesSeeder::class,
            CountrySeeder::class,
            YearSeeder::class,
        ]);
    }
}
