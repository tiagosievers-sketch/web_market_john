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

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Domain::factory()->create([
            'name' => 'Countries',
            'alias' => 'country'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Afghanistan",
            'alias' => 'countryAfghanistan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Albania",
            'alias' => 'countryAlbania'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Algeria",
            'alias' => 'countryAlgeria'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Andorra",
            'alias' => 'countryAndorra'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Angola",
            'alias' => 'countryAngola'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Anguilla",
            'alias' => 'countryAnguilla'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Antigua and Barbuda",
            'alias' => 'countryAntiguaAndBarbuda'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Argentina",
            'alias' => 'countryArgentina'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Armenia",
            'alias' => 'countryArmenia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Australia",
            'alias' => 'countryAustralia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Austria",
            'alias' => 'countryAustria'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Azerbaijan",
            'alias' => 'countryAzerbaijan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Bahamas",
            'alias' => 'countryBahamas'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Bahrain",
            'alias' => 'countryBahrain'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Bangladesh",
            'alias' => 'countryBangladesh'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Barbados",
            'alias' => 'countryBarbados'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Belarus",
            'alias' => 'countryBelarus'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Belgium",
            'alias' => 'countryBelgium'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Belize",
            'alias' => 'countryBelize'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Benin",
            'alias' => 'countryBenin'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Bermuda",
            'alias' => 'countryBermuda'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Bhutan",
            'alias' => 'countryBhutan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Bolivia",
            'alias' => 'countryBolivia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Bosnia and Herzegovina",
            'alias' => 'countryBosniaAndHerzegovina'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Botswana",
            'alias' => 'countryBotswana'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Brazil",
            'alias' => 'countryBrazil'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Brunei",
            'alias' => 'countryBrunei'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Bulgaria",
            'alias' => 'countryBulgaria'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Burkina Faso",
            'alias' => 'countryBurkinaFaso'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Burundi",
            'alias' => 'countryBurundi'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Cabo Verde",
            'alias' => 'countryCaboVerde'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Cambodia",
            'alias' => 'countryCambodia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Cameroon",
            'alias' => 'countryCameroon'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Canada",
            'alias' => 'countryCanada'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Central African Republic",
            'alias' => 'countryCentralAfricanRepublic'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Chad",
            'alias' => 'countryChad'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Chile",
            'alias' => 'countryChile'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "China",
            'alias' => 'countryChina'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Colombia",
            'alias' => 'countryColombia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Comoros",
            'alias' => 'countryComoros'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Congo (Brazzaville)",
            'alias' => 'countryCongoBrazzaville'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Congo (Kinshasa)",
            'alias' => 'countryCongoKinshasa'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Costa Rica",
            'alias' => 'countryCostaRica'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Croatia",
            'alias' => 'countryCroatia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Cuba",
            'alias' => 'countryCuba'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Cyprus",
            'alias' => 'countryCyprus'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Czech Republic",
            'alias' => 'countryCzechRepublic'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Denmark",
            'alias' => 'countryDenmark'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Djibouti",
            'alias' => 'countryDjibouti'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Dominica",
            'alias' => 'countryDominica'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Dominican Republic",
            'alias' => 'countryDominicanRepublic'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Ecuador",
            'alias' => 'countryEcuador'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Egypt",
            'alias' => 'countryEgypt'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "El Salvador",
            'alias' => 'countryElSalvador'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Equatorial Guinea",
            'alias' => 'countryEquatorialGuinea'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Eritrea",
            'alias' => 'countryEritrea'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Estonia",
            'alias' => 'countryEstonia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Eswatini",
            'alias' => 'countryEswatini'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Ethiopia",
            'alias' => 'countryEthiopia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Fiji",
            'alias' => 'countryFiji'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Finland",
            'alias' => 'countryFinland'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "France",
            'alias' => 'countryFrance'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Gabon",
            'alias' => 'countryGabon'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Gambia",
            'alias' => 'countryGambia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Georgia",
            'alias' => 'countryGeorgia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Germany",
            'alias' => 'countryGermany'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Ghana",
            'alias' => 'countryGhana'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Greece",
            'alias' => 'countryGreece'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Grenada",
            'alias' => 'countryGrenada'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Guatemala",
            'alias' => 'countryGuatemala'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Guinea",
            'alias' => 'countryGuinea'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Guinea-Bissau",
            'alias' => 'countryGuineaBissau'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Guyana",
            'alias' => 'countryGuyana'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Haiti",
            'alias' => 'countryHaiti'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Honduras",
            'alias' => 'countryHonduras'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Hungary",
            'alias' => 'countryHungary'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Iceland",
            'alias' => 'countryIceland'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "India",
            'alias' => 'countryIndia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Indonesia",
            'alias' => 'countryIndonesia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Iran",
            'alias' => 'countryIran'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Iraq",
            'alias' => 'countryIraq'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Ireland",
            'alias' => 'countryIreland'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Israel",
            'alias' => 'countryIsrael'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Italy",
            'alias' => 'countryItaly'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Ivory Coast (Côte d'Ivoire)",
            'alias' => 'countryIvoryCoastCteDIvoire'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Jamaica",
            'alias' => 'countryJamaica'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Japan",
            'alias' => 'countryJapan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Jordan",
            'alias' => 'countryJordan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Kazakhstan",
            'alias' => 'countryKazakhstan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Kenya",
            'alias' => 'countryKenya'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Kiribati",
            'alias' => 'countryKiribati'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Korea, North (North Korea)",
            'alias' => 'countryKoreaNorthNorthKorea'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Korea, South (South Korea)",
            'alias' => 'countryKoreaSouthSouthKorea'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Kosovo",
            'alias' => 'countryKosovo'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Kuwait",
            'alias' => 'countryKuwait'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Kyrgyzstan",
            'alias' => 'countryKyrgyzstan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Laos",
            'alias' => 'countryLaos'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Latvia",
            'alias' => 'countryLatvia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Lebanon",
            'alias' => 'countryLebanon'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Lesotho",
            'alias' => 'countryLesotho'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Liberia",
            'alias' => 'countryLiberia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Libya",
            'alias' => 'countryLibya'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Liechtenstein",
            'alias' => 'countryLiechtenstein'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Lithuania",
            'alias' => 'countryLithuania'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Luxembourg",
            'alias' => 'countryLuxembourg'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Madagascar",
            'alias' => 'countryMadagascar'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Malawi",
            'alias' => 'countryMalawi'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Malaysia",
            'alias' => 'countryMalaysia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Maldives",
            'alias' => 'countryMaldives'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Mali",
            'alias' => 'countryMali'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Malta",
            'alias' => 'countryMalta'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Marshall Islands",
            'alias' => 'countryMarshallIslands'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Mauritania",
            'alias' => 'countryMauritania'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Mauritius",
            'alias' => 'countryMauritius'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Mexico",
            'alias' => 'countryMexico'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Micronesia",
            'alias' => 'countryMicronesia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Moldova",
            'alias' => 'countryMoldova'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Monaco",
            'alias' => 'countryMonaco'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Mongolia",
            'alias' => 'countryMongolia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Montenegro",
            'alias' => 'countryMontenegro'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Montserrat",
            'alias' => 'countryMontserrat'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Morocco",
            'alias' => 'countryMorocco'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Mozambique",
            'alias' => 'countryMozambique'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Myanmar (Burma)",
            'alias' => 'countryMyanmarBurma'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Namibia",
            'alias' => 'countryNamibia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Nauru",
            'alias' => 'countryNauru'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Nepal",
            'alias' => 'countryNepal'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Netherlands",
            'alias' => 'countryNetherlands'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "New Zealand",
            'alias' => 'countryNewZealand'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Nicaragua",
            'alias' => 'countryNicaragua'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Niger",
            'alias' => 'countryNiger'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Nigeria",
            'alias' => 'countryNigeria'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "North Macedonia",
            'alias' => 'countryNorthMacedonia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Norway",
            'alias' => 'countryNorway'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Oman",
            'alias' => 'countryOman'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Pakistan",
            'alias' => 'countryPakistan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Palau",
            'alias' => 'countryPalau'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Panama",
            'alias' => 'countryPanama'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Papua New Guinea",
            'alias' => 'countryPapuaNewGuinea'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Paraguay",
            'alias' => 'countryParaguay'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Peru",
            'alias' => 'countryPeru'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Philippines",
            'alias' => 'countryPhilippines'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Poland",
            'alias' => 'countryPoland'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Portugal",
            'alias' => 'countryPortugal'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Qatar",
            'alias' => 'countryQatar'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Romania",
            'alias' => 'countryRomania'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Russia",
            'alias' => 'countryRussia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Rwanda",
            'alias' => 'countryRwanda'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Saint Kitts and Nevis",
            'alias' => 'countrySaintKittsAndNevis'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Saint Lucia",
            'alias' => 'countrySaintLucia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Saint Vincent and the Grenadines",
            'alias' => 'countrySaintVincentAndTheGrenadines'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Samoa",
            'alias' => 'countrySamoa'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "San Marino",
            'alias' => 'countrySanMarino'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Sao Tome and Principe",
            'alias' => 'countrySaoTomeAndPrincipe'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Saudi Arabia",
            'alias' => 'countrySaudiArabia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Senegal",
            'alias' => 'countrySenegal'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Serbia",
            'alias' => 'countrySerbia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Seychelles",
            'alias' => 'countrySeychelles'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Sierra Leone",
            'alias' => 'countrySierraLeone'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Singapore",
            'alias' => 'countrySingapore'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Slovakia",
            'alias' => 'countrySlovakia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Slovenia",
            'alias' => 'countrySlovenia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Solomon Islands",
            'alias' => 'countrySolomonIslands'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Somalia",
            'alias' => 'countrySomalia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "South Africa",
            'alias' => 'countrySouthAfrica'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "South Sudan",
            'alias' => 'countrySouthSudan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Spain",
            'alias' => 'countrySpain'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Sri Lanka",
            'alias' => 'countrySriLanka'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Sudan",
            'alias' => 'countrySudan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Suriname",
            'alias' => 'countrySuriname'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Sweden",
            'alias' => 'countrySweden'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Switzerland",
            'alias' => 'countrySwitzerland'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Syria",
            'alias' => 'countrySyria'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Taiwan",
            'alias' => 'countryTaiwan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Tajikistan",
            'alias' => 'countryTajikistan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Tanzania",
            'alias' => 'countryTanzania'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Thailand",
            'alias' => 'countryThailand'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Timor-Leste",
            'alias' => 'countryTimorLeste'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Togo",
            'alias' => 'countryTogo'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Tonga",
            'alias' => 'countryTonga'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Trinidad and Tobago",
            'alias' => 'countryTrinidadAndTobago'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Tunisia",
            'alias' => 'countryTunisia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Turkey",
            'alias' => 'countryTurkey'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Turkmenistan",
            'alias' => 'countryTurkmenistan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Tuvalu",
            'alias' => 'countryTuvalu'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Uganda",
            'alias' => 'countryUganda'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Ukraine",
            'alias' => 'countryUkraine'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "United Arab Emirates",
            'alias' => 'countryUnitedArabEmirates'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "United Kingdom",
            'alias' => 'countryUnitedKingdom'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Uruguay",
            'alias' => 'countryUruguay'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Uzbekistan",
            'alias' => 'countryUzbekistan'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Vanuatu",
            'alias' => 'countryVanuatu'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Vatican City",
            'alias' => 'countryVaticanCity'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Venezuela",
            'alias' => 'countryVenezuela'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Vietnam",
            'alias' => 'countryVietnam'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Yemen",
            'alias' => 'countryYemen'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Zambia",
            'alias' => 'countryZambia'
        ]);

        DomainValue::factory()->create([
            'domain_id' => Domain::where('alias', 'country')->first()->id,
            'name' => "Zimbabwe",
            'alias' => 'countryZimbabwe'
        ]);


    }
}
