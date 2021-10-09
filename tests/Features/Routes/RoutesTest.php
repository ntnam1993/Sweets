<?php

namespace Tests\Features\Routes;

use TestCase;

class RoutesTest extends TestCase
{
    protected $shopId;
    protected $productId;

    public function setUp()
    {
        parent::setUp();

        $this->shopId = 20944;
        $this->productId = 111;
    }

    public function testIndex()
    {
        $this->visit('/')
            ->assertResponseStatus(200)
            ->see('誕生日ケーキを予約');
    }

    public function testLogin()
    {
        $this->visit(route('login'))
            ->assertResponseStatus(200);
    }

    public function testTerms()
    {
        $this->visitRoute('terms')
            ->assertResponseStatus(200)
            ->see('利用規約');
    }

    public function testPrivacy()
    {
        $this->get(route('privacy'))
            ->see('プライバシーポリシー')
            ->assertResponseStatus(200);
    }

    public function testPrivacySp()
    {
        $this->setMobileAgent()
            ->get(route('privacy'))
            ->see('ドメイン・IPアドレスについて')
            ->assertResponseStatus(200);
    }

    public function testCompany()
    {
        $this->get(route('about_us'))
            ->see('株式会社EPARKスイーツ')
            ->assertResponseStatus(200);
    }

    public function testCompanySp()
    {
        $this->setMobileAgent()
            ->get(route('about_us'))
            ->see('加盟団体')
            ->assertResponseStatus(200);
    }

    public function testContact()
    {
        $this->get(route('contact'))
            ->see('「次へ」ボタンをタップしてください。')
            ->assertResponseStatus(200);
    }

    public function testContactSp()
    {
        $this->setMobileAgent()
            ->get(route('contact'))
            ->see('資料請求・お問い合わせ')
            ->assertResponseStatus(200);
    }

    public function testOriginal328()
    {
        $this->get(route('original-328'))
            ->see('商品を予約して下さい。')
            ->assertResponseStatus(200);
    }

    public function testOriginal328Sp()
    {
        $this->setMobileAgent()
            ->get(route('original-328'))
            ->see('希望受け取り日時に店舗へ商品を受け取りに行って下さい。')
            ->assertResponseStatus(200);
    }

    public function testOriginal333()
    {
        $this->get(route('original-333'))
            ->assertRedirectedTo(route('error'))
            ->assertResponseStatus(302)
        // Make sure after redirect to successfully
            ->followRedirects()
            ->assertResponseStatus(200);
    }

    public function testOriginal333Sp()
    {
        $this->setMobileAgent()
            ->get(route('original-333'))
            ->assertRedirectedTo(route('error'))
            ->assertResponseStatus(302)
        // Make sure after redirect to successfully
            ->followRedirects()
            ->assertResponseStatus(200);
    }

    public function testOriginal410()
    {
        $this->get(route('original-410'))
            ->see('キャンペーン実施期間')
            ->assertResponseStatus(200);
    }

    public function testOriginal410Sp()
    {
        $this->setMobileAgent()
            ->get(route('original-410'))
            ->see('キャンペーン対象者')
            ->assertResponseStatus(200);
    }

    public function testOriginal400()
    {
        $this->get(route('original-400'))
            ->see('キャンペーン概要')
            ->assertResponseStatus(200);
    }

    public function testOriginal400Sp()
    {
        $this->setMobileAgent()
            ->get(route('original-400'))
            ->see('※上記の口コミは書き方の例のため、キャンペーン対象とは異なります。')
            ->assertResponseStatus(200);
    }

    public function testGetRailLines()
    {
        $param = [
            'prefectureId' => 1,
            'isTopPC' => true,
            'rootName' => '北海道・東北',
            'provName' => '北海道',
        ];
        $itemsCount = 8;
        $assertion = $this->visit(route('get_rail_lines', $param))
            ->seeJP('北海道の駅から探す')
            ->assertResponseStatus(200);
        $crawler = $this->crawler();
        $listItems = $crawler->filter('ul li a');
        $assertion->assertEquals($itemsCount, $listItems->count());
    }

    public function testGetRailLinesSp()
    {
        $param = [
            'prefectureId' => 1,
            'isTopPC' => true,
            'rootName' => '北海道・東北',
            'provName' => '北海道',
        ];
        $itemsCount = 8;
        $assertion = $this->setMobileAgent()
            ->visit(route('get_rail_lines', $param))
            ->seeJP('北海道の駅から探す')
            ->assertResponseStatus(200);
        $crawler = $this->crawler();
        $listItems = $crawler->filter('li a');
        $assertion->assertEquals($itemsCount, $listItems->count());
    }

    public function testGetStations()
    {
        $param = [
            'railLineId' => 1,
            'prefectureId' => 1,
            'isTopPC' => true,
            'provName' => '北海道',
            'stationName' => '函館本線',
            'station_id' => 15,
        ];
        $assertion = $this->visitRoute('get_stations', $param)
            ->seeJP('〈 すべてに戻る')
            ->assertResponseStatus(200);
        $itemsCount = 2;
        $crawler = $assertion->crawler();
        $listItems = $crawler->filter('ul li a');
        $assertion->assertEquals($itemsCount, $listItems->count());
    }

    public function testGetStationsSpNonReTurnToResult()
    {
        $param = [
            'railLineId' => 1,
            'prefectureId' => 1,
            'isTopPC' => true,
            'provName' => '北海道',
            'stationName' => '函館本線',
            'station_id' => 15,
        ];
        $assertion = $this->setMobileAgent()
            ->visitRoute('get_stations', $param)
            ->seeJP('〈 すべてに戻る')
            ->assertResponseStatus(200);
        $itemsCount = 0;
        $crawler = $assertion->crawler();
        $listItems = $crawler->filter('ul li a');
        $assertion->assertEquals($itemsCount, $listItems->count());
    }

    public function testGetStationsSpReTurnToResult()
    {
        $param = [
            'railLineId' => 1,
            'prefectureId' => 1,
            'isTopPC' => true,
            'provName' => '北海道',
            'stationName' => '函館本線',
            'station_id' => 73,
        ];
        $assertion = $this->setMobileAgent()
            ->visitRoute('get_stations', $param)
            ->seeJP('〈 すべてに戻る')
            ->assertResponseStatus(200);
        $itemsCount = 2;
        $crawler = $assertion->crawler();
        $listItems = $crawler->filter('li a');
        $assertion->assertEquals($itemsCount, $listItems->count());
    }

    public function testGetGenres()
    {
        $assertion = $this->visitRoute('get_genres', ['genre_id' => 15, 'data_category_name' => 'チョコレートケーキ'])
            ->seeJP('青森県の駅から探す')
            ->assertResponseStatus(200);
        $itemsCount = 6;
        $crawler = $assertion->crawler();
        $listItems = $crawler->filter('ul li a');
        $assertion->assertEquals($itemsCount, $listItems->count());
    }

    public function testGetGenresSp()
    {
        $assertion = $this->setMobileAgent()
            ->visitRoute('get_genres', ['genre_id' => 15, 'data_category_name' => 'チョコレートケーキ'])
            ->assertResponseStatus(200);
        $itemsCount = 6;
        $crawler = $assertion->crawler();
        $listItems = $crawler->filter('ul li a');
        $assertion->assertEquals($itemsCount, $listItems->count());

    }

    public function testGetSubRegions()
    {
        $param = [
            'tokyo' => 1,
            'parent_region_id' => 783,
            'region_id' => 783,
            'parent_region_name' => '東京',
            'isShopSearch' => 'shopsearch . region',
        ];
        $assertion = $this->visitRoute('get_sub_regions', $param)
            ->seeJP('検索結果がありません')
            ->assertResponseStatus(200);
        $itemsCount = 63;
        $crawler = $assertion->crawler();
        $listItems = $crawler->filter('ul li a');
        $assertion->assertEquals($itemsCount, $listItems->count());
    }

    public function test302RedirectToRouteErrorWhen404Error()
    {
        $this->get(route('product.detail', 0))
            ->assertRedirectedTo(route('error'))
            ->assertResponseStatus(302)
        // Make sure after redirect to successfully
            ->followRedirects()
            ->assertResponseStatus(200);
    }

    public function test302RedirectToRouteErrorWhen404ErrorSp()
    {
        $this->setMobileAgent()
            ->get(route('product.detail', 0))
            ->assertRedirectedTo(route('error'))
            ->assertResponseStatus(302)
        // Make sure after redirect to successfully
            ->followRedirects()
            ->assertResponseStatus(200);
    }

    public function testBrowsingHistory()
    {
        $this->get(route('browsing_history'))
            ->assertResponseStatus(200);
    }

    public function testBrowsingHistorySP()
    {
        $this->setMobileAgent()
            ->get(route('browsing_history'))
            ->assertResponseStatus(200)
            ->seeJP('閲覧履歴');
    }

    public function testGetRailLinesById()
    {
        $params = ['station_id' => 113, 'isTopPC' => true];
        $this->get(route('get_rail_lines_by_id', $params))
            ->assertResponseStatus(200)
            ->seeJP('東北北海道');
    }

    public function testGetRailLinesByIdSP()
    {
        $params = ['station_id' => 113, 'isTopPC' => true];
        $this->setMobileAgent()
            ->get(route('get_rail_lines_by_id', $params))
            ->assertResponseStatus(200)
            ->seeJP('函館本線');
    }

    public function testGetSubRegionById()
    {
        $this->get(route('get_sub_regions_by_id', 1960))
            ->assertResponseStatus(200)
            ->seeJP('群馬県の駅から探す');
    }
}
