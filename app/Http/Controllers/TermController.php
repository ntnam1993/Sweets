<?php

namespace App\Http\Controllers;

class TermController extends BaseController
{

    public function index()
    {
        return view('term.' . $this->path . 'index');
    }

}
