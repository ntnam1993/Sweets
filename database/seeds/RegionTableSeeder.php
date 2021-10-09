<?php

use App\Region;
use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->truncate();

        $filePath = storage_path() . '/data/regions_2019_08_28.csv';
        if (env('APP_ENV') == 'staging') {
            $filePath = storage_path() . '/data/regions_stg_2019_08_28.csv';
        }

        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $region = new Region();
                $region->region_category_id = $data[0];
                $region->parent_region_category_id = $data[1];
                $region->order_no = $data[2];
                $region->level = $data[3];
                $region->end_flg = $data[4];
                $region->category_name = $data[5];
                $region->slug = $data[6];
                $region->image_file_name = $data[7];
                $region->display_flg = $data[8];
                $region->create_user_no = $data[9];
                $region->create_date = $data[10];
                $region->modify_user_no = $data[11];
                $region->modify_date = $data[12];
                $region->data_version = $data[13];
                $region->lat = $data[14];
                $region->long = $data[15];
                $region->save();
            }
            fclose($handle);
        }
    }
}
