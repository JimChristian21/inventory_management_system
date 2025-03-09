<?php

namespace App\Libraries\Exports;

use App\Libraries\Repository\ItemsRepository;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Items_export {

    protected $spreadsheet;
    protected $active_sheet;
    protected $items_repository;
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
        $this->items_repository = new ItemsRepository();
        $this->active_sheet = $this->spreadsheet->getActiveSheet();
    }

    public function run(): string
    {
        $this->write_headers();
        $this->write();
        $file = $this->save();
        return $file;
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
        $items = $this->items_repository->all();
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
        $timestamp = now()->timestamp;
        $filename = "exports/items_{$timestamp}.xlsx";
        $tmp_file = tmpfile();

        $writer = IOFactory::createWriter($this->spreadsheet, $this->type);
        $writer->save($tmp_file);

        Storage::put($filename, $tmp_file)
            && $ret = Storage::url($filename);
            
        return $ret;
    }
}