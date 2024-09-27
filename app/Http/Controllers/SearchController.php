<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search_restaurants(Request $request)
    {
        $restaurants = collect(); // 預設為空集合

        if ($request->has('query')) {
            $query = $request->input('query');
            // 根據名稱部分符合搜尋
            $restaurants = Restaurant::where('food_name', 'like', '%' . $query . '%')->get(); // 返回 Eloquent Collection
        }

        return view('home', compact('restaurants')); // 傳遞搜尋結果到首頁
    }
}
