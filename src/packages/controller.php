<?php

namespace Controller;

use App\Packages\Request;


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
