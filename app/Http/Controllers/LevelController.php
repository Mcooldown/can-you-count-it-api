<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class LevelController extends Controller
{
    public function getAllLevels()
    {
        try {
            JWTAuth::authenticate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'levels' => Level::all()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getLevelById(Request $request)
    {
        try {
            JWTAuth::authenticate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'level' => Level::find($request->level_id)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
