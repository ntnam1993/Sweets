<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Container\Container;

abstract class BaseRepository implements RepositoryInterface
{
    protected $app;

    protected $model;

    public function __construct()
    {
        $this->app = app(Container::class);

        $this->boot();
    }

    public function boot()
    {
        $this->model = $this->app->make($this->model());
    }

    abstract public function model();

    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    public function paginate($columns = ['*'])
    {
        return $this->model->paginate($columns);
    }

    public function findBy($fieldName, $value, $operator = '=', $columns = ['*'])
    {
        $this->boot();

        return $this->model->where($fieldName, $operator, $value)->get($columns);
    }

    public function findWhere($where, $columns = ['*'])
    {
        $this->boot();

        return $this->model->where($where)->get($columns);
    }

    public function with($relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }
}
