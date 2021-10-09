<?php

namespace App\Http\Controllers;

class AboutUsController extends BaseController
{

    public function index()
    {
        return view('about.' . $this->path . 'index');
    }

}
