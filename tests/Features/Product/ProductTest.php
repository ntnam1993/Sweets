<?php

namespace Tests\Features\Product;

use TestCase;

class ProductTest extends TestCase
{
    protected $productId;
    protected $commentId;
    protected $shopId;

    public function setUp()
    {
        parent::setUp();

        $this->shopId = 21010;
        $this->commentId = 21010;
        $this->productId = 12015;

    }

    public function testProductIndex()
    {
        $this->get(route('product.detail', $this->productId))
            ->see('ネオラボスイーツガイドテスト店舗　定休日なし＆カレンダー備考なし')
            ->assertResponseStatus(200);
    }

    public function testProductIndexSp()
    {
        $this->setMobileAgent()
            ->get(route('product.detail', $this->productId))
            ->assertResponseStatus(200)
            ->see('10号サイズ');
    }

    public function testRedirectsToParentProductWhenAccessingChildProduct()
    {
        $this->get(route('product.detail', 11859))
            ->assertRedirectedTo(route('product.detail', 11858))
            ->assertResponseStatus(301)
        // Make sure after redirect to shop comments successfully
            ->followRedirects()
            ->assertResponseStatus(200);
    }

    public function testRedirectsToShopCommentsWhenAccessProductComments()
    {
        $this->get(route('product.comments', $this->productId))
            ->assertRedirectedTo(route('shop.comments', $this->shopId))
            ->assertResponseStatus(301)
        // Make sure after redirect to shop comments successfully
            ->followRedirects()
            ->assertResponseStatus(200);

    }

    public function testRedirectsToShopCommentsWhenAccessProductCommentsSp()
    {
        $this->setMobileAgent()
            ->get(route('product.comments', $this->productId))
            ->assertRedirectedTo(route('shop.comments', $this->shopId))
            ->assertResponseStatus(301)
        // Make sure after redirect to shop comments successfully
            ->followRedirects()
            ->assertResponseStatus(200);
    }

    public function testRedirectsToShopCommentsWhenAccessProductCommentDetail()
    {
        $this->get(route('product.comment_detail', [$this->productId, $this->commentId]))
            ->assertRedirectedTo(route('shop.comments', $this->shopId))
            ->assertResponseStatus(301)
        // Make sure after redirect to shop comments successfully
            ->followRedirects()
            ->assertResponseStatus(200);
    }

    public function testRedirectsToShopCommentsWhenAccessProductCommentDetailSp()
    {
        $this->setMobileAgent()
            ->get(route('product.comment_detail', [$this->productId, $this->commentId]))
            ->assertRedirectedTo(route('shop.comments', $this->shopId))
            ->assertResponseStatus(301)
        // Make sure after redirect to shop comments successfully
            ->followRedirects()
            ->assertResponseStatus(200);
    }

    public function testOtherItemsOfShop()
    {
        $itemsCount = 5;
        $assertion = $this->visitRoute('product.other_item_of_shop', [$this->shopId, $this->productId])
            ->seeJP('9,999円（税込）〜');
        $crawler = $assertion->crawler();
        $listItems = $crawler->filter('a.other-product-link');
        $assertion->assertEquals($itemsCount, $listItems->count());
    }

    public function testOtherItemsOfShopSp()
    {
        $itemsCount = 6;
        $assertion = $this->setMobileAgent()
            ->visitRoute('product.other_item_of_shop', [$this->shopId, $this->productId])
            ->seeJP('9,999円（税込）〜');
        $crawler = $assertion->crawler();
        $listItems = $crawler->filter('div.item.item-scroll-det');
        $assertion->assertEquals($itemsCount, $listItems->count());
    }
}
