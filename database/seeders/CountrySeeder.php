<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            ['name' => "Austria", 'alpha_2_code' => 'AT', 'alpha_3_code' => 'AUT', 'numeric_code' => '040', 'calling_code' => '+43' ],
            ['name' => "Belgium", 'alpha_2_code' => 'BE', 'alpha_3_code' => 'BEL', 'numeric_code' => '056', 'calling_code' => '+32' ],
            ['name' => "Bulgaria", 'alpha_2_code' => 'BG', 'alpha_3_code' => 'BGR', 'numeric_code' => '100', 'calling_code' => '+359' ],
            ['name' => "Croatia", 'alpha_2_code' => 'HR', 'alpha_3_code' => 'HRV', 'numeric_code' => '191', 'calling_code' => '+385' ],
            ['name' => "Cyprus", 'alpha_2_code' => 'CY', 'alpha_3_code' => 'CYP', 'numeric_code' => '196', 'calling_code' => '+357' ],
            ['name' => "Czech Republic", 'alpha_2_code' => 'CZ', 'alpha_3_code' => 'CZE', 'numeric_code' => '203', 'calling_code' => '+420' ],
            ['name' => "Denmark", 'alpha_2_code' => 'DK', 'alpha_3_code' => 'DNK', 'numeric_code' => '208', 'calling_code' => '+45' ],
            ['name' => "Estonia", 'alpha_2_code' => 'EE', 'alpha_3_code' => 'EST', 'numeric_code' => '233', 'calling_code' => '+372' ],
            ['name' => "Finland", 'alpha_2_code' => 'FI', 'alpha_3_code' => 'FIN', 'numeric_code' => '246', 'calling_code' => '+358' ],
            ['name' => "France", 'alpha_2_code' => 'FR', 'alpha_3_code' => 'FRA', 'numeric_code' => '250', 'calling_code' => '+33' ],
            ['name' => "Germany", 'alpha_2_code' => 'DE', 'alpha_3_code' => 'DEU', 'numeric_code' => '276', 'calling_code' => '+49' ],
            ['name' => "Greece", 'alpha_2_code' => 'GR', 'alpha_3_code' => 'GRC', 'numeric_code' => '300', 'calling_code' => '+30' ],
            ['name' => "Hungary", 'alpha_2_code' => 'HU', 'alpha_3_code' => 'HUN', 'numeric_code' => '348', 'calling_code' => '+36' ],
            ['name' => "Ireland", 'alpha_2_code' => 'IE', 'alpha_3_code' => 'IRL', 'numeric_code' => '372', 'calling_code' => '+353' ],
            ['name' => "Iceland", 'alpha_2_code' => 'IS', 'alpha_3_code' => 'ISL', 'numeric_code' => '352', 'calling_code' => '+354' ],
            ['name' => "Italy", 'alpha_2_code' => 'IT', 'alpha_3_code' => 'ITA', 'numeric_code' => '380', 'calling_code' => '+39' ],
            ['name' => "Latvia", 'alpha_2_code' => 'LV', 'alpha_3_code' => 'LVA', 'numeric_code' => '428', 'calling_code' => '+371' ],
            ['name' => "Lithuania", 'alpha_2_code' => 'LT', 'alpha_3_code' => 'LTU', 'numeric_code' => '440', 'calling_code' => '+370' ],
            ['name' => "Liechtenstein", 'alpha_2_code' => 'LI', 'alpha_3_code' => 'LIE', 'numeric_code' => '438', 'calling_code' => '+423' ],
            ['name' => "Luxembourg", 'alpha_2_code' => 'LU', 'alpha_3_code' => 'LUX', 'numeric_code' => '442', 'calling_code' => '+352' ],
            ['name' => "Malta", 'alpha_2_code' => 'MT', 'alpha_3_code' => 'MLT', 'numeric_code' => '470', 'calling_code' => '+356' ],
            ['name' => "Netherlands", 'alpha_2_code' => 'NL', 'alpha_3_code' => 'NLD', 'numeric_code' => '528', 'calling_code' => '+31' ],
            ['name' => "Norway", 'alpha_2_code' => 'NO', 'alpha_3_code' => 'NOR', 'numeric_code' => '578', 'calling_code' => '+47' ],
            ['name' => "Poland", 'alpha_2_code' => 'PL', 'alpha_3_code' => 'POL', 'numeric_code' => '616', 'calling_code' => '+48' ],
            ['name' => "Portugal", 'alpha_2_code' => 'PR', 'alpha_3_code' => 'PRT', 'numeric_code' => '620', 'calling_code' => '+351' ],
            ['name' => "Romania", 'alpha_2_code' => 'RO', 'alpha_3_code' => 'ROU', 'numeric_code' => '642', 'calling_code' => '+40' ],
            ['name' => "Slovakia", 'alpha_2_code' => 'SK', 'alpha_3_code' => 'SVK', 'numeric_code' => '703', 'calling_code' => '+421' ],
            ['name' => "Slovenia", 'alpha_2_code' => 'SI', 'alpha_3_code' => 'SVN', 'numeric_code' => '705', 'calling_code' => '+386' ],
            ['name' => "Spain", 'alpha_2_code' => 'ES', 'alpha_3_code' => 'ESP', 'numeric_code' => '724', 'calling_code' => '+34' ],
            ['name' => "Sweden", 'alpha_2_code' => 'SE', 'alpha_3_code' => 'SWE', 'numeric_code' => '752', 'calling_code' => '+46' ],
            ['name' => "United Kingdom", 'alpha_2_code' => 'GB', 'alpha_3_code' => 'GBR', 'numeric_code' => '826', 'calling_code' => '+44' ],
        ]);
    }
}
