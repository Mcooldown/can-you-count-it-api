<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\UserItem;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserItemController extends Controller
{
    protected function validateUserItem(Request $request)
    {
        $data = $request->only('user_id', 'item_id');
        UtilController::validateRequest($data, [
            'user_id' => 'required|integer',
            'item_id' => 'required|integer',
        ]);
    }

    protected function getUserItem(Request $request)
    {
        return UserItem::with('user', 'item')
            ->where('user_id', $request->user_id)
            ->where('item_id', $request->item_id)
            ->first();
    }

    public function addUserItem(Request $request)
    {
        $this->validateUserItem($request);
        $userItem = $this->getUserItem($request);

        if ($userItem) {
            $userItem->quantity++;
            $userItem->save();
        } else {
            $user = User::find('user_id');
            $item = Item::find('item_id');

            if (!$user || !$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'User or item not found'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $userItem = UserItem::create([
                'user_id' => $request->user_id,
                'item_id' => $request->item_id,
                'quantity' => 1
            ]);
        }

        return response()->json([
            'success' => true,
            'user_item' => $userItem
        ]);
    }

    public function useUserItem(Request $request)
    {
        $this->validateUserItem($request);
        $userItem = $this->getUserItem($request);

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
    }
}
