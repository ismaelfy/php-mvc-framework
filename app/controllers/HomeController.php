<?php
namespace App\Controllers;

use App\Core\DB;

class HomeController
{
    public function index()
    {
        $users = DB::table('users')->findAll();
        return view('home', $users);
    }

    public function show($id)
    {
        $users = DB::table('users')->findAll();
        return view('show', $users);
    }
}
