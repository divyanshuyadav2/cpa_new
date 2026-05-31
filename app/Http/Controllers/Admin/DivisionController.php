<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions = Division::with('company')->orderBy('name')->paginate(10);
        return view('admin.divisions.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::where('is_active', true)->orderBy('name')->get();
        return view('admin.divisions.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        // Unique name per company
        $exists = Division::where('company_id', $request->input('company_id'))
            ->where('name', $request->input('name'))
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['name' => 'A division with this name already exists for the selected company.']);
        }

        $data = $request->only(['name', 'company_id', 'description']);
        $data['is_active'] = $request->has('is_active');

        Division::create($data);

        return redirect()->route('divisions.index')->with('success', 'Division created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        $companies = Company::where('is_active', true)->orderBy('name')->get();
        return view('admin.divisions.edit', compact('division', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        // Unique name per company (excluding current division)
        $exists = Division::where('company_id', $request->input('company_id'))
            ->where('name', $request->input('name'))
            ->where('id', '!=', $division->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['name' => 'A division with this name already exists for the selected company.']);
        }

        $data = $request->only(['name', 'company_id', 'description']);
        $data['is_active'] = $request->has('is_active');

        $division->update($data);

        return redirect()->route('divisions.index')->with('success', 'Division updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        $division->delete();
        return redirect()->route('divisions.index')->with('success', 'Division deleted successfully!');
    }

    /**
     * AJAX endpoint to get divisions by company.
     */
    public function byCompany(Request $request)
    {
        $companyId = $request->query('company_id');
        
        if (!$companyId) {
            return response()->json([]);
        }

        $divisions = Division::where('company_id', $companyId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($divisions);
    }
}
