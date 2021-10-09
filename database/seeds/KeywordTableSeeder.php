<?php

use Illuminate\Database\Seeder;
use App\Keyword;
use App\Region;
use Illuminate\Support\Facades\DB;

class KeywordTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('keywords')->truncate();
        $filePath = storage_path() . '/data/keyword_list.csv';
        $key           = 0;
        $type          = '';
        $keyword       = [];
        $regex_station = '[station]';
        $regex_genre   = '[genre_id]';
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ( $key < 1 ) {
                    $key++;
                    continue;
                }
                $condition = !empty($data[4]) ? $data[4] : '';

                if ($condition) {
                    if (preg_match($regex_station,$condition)) {
                        $type         = Keyword::STATION;
                        $explode      = explode('/',$condition);
                        $condition_id = end($explode);
                    }elseif(preg_match($regex_genre,$condition)) {
                        $type         = Keyword::GENRE;
                        $explode      = explode('=',$condition);
                        $condition_id = end($explode);
                    }else {
                        $type    = Keyword::AREA;
                        $explode = explode('/',$condition);
                        $area    = end($explode);
                        $region  = Region::where('slug',$area)->first();
                        $condition_id = $region->region_category_id ? $region->region_category_id : '';
                    }
                    $keyword[] = [
                        'keywords'     => $data[0] ? $data[0] : '',
                        'type'         => $type,
                        'condition_id' => $condition_id
                    ];
                }else{
                    continue;
                }
            }
            fclose($handle);
        }
        Keyword::insert($keyword);
    }
}
