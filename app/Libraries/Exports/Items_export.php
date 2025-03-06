<?php

namespace App\Libraries\Exports;

use App\Models\Item;
use Illuminate\Support\Facades\Storage;
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
        'Critical Quantity' => 'critical_quantity'
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

        if ($items) 
        {
            foreach($items as $item)
            {
                $this->write_row($row, $item);
                $row++;
            }
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
        $ret = NULL;
        $timestamp = rand(1,1000000);
        $file_path = storage_path("exports/items_{$timestamp}.xlsx");
        $writer = IOFactory::createWriter($this->spreadsheet, $this->type);
        $writer->save($file_path);

        if (Storage::get($file_path))
        {
            $file = Storage::url("exports/items_{$timestamp}.xlsx");
            $ret = $file;
        };
        
        return $ret;
    }
}