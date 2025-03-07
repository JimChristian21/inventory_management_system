<?php

namespace App\Libraries\Exports;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Items_export {

    protected $spreadsheet;
    protected $reader;
    protected $active_sheet;
    protected $type = 'Xlsx';
    protected $startRow = 2;

    protected $columns = [
        'Name' => 'name',
        'Description' => 'description',
        'Quantity' => 'quantity',
        'Critical Quantity' => 'critical_quantity'
    ];

    public function __construct($file)
    {
        $reader = new Xlsx();
        $this->spreadsheet = $reader->load($file);
    }

    public function run(): bool
    {
        $ret = FALSE;

        return $ret;
    }
}