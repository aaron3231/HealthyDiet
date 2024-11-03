<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Healthy Diet</title>
    <style>
        /* 搜尋區塊 */
        #info-box {
            position: absolute;
            top: 80px;
            left: 10px;
            z-index: 5;
            background-color: rgba(255, 255, 255, 0.7); /* 設定為白色的半透明背景 */
            padding: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            border-radius: 5px;
            font-family: Arial, sans-serif;
            width: auto;
        }

        /* 搜尋標題 */
        #search-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        /* 搜尋欄位 */
        #search-input {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            margin-right: 10px; /* 調整欄位與按鈕的距離 */
        }

        /* 按鈕 */
        #search-button {
            padding: 10px;
            background-color: #4285f4;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        /* 按鈕懸停效果 */
        #search-button:hover {
            background-color: #357ae8;
        }

        /* 篩選條件 */
        #checkboxes {
            display: flex;
            align-items: center;
            margin-left: 10px;
        }

        #checkboxes label {
            font-size: 14px;
            cursor: pointer;
            margin-left: 10px;
        }

        /* 提示訊息 */
        #no-results {
            margin-top: 10px;
            color: red;
            font-size: 14px;
        }

        /* 內容排版 */
        .content {
            display: flex;
            width: 100%;
            height: 95vh;
        }

        .list-container {
            position: absolute;
            top: 205px;
            left: 10px;
            z-index: 5;
            background-color: rgba(255, 255, 255, 0.7); /* 設定為白色的半透明背景 */
            max-height: 65vh;
            overflow-y: auto;
            width: 350px;
            padding: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            border-radius: 5px;
        }

        .list-container ul {
            list-style-type: none;
            padding: 0;
        }

        .list-container ul li {
            margin-bottom: 8px;
            font-size: 14px;
            cursor: pointer;
            color: #007bff;
        }

        /* 自定義滾動條樣式，讓滾動條更顯眼 */
        .list-container::-webkit-scrollbar {
            width: 8px; /* 滾動條寬度 */
        }

        .list-container::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2); /* 滾動條顏色 */
            border-radius: 4px;
        }

        .list-container::-webkit-scrollbar-track {
            background-color: rgba(0, 0, 0, 0.1); /* 滾動條背景 */
        }

        /* 地圖容器 */
        .map-container {
            flex-grow: 1;
            height: 95%;
            width: 100%;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        .text-orange {
            color: orange;
        }

        .text-gray {
            color: gray;
        }
    </style>
</head>
<body>
<div id="info-box">
        <h2 id="search-title">餐廳搜尋</h2>
        <form id="search-form" action="{{ route('list') }}" method="GET" style="display: flex; align-items: center;">
            <input type="text" id="search-input" name="query" placeholder="輸入餐廳名稱或留空以顯示所有餐廳..." value="{{ request('query') }}">
            <button id="search-button">搜尋</button>
            <div id="checkboxes">
                <label>
                    <input type="checkbox" name="med_food" value="N" {{ $med_food ? 'checked' : '' }}> 地中海飲食
                </label>
                <label>
                    <input type="checkbox" name="diet_food" value="N" {{ $diet_food ? 'checked' : '' }}> 減脂餐
                </label>
            </div>
            <input type="hidden" name="from" value="List">
        </form>
    </div>

    <!-- 提示訊息區域 -->
    <!-- <div id="no-results" style="display: none; color: red;">未找到符合的餐廳。</div> -->

    <div class="content">
        @if ($restaurants->isNotEmpty())
        <div class="list-container">
            <ul>
                @foreach ($restaurants as $restaurant)
                    <li>{{ $restaurant->food_name }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>

        window.onload = function() {
            // 檢查 URL 是否已有查詢參數
            const hasQueryParams = window.location.search.length > 0;

            if (!hasQueryParams) {
                document.getElementById('search-form').submit();
            }
        };

    </script>
</body>
</html>

</x-app-layout>