<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
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

    public function fetch_comments(Request $request)
    {
        $restaurant_name = $request->input('restaurant_name');
        
        // 獲取指定餐廳的所有評論資料
        $comments = Comment::where('restaurant_name', $restaurant_name)->get();

        // 轉換 user_id 為 user_name
        $commentsWithUserNames = $comments->map(function ($comment) {
            $user = User::find($comment->user_id); // 根據 user_id 獲取用戶資料
            $comment->user_name = $user ? $user->name : '未知用戶'; // 如果用戶存在則添加 user_name，否則顯示 '未知用戶'
            return $comment;
        });

        // 返回 JSON 格式的評論
        return response()->json([
            'comments' => $comments
        ]);
    }
}
