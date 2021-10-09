<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function all($columns = ['*']);

    public function paginate($columns = ['*']);

    public function findBy($fieldName, $value, $operator = '=', $columns = ['']);

    public function findWhere($where, $columns = ['*']);

    public function with($relations);
}
