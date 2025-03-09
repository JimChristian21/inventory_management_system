<?php

namespace App\Libraries\Imports;

use App\Libraries\Repository\ItemsRepository;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Items_import {

    protected $spreadsheet;
    protected $active_worksheet;
    protected $reader;
    protected $active_sheet;
    protected $type = 'Xlsx';
    protected $startRow = 2;
    protected $items_repository;

    protected $columns = [
        'A' => 'name',
        'B' => 'description',
        'C' => 'quantity',
        'D' => 'critical_quantity'
    ];

    public function __construct()
    {
        $this->reader = new Xlsx();
        $this->items_repository = new ItemsRepository();
    }

    public function run($file): bool
    {
        $ret = FALSE;

        $this->init($file);
        $this->process();

        $ret = TRUE;
        
        return $ret;
    }

    protected function init($file)
    {
        $this->spreadsheet = $this->reader->load($file);
        $this->active_worksheet = $this->spreadsheet->getActiveSheet();
    }

    protected function process()
    {
        foreach($this->active_worksheet->getRowIterator() as $key => $row) {

            if ($key == 1)
            {
                continue;
            }

            $cellIterator = $row->getCellIterator();

            $column_values = [];

            foreach($cellIterator as $key => $cell)
            {
                $column_values[$this->columns[$key]] = $cell->getValue();
            }

            $this->save((object) $column_values);
        }
    }

    protected function save($data)
    {
        $this->items_repository->create($data);
    }
}