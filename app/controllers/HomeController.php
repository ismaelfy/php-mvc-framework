<?php
// app/controllers/HomeController.php

class HomeController
{
    public function index()
    {
        dd("wewelel");
        $model = new HomeModel();
        $data = $model->all();
        require_once('views/home.php');
    }

    public function show($id)
    {
        $model = new HomeModel();
        $data = $model->find($id);
        require_once('views/show.php');
    }
}
