<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScoreController extends Controller
{
    public function storeScore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'nullable|string',
            'user_id' => 'nullable|integer',
            'level_id' => 'required|integer',
            'score' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()
            ]);
        }

        $level = Level::find($request->level_id);

        if ($level) {

            if ($request->user_id) {
                $user = User::find($request->user_id);

                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User not found',
                    ]);
                }
            }

            $newScore = Score::create([
                'username' => $request->username ? $request->username : null,
                'user_id' => $request->user_id ? $request->user_id : null,
                'level_id' => $request->level_id,
                'score' => $request->score,
            ]);

            return response()->json([
                'success' => true,
                'score' => Score::with(['level', 'user'])->where('id', $newScore->id)->first(),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Level not found',
            ]);
        }
        return response()->json([
            'success' => true,
        ]);
    }
}
