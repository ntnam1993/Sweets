<?php

namespace App;

use App\Station;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;

class Region extends Model
{
    protected $table = 'regions';

    protected $primaryKey = 'region_category_id';

    protected $fillable = [
        'region_category_id',
        'parent_region_category_id',
        'order_no',
        'level','end_flg',
        'category_name',
        'slug',
        'image_file_name',
        'display_flg',
        'create_user_no',
        'create_date',
        'modify_user_no',
        'modify_date',
        'data_version',
        'lat',
        'long'
    ];

    protected $appends = ['sub_categories'];

    public $timestamps = false;

    const ROOT_REGIONS = ['北海道・東北', '関東', '中部', '関西', '中国・四国', '九州・沖縄'];

    /**
     * Parent regions that are not tokyo, saitama and kanagawa
     */
    const PARENT_NOT_TOKYO_SAIKANA = [
        2, 7, 10, 13, 16, 19, 20, 60, 65, 68, 69, 74, 80, 83, 87, 88, 91, 92,
        95, 98, 101, 103, 111, 117, 120, 123, 126, 130, 134, 138, 139, 140, 143,
        146, 147, 150, 154, 159, 160, 163, 166, 169, 172, 175,
    ];

    CONST LEVEL1 = '1';
    CONST LEVEL2 = '2';

    CONST TOKYO_REGION = 'tokyo';
    CONST SAITAMA_REGION = 'saitama';
    CONST KANAGAWA_REGION = 'kanagawa';

    CONST CHARACTER_SPECIAL_NAME = '区';

    CONST SPECIAL_REGION_SEARCH_NAME = [
        self::TOKYO_REGION => '23区から探す',
        self::SAITAMA_REGION => 'さいたま市から探す',
        self::KANAGAWA_REGION => '横浜市から探す'
    ];

    CONST SPECIAL_REGION_SEARCH = [
        '1' => self::SAITAMA_REGION,
        '2' => self::KANAGAWA_REGION
    ];

    public function scopeMainCategories()
    {
        return $this->where('parent_region_category_id', 0);
    }

    public function getSubCategoriesAttribute()
    {
        return $this->subCategories()->orderBy('order_no')->get();
    }

    public function subCategories()
    {
        return $this->where('parent_region_category_id', $this->region_category_id);
    }

    public static function getRegionNameById($id)
    {
        return Region::where('region_category_id', $id)->first();
    }

    public function getCategoryNameAttribute($value)
    {
        $agent = new Agent();
        $isMobile = $agent->isMobile() && !$agent->isIpad() ? true : false;
        if (783 == $this->region_category_id && !$isMobile) {
            return '東京都';
        }
        return $value;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getIdAttribute($value)
    {
        return $this->attributes['region_category_id'];
    }

    public function scopeAreas()
    {
        $areaIds = [39, 37, 49, 31, 30, 29, 40, 33, 48, 187, 36, 43, 28, 52, 58, 59, 61, 377, 70, 75, 104, 118];
        return $this->whereIn('region_category_id', $areaIds)->get();
    }

    /**
     * get slug of default region 780
     * @return string
     */
    public static function defaultRegion()
    {
        return 'tokyo-citycenter';
    }

    public function subRegions()
    {
        return $this->where('parent_region_category_id', $this->region_category_id)
            ->orderBy('order_no')
            ->get();
    }

    public function scopeTokyoSubRegions()
    {
        return $this->where('parent_region_category_id', 783)->get();
    }

    public function scopeTokyoAreas()
    {
        return $this->where('parent_region_category_id', 780)->get();
    }

    public function scopeTokyoStations()
    {
        return Station::where('region_id', 783)->get();
    }

    public function stations()
    {
        return $this->hasMany(Station::class, 'region_id', 'region_category_id');
    }

    public function parentRegion()
    {
        return $this->where('region_category_id', $this->parent_region_category_id)->first();
    }
}
