<?php

namespace App\Console\Commands;

use App\Region;
use Illuminate\Console\Command;

class UpdateRegion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:region';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $row = 1;
        $pathFileOldSTG = storage_path().'/data/regions_stg.csv';
        $pathFileOldPRO = storage_path().'/data/regions.csv';
        $pathFileNewRegion = env('PATH_FILE_NEW_REGION');
        $pathFileNewSubRegion1 = env('PATH_FILE_NEW_SUB_REGION_01');
        $pathFileNewSubRegion2 = env('PATH_FILE_NEW_SUB_REGION_02');

        $pathFileAddNewRegion = env('PATH_ADD_NEW_REGION');
        $pathFileDeleteRegion = env('PATH_DELETE_REGION');

        $fileSTG = fopen("/var/www/html/sweets_server/storage/data/regions_stg_2019_08_28.csv","w");
        $filePRO = fopen("/var/www/html/sweets_server/storage/data/regions_2019_08_28.csv","w");
        $listLat = [];
        $listLong = [];

        /*****************************************************************************/
        $listIDDelete = [];
        if (($handle = fopen($pathFileDeleteRegion, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row < 2) {
                    $row++;
                    continue;
                }
                array_push($listIDDelete, $data[0]);
            }
            fclose($handle);
        }

        /*****************************************************************************/
        $row = 1;
        if (($handle = fopen($pathFileNewRegion, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row < 3) {
                    $row++;
                    continue;
                }
                $listLat[$data[4]] = $data[5];
                $listLong[$data[4]] = $data[6];
            }
            fclose($handle);
        }

        $row = 1;
        if (($handle = fopen($pathFileNewSubRegion1, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row < 3) {
                    $row++;
                    continue;
                }
                $listLat[$data[0]] = $data[1];
                $listLong[$data[0]] = $data[2];
            }
            fclose($handle);
        }

        $row = 1;
        if (($handle = fopen($pathFileNewSubRegion2, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row < 3) {
                    $row++;
                    continue;
                }
                $listLat[$data[4]] = $data[5];
                $listLong[$data[4]] = $data[6];
            }
            fclose($handle);
        }

        /*****************************************************************************/
        $listID = [];
        if (($handle = fopen($pathFileOldSTG, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (in_array($data[0], $listIDDelete)) {
                    continue;
                }
                array_push($listID, $data[0]);
                $dataPutCsv = [];
                $text = str_replace('(変更不可)', '',$data[5]);
                for ($c=0; $c <= 15; $c++) {
                    switch ($c) {
                        case 14 : !empty($listLat[$text]) ? array_push($dataPutCsv, preg_replace('/\s+/', '', $listLat[$text])) : array_push($dataPutCsv,'');break;
                        case 15 : !empty($listLong[$text]) ? array_push($dataPutCsv, preg_replace('/\s+/', '', $listLong[$text])) : array_push($dataPutCsv,'');break;
                        default : array_push($dataPutCsv, $data[$c]);break;
                    };
                }
                fputcsv($fileSTG, $dataPutCsv);
            }
            fclose($handle);
        }

        if (($handle = fopen($pathFileOldPRO, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (in_array($data[0], $listIDDelete)) {
                    continue;
                }
                $dataPutCsv = [];
                for ($c=0; $c <= 15; $c++) {
                    switch ($c) {
                        case 14 : !empty($listLat[$data[5]]) ? array_push($dataPutCsv, preg_replace('/\s+/', '', $listLat[$data[5]])) : array_push($dataPutCsv,'');break;
                        case 15 : !empty($listLong[$data[5]]) ? array_push($dataPutCsv, preg_replace('/\s+/', '', $listLong[$data[5]])) : array_push($dataPutCsv,'');break;
                        default : array_push($dataPutCsv, $data[$c]);break;
                    };
                }
                fputcsv($filePRO, $dataPutCsv);
            }
            fclose($handle);
        }
        /*****************************************************************************/
        $row = 1;
        if (($handle = fopen($pathFileAddNewRegion, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $dataPutCsv = [];
                if ($row < 2) {
                    $row++;
                    continue;
                }
                if (in_array($data[0], $listID)) {
                    continue;
                }
                if (in_array($data[0], $listIDDelete)) {
                    continue;
                }
                for ($c=0; $c <= 15; $c++) {
                    switch ($c) {
                        case 5 : array_push($dataPutCsv, '(変更不可)'.$data[5]);break;
                        case 6 : array_push($dataPutCsv, $data[8]);break;
                        case 7 : array_push($dataPutCsv, $data[6]);break;
                        case 8 : array_push($dataPutCsv, $data[7]);break;
                        case 9 : array_push($dataPutCsv, 'system');break;
                        case 10 : array_push($dataPutCsv, date('Y-m-d H:i:s'));break;
                        case 11 : array_push($dataPutCsv, 'system');break;
                        case 12 : array_push($dataPutCsv, date('Y-m-d H:i:s'));break;
                        case 13 : array_push($dataPutCsv, '3');break;
                        case 14 : array_push($dataPutCsv, $data[9]);break;
                        case 15 : array_push($dataPutCsv, $data[10]);break;
                        default : array_push($dataPutCsv, $data[$c]);break;
                    };
                }
                fputcsv($fileSTG, $dataPutCsv);
                $dataPutCsv = [];
                for ($c=0; $c <= 15; $c++) {
                    switch ($c) {
                        case 6 : array_push($dataPutCsv, $data[8]);break;
                        case 7 : array_push($dataPutCsv, $data[6]);break;
                        case 8 : array_push($dataPutCsv, $data[7]);break;
                        case 9 : array_push($dataPutCsv, 'system');break;
                        case 10 : array_push($dataPutCsv, date('Y-m-d H:i:s'));;break;
                        case 11 : array_push($dataPutCsv, 'system');break;
                        case 12 : array_push($dataPutCsv, date('Y-m-d H:i:s'));;break;
                        case 13 : array_push($dataPutCsv, '3');break;
                        case 14 : array_push($dataPutCsv, preg_replace('/\s+/', '', $data[9]));break;
                        case 15 : array_push($dataPutCsv, preg_replace('/\s+/', '', $data[10]));break;
                        default : array_push($dataPutCsv, $data[$c]);break;
                    };
                }
                fputcsv($filePRO, $dataPutCsv);
            }
            fclose($handle);
        }
        echo 'done';
    }
}

