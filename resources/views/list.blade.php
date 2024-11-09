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

        .text-orange {
            color: orange;
        }

        .text-gray {
            color: gray;
        }

        /* dialog 視窗 */
        #dialog {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            z-index: 10;
            width: 400px;
            max-height: 70vh;
            overflow-y: auto;
        }

        /* 關閉按鈕 */
        #dialog-close {
            cursor: pointer;
            color: red;
            float: right;
        }

        /* 上下部分分隔 */
        #dialog-details {
            font-size: 16px;
            margin-bottom: 10px;
        }

        #dialog-comments {
            margin-top: 20px;
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
        </form>
    </div>

    <div class="content">
        @if ($restaurants->isNotEmpty())
        <div class="list-container">
            <ul>
                @foreach ($restaurants as $restaurant)
                    <li style="display: flex; justify-content: space-between; align-items: center;">
                        <span onclick="showDialog('{{ $restaurant->food_name }}', '{{ $restaurant }}')">{{ $restaurant->food_name }}</span>
                        <i id="bookmark-icon-{{ $restaurant->food_name }}" 
                            class="fas fa-bookmark {{ $restaurant->isBookmarked ? 'text-orange' : 'text-gray' }}" 
                            style="cursor: pointer;" 
                            onclick="toggleBookmark('{{ $restaurant->food_name }}')"></i>
                    </li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- Dialog -->
        <div id="dialog">
            <span id="dialog-close" onclick="closeDialog()">✖</span>
            <div id="dialog-details"></div>
            <div id="dialog-comments">
                <h4>評論</h4>
                <ul id="comments-list"></ul>
                <textarea id="comment-input" placeholder="輸入您的評論"></textarea>
                <button onclick="submitComment()">送出</button>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>

        function toggleBookmark(foodName) {
            const authId = {{ Auth::id() }};
            const url = `{{ route('set_bookmark') }}?food_name=${encodeURIComponent(foodName)}&id=${authId}`;
            const iconElement = document.getElementById(`bookmark-icon-${foodName}`);

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        console.log(response);
                    }
                    return response.json();
                })
                .then(data => {
                    // console.log(data.message);
                    if (data.message === '新增收藏')
                    {
                        iconElement.classList.remove('text-gray');
                        iconElement.classList.add('text-orange');
                    }
                    else
                    {
                        iconElement.classList.remove('text-orange');
                        iconElement.classList.add('text-gray');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // 顯示 dialog
        function showDialog(foodName, details) {
            // 解析 JSON 格式的 details 字串
            const restaurant = JSON.parse(details);
            const introduce = restaurant.interduce;
            const address = restaurant.address;
            const Mon = restaurant.Mon;
            const Tue = restaurant.Tue;
            const Wed = restaurant.Wed;
            const Thu = restaurant.Thu;
            const Fri = restaurant.Fri;
            const Sat = restaurant.Sat;
            const Sun = restaurant.Sun;

            document.getElementById('dialog-details').innerHTML = `<h1>${foodName}</h1>
                        ${introduce}
                        
                        <h4>地址</h4> 
                        ${address}<br>

                        <h4>營業時間</h4>
                        周一   ${Mon}<br>
                        周二   ${Tue}<br>
                        周三   ${Wed}<br>
                        周四   ${Thu}<br>
                        周五   ${Fri}<br>
                        周六   ${Sat}<br>
                        周日   ${Sun}<br>`;
            loadComments(foodName);
            document.getElementById('dialog').style.display = 'block';
        }

        // 關閉 dialog
        function closeDialog() {
            document.getElementById('dialog').style.display = 'none';
        }

        // 加載評論
        function loadComments(foodName) {
            fetch(`{{ route('fetch_comments') }}?restaurant_name=${encodeURIComponent(foodName)}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const comments = data.comments;
                    console.log(comments);
                    const commentsContainer = document.getElementById('comments-list');
                    commentsContainer.innerHTML = ''; // 清空現有的評論

                    comments.forEach(comment => {
                        // 只顯示所需的欄位，這裡省略了 id
                        console.log(comment);
                        const commentElement = document.createElement('div');
                        commentElement.textContent = `${comment.user_name} 在 ${comment.restaurant_name} 的評論： ${comment.content}`;
                        commentsContainer.appendChild(commentElement);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // 送出評論
        function submitComment() {
            const commentText = document.getElementById('comment-input').value;
            if (!commentText) return alert('請輸入評論內容');
            const authId = {{ Auth::id() }};
            const foodName = document.getElementById('dialog-details').querySelector('strong').textContent;
            const url = `{{ route('submit_comment') }}?restaurant_name=${foodName}&user_id=${authId}&content=${commentText}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        console.log(response);
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                    closeDialog();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('提交評論時出錯。');
                });
        }

        window.onload = function() {
            // 檢查 URL 是否已有查詢參數
            const hasQueryParams = window.location.search.length > 0;

            if (!hasQueryParams) {
                document.getElementById('search-form').submit();
            }

            if (!window.location.search) {
                document.getElementById('search-form').submit();
            }
        };

    </script>
</body>
</html>

</x-app-layout>