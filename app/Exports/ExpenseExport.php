<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExpenseExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $ids;

    public function __construct($ids)
    {
        // Ensure $ids is always an array
        if (is_string($ids)) {
            $this->ids = explode(',', $ids);
        } else {
            $this->ids = $ids;
        }
    }

    public function collection()
    {
        return Expense::whereIn('id', $this->ids)->get();
    }
}
