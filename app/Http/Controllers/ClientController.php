<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('clients.index');
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        return view('clients.create');
    }

    public function edit()
    {   
        return view('clients.edit');
    }

}