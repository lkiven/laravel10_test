<?php
/**
 * Created by PhpStorm.
 * User: kiven
 * Date: 2025/2/23
 * Time: 15:15
 */

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SqlResultExport implements FromCollection, WithHeadings
{
    private $sql;

    public function __construct($sql)
    {
        $this->sql = $sql;
    }

    public function collection()
    {
        return collect(DB::select($this->sql));
    }

    public function headings(): array
    {
        $results = DB::select($this->sql);
        if (count($results) > 0) {
            return array_keys((array) $results[0]);
        }
        return [];
    }
}