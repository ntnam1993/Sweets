<?php

namespace App\Console\Commands;

use App\Region;
use App\Station;
use function GuzzleHttp\Promise\all;
use Illuminate\Console\Command;

class UpdateStation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:station';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Information about station with file エリア別緯度経度一覧_20190828.xlss';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pathFileNew = env('PATH_FILE_UPDATE_STATION');
        $pathFileOld = '/var/www/html/sweets_server/storage/data/stations_2019_08_28.csv';
        $file = fopen("/var/www/html/sweets_server/storage/data/stations.csv","w");
        $infoNew = [];

        /*****************************************************************************/
        $row = 1;
        if (($handle = fopen($pathFileNew, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row < 2) {
                    $row++;
                    continue;
                }
                $infoNew[$data[0]] = [
                    $data[0],
                    $data[1],
                    $data[2],
                    $data[3],
                    $data[4],
                    $data[5],
                    $data[6],
                    $data[7],
                    $data[8],
                    $data[9],
                    $data[10],
                    '',
                    $data[11],
                    'system',
                    date('Y-m-d H:i:s'),
                    'system',
                    date('Y-m-d H:i:s'),
                    '3',
                    $data[12],//lat
                    $data[13],//long
                ];
            }
            fclose($handle);
        }

        foreach ($infoNew as $key => $value) {
            $checkKey = Station::where('station_line_id', $key)->get();
            if(count($checkKey) > 0) {
                Station::where('station_line_id', $key)->delete();
            }
            $station = new Station();
            $station->station_line_id = $value[0];
            $station->prov_code = $value[1];
            $station->prov_name = $value[2];
            $station->prov_rank_no = $value[3];
            $station->rail_line_id = $value[4];
            $station->rail_line_name = $value[5];
            $station->rail_line_rank_no = $value[6];
            $station->station_id = $value[7];
            $station->station_name = $value[8];
            $station->station_rank_no = $value[9];
            $station->area_name = $value[10];
            $station->region_id = $value[11];
            $station->integration_id = $value[12];
            $station->create_user_no = $value[13];
            $station->create_date = $value[14];
            $station->modify_user_no = $value[15];
            $station->modify_date = $value[16];
            $station->data_version = $value[17];
            $station->lat = $value[18];
            $station->long = $value[19];
            $station->save();
        }
        $station = Station::all()->toArray();

        foreach ($station as $values) {
            $dataInput = [];
            foreach ($values as $value) {
                array_push($dataInput, $value);
            }
            $lat = $dataInput[19];
            $long = $dataInput[18];
            $dataInput[18] = $lat;
            $dataInput[19] = $long;
            fputcsv($file, $dataInput);
        }

        var_dump('done');
        return true;
    }
}
