<?PHP

namespace App;

class Shop
{

    private $shop;
    const REGION_NAME_DEFAULT = '全国';
    const GENRE_NAME_DEFAULT = 'すべて';
    const KEYWORD_NAME_DEFAULT = '例）店舗名・駅名など';
    const SHOP_CAN_NOT_PAY_IN_EPARK = 0;
    const STATUS_USER_HAVE_COUPON = 0;
    const COUPON_TYPE_SAVE_CASHPO = 1;
    const COUPON_TYPE_DIRECT_RATIO = 3;

    public function __construct($shop)
    {
        $this->shop = $shop;
    }

    public function __get($name)
    {
        return !empty($this->shop->$name) ? $this->shop->$name : '';
    }

    public function exist()
    {
        return !empty($this->shop->item);
    }

    public function stations()
    {
        $stations = [];
        if (!empty($this->shop->means1)) {
            $stations[] = ['means' => $this->shop->means1,
                'station' => $this->shop->station1];
        }
        if (!empty($this->shop->means2)) {
            $stations[] = ['means' => $this->shop->means2,
                'station' => $this->shop->station2];
        }
        if (!empty($this->shop->means3)) {
            $stations[] = ['means' => $this->shop->means3,
                'station' => $this->shop->station3];
        }
        if (!empty($this->shop->means4)) {
            $stations[] = ['means' => $this->shop->means4,
                'station' => $this->shop->station4];
        }
        if (!empty($this->shop->means5)) {
            $stations[] = ['means' => $this->shop->means5,
                'station' => $this->shop->station5];
        }
        if (empty($stations)) {
            $stations[] = ['means' => '-',
                'station' => '-'];
        }
        return $stations;
    }

    public function time_off()
    {
        $working = array_filter([
            $this->shop->item->working_times->working_times_1,
            $this->shop->item->working_times->working_times_2,
            $this->shop->item->working_times->working_times_3,
            $this->shop->item->working_times->working_times_4,
        ], function ($ary) {
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
            $week['mon'] += $work->mon;
            $week['tue'] += $work->tue;
            $week['wed'] += $work->wed;
            $week['thu'] += $work->thu;
            $week['fri'] += $work->fri;
            $week['sat'] += $work->sat;
            $week['sun'] += $work->sun;
            $week['holiday'] += $work->holiday;
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

    public function worktime()
    {
        $working = array_filter([
            $this->shop->item->working_times->working_times_1,
            $this->shop->item->working_times->working_times_2,
            $this->shop->item->working_times->working_times_3,
            $this->shop->item->working_times->working_times_4,
        ], function ($ary) {
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
            if ('1' == $weekNotHoliday[0]) {
                $weekNotHoliday[0] = '月曜日';
            }
            if ('1' == $weekNotHoliday[1]) {
                $weekNotHoliday[1] = '火曜日';
            }
            if ('1' == $weekNotHoliday[2]) {
                $weekNotHoliday[2] = '水曜日';
            }
            if ('1' == $weekNotHoliday[3]) {
                $weekNotHoliday[3] = '木曜日';
            }
            if ('1' == $weekNotHoliday[4]) {
                $weekNotHoliday[4] = '金曜日';
            }
            if ('1' == $weekNotHoliday[5]) {
                $weekNotHoliday[5] = '土曜日';
            }
            if ('1' == $weekNotHoliday[6]) {
                $weekNotHoliday[6] = '日曜日';
            }
            if ('1' == $week[7]) {
                $weekNotHoliday[7] = '祝日';
            }
            $weekHasHoliday = join('', $weekNotHoliday);
            $weekHasHoliday = str_replace('0', '', $weekHasHoliday);
            $weekHasHoliday = preg_replace("/[\-]+/i", '〜', $weekHasHoliday);
            $worktime[] = [
                'week' => $weekHasHoliday,
                'time' => $work->start . '〜' . $work->end,
            ];
        }
        return $worktime;
    }
}
