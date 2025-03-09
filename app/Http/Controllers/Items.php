<?php

namespace App\Http\Controllers;


use App\Libraries\Exports\Items_export;
use App\Libraries\Imports\Items_import;
use App\Libraries\Repository\ItemsRepository;
use App\Mail\LowItemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Items extends Controller
{
    protected $items_repository;

    public function __construct()
    {
        $this->items_repository = new ItemsRepository();
    }

    public function store(Request $request)
    {
        $validated = $request->validateWithBag('items_create', [
            'name' => 'required|string|unique:items,name',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'critical_quantity' => 'required|integer|min:0'
        ]);
        
        $created_item = $this->items_repository->create((object) $validated);

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
        
        $updated_item = $this->items_repository->update($id, $validated);

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

    public function import(Request $request)
    {
        $validated = (object) $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        $import_lib = new Items_import();

        $status = $import_lib->run($validated->file);

        return redirect()
            ->route('inventory.index')
            ->with('message', [
                'status' => 'S',
                'message' => 'Imported Successfully'
            ]);
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
        $deleted = $this->items_repository->delete($id);

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
