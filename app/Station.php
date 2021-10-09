<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $table = 'stations';
    public $timestamps = false;

    public function scopePrefectures($query)
    {
        return $query->groupBy('prov_code')->orderBy('rail_line_rank_no');
    }

    public function scopeRailLines($query, $prefectureId)
    {
        return $query->where('prov_code', $prefectureId)
            ->groupBy('rail_line_id');
    }

    public function scopeStations($query, $prefectureId, $railLineId)
    {
        return $query->where('prov_code', $prefectureId)
            ->where('rail_line_id', $railLineId);
    }

    public static function getStationNameById($id)
    {
        $station = Station::where('station_id', $id)->first();

        if ($station) {
            return $station->station_name;
        }

        return null;
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'region_category_id');
    }

    public function scopeTokyoStations()
    {
        return $this->where('region_id', 783)->groupBy('station_id');
    }

    public function scopeOrdered($query)
    {
        return $query
            ->orderBy('rail_line_rank_no')
            ->orderBy('station_rank_no');
    }
}
