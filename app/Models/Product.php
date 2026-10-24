<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hsn_code',
        'company_id',
        'division_id',
        'salt_id',
        'composition',
        'packing',
        'mrp',
        'ptr',
        'pts',
        'tax',
        'a_tax',
        'pur',
        'stock_qty',
        'image',
        'is_active',
        'schedule',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'mrp'        => 'decimal:2',
        'ptr'        => 'decimal:2',
        'pts'        => 'decimal:2',
        'tax'        => 'decimal:2',
        'a_tax'      => 'decimal:2',
        'pur'        => 'decimal:2',
        'stock_qty'  => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function salt()
    {
        return $this->belongsTo(Salt::class);
    }

    /**
     * Determine if product falls under Schedule H / H1 / X or requires Retail Drug License.
     */
    public function isRestrictedSchedule(): bool
    {
        $sched = $this->schedule ?? ($this->attributes['schedule'] ?? null);
        if (!empty($sched)) {
            $sched = strtoupper(trim((string) $sched));
            return in_array($sched, ['H', 'H1', 'X', 'SCHEDULE H', 'SCHEDULE H1', 'SCHEDULE X', 'NRX', 'RX'], true);
        }

        $saltText = '';
        if ($this->relationLoaded('salt') || $this->salt_id) {
            $saltText = ($this->salt?->name ?? '') . ' ' . ($this->salt?->description ?? '');
        }

        $haystack = strtolower(trim(($this->name ?? '') . ' ' . ($this->composition ?? '') . ' ' . ($this->packing ?? '') . ' ' . $saltText));

        // Check explicit schedule / prescription markings
        if (preg_match('/\b(nrx|sched(ule)?[\s\-_.]*(h1?|x)|sch[\s\-_.]*(h1?|x)|rx\b)/i', $haystack)) {
            return true;
        }

        // Common restricted Schedule H / H1 / X active ingredients (psychotropics, narcotics & critical antibiotics)
        $restrictedPatterns = [
            'clonazepam', 'alprazolam', 'diazepam', 'lorazepam', 'clobazam', 'chlordiazepoxide',
            'tramadol', 'pregabalin', 'gabapentin', 'zolpidem', 'etizolam', 'tapentadol',
            'paroxetine', 'duloxetine', 'sertraline', 'escitalopram', 'venlafaxine', 'fluoxetine',
            'olanzapine', 'quetiapine', 'risperidone', 'haloperidol', 'amisulpride',
            'divalproex', 'valproat', 'levetiracetam', 'carbamazepine', 'oxcarbazepine',
            'codeine', 'buprenorphine', 'nitrazepam', 'midazolam', 'ketamine',
            'azithromycin', 'amoxicillin', 'cefixime', 'ciprofloxacin', 'meropenem',
            'levofloxacin', 'ceftriaxone', 'clarithromycin', 'moxifloxacin', 'cefpodoxime',
            'piperacillin', 'linezolid', 'vancomycin', 'imipenem', 'colistin'
        ];

        foreach ($restrictedPatterns as $pattern) {
            if (str_contains($haystack, $pattern)) {
                return true;
            }
        }

        return false;
    }

    public function getIsRestrictedScheduleAttribute(): bool
    {
        return $this->isRestrictedSchedule();
    }
}
