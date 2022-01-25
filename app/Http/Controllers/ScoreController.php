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

        $level = Level::find($request->level_id);
        $user = User::find($request->user_id);

        if ($validator->fails()) {
            $message = $validator->errors();
        } else if (!$level) {
            $message = "Level not found";
        } else {
            if (!$request->username && !$user) {
                $message = "User not found";
            } else {

                $newScore = Score::create([
                    'username' => $request->username ? trim($request->username, " ") . '#' . uniqid() : null,
                    'user_id' => $request->user_id ? $request->user_id : null,
                    'level_id' => $request->level_id,
                    'score' => $request->score,
                ]);

                return response()->json([
                    'success' => true,
                    'score' => Score::with(['level', 'user'])->where('id', $newScore->id)->first(),
                ]);
            }
        }
        return response()->json([
            'success' => false,
            'message' => $message,
        ]);
    }

    public function getLevelWithScores(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'level_id' => 'required|integer',
        ]);

        $level = Level::find($request->level_id);

        if ($validator->fails()) {
            $message = $validator->errors();
        } else if (!$level) {
            $message = "Level not found";
        } else {
            return response()->json([
                'success' => true,
                'level' => Level::find($request->level_id),
                'scores' => Score::with('user')->where('level_id', $request->level_id)->get(),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $message
        ]);
    }
}
