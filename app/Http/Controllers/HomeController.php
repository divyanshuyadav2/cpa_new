<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use App\Models\StockistApplication;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        $companies = Company::where('is_active', true)->take(6)->get();
        $products = Product::with(['company', 'division', 'salt'])
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('home', compact('companies', 'products'));
    }

    /**
     * Display the about us and contact form page.
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Handle the contact/stockistship form submission.
     */
    public function submitAbout(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'message' => 'nullable|string',
        ]);

        StockistApplication::create($validated);

        return redirect()->route('about')->with('success', 'Your Stockistship application has been submitted successfully! We will contact you soon.');
    }
}
