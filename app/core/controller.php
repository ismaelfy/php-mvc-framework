<?php

namespace App\Core;

use App\Core\Request;


class Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function request()
    {
        return $this->request;
    }
}
