<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function makers()
    {
        return view('makers');
    }
    public function types()
    {
        return view('types');
    }
    public function beer()
    {
        return view('beer');
    }
    public function listTypes()
    {
        return view('listTypes');
    }
    public function listMakers()
    {
        return view('listMakers');
    }
}
