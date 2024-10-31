<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search_restaurants(Request $request)
    {
        $restaurants = collect(); // 預設為空集合
        $med_food = $request->input('med_food') ? 'Y' : null;
        $diet_food = $request->input('diet_food') ? 'Y' : null;
        $user_id = auth()->id(); // 取得使用者ID（假設從前端傳過來）

        // 獲取使用者的書籤清單
        $bookmarkedRestaurants = Bookmark::where('user_id', $user_id)->pluck('restaurant_name')->toArray();
        Log::info('Bookmarked Restaurants:', $bookmarkedRestaurants);

        Log::info('User ID:', ['user_id' => $user_id]);

        if ($request->has('query')) {
            $query = $request->input('query');

            // 根據名稱部分符合搜尋
            $restaurants = Restaurant::where('food_name', 'like', '%' . $query . '%')
                ->when($med_food, function ($query) {
                    return $query->where('med_food', 'Y');
                })
                ->when($diet_food, function ($query) {
                    return $query->where('diet_food', 'Y');
                })
                ->get()
                ->map(function ($restaurant) use ($bookmarkedRestaurants) {
                    // 檢查餐廳是否在書籤清單中
                    $restaurant->isBookmarked = in_array($restaurant->food_name, $bookmarkedRestaurants);
                    return $restaurant;
                }); // 將書籤狀態加入到每個餐廳項目
        }

        return view('dashboard', compact('restaurants', 'med_food', 'diet_food'));
    }
}
