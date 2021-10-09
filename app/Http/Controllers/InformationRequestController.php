<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\InformationRequestRepository;
use Illuminate\Http\Request;

class InformationRequestController extends Controller
{
    protected $repository;

    public function __construct(InformationRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function requests(Request $request, $shop)
    {
        if (!$request->isMethod('post')) {
            return redirect(route('shop.index', $shop), 301);
        }
        $user_requested = $this->repository->requestInformation($shop);

        $request_count = $this->repository->countByShop($shop);
        $request_count_pad = ($request_count < 1000) ? str_pad($request_count, 3, '0', STR_PAD_LEFT) : $request_count;

        return compact('request_count', 'user_requested', 'request_count_pad');
    }
}
