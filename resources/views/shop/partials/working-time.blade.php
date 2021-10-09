@if(!empty($shop->worktime()))
<table class="sales-table">
    <tr>
        <th>営業時間</th>
        <th>月</th>
        <th>火</th>
        <th>水</th>
        <th>木</th>
        <th>金</th>
        <th>土</th>
        <th>日</th>
        <th>祝</th>
    </tr>
    @php $checkFlg = 0; @endphp
    @for($i = 1; $i <= 4; $i++)
        @php $working_times = 'working_times_' . $i; @endphp
        @if(!empty($shop->item->working_times->$working_times))
            @php
                $shopWorkTimes = $shop->item->working_times->$working_times;
            @endphp

            <tr>
                <td>{{ empty($shopWorkTimes->start) ? '' : $shopWorkTimes->start }} ~ {{ empty($shopWorkTimes->end) ? '' : $shopWorkTimes->end }}</td>
                <td>{{ !empty($shopWorkTimes->mon) && $shopWorkTimes->mon == "1" ? "◯" : "×" }}</td>
                <td>{{ !empty($shopWorkTimes->tue) && $shopWorkTimes->tue == "1" ? "◯" : "×" }}</td>
                <td>{{ !empty($shopWorkTimes->wed) && $shopWorkTimes->wed == "1" ? "◯" : "×" }}</td>
                <td>{{ !empty($shopWorkTimes->thu) && $shopWorkTimes->thu == "1" ? "◯" : "×" }}</td>
                <td>{{ !empty($shopWorkTimes->fri) && $shopWorkTimes->fri == "1" ? "◯" : "×" }}</td>
                <td>{{ !empty($shopWorkTimes->sat) && $shopWorkTimes->sat == "1" ? "◯" : "×" }}</td>
                <td>{{ !empty($shopWorkTimes->sun) && $shopWorkTimes->sun == "1" ? "◯" : "×" }}</td>
                <td>{{ !empty($shopWorkTimes->holiday) && $shopWorkTimes->holiday == "1" ? "◯" : "×" }}</td>
            </tr>
            @php $checkFlg = 1; @endphp
        @endif
    @endfor
    @if (!$checkFlg)
    <tr>
        <td>ー</td>
        <td>ー</td>
        <td>ー</td>
        <td>ー</td>
        <td>ー</td>
        <td>ー</td>
        <td>ー</td>
        <td>ー</td>
        <td>ー</td>
    </tr>
    @endif
</table>
@endif
