<?php

namespace App;

use App\Services\CommentService;

class Review
{

    private $review;

    public static function connect($targetId, $count = 5, $start = 0)
    {
        $commentService = app(CommentService::class);
        $query = [
            'disp_count' => $count,
            'target_id' => $targetId,
            'disp_fg' => 1,
        ];
        if ($start) {
            $query['disp_start'] = $start;
        }
        $response = $commentService->search($query);
        return new Review($response->getBody());
    }

    public function __construct($review)
    {
        $this->review = $review;
    }

    public function __get($name)
    {
        return $this->review->$name;
    }

    public function item_exist()
    {
        return !empty($this->review->items);
    }

    public function star()
    {
        $stars = [
            '味' => 0,
            'ボリューム' => 0,
            '見た目' => 0,
            'サービス' => 0,
        ];
        $count = 0;
        foreach ($this->review->items as $key => $val) {
            $count++;
            foreach ($val->evaluate_star_list as $star) {
                if (!array_key_exists($star->evaluation_star_name, $stars)) {
                    $stars[$star->evaluation_star_name] = (int) $star->evaluation_star;
                } else {
                    $stars[$star->evaluation_star_name] += (int) $star->evaluation_star;
                }
            }
        }
        foreach ($stars as $key => $val) {
            if ($count > 0) {
                $stars[$key] = sprintf('%0.2f', round((float) ($val / $count), 2));
            }
        }
        return $stars;
    }

    public function image_list()
    {
        $items = [];
        foreach ($this->review->items as $item) {
            if (!empty($item->image)) {
                $items[] = $item;
            }
        }
        return $items;
    }
}
