<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Redirect;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index_all()
    {

        $userole2 = User::select('users.id', 'users.name', 'model_has_roles.role_id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->get();

        // echo $userole;
        $userole = array();
        foreach($userole2 as $user){
                // $user2 = json_decode($user);
                // print_r($user2,true);
                $userole [$user->id] =  $user->name;
        }
        // echo "<br>";
       //  dd($userole);

        // $Transacciones = Transaction::select(
        //     'Transactions.user_id',
        //     'Transactions.amount_total_transaction',
        //     'Transactions.type_transaction_id',
        //     'Transactions.client_id',
        //     'transactions.wallet_id',
        //     'transactions.transaction_date',
        //     'users.name',
        //     'type_transactions.name'
        // )->leftJoin(
        //     'users','users.id', '=', 'transactions.user_id'
        // )->leftJoin(
        //     'type_transactions', 'type_transactions.id', '=', '.transactions.type_transaction_id'
        // )->get();



        $Transacciones = Transaction::select(
            'Transactions.user_id',
            'Transactions.amount_total_transaction',
            'Transactions.type_transaction_id',
            'Transactions.client_id',
            'transactions.wallet_id',
            'transactions.transaction_date',
        )->get();



        dd($Transacciones);

        return view('agentes.index', compact('userole'));

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(5);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

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
       
        //$roles = Role::find();
        $user = User::find($user);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string', 'email','max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        User::findOrFail($user)->update($request->all());
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
