<?php

namespace App\Repositories\Eloquents;

use App\InformationRequest;
use App\Repositories\Contracts\InformationRequestRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class InformationRequestEloquent extends BaseRepository implements InformationRequestRepository
{
    const COOKIE_NAME = 'PHPSESSID_SG';

    protected $request;

    public function model()
    {
        return InformationRequest::class;
    }

    public function boot()
    {
        parent::boot();

        $this->request = app(Request::class);
    }

    public function getCookie()
    {
        if (!array_key_exists(static::COOKIE_NAME, $_COOKIE)) {
            return '';
        }

        return $_COOKIE[static::COOKIE_NAME];
    }

    /**
     * Find by using store_id and cookie_val from request
     *
     * @param mixed $shop_id
     * @param array $columns = ['*']
     * @return Collection
     */
    public function findByShop($shop_id, $columns = ['*'])
    {
        $cookie_val = $this->getCookie();

        $where = compact('shop_id', 'cookie_val');

        return $this->findWhere($where, $columns);
    }

    public function countByShop($shop_id)
    {
        return $this->findWhere(compact('shop_id'), ['id'])->count();
    }

    public function requestInformation($shop_id)
    {
        $cookie_val = $this->getCookie();
        $request_date = Carbon::now();

        $data = compact('shop_id', 'cookie_val', 'request_date');

        $request = $this->findByShop($shop_id, ['id'])->first();

        if (!empty($request)) {
            $request->delete();

            return false;
        } else {
            $this->model->insert($data);

            return true;
        }
    }
}
