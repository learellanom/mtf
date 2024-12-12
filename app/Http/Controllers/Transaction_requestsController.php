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
    public function indexOperaciones(Request $request)
    {
        //

        $user = auth()->user();
        

        $group = $this->getGroupsByUserExterno($user->id);
        $group = count($group) > 0 ? $group[0] : "";
        
        // $request->type_request = 2;

        
        if ($request->type_request){
            $type_request_desde = $request->type_request;
            $type_request_hasta = $request->type_request;
            
        }else{
            $type_request_desde = 1;
            $type_request_hasta = 2;
        }
        // $request->status = "Pendiente";
        if ($request->status){
            $status_desde = $request->status;
            $status_hasta = $request->status;
        }else{
            $status_desde = "";
            $status_hasta = "ZZZZZZZZZZ";
        }

        $Transaction_request  = Transaction_request::
            select(
                'transaction_requests.id',
                'amount',
                'status',
                'transaction_requests.description',
                'transaction_date',
                'user_id',
                'group_id',
                'type_coin_id',
                'type_transaction_requests_id',
                'note', 
                'type_transaction_requests.name', 
                'type_transaction_requests.description as type_description',
                'type_transaction_requests.type_request as type_request',                
                )
            ->where('group_id',$group->GroupID)
            ->whereBetween('type_transaction_requests.type_request',array($type_request_desde, $type_request_hasta))
            ->whereBetween('status',array($status_desde, $status_hasta))
            ->leftjoin('type_transaction_requests','transaction_requests.type_transaction_requests_id','=','type_transaction_requests.id' )
            ->orderBy('transaction_date','DESC')
            ->take(10)
            ->get()
        ;



        // dd($Transaction_request);
        $parametros['Transaction_request']      = $Transaction_request;
        $parametros['user']                     = $user;
        $parametros['group']                    = $group;
        

        return view('transaction_requests.index', $parametros);        
    }
        /**
     * Display a listing of the resource.
     */
    public function indexResumen()
    {
        //
        $Type_transaction_request  = Type_transaction_request::where('type_request','1')->pluck('name', 'id')->toArray();
        $user   = auth()->user();
        $group  = $this->getGroupsByUserExterno($user->id);
        $group  = count($group) > 0 ? $group[0] : "";
        
        $Transaction_request  = Transaction_request::
            select(
                'type_transaction_requests.type_request', 
                DB::raw("
                    CASE
                        WHEN type_transaction_requests.type_request = 1 then 'Solicitud'
                        WHEN type_transaction_requests.type_request = 2 then 'Notificacion'
                    END
                    as type_request_name
                "), 
                'transaction_requests.status',
                DB::raw('count(transaction_requests.id)   as cantidad'),
                DB::raw('sum(transaction_requests.amount) as monto'),
                )
            ->where('group_id',$group->GroupID)
            ->whereIn('type_transaction_requests.type_request',['1','2'])
            ->leftjoin('type_transaction_requests','transaction_requests.type_transaction_requests_id','=','type_transaction_requests.id' )
            ->groupBy(['type_transaction_requests.type_request','type_transaction_requests.name', 'transaction_requests.status'])
            ->orderBy('type_transaction_requests.type_request','ASC')
            ->orderBy('transaction_requests.status','ASC')
            ->get()
        ;

        // dd($Transaction_request);
        $parametros['Transaction_request']      = $Transaction_request;
        $parametros['user']                     = $user;
        $parametros['group']                    = $group;
                
        return view('transaction_requests.resumen', $parametros);   
        

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
        $transaction_request = Transaction_request::find($id);
        // dd($transaction_request->amount);
        // dd($transaction_request->user->name);
        
        // dd($transaction_request->type_transaction_requests->name);
        // dd($transaction_request->group->name);
        $parametros['transaction_request'] = $transaction_request;

        return view('transaction_requests.show', $parametros);
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
