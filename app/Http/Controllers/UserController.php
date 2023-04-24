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



        return redirect()->route('users.index')->with('success', 'Agente creado con exito.');
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

        return Redirect::route('users.index')->with('info', 'Contraseña modificada del Agente: <strong># '. $user->name . '</strong>');
    }

    public function update_users(Request $request, $user)
    {

            User::findOrFail($user)->update($request->all());

            $user = User::find($user);
            $user->syncRoles($request->roles);


            return Redirect::route('users.index')->with('info', 'Agente/Usuario modificado  <strong># '. $user->name . '</strong>');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($usuario): RedirectResponse
    {

        $usuario = User::find($usuario);

        $usuario->delete();

        return Redirect::route('users.index')->with('error', 'Agente/Usuario eliminado  <strong># '. $usuario->name . '</strong>');
    }


}

?>
