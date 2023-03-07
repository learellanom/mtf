<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transactions.index');
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        return view('transactions.create');
    }

}