<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search_restaurants(Request $request)
    {
        $restaurants = collect(); // 預設為空集合
        $med_food = $request->input('med_food') ? 'Y' : null; // 取得第一個checkbox的狀態
        $diet_food = $request->input('diet_food') ? 'Y' : null; // 取得第二個checkbox的狀態

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
                ->get(); // 返回 Eloquent Collection
        }

        return view('home', compact('restaurants', 'med_food', 'diet_food')); // 傳遞搜尋結果及checkbox狀態到首頁
    }
}
