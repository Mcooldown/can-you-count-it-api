<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function getAllLevels()
    {
        return response()->json([
            'success' => true,
            'levels' => Level::all()
        ]);
    }

    public function getLevelById(Request $request)
    {
        $data = $request->only('level_id');
        UtilController::validateRequest($data, [
            'level_id' => 'required|integer'
        ]);

        return response()->json([
            'success' => true,
            'level' => Level::find($request->level_id)
        ]);
    }
}
