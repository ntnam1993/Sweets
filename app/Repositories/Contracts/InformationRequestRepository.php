<?php

namespace App\Repositories\Contracts;

interface InformationRequestRepository extends RepositoryInterface
{
    public function findByShop($shop_id, $columns = ['*']);

    public function countByShop($shop_id);
}
