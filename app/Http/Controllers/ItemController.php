<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function getAllItems()
    {
        return response()->json([
            'success' => true,
            'items' => Item::all()
        ]);
    }

    public function getItemById(Request $request)
    {
        $data = $request->only('item_id');
        UtilController::validateRequest($data, [
            'item_id' => 'required|integer'
        ]);

        return response()->json([
            'success' => true,
            'item' => Item::find($request->item_id)
        ]);
    }
}
