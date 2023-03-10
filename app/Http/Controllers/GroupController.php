<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Client;
use Illuminate\Support\Facades\Redirect;
class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();
        return view('groups.index', compact('groups'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required|max:255',
            'phone' =>'required',
            'description' =>'required|max:255',
        ]);

        Group::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        return redirect(route('groups.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show($groups)
    {

        $group = Group::all($groups);

        return view('groups.show', compact('group'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $groups)
    {
       $group = Group::find($groups);

        return view('groups.edit', compact('group'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $groups)
    {
        Group::findOrFail($groups)->update($request->all());
        return Redirect::route('groups.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($groups)
    {
        $group = Group::find($groups);
        $group->delete();

        return Redirect::route('groups.index');

    }
}
