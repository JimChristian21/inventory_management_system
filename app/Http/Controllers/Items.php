<?php

namespace App\Http\Controllers;

use App\Libraries\Items as ItemsLib;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Items extends Controller
{
    protected $items_lib;

    public function __construct()
    {
        $this->items_lib = new ItemsLib();
    }

    public function store(Request $request)
    {
        $validated = $request->validateWithBag('items_create', [
            'name' => 'required|string|unique:items,name',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'critical_quantity' => 'required|integer|min:0'
        ]);
        
        $created_item = $this->items_lib->create((object) $validated);

        return redirect()->route('inventory.index');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validateWithBag('items_create', [
            'name' => 'required|string|unique:items,name',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'critical_quantity' => 'required|integer|min:0'
        ]);
        
        $updated_item = $this->items_lib->update($id, (object) $validated);

        return redirect()->route('inventory.index');
    }

    public function destroy($id)
    {
        $deleted = $this->items_lib->delete($id);

        return redirect()->route('inventory.index');
    }
}
