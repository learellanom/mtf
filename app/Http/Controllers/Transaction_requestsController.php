<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Type_transaction_request;
use App\Models\Transaction_request;
use Illuminate\Support\Facades\DB;

class Transaction_requestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Type_transaction_request  = Type_transaction_request::where('type_request','1')->pluck('name', 'id')->toArray();
        $user = auth()->user();
        

        $group = $this->getGroupsByUserExterno($user->id);
        $group = count($group) > 0 ? $group[0] : "";
        $transaction_date = now();
         // dd($group);
        $parametros['type_transaction_request'] = $Type_transaction_request;
        $parametros['user']                     = $user;
        $parametros['group']                    = $group;
        $parametros['transaction_date']         = $transaction_date;

        return view('transaction_requests.create', $parametros);        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
        return view('transaction_requests.create');        
    }
    public function createRequestNotificacion()
    {
        //
        $Type_transaction_request  = Type_transaction_request::where('type_request','2')->pluck('name', 'id')->toArray();
        $user = auth()->user();
        

        $group = $this->getGroupsByUserExterno($user->id);
        $group = count($group) > 0 ? $group[0] : "";
        $transaction_date = now();
         // dd($group);
        $parametros['type_transaction_request'] = $Type_transaction_request;
        $parametros['user']                     = $user;
        $parametros['group']                    = $group;
        $parametros['transaction_date']         = $transaction_date;      
        // dd($parametros);
        return view('transaction_requests.createNotificacion', $parametros);         
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        Transaction_request::create($request->all());

        flash()->addSuccess('Solicitud creado con exito.', 'Tipo de Material', ['timeOut' => 3000]);


        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function getGroupsByUserExterno( $myUser = 0){

        $groups            = array();     
        
        $myQuery =
        "
            select
                group_users.group_id  as GroupID,
                mtf.groups.name       as GroupName,
                mtf.groups.type       as GroupType
            from
                mtf.group_users
                left join mtf.groups              on mtf.group_users.group_id           = mtf.groups.id
            where
                user_id                 between $myUser                and $myUser
                and mtf.groups.type  in('1')
        ";
        
        
        $groups = DB::select($myQuery);
        // dd($myQuery);
        return $groups;
    }



}
