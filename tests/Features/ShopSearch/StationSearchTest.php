<?php

namespace Tests\Features\ShopSearch;

// use Illuminate\Foundation\Testing\WithoutMiddleware;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Station;

class StationSearchTest extends \TestCase
{

    protected $stationIds = [
        '2423', '2427', '2431', '2455', '3065', '3087', '3066',
    ];

    protected $checkList = [];

    public function setUp()
    {
        parent::setUp();
        $checkList = Station::whereIn('station_id', $this->stationIds)->get(['station_id', 'station_name']);
        $this->checkList = $checkList->map(function ($station) {
            return [
                'station_id' => $station->station_id,
                'station_name' => $station->station_name,
            ];
        });
    }

    public function testStationNameIsShownExactly()
    {

        foreach ($this->checkList as $station) {
            $this->visitRoute('shopsearch.station', $station['station_id'])
                ->see($station['station_name']);
        }
    }
}
