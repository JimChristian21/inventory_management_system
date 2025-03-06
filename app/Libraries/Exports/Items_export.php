<?php

namespace App\Libraries\Exports;

use App\Models\Item;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Items_export {

    protected $spreadsheet;
    protected $active_sheet;
    protected $type = 'Xlsx';

    protected $headers = [
        'Name' => 'name',
        'Description' => 'description',
        'Quantity' => 'quantity',
        'Critical Quantity' => $critical_quantity
    ];

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->active_sheet = $this->spreadsheet->getActiveSheet();
    }

    public function run(): string
    {
        $this->write_headers();
        $this->write();
        $file = $this->save();
        return $file;
    }

    protected function get_items()
    {
        return Item::all();
    }

    protected function write_headers()
    {
        $column = 'A';

        foreach($this->headers as $header => $field) 
        {
            $this->active_sheet->setCellValue("{$column}1", $header);
            $column++;
        }
    }

    protected function write()
    {
        $items = $this->get_items();
        $row = 2;

        foreach($items as $item)
        {
            $this->write_row($row, $item);
            $row++;
        }
    }

    protected function write_row(string $row, object $data)
    {
        $column = 'A';

        foreach($this->headers as $header => $field)
        {
            $this->active_sheet->setCellValue("{$column}{$row}", $data->{$field});
            $column++;
        }
    }

    protected function save()
    {
        $file = 'test.xlsx';
        $writer = IOFactory::createWriter($this->spreadsheet, $this->type);
        $writer->save($file);
        
        return $file;
    }
}