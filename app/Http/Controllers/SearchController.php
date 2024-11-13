<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search_restaurants_from_hybrid(Request $request)
    {
        $restaurants = collect(); // 預設為空集合
        $med_food = $request->input('med_food') ? 'Y' : null;
        $diet_food = $request->input('diet_food') ? 'Y' : null;
        $user_id = auth()->id(); // 取得使用者ID（假設從前端傳過來

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

    public function search_restaurants_from_list(Request $request)
    {
        $restaurants = collect(); // 預設為空集合
        $med_food = $request->input('med_food') ? 'Y' : null;
        $diet_food = $request->input('diet_food') ? 'Y' : null;
        $user_id = auth()->id(); // 取得使用者ID（假設從前端傳過來

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

        return view('list', compact('restaurants', 'med_food', 'diet_food'));
    }

    public function search_restaurants_from_adv(Request $request)
    {
        $restaurantsQuery = Restaurant::query();

        // 建立各種條件查詢
        if ($request->has('Restaurant_Category')) {
            $restaurantsQuery->where(function($query) use ($request) {
                foreach ($request->input('Restaurant_Category') as $category) {
                    $query->orWhere('Restaurant Category', $category);
                }
            });
        }

        if ($request->has('Town')) {
            $restaurantsQuery->where(function($query) use ($request) {
                foreach ($request->input('Town') as $town) {
                    $query->orWhere('Town', $town);
                }
            });
        }

        if ($request->has('Delivery_Platform')) {
            $restaurantsQuery->where(function($query) use ($request) {
                $query->orWhere('Delivery Platform', 'Both'); // 加上 Both 條件
                foreach ($request->input('Delivery_Platform') as $platform) {
                    $query->orWhere('Delivery Platform', $platform);
                }
            });
        }

        if ($request->has('CarrierInvoice_Carrier')) {
            $restaurantsQuery->where(function($query) use ($request) {
                $query->orWhere('Carrier (Invoice Carrier)', 'Y');
                foreach ($request->input('CarrierInvoice_Carrier') as $carrier) {
                    $query->orWhere('Carrier (Invoice Carrier)', $carrier);
                }
            });
        }

        if ($request->has('Electronic_Payment')) {
            $restaurantsQuery->where(function($query) use ($request) {
                $query->orWhere('Electronic Payment', 'Y');
                foreach ($request->input('Electronic_Payment') as $payment) {
                    $query->orWhere('Electronic Payment', $payment);
                }
            });
        }

        if ($request->has('Credit_Card')) {
            $restaurantsQuery->where(function($query) use ($request) {
                $query->orWhere('Credit Card', 'Y');
                foreach ($request->input('Credit_Card') as $credit) {
                    $query->orWhere('Credit Card', $credit);
                }
            });
        }

        if ($request->has('Buffet_A_La_Carte')) {
            $restaurantsQuery->where(function($query) use ($request) {
                foreach ($request->input('Buffet_A_La_Carte') as $buffet) {
                    $query->orWhere('Buffet/A La Carte', $buffet);
                }
            });
        }

        if ($request->filled('Average_Price_per_Person')) {
            $price = $request->input('Average_Price_per_Person');
            $restaurantsQuery->whereRaw("CAST(REGEXP_REPLACE(`Average Price per Person`, '\\\\$(\\\\d+)–(\\\\d+)', '\\\\1') AS SIGNED) <= ?", [$price])
                            ->whereRaw("CAST(REGEXP_REPLACE(`Average Price per Person`, '\\\\$(\\\\d+)–(\\\\d+)', '\\\\2') AS SIGNED) >= ?", [$price]);
        }

        if ($request->filled('Google_Rating')) {
            $rating = $request->input('Google_Rating');
            $restaurantsQuery->whereRaw("CAST(Google_Rating AS DOUBLE) >= ?", [$rating]);
        }

        if ($request->filled('Number_of_Google_reviews')) {
            $reviews = $request->input('Number_of_Google_reviews');
            $restaurantsQuery->whereRaw("CAST(`Number of Google reviews` AS SIGNED) >= ?", [$reviews]);
        }

        // 排序和取得結果
        // $restaurants = $restaurantsQuery->orderBy('ID')->get();
        $restaurants = $restaurantsQuery->get();

        return view('filter', compact('restaurants'));
    }

}
