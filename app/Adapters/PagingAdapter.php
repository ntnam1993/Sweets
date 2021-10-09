<?php

namespace App\Adapters;

class PagingAdapter
{
    protected function getCommonParams($numFound, $page, $quantity)
    {
        $paging = [
            'numFound' => $numFound,
            'numPage' => ceil($numFound / $quantity),
            'numCount' => $quantity,
            'currentPage' => $page,
        ];
        if (is_null($paging['currentPage']) || $paging['currentPage'] < 1) {
            $paging['currentPage'] = 1;
        }
        return $paging;
    }

    public function fromAPI($list, $page, $quantity)
    {
        if (empty($list->item) && empty($list->items)) {
            return $this->getCommonParams(0, $page, $quantity);
        }

        $numFound = $list->num_found;
        $paging = $this->getCommonParams($numFound, $page, $quantity);

        return $paging;
    }

    public function fromList(array $list, $page, $quantity)
    {
        $numFound = !empty($list) ? count($list) : 0;
        return $this->getCommonParams($numFound, $page, $quantity);
    }

    public function fromArray($count, $page, $quantity)
    {
        return $this->getCommonParams($count, $page, $quantity);
    }
}
