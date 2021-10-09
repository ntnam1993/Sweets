<?php

namespace App\Adapters;

class TitleDescriptionKeywordH1Adapter
{
    public function getTitleDescriptionKeywordH1ForShopSearch($request, $data)

    {
        $page = $this->getPageAndDescription($request);

         $title_region_station = $keyword = $description_region_station = $keyword_region_station = $h1_region_station = "";
         $title_constant = 'の誕生日ケーキ・バースデーケーキ・カットケーキ・スイーツ店｜EPARKスイーツガイド';
         $description_constant = 'の店舗一覧ページ('.numberFormat($data['shops'] -> num_found).')です。
         全国約40,000件のスイーツ店情報から誕生日ケーキ・バースデーケーキ・カットケーキまでいろいろなスイーツがネット予約・WEB予約・お取り寄せできるEPARKスイーツガイド！
         有名店・人気店・ホテルのおすすめスイーツを続々掲載中。';
         $keyword_constant = ',誕生日ケーキ,バースデーケーキ,スイーツ,予約';
         $h1_constant = 'のケーキ屋さん・スイーツ店';

         if (!empty($data['parentRegionId']) && $data['parentRegionId'] == $data['regionId']) {
             $title_region_station = $description_region_station = $keyword_region_station = $h1_region_station = $data['searchResult']['region'];
         } elseif (!empty($data['parentRegionId']) && !empty($data['regionId']) && $data['parentRegionId'] != $data['regionId']) {
             $title_region_station = $description_region_station = $h1_region_station = $data['regionName'].'の'.$data['searchResult']['region'];
             $keyword_region_station = $data['regionName'].','.$data['searchResult']['region'];
         } elseif (!empty($data['stationId'])) {
             $title_region_station = $description_region_station = $keyword_region_station = $h1_region_station = $data['stationName'];
         }

         if (!empty($request->keyword)) {
             $keyword = $request->keyword;
         }

         if ($title_region_station != '' && $keyword != '') {
            $title_variable = $description_variable = $h1_variable = $title_region_station . 'の' . $keyword;
            $keyword_variable = $keyword_region_station . ',' . $keyword;
          } elseif ($title_region_station != '') {
            $title_variable = $title_region_station;
            $description_variable = $description_region_station;
            $keyword_variable = $keyword_region_station;
            $h1_variable = $h1_region_station;
          } elseif ($keyword != '') {
            $title_variable = $description_variable = $keyword_variable = $h1_variable = $keyword;
          } else {
            $title_variable = $description_variable = $keyword_variable = $h1_variable = '全国';
          }

         $title = $title_variable . $title_constant;

	 $title = isset($request->reservation_flag) && $request->reservation_flag == 1 ? '<ネット予約可>'.$title : $title;
         $description = 'EPARKスイーツガイドの' . $description_variable . $description_constant;
         $keywords = $keyword_variable . $keyword_constant;
         if (!empty($request->pos)) {
          $h1 = '現在地周辺のケーキ屋さん・スイーツ店（おすすめ順）';
         }
         elseif (!empty($data['coupon'])) {
            $h1Coupon = $data['coupon']->coupon_name . 'の';
            $h1 = $h1_variable . $h1_constant;
         }
         else {
           $h1 = $h1_variable . $h1_constant;
         }
        return compact('title', 'description', 'keywords', 'h1', 'h1Coupon');
    }

    public function getTitleDescriptionKeywordH1ForSearch($request, $data)
    {
        $page = $this->getPageAndDescription($request);
        $sortName = !empty(getSortName($request->sort)) ? '(' . getSortName($request->sort) . ')' : '';
        $sortNameForKeyWord = !empty(getSortName($request->sort)) ? ',' . getSortName($request->sort) : '';
        $genreName = !empty($data['searchResult']['genre']) ? $data['searchResult']['genre'] : '誕生日ケーキやスイーツ';
        $genreNameForKeyWord = !empty($data['searchResult']['genre']) ? $data['searchResult']['genre'] : '誕生日ケーキ,バースデーケーキ';
        $sort = !empty($request->sort) ? $request->sort : '';

        if (empty($request->keyword)) {
            if (!empty($data['searchResult']['region'])) {
                $title = $data['searchResult']['region'] . 'の' . $genreName . $sortName . '' . $page['page'] . '｜EPARKスイーツガイド';
                $description = 'EPARKスイーツガイドの' . $data['searchResult']['region'] . 'の' . $genreName . $sortName . 'の一覧ページです。' . '誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,001件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！' . $page['pageForDescription'];
                $keywords = $data['searchResult']['region'] . ',' . $genreNameForKeyWord . ',スイーツ,予約' . $sortNameForKeyWord;
                $h1 = $data['searchResult']['region'] . 'の' . $genreName . $sortName . 'の一覧';
            } elseif (!empty($searchResult['station'])) {
                $title = $searchResult['station'] . 'の' . $genreName . $sortName . '' . $page['page'] . '｜EPARKスイーツガイド';
                $description = 'EPARKスイーツガイドの' . $searchResult['station'] . 'の' . $genreName . $sortName . 'の一覧ページです。' . '誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,001件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！' . $page['pageForDescription'];
                $keywords = $searchResult['station'] . ',' . $genreNameForKeyWord . ',スイーツ,予約' . $sortNameForKeyWord;
                $h1 = $searchResult['station'] . 'の' . $genreName . $sortName . 'の一覧';
            } else {
                $title = '全国の' . $genreName . $sortName . '' . $page['page'] . '｜EPARKスイーツガイド';
                $description = 'EPARKスイーツガイドの全国の' . $genreName . $sortName . 'の一覧ページです。' . '誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,006件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！' . $page['pageForDescription'];
                $keywords = '全国,' . $genreNameForKeyWord . ',スイーツ,予約' . $sortNameForKeyWord;
                $h1 = '全国の' . $genreName . $sortName . 'の一覧';
            }
        } else {
            if (!empty($data['searchResult']['region'])) {
                $title = $request->keyword . 'の' . $data['searchResult']['region'] . 'の' . $genreName . $sortName . '' . $page['page'] . '｜EPARKスイーツガイド';
                $description = 'EPARKスイーツガイドの' . $request->keyword . 'の' . $data['searchResult']['region'] . 'の' . $genreName . $sortName . 'の一覧ページです。' . '誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,001件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！' . $page['pageForDescription'];
                $keywords = $request->keyword . ',' . $data['searchResult']['region'] . ',' . $genreNameForKeyWord . ',スイーツ,予約' . $sortNameForKeyWord;
                $h1 = $request->keyword . 'の' . $data['searchResult']['region'] . 'の' . $genreName . $sortName . 'の一覧';
            } elseif (!empty($searchResult['station'])) {
                $title = $request->keyword . 'の' . $searchResult['station'] . 'の' . $genreName . $sortName . '' . $page['page'] . '｜EPARKスイーツガイド';
                $description = 'EPARKスイーツガイドの' . $request->keyword . 'の' . $searchResult['station'] . 'の' . $genreName . $sortName . 'の一覧ページです。' . '誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,001件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！' . $page['pageForDescription'];
                $keywords = $request->keyword . ',' . $searchResult['station'] . ',' . $genreNameForKeyWord . ',スイーツ,予約' . $sortNameForKeyWord;
                $h1 = $request->keyword . 'の' . $searchResult['station'] . 'の' . $genreName . $sortName . 'の一覧';
            } else {
                $title = $request->keyword . 'の全国の' . $genreName . $sortName . '' . $page['page'] . '｜EPARKスイーツガイド';
                $description = 'EPARKスイーツガイドの' . $request->keyword . 'の全国の' . $genreName . $sortName . 'の一覧ページです。' . '誕生日ケーキ・バースデーケーキがネット予約できるEPARKスイーツガイド！全国約40,006件のスイーツ店情報から、話題の誕生日ケーキやスイーツを検索・WEB予約・お取り寄せできるサイトです。東京、神奈川、千葉、埼玉、大阪を中心に人気店などが続々掲載！' . $page['pageForDescription'];
                $keywords = $request->keyword . ',' . $genreNameForKeyWord . ',スイーツ,予約' . $sortNameForKeyWord;
                $h1 = $request->keyword . 'の全国の' . $genreName . $sortName . 'の一覧';
            }
        }
	$title = isset($request->reservation_flag) && $request->reservation_flag == 1 ? '<ネット予約可>'.$title : $title;
        return compact('title', 'description', 'keywords', 'h1', 'sort');
    }

    public function getPageAndDescription($request)
    {
        $page = ($request->has('page') && (int) $request->page > 0) ? '（おすすめ順・' . $request->page . 'ページ目）' : '';
        $pageForDescription = ($request->has('page') && (int) $request->page > 0) ? '(' . $request->page . 'ページ目)' : '';
        return compact('page', 'pageForDescription');
    }
}
