<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class Dbass extends Controller
{
    //
    public function airport(){
        $consonants = ['B','C','D','F','G','H','J','K','L','M','N','P','Q','R','S','T','V','W','X','Y','Z'];
        $vowels = ['A','E','I','O','U'];


        $country = ["Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola",
             "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia",
            "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium",
            "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana",
            "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria",
            "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands",
            "Central African Republic", "Chad", "Chile", "China", "Christmas Island",
            "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the",
            "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus",
            "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor",
            "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia",
            "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France",
            "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories",
            "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland",
            "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti",
            "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"];

//             $countries =
// [
// 	'AF' => 'Afghanistan',
// 	'AX' => 'Aland Islands',
// 	'AL' => 'Albania',
// 	'DZ' => 'Algeria',
// 	'AS' => 'American Samoa',
// 	'AD' => 'Andorra',
// 	'AO' => 'Angola',
// 	'AI' => 'Anguilla',
// 	'AQ' => 'Antarctica',
// 	'AG' => 'Antigua And Barbuda',
// 	'AR' => 'Argentina',
// 	'AM' => 'Armenia',
// 	'AW' => 'Aruba',
// 	'AU' => 'Australia',
// 	'AT' => 'Austria',
// 	'AZ' => 'Azerbaijan',
// 	'BS' => 'Bahamas',
// 	'BH' => 'Bahrain',
// 	'BD' => 'Bangladesh',
// 	'BB' => 'Barbados',
// 	'BY' => 'Belarus',
// 	'BE' => 'Belgium',
// 	'BZ' => 'Belize',
// 	'BJ' => 'Benin',
// 	'BM' => 'Bermuda',
// 	'BT' => 'Bhutan',
// 	'BO' => 'Bolivia',
// 	'BA' => 'Bosnia And Herzegovina',
// 	'BW' => 'Botswana',
// 	'BV' => 'Bouvet Island',
// 	'BR' => 'Brazil',
// 	'IO' => 'British Indian Ocean Territory',
// 	'BN' => 'Brunei Darussalam',
// 	'BG' => 'Bulgaria',
// 	'BF' => 'Burkina Faso',
// 	'BI' => 'Burundi',
// 	'KH' => 'Cambodia',
// 	'CM' => 'Cameroon',
// 	'CA' => 'Canada',
// 	'CV' => 'Cape Verde',
// 	'KY' => 'Cayman Islands',
// 	'CF' => 'Central African Republic',
// 	'TD' => 'Chad',
// 	'CL' => 'Chile',
// 	'CN' => 'China',
// 	'CX' => 'Christmas Island',
// 	'CC' => 'Cocos (Keeling) Islands',
// 	'CO' => 'Colombia',
// 	'KM' => 'Comoros',
// 	'CG' => 'Congo',
// 	'CD' => 'Congo, Democratic Republic',
// 	'CK' => 'Cook Islands',
// 	'CR' => 'Costa Rica',
// 	'CI' => 'Cote D\'Ivoire',
// 	'HR' => 'Croatia',
// 	'CU' => 'Cuba',
// 	'CY' => 'Cyprus',
// 	'CZ' => 'Czech Republic',
// 	'DK' => 'Denmark',
// 	'DJ' => 'Djibouti',
// 	'DM' => 'Dominica',
// 	'DO' => 'Dominican Republic',
// 	'EC' => 'Ecuador',
// 	'EG' => 'Egypt',
// 	'SV' => 'El Salvador',
// 	'GQ' => 'Equatorial Guinea',
// 	'ER' => 'Eritrea',
// 	'EE' => 'Estonia',
// 	'ET' => 'Ethiopia',
// 	'FK' => 'Falkland Islands (Malvinas)',
// 	'FO' => 'Faroe Islands',
// 	'FJ' => 'Fiji',
// 	'FI' => 'Finland',
// 	'FR' => 'France',
// 	'GF' => 'French Guiana',
// 	'PF' => 'French Polynesia',
// 	'TF' => 'French Southern Territories',
// 	'GA' => 'Gabon',
// 	'GM' => 'Gambia',
// 	'GE' => 'Georgia',
// 	'DE' => 'Germany',
// 	'GH' => 'Ghana',
// 	'GI' => 'Gibraltar',
// 	'GR' => 'Greece',
// 	'GL' => 'Greenland',
// 	'GD' => 'Grenada',
// 	'GP' => 'Guadeloupe',
// 	'GU' => 'Guam',
// 	'GT' => 'Guatemala',
// 	'GG' => 'Guernsey',
// 	'GN' => 'Guinea',
// 	'GW' => 'Guinea-Bissau',
// 	'GY' => 'Guyana',
// 	'HT' => 'Haiti',
// 	'HM' => 'Heard Island & Mcdonald Islands',
// 	'VA' => 'Holy See (Vatican City State)',
// 	'HN' => 'Honduras',
// 	'HK' => 'Hong Kong',
// 	'HU' => 'Hungary',
// 	'IS' => 'Iceland',
// 	'IN' => 'India',
// 	'ID' => 'Indonesia',
// 	'IR' => 'Iran, Islamic Republic Of',
// 	'IQ' => 'Iraq',
// 	'IE' => 'Ireland',
// 	'IM' => 'Isle Of Man',
// 	'IL' => 'Israel',
// 	'IT' => 'Italy',
// 	'JM' => 'Jamaica',
// 	'JP' => 'Japan',
// 	'JE' => 'Jersey',
// 	'JO' => 'Jordan',
// 	'KZ' => 'Kazakhstan',
// 	'KE' => 'Kenya',
// 	'KI' => 'Kiribati',
// 	'KR' => 'Korea',
// 	'KW' => 'Kuwait',
// 	'KG' => 'Kyrgyzstan',
// 	'LA' => 'Lao People\'s Democratic Republic',
// 	'LV' => 'Latvia',
// 	'LB' => 'Lebanon',
// 	'LS' => 'Lesotho',
// 	'LR' => 'Liberia',
// 	'LY' => 'Libyan Arab Jamahiriya',
// 	'LI' => 'Liechtenstein',
// 	'LT' => 'Lithuania',
// 	'LU' => 'Luxembourg',
// 	'MO' => 'Macao',
// 	'MK' => 'Macedonia',
// 	'MG' => 'Madagascar',
// 	'MW' => 'Malawi',
// 	'MY' => 'Malaysia',
// 	'MV' => 'Maldives',
// 	'ML' => 'Mali',
// 	'MT' => 'Malta',
// 	'MH' => 'Marshall Islands',
// 	'MQ' => 'Martinique',
// 	'MR' => 'Mauritania',
// 	'MU' => 'Mauritius',
// 	'YT' => 'Mayotte',
// 	'MX' => 'Mexico',
// 	'FM' => 'Micronesia, Federated States Of',
// 	'MD' => 'Moldova',
// 	'MC' => 'Monaco',
// 	'MN' => 'Mongolia',
// 	'ME' => 'Montenegro',
// 	'MS' => 'Montserrat',
// 	'MA' => 'Morocco',
// 	'MZ' => 'Mozambique',
// 	'MM' => 'Myanmar',
// 	'NA' => 'Namibia',
// 	'NR' => 'Nauru',
// 	'NP' => 'Nepal',
// 	'NL' => 'Netherlands',
// 	'AN' => 'Netherlands Antilles',
// 	'NC' => 'New Caledonia',
// 	'NZ' => 'New Zealand',
// 	'NI' => 'Nicaragua',
// 	'NE' => 'Niger',
// 	'NG' => 'Nigeria',
// 	'NU' => 'Niue',
// 	'NF' => 'Norfolk Island',
// 	'MP' => 'Northern Mariana Islands',
// 	'NO' => 'Norway',
// 	'OM' => 'Oman',
// 	'PK' => 'Pakistan',
// 	'PW' => 'Palau',
// 	'PS' => 'Palestinian Territory, Occupied',
// 	'PA' => 'Panama',
// 	'PG' => 'Papua New Guinea',
// 	'PY' => 'Paraguay',
// 	'PE' => 'Peru',
// 	'PH' => 'Philippines',
// 	'PN' => 'Pitcairn',
// 	'PL' => 'Poland',
// 	'PT' => 'Portugal',
// 	'PR' => 'Puerto Rico',
// 	'QA' => 'Qatar',
// 	'RE' => 'Reunion',
// 	'RO' => 'Romania',
// 	'RU' => 'Russian Federation',
// 	'RW' => 'Rwanda',
// 	'BL' => 'Saint Barthelemy',
// 	'SH' => 'Saint Helena',
// 	'KN' => 'Saint Kitts And Nevis',
// 	'LC' => 'Saint Lucia',
// 	'MF' => 'Saint Martin',
// 	'PM' => 'Saint Pierre And Miquelon',
// 	'VC' => 'Saint Vincent And Grenadines',
// 	'WS' => 'Samoa',
// 	'SM' => 'San Marino',
// 	'ST' => 'Sao Tome And Principe',
// 	'SA' => 'Saudi Arabia',
// 	'SN' => 'Senegal',
// 	'RS' => 'Serbia',
// 	'SC' => 'Seychelles',
// 	'SL' => 'Sierra Leone',
// 	'SG' => 'Singapore',
// 	'SK' => 'Slovakia',
// 	'SI' => 'Slovenia',
// 	'SB' => 'Solomon Islands',
// 	'SO' => 'Somalia',
// 	'ZA' => 'South Africa',
// 	'GS' => 'South Georgia And Sandwich Isl.',
// 	'ES' => 'Spain',
// 	'LK' => 'Sri Lanka',
// 	'SD' => 'Sudan',
// 	'SR' => 'Suriname',
// 	'SJ' => 'Svalbard And Jan Mayen',
// 	'SZ' => 'Swaziland',
// 	'SE' => 'Sweden',
// 	'CH' => 'Switzerland',
// 	'SY' => 'Syrian Arab Republic',
// 	'TW' => 'Taiwan',
// 	'TJ' => 'Tajikistan',
// 	'TZ' => 'Tanzania',
// 	'TH' => 'Thailand',
// 	'TL' => 'Timor-Leste',
// 	'TG' => 'Togo',
// 	'TK' => 'Tokelau',
// 	'TO' => 'Tonga',
// 	'TT' => 'Trinidad And Tobago',
// 	'TN' => 'Tunisia',
// 	'TR' => 'Turkey',
// 	'TM' => 'Turkmenistan',
// 	'TC' => 'Turks And Caicos Islands',
// 	'TV' => 'Tuvalu',
// 	'UG' => 'Uganda',
// 	'UA' => 'Ukraine',
// 	'AE' => 'United Arab Emirates',
// 	'GB' => 'United Kingdom',
// 	'US' => 'United States',
// 	'UM' => 'United States Outlying Islands',
// 	'UY' => 'Uruguay',
// 	'UZ' => 'Uzbekistan',
// 	'VU' => 'Vanuatu',
// 	'VE' => 'Venezuela',
// 	'VN' => 'Viet Nam',
// 	'VG' => 'Virgin Islands, British',
// 	'VI' => 'Virgin Islands, U.S.',
// 	'WF' => 'Wallis And Futuna',
// 	'EH' => 'Western Sahara',
// 	'YE' => 'Yemen',
// 	'ZM' => 'Zambia',
//     'ZW' => 'Zimbabwe'
// ];
        for($i = 0; $i < 50; $i++){
            $airportcode = "APT" . rand(100,999);
            $airportname = $consonants[rand(0,20)] . $vowels[rand(0,4)] . $consonants[rand(0,20)] . $vowels[rand(0,4)] . $consonants[rand(0,20)] . " Airport";
            $city = $consonants[rand(0,20)] . $vowels[rand(0,4)] . $consonants[rand(0,20)] . $vowels[rand(0,4)] . $consonants[rand(0,20)] . $vowels[rand(0,4)] . $consonants[rand(0,20)] ;



            DB::table('airport')->insert(['airportcode' => $airportcode, 'name' => $airportname,
            'city' => $city,
            'country' => $country[rand(0,(sizeof($country)-1))],]);
        }


       //return $airportcode . "<br />" . $airportname . "<br />" . $city . "<br />" . $country . "<br />";
       return "done";
    }

    public function flight(){
        $consonants = ['B','C','D','F','G','H','J','K','L','M','N','P','Q','R','S','T','V','W','X','Y','Z'];
        $vowels = ['A','E','I','O','U'];
        $flightnumber = [];

        for($i = 0; $i < 50; $i++){
            array_push($flightnumber, "Flight " . $i < 10 ? "0" . $i : $i);
        }
        $airlines = DB::table("airport")->get();
        $airliner = [];
        $aircode = [];
        foreach($airlines as $airline){
            array_push($airliner, $consonants[rand(0,20)] . $vowels[rand(0,4)] . $consonants[rand(0,20)] . $vowels[rand(0,4)] . $consonants[rand(0,20)] . " Airline");
            array_push($aircode, $airline->airportcode);
        }
        for($i = 0; $i < 50; $i++){
            DB::table('flight')->insert(['flightnumber' => "Flight " . $flightnumber[$i], 'airline' => $airliner[rand(0,49)],
            'from_airport_code' => $aircode[rand(0,49)],'to_airport_code' => $aircode[rand(0,49)] ]);

        }

        return "Done";
    }

    public function reservation(){
        $flights = DB::table('flight')->get();
        $consonants = ['B','C','D','F','G','H','J','K','L','M','N','P','Q','R','S','T','V','W','X','Y','Z'];
        $vowels = ['A','E','I','O','U'];

        foreach($flights as $flight){
            $date = rand(1,28) . "/" . rand(1,12) . "/2019";

            for($i = 0; $i < 5; $i++){

                $firstname = $consonants[rand(0,20)] . $vowels[rand(0,4)] . $consonants[rand(0,20)] . $vowels[rand(0,4)] . $consonants[rand(0,20)];
                $lastname = $consonants[rand(0,20)] . $vowels[rand(0,4)] . $consonants[rand(0,20)] . $vowels[rand(0,4)] . $consonants[rand(0,20)] . $vowels[rand(0,4)] . $consonants[rand(0,20)] ;

                $name = $lastname . " " . $firstname;

                DB::table('reservation')->insert(['flightnumber' => $flight->flightnumber, 'seat_number' => "ST" . ($i+1), 'date' => $date,
                'passanger_name' => $name]);
            }
        }
        return "Done";
    }
}
