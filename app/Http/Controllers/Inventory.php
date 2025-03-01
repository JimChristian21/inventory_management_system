<?php

namespace App\Http\Controllers;

use App\Libraries\Items;
use Inertia\Inertia;

class Inventory extends Controller
{
    protected $items_lib;

    public function __construct() 
    {
        $this->items_lib = new Items();
    }
    
    public function index()
    {
        $item_pagination = $this->items_lib->get_pagination();

        return Inertia::render('Inventory', [
            'items' =>  $item_pagination
        ]);
    }
}
