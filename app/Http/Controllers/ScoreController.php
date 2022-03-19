<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class ScoreController extends Controller
{
    public function addScore(Request $request)
    {
        try {
            JWTAuth::authenticate(JWTAuth::getToken());
            $data = $request->only('user_id', 'level_id', 'score');
            $validation = Validator::make($data, [
                'username' => 'nullable|string',
                'user_id' => 'nullable|integer',
                'level_id' => 'required|integer',
                'score' => 'required|integer',
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validation->errors()
                ], Response::HTTP_BAD_REQUEST);
            }

            $level = Level::find($request->level_id);
            $user = User::find($request->user_id);

            if (!$level || !$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User or level not found'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }


            $score = Score::create([
                'user_id' => $request->user_id,
                'level_id' => $request->level_id,
                'score' => $request->score,
            ]);

            return response()->json([
                'success' => true,
                'score' => $score,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getScoreById(Request $request)
    {
        try {
            JWTAuth::authenticate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'score' => Score::find($request->score_id)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function getScores($whereAttr, $value, $total)
    {
        $scores = Score::with('user', 'level')
            ->where($whereAttr, $value);

        if ($total) {
            return $scores->take($total)->get();
        } else {
            return $scores->get();
        }
    }

    public function getScoresByLevelId(Request $request)
    {
        try {
            JWTAuth::authenticate(JWTAuth::getToken());
            $scores = $this->getScores('level_id', $request->level_id, $request->total);
            return response()->json([
                'success' => true,
                'scores' => $scores
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getScoresByUserId(Request $request)
    {
        try {
            JWTAuth::authenticate(JWTAuth::getToken());
            $scores = $this->getScores('user_id', $request->user_id, $request->total);
            return response()->json([
                'success' => true,
                'scores' => $scores
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
