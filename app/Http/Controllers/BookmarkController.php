<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function set_bookmark(Request $request)
    {
        $restaurantName = $request->input('food_name');
        $user_id = $request->input('id');

        // 檢查該餐廳是否已被收藏
        $bookmark = Bookmark::where('user_id', $user_id)
            ->where('restaurant_name', $restaurantName)
            ->first();

        if ($bookmark) {
            // 如果已存在，則刪除書籤
            $bookmark->delete();
            return response()->json(['message' => '已取消收藏']);
        } else {
            // 如果不存在，則新增書籤
            try {
                Bookmark::create([
                    'user_id' => $user_id, // 確保這是有效的用戶 ID
                    'restaurant_name' => $restaurantName,
                ]);
                return response()->json(['message' => '新增收藏']);
            } catch (\Exception $e) {
                // 捕獲並返回錯誤信息
                return response()->json(['message' => $e->getMessage()]);
            }
        }
    }
}
