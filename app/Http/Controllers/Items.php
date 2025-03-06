<?php

namespace App\Http\Controllers;

use App\Libraries\Exports\Item_export;
use App\Libraries\Exports\Items_export;
use App\Libraries\Items as ItemsLib;
use App\Mail\LowItemNotification;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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

        $message = $created_item
            ? 'Item created successfuly!'
                : 'Failed creating user!';

        $o = (object) [
            'status' => $created_item ? 'S' : 'E',
            'message' => $message
        ];

        return redirect()
            ->route('inventory.index')
            ->with('message', $o);
    }

    public function update(Request $request, $id)
    {
        $validated = (object) $request->validateWithBag('items_create', [
            'name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'critical_quantity' => 'required|integer|min:0'
        ]);
        
        $updated_item = $this->items_lib->update($id, $validated);

        if ($validated->quantity <= $validated->critical_quantity)
        {
            Mail::to($request->user())->send( new LowItemNotification($id));
        }

        $message = $updated_item
            ? 'Item updated successfuly!'
                : 'Failed updating item!';

        $o = (object) [
            'status' => $updated_item ? 'S' : 'E',
            'message' => $message
        ];

        return redirect()
            ->route('inventory.index')
            ->with('message', $o);
    }

    public function export()
    {
        $export_lib = new Items_export();
        $filePath = $export_lib->run();

        return redirect()
            ->route('inventory.index')
            ->with('download', $filePath);
    }

    public function destroy($id)
    {
        $deleted = $this->items_lib->delete($id);

        $message = $deleted
            ? 'Item deleted successfuly!'
                : 'Failed deleting item!';
            
        $o = (object) [
            'status' => $deleted ? 'S' : 'E',
            'message' => $message
        ];

        return redirect()
            ->route('inventory.index')
            ->with('message', $o);
    }
}
