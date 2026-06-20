<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::orderBy('name')->paginate(10);
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'logo' => 'nullable|image|max:2048', // max 2MB
            'logo_url' => 'nullable|url|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['name', 'description']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo')) {
            // File upload takes priority
            $logoPath = $request->file('logo')->store('companies', 'public');
            $data['logo'] = $logoPath;
        } elseif ($request->filled('logo_url')) {
            // Store URL directly
            $data['logo'] = $request->input('logo_url');
        }

        Company::create($data);

        return redirect()->route('companies.index')->with('success', 'Company created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:companies,name,' . $company->id,
            'logo' => 'nullable|image|max:2048',
            'logo_url' => 'nullable|url|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['name', 'description']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo')) {
            // Delete old logo if it was a stored file (not a URL)
            if ($company->logo && !filter_var($company->logo, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($company->logo);
            }
            $logoPath = $request->file('logo')->store('companies', 'public');
            $data['logo'] = $logoPath;
        } elseif ($request->filled('logo_url')) {
            // Delete old file if switching to URL
            if ($company->logo && !filter_var($company->logo, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($company->logo);
            }
            $data['logo'] = $request->input('logo_url');
        }

        $company->update($data);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // Delete logo file only if it's a stored file (not a URL)
        if ($company->logo && !filter_var($company->logo, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully!');
    }
}
