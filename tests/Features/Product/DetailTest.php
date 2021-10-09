<?php

namespace Tests\Features\Product;

use TestCase;

class DetailTest extends TestCase
{
    public function testNumberOfShownOtherItemsOfShop()
    {
        $params = [
            'shopId' => 20944,
            'productId' => 111,
        ];
        $this->visitRoute('product.other_item_of_shop', $params)
            ->assertResponseStatus(200)
            ->seeHeader('Content-Type', 'text/html; charset=UTF-8');

        $crawler = $this->crawler();
        $listItems = $crawler->filter('.red.pad-bot-10px');
        $this->assertTrue(5 >= $listItems->count());
    }
}
