<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function submit_comment(Request $request)
    {
        $restaurant_name = $request->input('restaurant_name');
        $user_id = $request->input('user_id');
        $content = $request->input('content');

        try {
            Comment::create([
                'user_id' => $user_id, // 確保這是有效的用戶 ID
                'restaurant_name' => $restaurant_name,
                'content' => $content,
            ]);
            return response()->json(['message' => '新增評論成功']);
        } catch (\Illuminate\Database\QueryException $e) {
            // 捕獲數據庫層級的錯誤並返回具體信息
            return response()->json(['message' => '資料庫錯誤: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            // 捕獲其他一般性錯誤
            return response()->json(['message' => '未知錯誤: ' . $e->getMessage()]);
        }
    }
}
