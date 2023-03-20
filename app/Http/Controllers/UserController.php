<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Client;
use App\Models\Wallet;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Redirect;
use Pest\Support\Str;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index_all(Request $request)
    {

        $myUser = 0;
        if ($request->usuario) {
            $myUser = $request->usuario;
        }     
        
        $myCliente = 0;
        if ($request->cliente) {
            $myCliente = $request->cliente;
        }     


        $myWallet = 0;
        if ($request->wallet) {
            $myWallet = $request->wallet;
        }     

        \Log::info('leam usuario *** -> ' . $request->usuario);
        \Log::info('leam cliente *** -> ' . $request->cliente);
        \Log::info('leam wallet *** -> ' . $request->wallet);

        /*
        echo "<br>con el request";
        echo "<br>usuariox -> " . $request->usuario;
        echo "<br>Cliente  -> " . $request->cliente;      
          
        echo "<br>Wallet  -> "  . $request->wallet;                
        echo "<br>";
        var_dump($request);
        die(); 
        */


        $myUserDesde = 0;
        $myUserHasta = 9999;
        $myClienteDesde = 0;
        $myClienteHasta = 9999;
        $myWalletDesde = 0;
        $myWalletHasta = 9999;

        if ($myUser != 0){
            $myUserDesde = $myUser;
            $myUserHasta = $myUser;
        }
        if ($myCliente != 0){
            $myClienteDesde = $myCliente;
            $myClienteHasta = $myCliente;
        }
        if ($myWallet != 0){
            $myWalletDesde = $myWallet;
            $myWalletHasta = $myWallet;
        }                

        // print_r($myUser);
        // die();

        $userole2 = User::select('users.id', 'users.name', 'model_has_roles.role_id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->get();

        // echo $userole;
        $userole = array();
        foreach($userole2 as $user){
            $userole [$user->id] =  $user->name;
        }

        $Transacciones = Transaction::select(
        //  'Transactions.user_id as Id',
            'users.name as AgenteName',
            'Transactions.amount as Monto',
        //  'Transactions.type_transaction_id as TransactionId',
            'type_transactions.name as TipoTransaccion',
        //  'Transactions.client_id as ClienteId',
        //  'transactions.wallet_id As WalletId',
            'wallets.name As WalletName',
            'transactions.transaction_date as FechaTransaccion',
            'clients.name as ClientName',
        )->leftJoin(
            'users','users.id', '=', 'transactions.user_id'
        )->leftJoin(
            'type_transactions', 'type_transactions.id', '=', 'transactions.type_transaction_id'
        )->leftJoin(
            'wallets', 'wallets.id', '=', 'transactions.wallet_id'
        )->leftJoin(
            'clients', 'clients.id', '=', 'transactions.client_id'  
        )->whereBetween('Transactions.user_id', [$myUserDesde, $myUserHasta]
        )->whereBetween('Transactions.client_id', [$myClienteDesde, $myClienteHasta]
        )->whereBetween('Transactions.wallet_id', [$myWalletDesde, $myWalletHasta]        
        )->get();
    
        $Transacciones2 = array();
        foreach($Transacciones as $tran){
            // echo " trans " . json_decode($tran);
            $value1 = json_decode($tran);

            $value2 = array_values(json_decode(json_encode($tran), true));

            array_push($Transacciones2, $value2);
        }
  
        // $Transacciones = Transaction::select(
        //     'Transactions.user_id',
        //     'Transactions.amount_total_transaction',
        //     'Transactions.type_transaction_id',
        //     'Transactions.client_id',
        //     'transactions.wallet_id',
        //     'transactions.transaction_date',
        // )->get();

          $Transacciones3 = Transaction::all();

          $cliente = Client::select('clients.id', 'clients.name')
          ->get();

          //dd($cliente);

          //*********************************************************

          $cliente2 = array();
          foreach($cliente as $cliente){
              $cliente2 [$cliente->id] =  $cliente->name;
          }
          $cliente = $cliente2;

          //***********************************************************

          $wallet = Wallet::select('wallets.id', 'wallets.name')
          ->get();

          //dd($wallet);

          $wallet2 = array();
          foreach($wallet as $wallet){
              $wallet22 [$wallet->id] =  $wallet->name;
          }
          $wallet = $wallet22;

        return view('agentes.index', compact('myUser','userole','Transacciones','cliente','wallet','myCliente','myUser','myWallet'));

    }

    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::all();
        return view('users.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->assignRole($request->roles);



        return redirect()->route('users.index')->with('success', 'Successfully created');
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
    public function edit($user)
    {
        $user = User::find($user);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function password($user)
    {
        $user = User::find($user);

        return view('users.password', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_password(Request $request, $user)
    {
        $user = User::findOrFail($user);
        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->update();

        return Redirect::route('users.index')->with('update', 'ok');
    }

    public function update_users(Request $request, $user)
    {

            User::findOrFail($user)->update($request->all());

            $user = User::find($user);
            $user->syncRoles($request->roles);


            return Redirect::route('users.index')->with('update', 'ok');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($usuario): RedirectResponse
    {

        $usuario = User::find($usuario);

        $usuario->delete();

        return Redirect::route('users.index')->with('destroy','ok');
    }
}

?>
