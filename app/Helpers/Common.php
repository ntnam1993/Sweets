<?php
use App\Category;
use App\Region;

function subString($str, $len)
{
    $str = mb_strlen($str) > $len ? mb_substr($str, 0, $len) . '…' : $str;
    return $str;
}

function translate($str)
{
    switch ($str) {
        case 'mon':
            return '月曜日';
            break;
        case 'tue':
            return '火曜日';
            break;
        case 'wed':
            return '水曜日';
            break;
        case 'thu':
            return '木曜日';
            break;
        case 'fri':
            return '金曜日';
            break;
        case 'sat':
            return '土曜日';
            break;
        case 'sun':
            return '日曜日';
            break;
        case 'holiday':
            return '祝日';
            break;
    }
}

function displayDaysOff($day, $value)
{
    if ('holiday' == $day) {
        return translate($day);
    }

    switch (count($value)) {
        case 4:
            $text = translate($day);
            break;
        case 3:
        case 2:
        case 1:
            array_walk($value, function (&$value, $key) {
                $value = "第$value";
            });
            $commaSeperated = implode('、', $value);
            $text = $commaSeperated . translate($day);
            break;
        default:
            $text = '';
            break;
    }

    return $text;
}

/**
 * @author chuong
 * get year or mounth or day or hour or minute or second
 * @param $id
 */
function dateFormat($date, $format)
{
    switch ($format) {
        case 'yeah':
            return date('Y', strtotime($date));
            break;
        case 'mounth':
            return date('m', strtotime($date));
            break;
        case 'day':
            return date('d', strtotime($date));
            break;
        case 'hour':
            return date('h', strtotime($date));
            break;
        case 'minute':
            return date('m', strtotime($date));
            break;
        case 'second':
            return date('s', strtotime($date));
            break;
        case 'full':
            return date('Y/m/d', strtotime($date));
            break;
        default:
            return date('Y/m/d H:i:s', strtotime($date));
    }
}

/**
 * get previous route name
 * @param  [type]
 * @return [type]
 */
function getPreviousRouteName($url)
{
    return app('router')->getRoutes()->match(app('request')->create($url))->getName();
}

function getTxtShopContactTime($num)
{
    switch ($num) {
        case 1:
            return '午前中';
            break;
        case 2:
            return '12時〜14時';
            break;
        case 3:
            return '14時〜16時';
            break;
        case 4:
            return '16時〜17時';
            break;
        case 5:
            return 'いつでも';
            break;
        default:
            return '';
            break;
    }
}

function getRegionNameById($id)
{
    return Region::getRegionNameById($id);
}

function getGenreNameById($id)
{
    return Category::getGenreNameById($id);
}

/**
 * Converts decimal longitude / latitude to DMS
 *
 * @return string
 *
 * @author thanhnt1@greenglobal.vn
 */
function convertToDMS($value, $isLng = false)
{
    $vars = explode('.', $value);
    $deg = $vars[0];
    $tempma = '0.' . $vars[1];

    $tempma = $tempma * 3600;
    $min = floor($tempma / 60);
    $sec = $tempma - ($min * 60);

    if ($isLng) {
        if ($value < 0) {
            $direction = 'W';
        } else {
            $direction = 'E';
        }
    } else {
        if ($value < 0) {
            $direction = 'S';
        } else {
            $direction = 'N';
        }
    }

    return "{$deg}°{$min}'{$sec}\"{$direction}";
}

/**
 * Encodes coordinate for google map
 *
 * @return string
 *
 * @author thanhnt1@greenglobal.vn
 */
function encodeCoordinate($longitude, $latitude)
{
    $longitudeDMS = convertToDMS($longitude, true);
    $latitudeDMS = convertToDMS($latitude, false);
    return base64_encode("$latitudeDMS $longitudeDMS");
}

/**
 * Convert to japanese week day
 *
 * @return string
 *
 * @author ngo.ld@neo-lab.vn
 */
function convertToWeekday($date)
{
    $weekDateArr = [
        'Monday' => '月',
        'Tuesday' => '火',
        'Wednesday' => '水',
        'Thursday' => '木',
        'Friday' => '金',
        'Saturday' => '土',
        'Sunday' => '日',
    ];
    $weekDate = '(' . $weekDateArr[date('l', $date)] . ')';
    return $weekDate;
}

function numberFormat($string, $num = 0)
{
    return number_format(floatval($string), $num);
}

function formatSlug($slug)
{
    $slug = str_replace('ō', 'o', $slug);
    $slug = strtolower(trim($slug));
    $slug = str_replace(['·', '(', '/'], '-', $slug); //however str_replace returns '--' after replacing '·' with '-'
    $slug = str_replace('--', '-', $slug); //continue replacing '--' with '-'
    $slug = str_replace(')', '', $slug);
    return $slug;
}

function metaKeywords()
{
    return '夏のおすすめスイーツ,誕生日ケーキ,バースデーケーキ,予約';
}

function httpsUrl($url, $size = null)
{
    // check if valid url
    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        return $url;
    }

    if (!empty($url) && !empty($size)) {
        $fileParts = pathinfo($url);
        $url = $fileParts['dirname'] . '/' . $fileParts['filename'] . '_' . $size . '.' . $fileParts['extension'];
        $url = env('REDIRECT_URI_COOKIE') . '/images/convert/get?url=' . urlencode($url);
    } else {
        $url = preg_replace('/^http:/i', 'https:', $url);
    }

    return $url;
}

function convertCakeSize($cakeSize)
{
    if (!empty($cakeSize)) {
        if (9 == $cakeSize) {
            return ($cakeSize + 2) . '号以上';
        }
        return ($cakeSize + 2) . '号';
    }
    return;
}

function productChildSizeText($size)
{
    switch ($size) {
        case '1':
            $childSizeText = '(1～2名様分)';
            break;
        case '2':
            $childSizeText = '(2～4名様分)';
            break;
        case '3':
            $childSizeText = '(４〜６名様分)';
            break;
        case '4':
            $childSizeText = '(６〜８名様分)';
            break;
        case '5':
            $childSizeText = '(８〜10名様分)';
            break;
        case '6':
            $childSizeText = '(10～12名様分)';
            break;
        case '7':
            $childSizeText = '(12～16名様分)';
            break;
        case '8':
            $childSizeText = '(16～20名様分)';
            break;
        case '9':
            $childSizeText = '(20名様分～)';
            break;
        default:
            $childSizeText = '';
    }
    return $childSizeText;
}

function getSortName($sort)
{
    switch ($sort) {
        case '0':
            $sortName = 'おすすめ順';
            break;
        case '1':
            $sortName = '価格の安い順';
            break;
        case '2':
            $sortName = '価格の高い順';
            break;
        case '5':
            $sortName = '駅からの距離順';
            break;
        case '6':
            $sortName = '現在地から近い順';
            break;
        default:
            $sortName = '';
            break;
    }
    return $sortName;
}

function getPrefectures()
{
    return [
        '1' => '北海道',
        '2' => '青森県',
        '3' => '岩手県',
        '4' => '宮城県',
        '5' => '秋田県',
        '6' => '山形県',
        '7' => '福島県',
        '8' => '茨城県',
        '9' => '栃木県',
        '10' => '群馬県',
        '11' => '埼玉県',
        '12' => '千葉県',
        '13' => '東京都',
        '14' => '神奈川県',
        '15' => '新潟県',
        '16' => '富山県',
        '17' => '石川県',
        '18' => '福井県',
        '19' => '山梨県',
        '20' => '長野県',
        '21' => '岐阜県',
        '22' => '静岡県',
        '23' => '愛知県',
        '24' => '三重県',
        '25' => '滋賀県',
        '26' => '京都府',
        '27' => '大阪府',
        '28' => '兵庫県',
        '29' => '奈良県',
        '30' => '和歌山県',
        '31' => '鳥取県',
        '32' => '島根県',
        '33' => '岡山県',
        '34' => '広島県',
        '35' => '山口県',
        '36' => '徳島県',
        '37' => '香川県',
        '38' => '愛媛県',
        '39' => '高知県',
        '40' => '福岡県',
        '41' => '佐賀県',
        '42' => '長崎県',
        '43' => '熊本県',
        '44' => '大分県',
        '45' => '宮崎県',
        '46' => '鹿児島県',
        '47' => '沖縄県',
    ];
}

function convertToDayOfWeek($workingTimes)
{
    $workingTimes = (array) $workingTimes;
    $results = [];
    $arrs = [
        'mon' => 'Monday',
        'tue' => 'Tuesday',
        'wed' => 'Wednesday',
        'thu' => 'Thursday',
        'fri' => 'Friday',
        'sat' => 'Saturday',
        'sun' => 'Sunday',
        'holiday' => 'PublicHolidays',
    ];
    foreach ($workingTimes as $key => $value) {
        if (!empty($value)) {
            foreach ($arrs as $k => $v) {
                if ($key == $k) {
                    $results[] = $v;
                }
            }
        }
    }
    return $results;
}
function convertToKeyOfWeek($arrayDayOfWeek)
{
    $arrs = [
        'Monday' => 'mon',
        'Tuesday' => 'tue',
        'Wednesday' => 'wed',
        'Thursday' => 'thu',
        'Friday' => 'fri',
        'Saturday' => 'sat',
        'Sunday' => 'sun',
        'PublicHolidays' => 'holiday',
    ];

    $ret = [];
    foreach ($arrayDayOfWeek as $day) {
        if (!empty($arrs[$day])) {
            $ret[$arrs[$day]] = 1;
        }
    }

    return $ret;
}

function worktime($shop)
{
    for ($i = 1; $i <= 4; $i++) {
        $worktime = 'worktime' . $i;
        $start_time = 'start_time' . $i;
        $end_time = 'end_time' . $i;
        $monday = 'monday' . $i;
        $tuesday = 'tuesday' . $i;
        $wednesday = 'wednesday' . $i;
        $thursday = 'thursday' . $i;
        $friday = 'friday' . $i;
        $saturday = 'saturday' . $i;
        $sunday = 'sunday' . $i;
        $holiday = 'holiday' . $i;
        $worktime = new \StdClass();
        $worktime->start = $shop->$start_time;
        $worktime->end = $shop->$end_time;
        $worktime->mon = $shop->$monday;
        $worktime->tue = $shop->$tuesday;
        $worktime->wed = $shop->$wednesday;
        $worktime->thu = $shop->$thursday;
        $worktime->fri = $shop->$friday;
        $worktime->sat = $shop->$saturday;
        $worktime->sun = $shop->$sunday;
        $worktime->holiday = $shop->$holiday;
        $worktimeShop[] = $worktime;
    }
    $working = array_filter($worktimeShop, function ($ary) {
        return !empty($ary);
    });
    $worktime = [];
    foreach ($working as $work) {
        $weekNotHoliday = join([
            $work->mon,
            $work->tue,
            $work->wed,
            $work->thu,
            $work->fri,
            $work->sat,
            $work->sun,
        ]);
        $week = join([
            $weekNotHoliday,
            $work->holiday,
        ]);
        while (true) {
            $weekNotHoliday = str_replace('111', '1-1', $weekNotHoliday, $count1);
            $weekNotHoliday = str_replace('-11', '--1', $weekNotHoliday, $count2);
            $weekNotHoliday = str_replace('-1-', '---', $weekNotHoliday, $count3);
            if (0 == $count1 && 0 == $count2 && 0 == $count3) {
                break;
            }
        }
        $weekNotHoliday = str_split($weekNotHoliday);
        if (isset($weekNotHoliday[0]) && '1' == $weekNotHoliday[0]) {
            $weekNotHoliday[0] = '月曜日';
        }
        if (isset($weekNotHoliday[1]) && '1' == $weekNotHoliday[1]) {
            $weekNotHoliday[1] = '火曜日';
        }
        if (isset($weekNotHoliday[2]) && '1' == $weekNotHoliday[2]) {
            $weekNotHoliday[2] = '水曜日';
        }
        if (isset($weekNotHoliday[3]) && '1' == $weekNotHoliday[3]) {
            $weekNotHoliday[3] = '木曜日';
        }
        if (isset($weekNotHoliday[4]) && '1' == $weekNotHoliday[4]) {
            $weekNotHoliday[4] = '金曜日';
        }
        if (isset($weekNotHoliday[5]) && '1' == $weekNotHoliday[5]) {
            $weekNotHoliday[5] = '土曜日';
        }
        if (isset($weekNotHoliday[6]) && '1' == $weekNotHoliday[6]) {
            $weekNotHoliday[6] = '日曜日';
        }
        if (isset($week[7]) && '1' == $week[7]) {
            $weekNotHoliday[7] = '祝日';
        }
        $weekHasHoliday = join('', $weekNotHoliday);
        $weekHasHoliday = str_replace('0', '', $weekHasHoliday);
        $weekHasHoliday = preg_replace("/[\-]+/i", '〜', $weekHasHoliday);
        $worktime[] = [
            'week' => $weekHasHoliday,
            'time' => $work->start . ((!empty($work->start) && !empty($work->start)) ? '〜' : '') . $work->end,
        ];
    }
    return $worktime;
}

function time_off($shop)
{
    for ($i = 1; $i <= 4; $i++) {
        $worktime = 'worktime' . $i;
        $start_time = 'start_time' . $i;
        $end_time = 'end_time' . $i;
        $monday = 'monday' . $i;
        $tuesday = 'tuesday' . $i;
        $wednesday = 'wednesday' . $i;
        $thursday = 'thursday' . $i;
        $friday = 'friday' . $i;
        $saturday = 'saturday' . $i;
        $sunday = 'sunday' . $i;
        $holiday = 'holiday' . $i;
        $worktime = new \StdClass();
        $worktime->start = $shop->$start_time;
        $worktime->end = $shop->$end_time;
        $worktime->mon = $shop->$monday;
        $worktime->tue = $shop->$tuesday;
        $worktime->wed = $shop->$wednesday;
        $worktime->thu = $shop->$thursday;
        $worktime->fri = $shop->$friday;
        $worktime->sat = $shop->$saturday;
        $worktime->sun = $shop->$sunday;
        $worktime->holiday = $shop->$holiday;
        $worktimeShop[] = $worktime;
    }
    $working = array_filter($worktimeShop, function ($ary) {
        return !empty($ary);
    });
    $week = [
        'mon' => 0,
        'tue' => 0,
        'wed' => 0,
        'thu' => 0,
        'fri' => 0,
        'sat' => 0,
        'sun' => 0,
        'holiday' => 0,
    ];
    foreach ($working as $work) {
        $week['mon'] += !empty($work->mon) ? $work->mon : 0;
        $week['tue'] += !empty($work->tue) ? $work->tue : 0;
        $week['wed'] += !empty($work->wed) ? $work->wed : 0;
        $week['thu'] += !empty($work->thu) ? $work->thu : 0;
        $week['fri'] += !empty($work->fri) ? $work->fri : 0;
        $week['sat'] += !empty($work->sat) ? $work->sat : 0;
        $week['sun'] += !empty($work->sun) ? $work->sun : 0;
        $week['holiday'] += !empty($work->holiday) ? $work->holiday : 0;
    }
    $offTimes = [];
    foreach ($week as $key => $val) {
        if (0 == $week[$key]) {
            $offTimes[] = trans('global.timeoff.' . $key);
        }
    }

    if (empty($offTimes)) {
        $offTimes[] = '-';
    }

    return $offTimes;
}

/**
 * Override the built-in urlencode in PHP
 * @param  string $url
 * @return string
 */
function override_urlencode($url)
{
    // Prevent double encoding
    return urlencode(urldecode($url));
}

/**
 * Checking for the input string is base64 string or not
 * @param  string  $string input value
 * @return boolean
 */
function is_base64($string)
{
    $decoded = base64_decode($string, true);

    // Check if there is no invalid character in string
    if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string)) {
        return false;
    }

    // Decode the string in strict mode and send the response
    if (!base64_decode($string, true)) {
        return false;
    }

    // Encode and compare it to original one
    if (base64_encode($decoded) != $string) {
        return false;
    }

    return true;
}

/**
 * This function is used to decode url string and determind whether it's
 * base64 string or not to take some action to decode and refresh the string
 * @param  string $url input string
 * @return string
 */
function url_page_decode($url)
{
    $url = urldecode($url);
    if (is_base64($url)) {
        $url = base64_decode($url);
    }
    return urldecode($url);
}

function rate_detail_string($list)
{
    $arr = [];
    foreach ($list as $star) {
        if ($star->display_flg) {
            $arr[] = $star->evaluation_star_name . ' ' . numberFormat($star->evaluation_star, 1);
        }
    }
    return '［' . implode(' | ', $arr) . '］';
}

function count_not_null(array $list)
{
    $count = 0;
    foreach ($list as $key => $value) {
        if (!empty($value)) {
            $count += 1;
        }
    }
    return $count;
}

function build_query_string($paramsArray)
{
    $query = http_build_query($paramsArray);
    return urldecode($query);
}

function countProductSizes($product)
{
    $counter = 0;
    if (!empty($product->product_size)) {
        $counter += 1;
    }
    $priceSizes = (array) $product->product_price_by_size;
    foreach ($priceSizes as $size => $price) {
        if (!empty($price)) {
            $counter += 1;
        }
    }
    return $counter;
}

function fullQueryExcept(array $excepts = [])
{
    $query = request()->query();
    foreach ($excepts as $key) {
        unset($query[$key]);
    }
    return http_build_query($query);
}

function fullQueryOnly(array $keep = [], $extends = [])
{
    $query = request()->query();
    foreach ($query as $key => $value) {
        if (!in_array($key, $keep)) {
            unset($query[$key]);
        }
    }
    $query = array_merge($query, $extends);
    return http_build_query($query);
}

function listPatternGenres()
{
    return [
        '14' => 'ショートケーキ',
        '15' => 'チョコレートケーキ',
        '16' => 'シフォンケーキ',
        '17' => 'チーズケーキ',
        '18' => 'モンブラン',
        '19' => 'ロールケーキ',
        '20' => 'タルト',
        '21' => 'パイ',
        '22' => 'ティラミス',
        '23' => 'ミルフィーユ',
        '24' => 'バターケーキ',
        '25' => 'パウンドケーキ',
        '26' => 'アイスケーキ',
        '28' => '動物ケーキ',
        '29' => 'キャラクターケーキ',
        '30' => 'ムース',
        '31' => 'ババロア',
        '32' => 'プリンセスケーキ',
        '34' => 'ウェディングケーキ',
        '35' => 'パーティーケーキ',
        '37' => '二段ケーキ',
        '103' => 'クレープ',
        '104' => 'ガレット',
        '105' => 'ミルクレープ',
        '106' => 'パンケーキ',
        '107' => 'ムース',
        '108' => 'ババロア',
        '109' => 'ゼリー',
        '110' => 'キャンディー',
        '111' => 'プリン',
        '112' => 'キャラメル',
        '113' => 'マロングラッセ',
        '114' => 'パフェ',
        '115' => 'パンナコッタ',
        '116' => 'デザート（その他）',
        '395' => '写真・プリントケーキ',
        '396' => '無地・半製デコレーション',
        '397' => 'イラストケーキ',
        '48' => 'クリスマスケーキ',
    ];
}

function getPrefectureByCode($code)
{
    if (!empty($code)) {
        $code = intval($code);
        return getPrefectures()[$code];
    }
    return '';
}

function formatDateFromString($date, $format = 'Y-m-d')
{
    $date = new DateTime($date);
    return $date->format($format);
}

function normalizeDateNumber($number)
{
    $number = +$number;
    if (0 === $number) {
        return 1;
    }
    if ($number < 10) {
        return "0{$number}";
    }
    return $number;
}

function normalizeDateNumberArray(array $numbers)
{
    return array_map(function ($item) {
        return normalizeDateNumber($item);
    }, $numbers);
}

/**
 * Parse array k,v to form data format
 *
 * @param  array  $data
 * @return array
 */
function parseFormData(array $data = [])
{
    $output = [];
    foreach ($data as $key => $value) {
        if (!is_array($value)) {
            $output[] = ['name' => $key, 'contents' => $value];
            continue;
        }

        foreach ($value as $multiKey => $multiValue) {
            if (is_array($multiValue)) {
                foreach ($multiValue as $keyLast => $valueLast) {
                    if (is_array($valueLast)) {
                        foreach ($valueLast as $k => $v) {
                            if (is_array($v)) {
                                foreach ($v as $k1 => $v1) {
                                    $multiName = $key . '[' . $multiKey . ']' . '[' . $keyLast . ']' . '[' . $k . ']' . '[' . $k1 . ']' . (is_array($v1) ? '[' . key($v1) . ']' : '') . '';
                                    $output[] = ['name' => $multiName, 'contents' => (is_array($v1) ? reset($v1) : $v1)];
                                }
                            } else {
                                $multiName = $key . '[' . $multiKey . ']' . '[' . $keyLast . ']' . '[' . $k . ']' . (is_array($v) ? '[' . key($v) . ']' : '') . '';
                                $output[] = ['name' => $multiName, 'contents' => (is_array($v) ? reset($v) : $v)];
                            }
                        }
                    } else {
                        $multiName = $key . '[' . $multiKey . ']' . '[' . $keyLast . ']' . (is_array($valueLast) ? '[' . key($valueLast) . ']' : '') . '';
                        $output[] = ['name' => $multiName, 'contents' => (is_array($valueLast) ? reset($valueLast) : $valueLast)];
                    }
                }
            } else {
                $multiName = $key . '[' . $multiKey . ']' . (is_array($multiValue) ? '[' . key($multiValue) . ']' : '') . '';
                $output[] = ['name' => $multiName, 'contents' => (is_array($multiValue) ? reset($multiValue) : $multiValue)];
            }
        }
    }
    return $output;
}

function render_region_list(array $regionIds)
{
    $regions = [];
    foreach ($regionIds as $id) {
        $regions[] = \App\Region::find($id);
    }
    return view(
        'partials.components.mobile.regions_search_list',
        compact('regions')
    )->render();
}

function routePath($routeName, array $parameters = [])
{
    return parse_url(
        route($routeName, $parameters),
        PHP_URL_PATH
    );
}

function getCurrentPathWithQuery()
{
    $url = request()->fullUrl();

    return getPathWithQuery($url);
}

function getPathWithQuery($url)
{
    $path = parse_url($url, PHP_URL_PATH);
    $query = parse_url($url, PHP_URL_QUERY);

    $path = empty($path) ? '/' : $path;
    $query = empty($query) ? '' : ('?' . $query);

    return $path . $query;
}

function eparkLoginUrl($redirectPath = '/')
{
    return env('SWEETS_LOGIN_ENDPOINT') . '?callerPageType=1&afterLoginPath=' . urlencode($redirectPath);
}

function showNearestStation($shop)
{
    $flg = 0;
    $result = '';
    $routeForSearchPage = ['shopsearch.index', 'shopsearch.all', 'shopsearch.station', 'shopsearch.region', 'shop.get_info_shop'];
    $routeName = \Route::currentRouteName();
    for ($i = 1; $i <= 5; $i++) {
        $station = 'station' . $i;
        $train_line = 'train_line' . $i;
        $means = 'means' . $i;
        $time_required = 'time_required' . $i;
        $exit_station = 'exit_station' . $i;
        if (!empty($shop->$station)) {
            $flg++;
            $result .= ('<span>')
                . ($flg < 2 && !in_array($routeName, $routeForSearchPage) ? '最寄駅: ' : '')
                . (!empty($shop->$train_line) ? ($shop->$train_line . (' ')) : '')
                . ($shop->$station . (' '))
                . (!empty($shop->$exit_station) ? ($shop->$exit_station . (' ')) : '')
                . (!empty($shop->$means) ? ($shop->$means . (' ')) : '')
                . (!empty($shop->$time_required) ? $shop->$time_required . '分' : '')
                . ('</span>');
        }
    }
    $result = '<span  class="nearest-station">' . $result . '</span>';

    return $result;
}

function showNearestStationSimple($product)
{
    $result = '';
    $result .= (!empty($product->train_line1) ? ($product->train_line1 . (' ')) : '');
    $result .=  (!empty($product->station1) ? ($product->station1 . (' ')) : '');
    $result .=  (!empty($product->exit_station1) ? ($product->exit_station1 . (' ')) : '');
    $result .=  (!empty($product->means1) ? ($product->means1 . (' ')) : '');
    $result .=  (!empty($product->time_required1) ? $product->time_required1 . '分' : '');

    $result = '<span  class="nearest-station">' . $result . '</span>';

    return $result;
}

function isRefererSameHost()
{
    $referer = request()->headers->get('referer');
    $refererParsed = parse_url($referer);

    return ! array_key_exists('host', $refererParsed) || (
        array_key_exists('host', $refererParsed) &&
        $refererParsed['host'] === request()->getHttpHost()
    );
}

function hasTargetMember(array $members, array $targetLookup)
{
    foreach ($members as $member) {
        if (in_array($member->relationship, $targetLookup)) {
            return true;
        }
    }

    return false;
}

function checkShowIntType($data)
{
    if( isset($data) && !empty($data) && is_numeric($data) > 0) {
        return '-' . number_format($data);
    }
    return 0;
}
function subNumber($a, $b)
{
    return ($a-$b);
}

function checkPaginateForList($params, $data, $numPage, $allItem)
{
    $numFoundInPage = $data['data']['paging']['numFound'];
    $numCount = $data['data']['paging']['numCount'];
    if ($numPage > 1) {
        $params['page'] = $numPage;
    }elseif ($numFoundInPage < 1) {
        $page = ceil($allItem/$numCount);
        $params['page'] = ( $page == 0) ? 1 : $page;
        return [
            'params' => $params,
            'status' => 'redirect'
        ];
    }
    return $params;
}
function checkNotNullReturnTrue($variable)
{
    return ('' != $variable) ? 1 : '';
}
function objectCodes($numCode) {
  switch ($numCode) {
    case 1:
      case 3:
        return "一部店舗";
        break;
    case 2:
        return "一部商品";
        break;
    case 9:
        return "全店舗";
        break;
    default:
        return "";
    }
}
function getProductPrice($value)
{
    $product_price = $value->product_price ? $value->product_price : 0;
    $portal_discount = $value->portal_discount ? $value->portal_discount : 0;
    $product_price = $product_price - $portal_discount;
    $product_price = $product_price > 0 ? $product_price : 0;
    return $product_price;
}
function getYear () {
   return date('Y');
}
function calculateExpireDate($cashpoExpireDate)
{
    if ($cashpoExpireDate && (strtotime($cashpoExpireDate) > time()) ) {
        $cashpoExpireDate = strtotime($cashpoExpireDate);
        $now = time();
        $remainedDays = ($cashpoExpireDate - $now) / 86400;

        if ($remainedDays > 1) {
            return 'あと'.floor($remainedDays).'日で失効';
        }
        $remainedHours = $remainedDays*24;
        if ($remainedHours > 1) {
            return 'あと'.floor($remainedHours).'時間で失効';
        }
        $remainedMinutes = $remainedHours*60;
        if ($remainedMinutes > 1) {
            return 'あと'.floor($remainedMinutes).'分で失効';
        }
        $remainedSeconds = $remainedMinutes*60;
        if ($remainedSeconds > 1) {
            return 'あと'.floor($remainedSeconds).'秒で失効';
        }
    }
    return '0';
}

function removeStripTags($str)
{
    return strip_tags($str, '');
}
function convertAmp($string) {
  $pattern = array('/img/','/>/');
  preg_match_all('/<img[^>]*>/', $string, $matches);
  $replacement = array('amp-img class="img contain" layout="fill"','></amp-img>');
  for($i = 0; $i < count($matches); $i++) {
    $ampTag = preg_replace($pattern, $replacement, $matches[$i]);
    $string = str_replace($matches[$i], $ampTag, $string);
  }
  return $string;
}

function formatTimeWithMiliSecond($time = null)
{
    if (!($time > 0)) {
        return $time;
    }
    $time = $time ? $time : microtime(true);
    $micro = sprintf("%03d",($time - floor($time)) * 1000);
    $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $time) );
    return str_replace('000','', $d->format("Y-m-d H:i:s.u"));
}
