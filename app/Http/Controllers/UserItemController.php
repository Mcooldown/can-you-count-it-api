<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\UserItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserItemController extends Controller
{
    public function getAllUserItems()
    {
        try {
            $user = JWTAuth::authenticate(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'userItems' => UserItem::where('user_id', $user->id)->get()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function getUserItem($userId, $itemId)
    {
        return UserItem::with('user', 'item')
            ->where('user_id', $userId)
            ->where('item_id', $itemId)
            ->first();
    }

    public function addUserItem(Request $request)
    {
        try {
            $user = JWTAuth::authenticate(JWTAuth::getToken());

            $data = $request->only('item_id');
            $validation = Validator::make($data, [
                'item_id' => 'required|integer',
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validation->errors()
                ], Response::HTTP_BAD_REQUEST);
            }

            $userItem = $this->getUserItem($user->id, $request->item_id);

            if ($userItem) {
                $userItem->quantity++;
                $userItem->save();
            } else {
                $item = Item::find('item_id');

                if (!$item) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User or item not found'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                $userItem = UserItem::create([
                    'user_id' => $user->id,
                    'item_id' => $request->item_id,
                    'quantity' => 1
                ]);
            }

            return response()->json([
                'success' => true,
                'user_item' => $userItem
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function useUserItem(Request $request)
    {
        try {
            $user = JWTAuth::authenticate(JWTAuth::getToken());
            $data = $request->only('item_id');
            $validation = Validator::make($data, [
                'item_id' => 'required|integer',
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validation->errors()
                ], Response::HTTP_BAD_REQUEST);
            }
            $userItem = $this->getUserItem($user->id, $request->item_id);

            if (!$userItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'User item not found',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $userItem->quantity--;
            if ($userItem->quantity <= 0) {
                $userItem->delete();
            } else {
                $userItem->save();
            }
            return response()->json([
                'success' => true,
                'message' => 'User item used'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
