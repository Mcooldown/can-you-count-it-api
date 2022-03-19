<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class ItemController extends Controller
{
    public function getAllItems()
    {
        try {
            JWTAuth::authenticate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'items' => Item::all()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getItemById(Request $request)
    {
        try {
            JWTAuth::authenticate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'item' => Item::find($request->item_id)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
