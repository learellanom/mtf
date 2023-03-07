<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class UserController extends Controller
{
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

        return redirect()->route('users.index');
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
    public function edit(User $user)
    {
        $role = Role::all();
        $user = User::find($user);
        return view('users.edit', compact('user', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'=> 'required',
            'slug'=> 'required|unique:categories',
        ]);

        $user->update($request->all());
        return redirect()->route('users.index')->with('info','El usuario se actualizo con exito! ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $users = User::find($user->id);
        $users->delete();
        return Redirect()->route('users.index')->with('info','Se elimino con extio al usuario');
    }
}

?>
