<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\Controller;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.transactions.index');
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.transactions.create');
    }

}
