<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Country::exists()) {
            return;
        }

        $countries = [
            ['code' => 'GE', 'en' => 'Georgia', 'ka' => 'საქართველო'],
            ['code' => 'ES', 'en' => 'Spain', 'ka' => 'ესპანეთი'],
            ['code' => 'DE', 'en' => 'Germany', 'ka' => 'გერმანია'],
            ['code' => 'IT', 'en' => 'Italy', 'ka' => 'იტალია'],
            ['code' => 'FR', 'en' => 'France', 'ka' => 'საფრანგეთი'],
            ['code' => 'BR', 'en' => 'Brazil', 'ka' => 'ბრაზილია'],
            ['code' => 'GB', 'en' => 'United Kingdom', 'ka' => 'დიდი ბრიტანეთი'],
            ['code' => 'AR', 'en' => 'Argentina', 'ka' => 'არგენტინა'],
        ];

        foreach ($countries as $country) {
            Country::create([
                'code' => $country['code'],
                'en' => ['name' => $country['en']],
                'ka' => ['name' => $country['ka']],
            ]);
        }
    }
}
