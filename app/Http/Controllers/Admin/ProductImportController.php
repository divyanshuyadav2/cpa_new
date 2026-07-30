<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Models\Division;
use App\Models\Salt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;
use Shuchkin\SimpleXLSX;

// NOTE: The 'local' disk root is storage/app/private (not storage/app).
// Always use Storage::disk('local')->path() instead of storage_path('app/...').

class ProductImportController extends Controller
{
    /**
     * DB field definitions: key => [label, common CSV header aliases for auto-detection]
     */
    private function dbFields(): array
    {
        return [
            'name'          => ['label' => 'Item Name (Required)',       'aliases' => ['name', 'item name', 'product name', 'item', 'product']],
            'hsn_code'      => ['label' => 'HSN Code',                   'aliases' => ['hsn', 'hsn code', 'hsn_code', 'hsncode']],
            'company_name'  => ['label' => 'Company Name',               'aliases' => ['company', 'company name', 'manufacturer', 'brand']],
            'division_name' => ['label' => 'Division Name',              'aliases' => ['division', 'division name']],
            'salt_name'     => ['label' => 'Salt / Composition',         'aliases' => ['salt', 'composition', 'salt name', 'ingredient']],
            'packing'       => ['label' => 'Packing (e.g. 10x10)',       'aliases' => ['packing', 'pack', 'pack size']],
            'mrp'           => ['label' => 'MRP',                        'aliases' => ['mrp', 'max retail price', 'retail price']],
            'ptr'           => ['label' => 'PTR / Sale Rate',            'aliases' => ['ptr', 'sale', 'sale rate', 'trade rate', 'ptr rate']],
            'pts'           => ['label' => 'PTS / Net Purchase Rate',    'aliases' => ['pts', 'np rate', 'np', 'net rate', 'purchase rate', 'net purchase']],
            'tax'           => ['label' => 'Tax (%)',                    'aliases' => ['tax', 'gst', 'tax %', 'gst %']],
            'a_tax'         => ['label' => 'Additional Tax (%)',         'aliases' => ['a.tax', 'a tax', 'additional tax', 'atax', 'a_tax']],
            'pur'           => ['label' => 'Purchase Price',             'aliases' => ['pur', 'purchase', 'pur rate', 'purchase price']],
            'stock_qty'     => ['label' => 'Stock Quantity',             'aliases' => ['stock', 'qty', 'stock qty', 'quantity', 'stock_qty']],
        ];
    }

    /**
     * Auto-detect the best matching DB field for each CSV header.
     */
    private function autoDetectMapping(array $csvHeaders): array
    {
        $autoMap     = [];
        $lowerHeaders = array_map('strtolower', $csvHeaders);

        foreach ($this->dbFields() as $fieldKey => $fieldDef) {
            foreach ($fieldDef['aliases'] as $alias) {
                $idx = array_search(strtolower($alias), $lowerHeaders);
                if ($idx !== false) {
                    $autoMap[$fieldKey] = $csvHeaders[$idx];
                    break;
                }
            }
        }

        return $autoMap;
    }

    /**
     * Find the index of the header row by looking for known column names.
     */
    private function findHeaderRowIndex(array $rows): int
    {
        $knownAliases = [];
        foreach ($this->dbFields() as $def) {
            $knownAliases = array_merge($knownAliases, $def['aliases']);
        }
        $knownAliases = array_map('strtolower', $knownAliases);

        $bestIndex = 0;
        $maxMatches = 0;

        // Scan first 30 rows to find the one with the most known headers
        $limit = min(30, count($rows));
        for ($i = 0; $i < $limit; $i++) {
            $row = $rows[$i];
            $matches = 0;
            foreach ($row as $cell) {
                if (is_string($cell) && in_array(strtolower(trim($cell)), $knownAliases)) {
                    $matches++;
                }
            }
            if ($matches > $maxMatches) {
                $maxMatches = $matches;
                $bestIndex  = $i;
            }
        }

        return $bestIndex;
    }

    /**
     * Find or create a Company by name (case-insensitive search first).
     */
    private function findOrCreateCompany(string $name): ?Company
    {
        $name = trim($name);
        if (empty($name) || strtoupper($name) === 'NULL') {
            return null;
        }

        // Case-insensitive lookup first
        $company = Company::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();
        if ($company) {
            return $company;
        }

        // Create new company
        return Company::create([
            'name'      => $name,
            'is_active' => true,
        ]);
    }

    /**
     * Show the upload form.
     */
    public function index()
    {
        return view('admin.products.import');
    }

    /**
     * Handle the file upload, parse headers, auto-detect mapping, show mapping form.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:csv,txt,xlsx,xls|max:10240',
        ]);

        $file = $request->file('import_file');
        $ext  = strtolower($file->getClientOriginalExtension());

        // Save file temporarily on the local disk (root: storage/app/private)
        $path = $file->storeAs('temp', 'import_' . time() . '.' . $ext, 'local');

        if (!$path || !Storage::disk('local')->exists($path)) {
            return back()->with('error', 'Failed to upload file. Please check storage permissions and try again.');
        }

        $fullPath = Storage::disk('local')->path($path);

        $allRows = [];

        if (in_array($ext, ['xlsx', 'xls'])) {
            if ($xlsx = SimpleXLSX::parse($fullPath)) {
                $allRows = $xlsx->rows();
            } else {
                Storage::disk('local')->delete($path);
                return back()->with('error', 'Error parsing Excel file: ' . SimpleXLSX::parseError());
            }
        } else {
            $handle = fopen($fullPath, 'r');
            while (($row = fgetcsv($handle)) !== false) {
                $allRows[] = $row;
            }
            fclose($handle);
        }

        if (empty($allRows)) {
            Storage::disk('local')->delete($path);
            return back()->with('error', 'The uploaded file is empty or unreadable.');
        }

        $headerIdx = $this->findHeaderRowIndex($allRows);
        $headers   = $allRows[$headerIdx];
        $dataRows  = array_slice($allRows, $headerIdx + 1);

        // Clean headers
        $headers = array_map(function ($header) {
            return trim(preg_replace('/\x{FEFF}/u', '', (string)$header));
        }, $headers);

        $previewRows = [];
        $totalRows   = 0;

        foreach ($dataRows as $row) {
            if (!empty(array_filter($row))) {
                if ($totalRows < 5) {
                    $previewRows[] = $row;
                }
                $totalRows++;
            }
        }

        if (empty($headers)) {
            Storage::disk('local')->delete($path);
            return back()->with('error', 'No headers found in the file.');
        }

        // Auto-detect column mapping
        $autoMap  = $this->autoDetectMapping($headers);
        $dbFields = array_map(fn($f) => $f['label'], $this->dbFields());

        return view('admin.products.import_mapping', compact('headers', 'dbFields', 'path', 'autoMap', 'previewRows', 'totalRows'));
    }

    /**
     * Process the CSV with the mapped columns.
     */
    public function process(Request $request)
    {
        $request->validate([
            'path'         => 'required|string',
            'mapping'      => 'required|array',
            'mapping.name' => 'required|string',
        ], [
            'mapping.name.required' => 'You must map a column to the Item Name.',
        ]);

        // Resolve full path via the local disk (root: storage/app/private)
        $relativePath = $request->path;

        if (!Storage::disk('local')->exists($relativePath)) {
            return redirect()->route('products.import.index')
                ->with('error', 'Import file not found. Please upload again.');
        }

        $storagePath = Storage::disk('local')->path($relativePath);
        $ext         = strtolower(pathinfo($storagePath, PATHINFO_EXTENSION));
        $mapping     = $request->mapping;

        $allRows = [];

        if (in_array($ext, ['xlsx', 'xls'])) {
            if ($xlsx = SimpleXLSX::parse($storagePath)) {
                $allRows = $xlsx->rows();
            } else {
                return redirect()->route('products.index')
                    ->with('error', 'Error parsing Excel file: ' . SimpleXLSX::parseError());
            }
        } else {
            $handle = fopen($storagePath, 'r');
            while (($row = fgetcsv($handle)) !== false) {
                $allRows[] = $row;
            }
            fclose($handle);
        }

        if (empty($allRows)) {
            return redirect()->route('products.index')
                ->with('error', 'No data found in the file.');
        }

        $headerIdx = $this->findHeaderRowIndex($allRows);
        $headers   = $allRows[$headerIdx];
        $dataRows  = array_slice($allRows, $headerIdx + 1);

        // Clean headers
        $headers = array_map(function ($h) {
            return trim(preg_replace('/\x{FEFF}/u', '', (string)$h));
        }, $headers);

        // Map header name → column index
        $headerIndices = array_flip($headers);

        $successCount = 0;
        $errorCount   = 0;
        $errors       = [];

        // Helper: get trimmed value from a row by mapped DB field key
        // Need to pass $row by reference at each iteration
        $getVal = function (string $fieldKey, array $row) use ($mapping, $headerIndices): ?string {
            $col = $mapping[$fieldKey] ?? null;
            if ($col && isset($headerIndices[$col])) {
                $val = trim($row[$headerIndices[$col]] ?? '');
                return $val !== '' ? $val : null;
            }
            return null;
        };

        $lineNumber = 1; // header already consumed

        foreach ($dataRows as $row) {
            $lineNumber++;

            // Skip blank rows
            if (empty(array_filter($row))) {
                continue;
            }

            try {
                // ── Product Name (required) ───────────────────────────
                $name = $getVal('name', $row);
                if (empty($name)) {
                    $errorCount++;
                    $errors[] = "Row {$lineNumber}: skipped — item name is empty.";
                    continue;
                }

                // ── Company: find by name (case-insensitive) or create ─
                $companyId   = null;
                $companyName = $getVal('company_name', $row);
                if ($companyName) {
                    $company   = $this->findOrCreateCompany($companyName);
                    $companyId = $company?->id;
                }

                // ── Division ──────────────────────────────────────────
                $divisionId   = null;
                $divisionName = $getVal('division_name', $row);
                if ($divisionName && $companyId) {
                    $division = Division::where('company_id', $companyId)
                        ->whereRaw('LOWER(name) = ?', [strtolower($divisionName)])
                        ->first();

                    if (!$division) {
                        $division = Division::create([
                            'name'       => $divisionName,
                            'company_id' => $companyId,
                            'is_active'  => true,
                        ]);
                    }
                    $divisionId = $division->id;
                }

                // ── Salt / Composition ────────────────────────────────
                $saltId   = null;
                $saltName = $getVal('salt_name', $row);
                if ($saltName) {
                    $salt = Salt::whereRaw('LOWER(name) = ?', [strtolower($saltName)])->first();
                    if (!$salt) {
                        $salt = Salt::create(['name' => $saltName, 'is_active' => true]);
                    }
                    $saltId = $salt->id;
                }

                // ── Numeric fields ────────────────────────────────────
                $mrp      = $getVal('mrp', $row)      !== null ? (float) str_replace(',', '', $getVal('mrp', $row))      : 0;
                $ptr      = $getVal('ptr', $row)      !== null ? (float) str_replace(',', '', $getVal('ptr', $row))      : 0;
                $pts      = $getVal('pts', $row)      !== null ? (float) str_replace(',', '', $getVal('pts', $row))      : 0;
                $tax      = $getVal('tax', $row)      !== null ? (float) str_replace(',', '', $getVal('tax', $row))      : null;
                $aTax     = $getVal('a_tax', $row)    !== null ? (float) str_replace(',', '', $getVal('a_tax', $row))    : null;
                $pur      = $getVal('pur', $row)      !== null ? (float) str_replace(',', '', $getVal('pur', $row))      : null;
                $stockQty = $getVal('stock_qty', $row) !== null ? (int) $getVal('stock_qty', $row) : 0;

                // ── Other fields ──────────────────────────────────────
                $hsnCode = $getVal('hsn_code', $row);
                $packing = $getVal('packing', $row) ?? '1*10*10';

                // ── Upsert: match on name + company_id ────────────────
                Product::updateOrCreate(
                    [
                        'name'       => $name,
                        'company_id' => $companyId,
                    ],
                    [
                        'hsn_code'    => $hsnCode,
                        'division_id' => $divisionId,
                        'salt_id'     => $saltId,
                        'composition' => $saltName,
                        'packing'     => $packing,
                        'mrp'         => $mrp,
                        'ptr'         => $ptr,
                        'pts'         => $pts,
                        'tax'         => $tax,
                        'a_tax'       => $aTax,
                        'pur'         => $pur,
                        'stock_qty'   => $stockQty,
                        'is_active'   => true,
                    ]
                );

                $successCount++;

            } catch (Exception $e) {
                $errorCount++;
                $errorMsg = "Row {$lineNumber}: " . $e->getMessage();
                $errors[] = $errorMsg;
                Log::error('CSV Import Error — ' . $errorMsg, [
                    'row'  => $row ?? [],
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
            }
        }

        // Clean up temp file from local disk
        Storage::disk('local')->delete($request->path);

        $message = "Import complete: {$successCount} product(s) imported/updated successfully.";
        if ($errorCount > 0) {
            $message .= " {$errorCount} row(s) failed.";
        }

        return redirect()->route('products.index')
            ->with('import_success', $message)
            ->with('import_errors', $errors);
    }

    /**
     * Generate and download a sample CSV template.
     */
    public function sampleCsv()
    {
        // Headers match the Chitranshu Pharmaceuticals Agency price list format.
        // All column names are recognised by the auto-detect mapping on upload.
        $headers = ['Name', 'Hsn', 'Company', 'Division', 'Salt', 'Packing', 'MRP', 'Sale', 'Np Rate', 'Tax', 'A.Tax', 'Pur', 'Stock Qty'];
        $sample  = [
            ['BCCA PLUS',        '300490',   'ADSILA', '', '', '10x10',   '2390.00', '0.00',   '0.00',   '2.50', '2.50', '0.00',   '0'],
            ['CIRETA',           '',         'CIPLA',  '', '', '10x10',   '159.00',  '133.57', '103.00', '2.50', '2.50', '103.00', '0'],
            ['COLOWIPE NEO',     '21061000', 'CIPLA',  '', '', '1 strip', '386.25',  '294.32', '294.32', '2.50', '2.50', '294.32', '0'],
            ['ESOGRESS HP FORT', '3004',     'CIPLA',  '', '', '10x10',   '248.00',  '177.14', '177.14', '2.50', '2.50', '177.14', '0'],
            ['FULLYTE TRIO',     '21069099', 'ALKEM',  '', '', '10x10',   '1192.37', '908.47', '817.62', '2.50', '2.50', '817.62', '0'],
        ];

        $filename = 'products_import_template.csv';
        $tmpFile  = tempnam(sys_get_temp_dir(), 'csv');
        $fh       = fopen($tmpFile, 'w');
        fputcsv($fh, $headers);
        foreach ($sample as $row) {
            fputcsv($fh, $row);
        }
        fclose($fh);

        return response()->download($tmpFile, $filename, [
            'Content-Type' => 'text/csv',
        ])->deleteFileAfterSend(true);
    }
}
