<?php

namespace Tests\Features\Shops;

use Symfony\Component\DomCrawler\Crawler;

// use Illuminate\Foundation\Testing\WithoutMiddleware;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

use TestCase;

class CommentsTest extends TestCase
{

    const NUM_OF_ITEMS = 10;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $test = $this->visitRoute('shop.comments', 20944);
        $crawler = $test->crawler();

        $totalCommentCount = $this->getTotalComments($crawler);
        $itemsPerPage = ceil($totalCommentCount / self::NUM_OF_ITEMS);
        $this->assertTrue($this->getShownComment($crawler) <= $itemsPerPage);
    }

    public function getShownComment(Crawler $crawler)
    {
        $items = $crawler->filter('#comments-panel')->children();
        return count($items);
    }

    private function getTotalComments(Crawler $crawler)
    {
        // Get total number in crawler
        $num = $crawler->filter('.list-tab ul li.active')->text();
        $num = preg_match('/[0-9]+/', $num, $numOutput);
        $num = count($numOutput) > 0 ? $numOutput[0] : 0;
        return $num;
    }

}
