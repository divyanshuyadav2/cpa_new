<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Models\Division;
use App\Models\Salt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Exception;

class ProductImportController extends Controller
{
    /**
     * Show the upload form.
     */
    public function index()
    {
        return view('admin.products.import');
    }

    /**
     * Handle the file upload, parse headers, and show mapping form.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('import_file');
        
        // Save file temporarily
        $path = $file->storeAs('temp', 'import_' . time() . '.csv');
        $fullPath = storage_path('app/' . $path);

        if (!file_exists($fullPath)) {
            return back()->with('error', 'Failed to upload file.');
        }

        // Read the first line to get headers
        $handle = fopen($fullPath, 'r');
        $headers = fgetcsv($handle);
        fclose($handle);

        if (!$headers) {
            return back()->with('error', 'The uploaded file is empty or not a valid CSV.');
        }

        // Clean headers (remove BOM and trim)
        $headers = array_map(function($header) {
            // Remove BOM if present
            $header = preg_replace('/\x{FEFF}/u', '', $header);
            return trim($header);
        }, $headers);

        // Required or available fields in the DB to map to
        $dbFields = [
            'name' => 'Item Name (Required)',
            'company_name' => 'Company Name',
            'division_name' => 'Division Name',
            'salt_name' => 'Salt / Composition',
            'packing' => 'Packing (e.g. 10x10)',
            'mrp' => 'MRP',
            'ptr' => 'PTR',
            'pts' => 'PTS',
            'stock_qty' => 'Stock Quantity',
        ];

        return view('admin.products.import_mapping', compact('headers', 'dbFields', 'path'));
    }

    /**
     * Process the CSV with the mapped columns.
     */
    public function process(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
            'mapping' => 'required|array',
            'mapping.name' => 'required|string', // Product name is strictly required
        ], [
            'mapping.name.required' => 'You must map a column to the Item Name.',
        ]);

        $path = storage_path('app/' . $request->path);
        
        if (!file_exists($path)) {
            return redirect()->route('products.import.index')->with('error', 'Import file not found. Please upload again.');
        }

        $mapping = $request->mapping;
        
        $handle = fopen($path, 'r');
        $headers = fgetcsv($handle);
        
        // Clean headers
        $headers = array_map(function($header) {
            return trim(preg_replace('/\x{FEFF}/u', '', $header));
        }, $headers);

        $successCount = 0;
        $errorCount = 0;
        
        // Map header name to its column index
        $headerIndices = array_flip($headers);

        // Read rows
        while (($row = fgetcsv($handle)) !== false) {
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            try {
                // Get mapped values for this row
                $nameCol = $mapping['name'] ?? null;
                $name = $nameCol && isset($headerIndices[$nameCol]) ? trim($row[$headerIndices[$nameCol]]) : null;

                if (empty($name)) {
                    $errorCount++;
                    continue; // Skip if no name
                }

                // Handle Company
                $companyId = null;
                $companyCol = $mapping['company_name'] ?? null;
                if ($companyCol && isset($headerIndices[$companyCol])) {
                    $companyName = trim($row[$headerIndices[$companyCol]]);
                    if (!empty($companyName)) {
                        $company = Company::firstOrCreate(['name' => $companyName], ['is_active' => true]);
                        $companyId = $company->id;
                    }
                }

                // Handle Division
                $divisionId = null;
                $divisionCol = $mapping['division_name'] ?? null;
                if ($divisionCol && isset($headerIndices[$divisionCol])) {
                    $divisionName = trim($row[$headerIndices[$divisionCol]]);
                    if (!empty($divisionName) && $companyId) {
                        $division = Division::firstOrCreate([
                            'name' => $divisionName,
                            'company_id' => $companyId
                        ], ['is_active' => true]);
                        $divisionId = $division->id;
                    }
                }

                // Handle Salt
                $saltId = null;
                $saltCol = $mapping['salt_name'] ?? null;
                if ($saltCol && isset($headerIndices[$saltCol])) {
                    $saltName = trim($row[$headerIndices[$saltCol]]);
                    if (!empty($saltName)) {
                        $salt = Salt::firstOrCreate(['name' => $saltName], ['is_active' => true]);
                        $saltId = $salt->id;
                    }
                }

                // Basic fields
                $getVal = function($fieldKey) use ($mapping, $headerIndices, $row) {
                    $col = $mapping[$fieldKey] ?? null;
                    return ($col && isset($headerIndices[$col])) ? trim($row[$headerIndices[$col]]) : null;
                };

                $packing = $getVal('packing');
                $mrp = floatval($getVal('mrp')) ?: 0;
                $ptr = floatval($getVal('ptr')) ?: 0;
                $pts = floatval($getVal('pts')) ?: 0;
                $stockQty = intval($getVal('stock_qty')) ?: 0;

                // Create or update product
                Product::updateOrCreate(
                    [
                        'name' => $name,
                        'company_id' => $companyId
                    ],
                    [
                        'division_id' => $divisionId,
                        'salt_id' => $saltId,
                        'composition' => $saltName ?? null, // Often same as salt for legacy reasons
                        'packing' => $packing,
                        'mrp' => $mrp,
                        'ptr' => $ptr,
                        'pts' => $pts,
                        'stock_qty' => $stockQty,
                        'is_active' => true,
                    ]
                );

                $successCount++;
            } catch (Exception $e) {
                // Log or ignore individual row errors
                $errorCount++;
            }
        }

        fclose($handle);
        
        // Clean up temp file
        Storage::delete($request->path);

        return redirect()->route('products.index')->with('success', "Import completed. {$successCount} products imported successfully. " . ($errorCount > 0 ? "{$errorCount} failed." : ""));
    }
}
