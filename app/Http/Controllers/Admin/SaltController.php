<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Salt;
use Illuminate\Http\Request;

class SaltController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salts = Salt::orderBy('name')->paginate(10);
        return view('admin.salts.index', compact('salts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.salts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:salts,name',
            'description' => 'nullable|string',
        ]);

        Salt::create($request->only(['name', 'description']));

        return redirect()->route('salts.index')->with('success', 'Salt/Composition created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salt $salt)
    {
        return view('admin.salts.edit', compact('salt'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salt $salt)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:salts,name,' . $salt->id,
            'description' => 'nullable|string',
        ]);

        $salt->update($request->only(['name', 'description']));

        return redirect()->route('salts.index')->with('success', 'Salt/Composition updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salt $salt)
    {
        $salt->delete();
        return redirect()->route('salts.index')->with('success', 'Salt/Composition deleted successfully!');
    }
}
