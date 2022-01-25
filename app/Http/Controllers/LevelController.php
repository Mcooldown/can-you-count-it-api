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
        $levelId = $request->levelId;

        if ($levelId) {
            $level = Level::find($levelId);

            if ($level) {
                return response()->json([
                    'success' => true,
                    'level' => $level,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Level Not Found',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Level ID Not Found'
            ]);
        }
    }
}
