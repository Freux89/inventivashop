<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('countries')->delete();
        
        \DB::table('countries')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'AF',
                'name' => 'Afghanistan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'AL',
                'name' => 'Albania',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'DZ',
                'name' => 'Algeria',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'AS',
                'name' => 'American Samoa',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'AD',
                'name' => 'Andorra',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'AO',
                'name' => 'Angola',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'AI',
                'name' => 'Anguilla',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'AQ',
                'name' => 'Antarctica',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'AG',
                'name' => 'Antigua And Barbuda',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'AR',
                'name' => 'Argentina',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'AM',
                'name' => 'Armenia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'AW',
                'name' => 'Aruba',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 'AU',
                'name' => 'Australia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 'AT',
                'name' => 'Austria',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'code' => 'AZ',
                'name' => 'Azerbaijan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'code' => 'BS',
                'name' => 'Bahamas The',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'code' => 'BH',
                'name' => 'Bahrain',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'code' => 'BD',
                'name' => 'Bangladesh',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => '2021-09-28 08:16:11',
            ),
            18 => 
            array (
                'id' => 19,
                'code' => 'BB',
                'name' => 'Barbados',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'code' => 'BY',
                'name' => 'Belarus',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'code' => 'BE',
                'name' => 'Belgium',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'code' => 'BZ',
                'name' => 'Belize',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'code' => 'BJ',
                'name' => 'Benin',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'code' => 'BM',
                'name' => 'Bermuda',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'code' => 'BT',
                'name' => 'Bhutan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'code' => 'BO',
                'name' => 'Bolivia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'code' => 'BA',
                'name' => 'Bosnia and Herzegovina',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'code' => 'BW',
                'name' => 'Botswana',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'code' => 'BV',
                'name' => 'Bouvet Island',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'code' => 'BR',
                'name' => 'Brazil',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'code' => 'IO',
                'name' => 'British Indian Ocean Territory',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'code' => 'BN',
                'name' => 'Brunei',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'code' => 'BG',
                'name' => 'Bulgaria',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'code' => 'BF',
                'name' => 'Burkina Faso',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'code' => 'BI',
                'name' => 'Burundi',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'code' => 'KH',
                'name' => 'Cambodia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'code' => 'CM',
                'name' => 'Cameroon',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'code' => 'CA',
                'name' => 'Canada',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'code' => 'CV',
                'name' => 'Cape Verde',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'code' => 'KY',
                'name' => 'Cayman Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'code' => 'CF',
                'name' => 'Central African Republic',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'code' => 'TD',
                'name' => 'Chad',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'code' => 'CL',
                'name' => 'Chile',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'code' => 'CN',
                'name' => 'China',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'code' => 'CX',
                'name' => 'Christmas Island',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'code' => 'CC',
            'name' => 'Cocos (Keeling) Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'code' => 'CO',
                'name' => 'Colombia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 48,
                'code' => 'KM',
                'name' => 'Comoros',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 49,
                'code' => 'CG',
                'name' => 'Republic Of The Congo',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 50,
                'code' => 'CD',
                'name' => 'Democratic Republic Of The Congo',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 51,
                'code' => 'CK',
                'name' => 'Cook Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 52,
                'code' => 'CR',
                'name' => 'Costa Rica',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 53,
                'code' => 'CI',
            'name' => 'Cote D\'Ivoire (Ivory Coast)',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 54,
                'code' => 'HR',
            'name' => 'Croatia (Hrvatska)',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 55,
                'code' => 'CU',
                'name' => 'Cuba',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 56,
                'code' => 'CY',
                'name' => 'Cyprus',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'id' => 57,
                'code' => 'CZ',
                'name' => 'Czech Republic',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'id' => 58,
                'code' => 'DK',
                'name' => 'Denmark',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            58 => 
            array (
                'id' => 59,
                'code' => 'DJ',
                'name' => 'Djibouti',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            59 => 
            array (
                'id' => 60,
                'code' => 'DM',
                'name' => 'Dominica',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            60 => 
            array (
                'id' => 61,
                'code' => 'DO',
                'name' => 'Dominican Republic',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            61 => 
            array (
                'id' => 62,
                'code' => 'TP',
                'name' => 'East Timor',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            62 => 
            array (
                'id' => 63,
                'code' => 'EC',
                'name' => 'Ecuador',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            63 => 
            array (
                'id' => 64,
                'code' => 'EG',
                'name' => 'Egypt',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            64 => 
            array (
                'id' => 65,
                'code' => 'SV',
                'name' => 'El Salvador',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            65 => 
            array (
                'id' => 66,
                'code' => 'GQ',
                'name' => 'Equatorial Guinea',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            66 => 
            array (
                'id' => 67,
                'code' => 'ER',
                'name' => 'Eritrea',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            67 => 
            array (
                'id' => 68,
                'code' => 'EE',
                'name' => 'Estonia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            68 => 
            array (
                'id' => 69,
                'code' => 'ET',
                'name' => 'Ethiopia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            69 => 
            array (
                'id' => 70,
                'code' => 'XA',
                'name' => 'External Territories of Australia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            70 => 
            array (
                'id' => 71,
                'code' => 'FK',
                'name' => 'Falkland Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            71 => 
            array (
                'id' => 72,
                'code' => 'FO',
                'name' => 'Faroe Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            72 => 
            array (
                'id' => 73,
                'code' => 'FJ',
                'name' => 'Fiji Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            73 => 
            array (
                'id' => 74,
                'code' => 'FI',
                'name' => 'Finland',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            74 => 
            array (
                'id' => 75,
                'code' => 'FR',
                'name' => 'France',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            75 => 
            array (
                'id' => 76,
                'code' => 'GF',
                'name' => 'French Guiana',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            76 => 
            array (
                'id' => 77,
                'code' => 'PF',
                'name' => 'French Polynesia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            77 => 
            array (
                'id' => 78,
                'code' => 'TF',
                'name' => 'French Southern Territories',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            78 => 
            array (
                'id' => 79,
                'code' => 'GA',
                'name' => 'Gabon',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            79 => 
            array (
                'id' => 80,
                'code' => 'GM',
                'name' => 'Gambia The',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            80 => 
            array (
                'id' => 81,
                'code' => 'GE',
                'name' => 'Georgia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            81 => 
            array (
                'id' => 82,
                'code' => 'DE',
                'name' => 'Germany',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            82 => 
            array (
                'id' => 83,
                'code' => 'GH',
                'name' => 'Ghana',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            83 => 
            array (
                'id' => 84,
                'code' => 'GI',
                'name' => 'Gibraltar',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            84 => 
            array (
                'id' => 85,
                'code' => 'GR',
                'name' => 'Greece',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            85 => 
            array (
                'id' => 86,
                'code' => 'GL',
                'name' => 'Greenland',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            86 => 
            array (
                'id' => 87,
                'code' => 'GD',
                'name' => 'Grenada',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            87 => 
            array (
                'id' => 88,
                'code' => 'GP',
                'name' => 'Guadeloupe',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            88 => 
            array (
                'id' => 89,
                'code' => 'GU',
                'name' => 'Guam',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            89 => 
            array (
                'id' => 90,
                'code' => 'GT',
                'name' => 'Guatemala',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            90 => 
            array (
                'id' => 91,
                'code' => 'XU',
                'name' => 'Guernsey and Alderney',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            91 => 
            array (
                'id' => 92,
                'code' => 'GN',
                'name' => 'Guinea',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            92 => 
            array (
                'id' => 93,
                'code' => 'GW',
                'name' => 'Guinea-Bissau',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            93 => 
            array (
                'id' => 94,
                'code' => 'GY',
                'name' => 'Guyana',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            94 => 
            array (
                'id' => 95,
                'code' => 'HT',
                'name' => 'Haiti',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            95 => 
            array (
                'id' => 96,
                'code' => 'HM',
                'name' => 'Heard and McDonald Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            96 => 
            array (
                'id' => 97,
                'code' => 'HN',
                'name' => 'Honduras',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            97 => 
            array (
                'id' => 98,
                'code' => 'HK',
                'name' => 'Hong Kong S.A.R.',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            98 => 
            array (
                'id' => 99,
                'code' => 'HU',
                'name' => 'Hungary',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            99 => 
            array (
                'id' => 100,
                'code' => 'IS',
                'name' => 'Iceland',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            100 => 
            array (
                'id' => 101,
                'code' => 'IN',
                'name' => 'India',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            101 => 
            array (
                'id' => 102,
                'code' => 'ID',
                'name' => 'Indonesia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            102 => 
            array (
                'id' => 103,
                'code' => 'IR',
                'name' => 'Iran',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            103 => 
            array (
                'id' => 104,
                'code' => 'IQ',
                'name' => 'Iraq',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            104 => 
            array (
                'id' => 105,
                'code' => 'IE',
                'name' => 'Ireland',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            105 => 
            array (
                'id' => 106,
                'code' => 'IL',
                'name' => 'Israel',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            106 => 
            array (
                'id' => 107,
                'code' => 'IT',
                'name' => 'Italy',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            107 => 
            array (
                'id' => 108,
                'code' => 'JM',
                'name' => 'Jamaica',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            108 => 
            array (
                'id' => 109,
                'code' => 'JP',
                'name' => 'Japan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            109 => 
            array (
                'id' => 110,
                'code' => 'XJ',
                'name' => 'Jersey',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            110 => 
            array (
                'id' => 111,
                'code' => 'JO',
                'name' => 'Jordan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            111 => 
            array (
                'id' => 112,
                'code' => 'KZ',
                'name' => 'Kazakhstan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            112 => 
            array (
                'id' => 113,
                'code' => 'KE',
                'name' => 'Kenya',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            113 => 
            array (
                'id' => 114,
                'code' => 'KI',
                'name' => 'Kiribati',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            114 => 
            array (
                'id' => 115,
                'code' => 'KP',
                'name' => 'Korea North',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            115 => 
            array (
                'id' => 116,
                'code' => 'KR',
                'name' => 'Korea South',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            116 => 
            array (
                'id' => 117,
                'code' => 'KW',
                'name' => 'Kuwait',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            117 => 
            array (
                'id' => 118,
                'code' => 'KG',
                'name' => 'Kyrgyzstan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            118 => 
            array (
                'id' => 119,
                'code' => 'LA',
                'name' => 'Laos',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            119 => 
            array (
                'id' => 120,
                'code' => 'LV',
                'name' => 'Latvia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            120 => 
            array (
                'id' => 121,
                'code' => 'LB',
                'name' => 'Lebanon',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            121 => 
            array (
                'id' => 122,
                'code' => 'LS',
                'name' => 'Lesotho',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            122 => 
            array (
                'id' => 123,
                'code' => 'LR',
                'name' => 'Liberia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            123 => 
            array (
                'id' => 124,
                'code' => 'LY',
                'name' => 'Libya',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            124 => 
            array (
                'id' => 125,
                'code' => 'LI',
                'name' => 'Liechtenstein',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            125 => 
            array (
                'id' => 126,
                'code' => 'LT',
                'name' => 'Lithuania',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            126 => 
            array (
                'id' => 127,
                'code' => 'LU',
                'name' => 'Luxembourg',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            127 => 
            array (
                'id' => 128,
                'code' => 'MO',
                'name' => 'Macau S.A.R.',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            128 => 
            array (
                'id' => 129,
                'code' => 'MK',
                'name' => 'Macedonia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            129 => 
            array (
                'id' => 130,
                'code' => 'MG',
                'name' => 'Madagascar',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            130 => 
            array (
                'id' => 131,
                'code' => 'MW',
                'name' => 'Malawi',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            131 => 
            array (
                'id' => 132,
                'code' => 'MY',
                'name' => 'Malaysia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            132 => 
            array (
                'id' => 133,
                'code' => 'MV',
                'name' => 'Maldives',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            133 => 
            array (
                'id' => 134,
                'code' => 'ML',
                'name' => 'Mali',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            134 => 
            array (
                'id' => 135,
                'code' => 'MT',
                'name' => 'Malta',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            135 => 
            array (
                'id' => 136,
                'code' => 'XM',
            'name' => 'Man (Isle of)',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            136 => 
            array (
                'id' => 137,
                'code' => 'MH',
                'name' => 'Marshall Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            137 => 
            array (
                'id' => 138,
                'code' => 'MQ',
                'name' => 'Martinique',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            138 => 
            array (
                'id' => 139,
                'code' => 'MR',
                'name' => 'Mauritania',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            139 => 
            array (
                'id' => 140,
                'code' => 'MU',
                'name' => 'Mauritius',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            140 => 
            array (
                'id' => 141,
                'code' => 'YT',
                'name' => 'Mayotte',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            141 => 
            array (
                'id' => 142,
                'code' => 'MX',
                'name' => 'Mexico',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            142 => 
            array (
                'id' => 143,
                'code' => 'FM',
                'name' => 'Micronesia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            143 => 
            array (
                'id' => 144,
                'code' => 'MD',
                'name' => 'Moldova',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            144 => 
            array (
                'id' => 145,
                'code' => 'MC',
                'name' => 'Monaco',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            145 => 
            array (
                'id' => 146,
                'code' => 'MN',
                'name' => 'Mongolia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            146 => 
            array (
                'id' => 147,
                'code' => 'MS',
                'name' => 'Montserrat',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            147 => 
            array (
                'id' => 148,
                'code' => 'MA',
                'name' => 'Morocco',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            148 => 
            array (
                'id' => 149,
                'code' => 'MZ',
                'name' => 'Mozambique',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            149 => 
            array (
                'id' => 150,
                'code' => 'MM',
                'name' => 'Myanmar',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            150 => 
            array (
                'id' => 151,
                'code' => 'NA',
                'name' => 'Namibia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            151 => 
            array (
                'id' => 152,
                'code' => 'NR',
                'name' => 'Nauru',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            152 => 
            array (
                'id' => 153,
                'code' => 'NP',
                'name' => 'Nepal',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            153 => 
            array (
                'id' => 154,
                'code' => 'AN',
                'name' => 'Netherlands Antilles',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            154 => 
            array (
                'id' => 155,
                'code' => 'NL',
                'name' => 'Netherlands The',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            155 => 
            array (
                'id' => 156,
                'code' => 'NC',
                'name' => 'New Caledonia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            156 => 
            array (
                'id' => 157,
                'code' => 'NZ',
                'name' => 'New Zealand',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            157 => 
            array (
                'id' => 158,
                'code' => 'NI',
                'name' => 'Nicaragua',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            158 => 
            array (
                'id' => 159,
                'code' => 'NE',
                'name' => 'Niger',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            159 => 
            array (
                'id' => 160,
                'code' => 'NG',
                'name' => 'Nigeria',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            160 => 
            array (
                'id' => 161,
                'code' => 'NU',
                'name' => 'Niue',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            161 => 
            array (
                'id' => 162,
                'code' => 'NF',
                'name' => 'Norfolk Island',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            162 => 
            array (
                'id' => 163,
                'code' => 'MP',
                'name' => 'Northern Mariana Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            163 => 
            array (
                'id' => 164,
                'code' => 'NO',
                'name' => 'Norway',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            164 => 
            array (
                'id' => 165,
                'code' => 'OM',
                'name' => 'Oman',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            165 => 
            array (
                'id' => 166,
                'code' => 'PK',
                'name' => 'Pakistan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            166 => 
            array (
                'id' => 167,
                'code' => 'PW',
                'name' => 'Palau',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            167 => 
            array (
                'id' => 168,
                'code' => 'PS',
                'name' => 'Palestinian Territory Occupied',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            168 => 
            array (
                'id' => 169,
                'code' => 'PA',
                'name' => 'Panama',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            169 => 
            array (
                'id' => 170,
                'code' => 'PG',
                'name' => 'Papua new Guinea',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            170 => 
            array (
                'id' => 171,
                'code' => 'PY',
                'name' => 'Paraguay',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            171 => 
            array (
                'id' => 172,
                'code' => 'PE',
                'name' => 'Peru',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            172 => 
            array (
                'id' => 173,
                'code' => 'PH',
                'name' => 'Philippines',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            173 => 
            array (
                'id' => 174,
                'code' => 'PN',
                'name' => 'Pitcairn Island',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            174 => 
            array (
                'id' => 175,
                'code' => 'PL',
                'name' => 'Poland',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            175 => 
            array (
                'id' => 176,
                'code' => 'PT',
                'name' => 'Portugal',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            176 => 
            array (
                'id' => 177,
                'code' => 'PR',
                'name' => 'Puerto Rico',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            177 => 
            array (
                'id' => 178,
                'code' => 'QA',
                'name' => 'Qatar',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            178 => 
            array (
                'id' => 179,
                'code' => 'RE',
                'name' => 'Reunion',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            179 => 
            array (
                'id' => 180,
                'code' => 'RO',
                'name' => 'Romania',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            180 => 
            array (
                'id' => 181,
                'code' => 'RU',
                'name' => 'Russia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            181 => 
            array (
                'id' => 182,
                'code' => 'RW',
                'name' => 'Rwanda',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            182 => 
            array (
                'id' => 183,
                'code' => 'SH',
                'name' => 'Saint Helena',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            183 => 
            array (
                'id' => 184,
                'code' => 'KN',
                'name' => 'Saint Kitts And Nevis',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            184 => 
            array (
                'id' => 185,
                'code' => 'LC',
                'name' => 'Saint Lucia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            185 => 
            array (
                'id' => 186,
                'code' => 'PM',
                'name' => 'Saint Pierre and Miquelon',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            186 => 
            array (
                'id' => 187,
                'code' => 'VC',
                'name' => 'Saint Vincent And The Grenadines',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            187 => 
            array (
                'id' => 188,
                'code' => 'WS',
                'name' => 'Samoa',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            188 => 
            array (
                'id' => 189,
                'code' => 'SM',
                'name' => 'San Marino',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            189 => 
            array (
                'id' => 190,
                'code' => 'ST',
                'name' => 'Sao Tome and Principe',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            190 => 
            array (
                'id' => 191,
                'code' => 'SA',
                'name' => 'Saudi Arabia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            191 => 
            array (
                'id' => 192,
                'code' => 'SN',
                'name' => 'Senegal',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            192 => 
            array (
                'id' => 193,
                'code' => 'RS',
                'name' => 'Serbia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            193 => 
            array (
                'id' => 194,
                'code' => 'SC',
                'name' => 'Seychelles',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            194 => 
            array (
                'id' => 195,
                'code' => 'SL',
                'name' => 'Sierra Leone',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            195 => 
            array (
                'id' => 196,
                'code' => 'SG',
                'name' => 'Singapore',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            196 => 
            array (
                'id' => 197,
                'code' => 'SK',
                'name' => 'Slovakia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            197 => 
            array (
                'id' => 198,
                'code' => 'SI',
                'name' => 'Slovenia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            198 => 
            array (
                'id' => 199,
                'code' => 'XG',
                'name' => 'Smaller Territories of the UK',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            199 => 
            array (
                'id' => 200,
                'code' => 'SB',
                'name' => 'Solomon Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            200 => 
            array (
                'id' => 201,
                'code' => 'SO',
                'name' => 'Somalia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            201 => 
            array (
                'id' => 202,
                'code' => 'ZA',
                'name' => 'South Africa',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            202 => 
            array (
                'id' => 203,
                'code' => 'GS',
                'name' => 'South Georgia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            203 => 
            array (
                'id' => 204,
                'code' => 'SS',
                'name' => 'South Sudan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            204 => 
            array (
                'id' => 205,
                'code' => 'ES',
                'name' => 'Spain',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            205 => 
            array (
                'id' => 206,
                'code' => 'LK',
                'name' => 'Sri Lanka',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            206 => 
            array (
                'id' => 207,
                'code' => 'SD',
                'name' => 'Sudan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            207 => 
            array (
                'id' => 208,
                'code' => 'SR',
                'name' => 'Suriname',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            208 => 
            array (
                'id' => 209,
                'code' => 'SJ',
                'name' => 'Svalbard And Jan Mayen Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            209 => 
            array (
                'id' => 210,
                'code' => 'SZ',
                'name' => 'Swaziland',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            210 => 
            array (
                'id' => 211,
                'code' => 'SE',
                'name' => 'Sweden',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            211 => 
            array (
                'id' => 212,
                'code' => 'CH',
                'name' => 'Switzerland',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            212 => 
            array (
                'id' => 213,
                'code' => 'SY',
                'name' => 'Syria',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            213 => 
            array (
                'id' => 214,
                'code' => 'TW',
                'name' => 'Taiwan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            214 => 
            array (
                'id' => 215,
                'code' => 'TJ',
                'name' => 'Tajikistan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            215 => 
            array (
                'id' => 216,
                'code' => 'TZ',
                'name' => 'Tanzania',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            216 => 
            array (
                'id' => 217,
                'code' => 'TH',
                'name' => 'Thailand',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            217 => 
            array (
                'id' => 218,
                'code' => 'TG',
                'name' => 'Togo',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            218 => 
            array (
                'id' => 219,
                'code' => 'TK',
                'name' => 'Tokelau',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            219 => 
            array (
                'id' => 220,
                'code' => 'TO',
                'name' => 'Tonga',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            220 => 
            array (
                'id' => 221,
                'code' => 'TT',
                'name' => 'Trinidad And Tobago',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            221 => 
            array (
                'id' => 222,
                'code' => 'TN',
                'name' => 'Tunisia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            222 => 
            array (
                'id' => 223,
                'code' => 'TR',
                'name' => 'Turkey',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            223 => 
            array (
                'id' => 224,
                'code' => 'TM',
                'name' => 'Turkmenistan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            224 => 
            array (
                'id' => 225,
                'code' => 'TC',
                'name' => 'Turks And Caicos Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            225 => 
            array (
                'id' => 226,
                'code' => 'TV',
                'name' => 'Tuvalu',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            226 => 
            array (
                'id' => 227,
                'code' => 'UG',
                'name' => 'Uganda',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            227 => 
            array (
                'id' => 228,
                'code' => 'UA',
                'name' => 'Ukraine',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            228 => 
            array (
                'id' => 229,
                'code' => 'AE',
                'name' => 'United Arab Emirates',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            229 => 
            array (
                'id' => 230,
                'code' => 'GB',
                'name' => 'United Kingdom',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            230 => 
            array (
                'id' => 231,
                'code' => 'US',
                'name' => 'United States',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => '2021-11-02 14:24:38',
            ),
            231 => 
            array (
                'id' => 232,
                'code' => 'UM',
                'name' => 'United States Minor Outlying Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            232 => 
            array (
                'id' => 233,
                'code' => 'UY',
                'name' => 'Uruguay',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            233 => 
            array (
                'id' => 234,
                'code' => 'UZ',
                'name' => 'Uzbekistan',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            234 => 
            array (
                'id' => 235,
                'code' => 'VU',
                'name' => 'Vanuatu',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            235 => 
            array (
                'id' => 236,
                'code' => 'VA',
                'name' => 'Vatican City State (Holy See)',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            236 => 
            array (
                'id' => 237,
                'code' => 'VE',
                'name' => 'Venezuela',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            237 => 
            array (
                'id' => 238,
                'code' => 'VN',
                'name' => 'Vietnam',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            238 => 
            array (
                'id' => 239,
                'code' => 'VG',
                'name' => 'Virgin Islands (British)',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            239 => 
            array (
                'id' => 240,
                'code' => 'VI',
                'name' => 'Virgin Islands (US)',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            240 => 
            array (
                'id' => 241,
                'code' => 'WF',
                'name' => 'Wallis And Futuna Islands',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            241 => 
            array (
                'id' => 242,
                'code' => 'EH',
                'name' => 'Western Sahara',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            242 => 
            array (
                'id' => 243,
                'code' => 'YE',
                'name' => 'Yemen',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            243 => 
            array (
                'id' => 244,
                'code' => 'YU',
                'name' => 'Yugoslavia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            244 => 
            array (
                'id' => 245,
                'code' => 'ZM',
                'name' => 'Zambia',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
            245 => 
            array (
                'id' => 246,
                'code' => 'ZW',
                'name' => 'Zimbabwe',
                'is_active' => 0,
                'created_at' => '2021-04-06 13:06:30',
                'updated_at' => NULL,
            ),
        )); 
    }
}