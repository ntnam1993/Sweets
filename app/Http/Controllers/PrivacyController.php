<?php

namespace App\Http\Controllers;

class PrivacyController extends BaseController
{

    public function index()
    {
        return view('privacy.' . $this->path . 'index');
    }

}
