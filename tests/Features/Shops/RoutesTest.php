<?php

namespace Tests\Features\Shops;

use TestCase;

class RoutesTest extends TestCase
{
    protected $shopId;
    protected $commentId;
    protected $noneShopId;

    public function setUp()
    {
        parent::setUp();

        $this->shopId = 20944;
        $this->commentId = 785;
        $this->noneShopId = 209442;
    }

    public function testShopIndex()
    {
        $this->get(route('shop.index', $this->shopId))
            ->assertResponseStatus(200)
            ->seeJP('臼倉テスト');
    }

    public function testShopIndexSP()
    {
        $this->setMobileAgent()
            ->get(route('shop.index', $this->shopId))
            ->assertResponseStatus(200)
            ->seeJP('臼倉テスト');
    }

    public function testNoneShopIndex()
    {
        $this->get(route('shop.index', $this->noneShopId))
            ->assertResponseStatus(302)
            ->assertRedirectedTo(route('error'));
    }

    public function testShopMenu()
    {
        $this->get(route('shop.menu', $this->shopId))
            ->assertResponseStatus(200)
            ->seeJP('メニュー');
    }

    public function testShopMenuSP()
    {
        $this->setMobileAgent()
            ->get(route('shop.menu', $this->shopId))
            ->assertResponseStatus(200)
            ->seeJP('メニュー');
    }

    public function testShopNoneMenu()
    {
        $this->get(route('shop.menu', $this->noneShopId))
            ->assertResponseStatus(302)
            ->assertRedirectedTo(route('error'))
            ->seeJP('お探しのページは見つかりませんでした');
    }

    public function testShopComments()
    {
        $this->get(route('shop.comments', $this->shopId))
            ->assertResponseStatus(200)
            ->seeJP('口コミ');
    }

    public function testShopNoneComments()
    {
        $this->get(route('shop.comments', $this->noneShopId))
            ->assertResponseStatus(302)
            ->assertRedirectedTo(route('error'));
    }

    public function testShopCommentDetail()
    {
        $this->get(route('shop.comment_detail', [$this->shopId, $this->commentId]))
            ->seeJP('口コミ詳細');
    }

    public function testShopPhoto()
    {
        $this->get(route('shop.photo', $this->shopId))
            ->assertRedirectedTo(route('shop.index', $this->shopId));
    }

    public function testShopNonePhoto()
    {
        $this->get(route('shop.photo', $this->noneShopId))
            ->assertResponseStatus(302)
            ->assertRedirectedTo(route('error'));
    }

    public function testShopPhotoSP()
    {
        $this->setMobileAgent()
            ->get(route('shop.photo', $this->shopId))
            ->assertResponseStatus(200)
            ->seeJP('写真一覧');
    }

    public function testShopMap()
    {
        $this->get(Route('shop.map', $this->shopId))
            ->assertResponseStatus(200)
            ->seeJP('地図');
    }

    public function testShopNoneMap()
    {
        $this->get(Route('shop.map', $this->noneShopId))
            ->assertResponseStatus(302)
            ->assertRedirectedTo(route('error'));
    }

    public function testShopNoneMapSP()
    {
        $this->setMobileAgent()
            ->get(route('shop.map', $this->noneShopId))
            ->assertResponseStatus(302)
            ->assertRedirectedTo(route('error'));
    }

    public function testShopCoupon()
    {
        $this->get(route('shop.coupon', $this->shopId))
            ->assertResponseStatus(200)
            ->seeJP('クーポン');
    }

    public function testShopNoneCoupon()
    {
        $this->get(route('shop.coupon', $this->noneShopId))
            ->assertResponseStatus(302)
            ->assertRedirectedTo(route('error'));
    }

    public function testShopNoneCouponSP()
    {
        $this->setMobileAgent()
            ->get(route('shop.coupon', $this->noneShopId))
            ->assertResponseStatus(302)
            ->assertRedirectedTo(route('error'));
    }
}
