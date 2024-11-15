<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        return view('web.pages.services.index', []);
    }


    public function show($id, $slug)
    {
        return view('web.pages.services.service.index', []);
    }
}
