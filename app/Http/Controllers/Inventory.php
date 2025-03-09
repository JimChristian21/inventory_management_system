<?php

namespace App\Http\Controllers;

use App\Libraries\Repository\ItemsRepository;
use Inertia\Inertia;

class Inventory extends Controller
{    
    protected $items_repository;

    public function __construct()
    {
        $this->items_repository = new ItemsRepository();
    }

    public function index()
    {
        $items_pagination = $this->items_repository->get_pagination();

        return Inertia::render('Inventory', [
            'items' => $items_pagination
        ]);
    }
}
