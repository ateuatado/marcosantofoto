<?php

namespace App\Controllers;

class Inicial extends BaseController
{
    public function index(): string
    {
        return view('inicial/index');
    }
}
