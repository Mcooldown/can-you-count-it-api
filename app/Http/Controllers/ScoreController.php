<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ScoreController extends Controller
{
    public function addScore(Request $request)
    {
        $data = $request->only('user_id', 'level_id', 'score');
        UtilController::validateRequest($data, [
            'username' => 'nullable|string',
            'user_id' => 'nullable|integer',
            'level_id' => 'required|integer',
            'score' => 'required|integer',
        ]);

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
    }

    public function getScoreById(Request $request)
    {
        $data = $request->only('score_id');
        UtilController::validateRequest($data, [
            'score_id' => 'required|integer'
        ]);

        return response()->json([
            'success' => true,
            'score' => Level::find($request->score_id)
        ]);
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
        $data = $request->only('level_id');
        UtilController::validateRequest($data, [
            'level_id' => 'required|integer',
            'total' => 'nullable|integer'
        ]);

        $scores = $this->getScores('level_id', $request->level_id, $request->total);
        return response()->json([
            'success' => true,
            'scores' => $scores
        ]);
    }

    public function getScoresByUserId(Request $request)
    {
        $data = $request->only('user_id');
        UtilController::validateRequest($data, [
            'user_id' => 'required|integer',
            'total' => 'nullable|integer'
        ]);

        $scores = $this->getScores('user_id', $request->user_id, $request->total);
        return response()->json([
            'success' => true,
            'scores' => $scores
        ]);
    }
}
