<?php

use App\Station;
use Illuminate\Database\Seeder;

class StationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stations')->truncate();

        if (($handle = fopen(storage_path() . '/data/stations_2019_08_28.csv', 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $station = new Station();
                $station->station_line_id = $data[0];
                $station->prov_code = $data[1];
                $station->prov_name = $data[2];
                $station->prov_rank_no = $data[3];
                $station->rail_line_id = $data[4];
                $station->rail_line_name = $data[5];
                $station->rail_line_rank_no = $data[6];
                $station->station_id = $data[7];
                $station->station_name = $data[8];
                $station->station_rank_no = $data[9];
                $station->area_name = $data[10];
                $station->region_id = $data[11];
                $station->integration_id = $data[12];
                $station->create_user_no = $data[13];
                $station->create_date = $data[14];
                $station->modify_user_no = $data[15];
                $station->modify_date = $data[16];
                $station->data_version = $data[17];
                $station->lat = $data[18];
                $station->long = $data[19];
                $station->save();
            }
            fclose($handle);
        }
    }
}
