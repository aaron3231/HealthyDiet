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
        <form id="search-form" action="{{ route('dashboard') }}" method="GET" style="display: flex; align-items: center;">
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
            <input type="hidden" name="from" value="Hybrid">
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

        <div class="map-container">
            <div id="map"></div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqvU9bwZxzsHJqAl1pgdrM5HOdz_GvuKM&language=zh-TW&callback=initMap&loading=async&v=weekly&libraries=marker" async defer></script>
    <script>
        const markers = [];  // 用來存儲所有標記
        const infoWindows = [];  // 用來存儲所有 infoWindow
        const collect_restaurants = [];

        function initMap() {
            const map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 23.6432, lng: 121.0730 },
                zoom: 8,
                language: 'zh-TW',
                streetViewControl: false,
                fullscreenControl: false,
                mapTypeControl: false,
                mapTypeId: 'roadmap',
                mapId: "DEMO_MAP_ID", // Map ID is required for advanced markers.
            });

            // 店家資料（從 Blade 視圖傳遞至 JavaScript）
            const locations = {!!json_encode($restaurants)!!};

            const geocoder = new google.maps.Geocoder();
            const bounds = new google.maps.LatLngBounds(); // 用來拉近拉遠標記範圍

            // 遍歷餐廳地址並呼叫 Geocoding API
            locations.forEach((location, index) => {
                geocodeAddress(geocoder, map, location, bounds, index);
            });
        }

        // 使用 Geocoding API 將地址轉換為經緯度並新增標記
        function geocodeAddress(geocoder, resultsMap, location, bounds, index) {

            geocoder.geocode({ address: location.address }, (results, status) => {
                if (status === "OK") {
                    const marker = new google.maps.Marker({
                        map: resultsMap,
                        position: results[0].geometry.location,
                        title: location.food_name
                    });

                    // 將標記的位置添加到 bounds
                    bounds.extend(marker.position);

                    // 創建資訊窗口
                    const infoWindow = new google.maps.InfoWindow({
                        content: 
                        `<div style="position: relative; padding: 10px;">
                        <h1>${location.food_name}</h1>
                        ${location.interduce}
                        
                        <h4>地址</h4> 
                        ${location.address}<br>

                        <h4>營業時間</h4>
                        周一   ${location.Mon}<br>
                        周二   ${location.Tue}<br>
                        周三   ${location.Wed}<br>
                        周四   ${location.Thu}<br>
                        周五   ${location.Fri}<br>
                        周六   ${location.Sat}<br>
                        周日   ${location.Sun}<br>

                        <i id="bookmark-icon-${location.food_name}" 
                        class="fas fa-bookmark ${location.isBookmarked ? 'text-orange' : 'text-grey'}" 
                        style="position: absolute; top: 10px; right: 10px; cursor:pointer;" 
                        onclick="toggleBookmark('${location.food_name}')"></i>

                        <button onclick="openReviewDialog('${location.food_name}')" 
                            style="position: absolute; right: 10px; bottom: 10px; background-color: orange; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
                            查看評論
                        </button>
                    </div>`
                    });

                    // 立即顯示資訊窗口
                    // infoWindow.open(resultsMap, marker);

                    markers[index] = marker;  // 將標記保存到陣列
                    infoWindows[index] = infoWindow;  // 將 infoWindow 保存到陣列

                    // 在標記上添加 click 事件
                    marker.addListener('click', () => {
                        infoWindow.open(resultsMap, marker);
                    });

                    resultsMap.fitBounds(bounds);

                    // 調整地圖視圖，向左平移 100 像素
                    resultsMap.panBy(-100, 0);  // -100 像素向左移動，y 值為 0 表示不垂直移動
                } else {
                    console.error("Geocode 失敗，原因: " + status);
                }
            });
        }

        // 添加滑鼠事件到清單項目
        document.querySelectorAll('.list-container li').forEach((listItem, index) => {

            // 點擊事件
            listItem.addEventListener('click', () => {
                infoWindows[index].open(map, markers[index]);
            });
        });

        // 當checkbox變更時，自動提交表單
        document.querySelectorAll('#checkboxes input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                    document.getElementById('search-form').submit();
            });
        });

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

        function openReviewDialog(restaurantName) {
            const dialogHtml = `
                <div style="padding: 20px;">
                    <h2>${restaurantName} 的評論</h2>
                    <textarea id="review-text" rows="4" style="width: 100%;"></textarea><br>
                    <button onclick="submitComment('${restaurantName}')">提交評論</button>
                    <button onclick="closeDialog()">關閉</button>
                </div>
            `;
    
            const dialog = document.createElement('div');
                dialog.innerHTML = dialogHtml;
                dialog.style.position = 'fixed';
                dialog.style.top = '50%';
                dialog.style.left = '50%';
                dialog.style.transform = 'translate(-50%, -50%)';
                dialog.style.backgroundColor = 'white';
                dialog.style.padding = '20px';
                dialog.style.boxShadow = '0 0 10px rgba(0, 0, 0, 0.5)';
                document.body.appendChild(dialog);
        }

        function closeDialog() {
            const dialog = document.querySelector('div[style*="fixed"]');
            if (dialog) {
                document.body.removeChild(dialog);
            }
        }

        function submitComment(restaurantName) {
            const reviewText = document.getElementById('review-text').value;
            const authId = {{ Auth::id() }};
            const url = `{{ route('submit_comment') }}?restaurant_name=${restaurantName}&user_id=${authId}&content=${reviewText}`;

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
        };

    </script>
</body>
</html>

</x-app-layout>