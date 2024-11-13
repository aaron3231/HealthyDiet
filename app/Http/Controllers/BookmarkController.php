<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function get_bookmarks(Request $request)
    {
        $user_id = $request->input('id');
        Log::info('User ID:', ['user_id' => $user_id]);
        
        // 獲取使用者的書籤清單
        $bookmarkedRestaurants = Bookmark::where('user_id', $user_id)->pluck('restaurant_name')->toArray();
        Log::info('Bookmarked Restaurants:', $bookmarkedRestaurants);

        return view('bookmark', compact('bookmarkedRestaurants'));
    }
}
