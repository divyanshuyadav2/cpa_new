<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockistApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the applications.
     */
    public function index()
    {
        $applications = StockistApplication::latest()->paginate(15);
        return view('admin.applications.index', compact('applications'));
    }

    /**
     * Display the details of a specific application.
     */
    public function show(StockistApplication $application)
    {
        return view('admin.applications.show', compact('application'));
    }

    /**
     * Update the status of the application.
     */
    public function updateStatus(Request $request, StockistApplication $application)
    {
        $request->validate([
            'status' => 'required|in:Pending,Reviewed,Actioned',
        ]);

        $application->update(['status' => $request->input('status')]);

        return redirect()->route('applications.show', $application->id)
            ->with('success', "Application status updated to {$application->status} successfully!");
    }

    /**
     * Remove the application from storage.
     */
    public function destroy(StockistApplication $application)
    {
        $application->delete();
        return redirect()->route('applications.index')->with('success', 'Application deleted successfully!');
    }
}
