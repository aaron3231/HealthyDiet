<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthy Diet</title>
    <style>
        /* 搜尋區塊 */
        #info-box {
            position: absolute;
            top: 10px;
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
            height: 100vh;
        }

        .list-container {
            position: absolute;
            top: 140px;
            left: 10px;
            z-index: 5;
            background-color: rgba(255, 255, 255, 0.7); /* 設定為白色的半透明背景 */
            max-height: 70vh;
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
            height: 100%;
            width: 100%;
        }

        #map {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div id="info-box">
        <h2 id="search-title">餐廳搜尋</h2>
        <form id="search-form" action="{{ route('home') }}" method="GET" style="display: flex; align-items: center;">
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

    <script src="https://maps.googleapis.com/maps/api/js?key=API_KEY&language=zh-TW&callback=initMap&loading=async&v=weekly&libraries=marker" async defer></script>
    <script>
        const markers = [];  // 用來存儲所有標記
        const infoWindows = [];  // 用來存儲所有 infoWindow

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
            const locations = [
                @foreach ($restaurants as $restaurant)
                    { name: "{{ $restaurant->food_name }}", address: "{{ $restaurant->address }}" },
                @endforeach
            ];

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
                    const marker = new google.maps.marker.AdvancedMarkerElement({
                        map: resultsMap,
                        position: results[0].geometry.location,
                        title: location.name
                    });

                    // 將標記的位置添加到 bounds
                    bounds.extend(marker.position);

                    // 創建資訊窗口
                    const infoWindow = new google.maps.InfoWindow({
                        content: `<div><strong>${location.name}</strong><br>${location.address}</div>`
                    });

                    // 立即顯示資訊窗口
                    // infoWindow.open(resultsMap, marker);

                    markers[index] = marker;  // 將標記保存到陣列
                    infoWindows[index] = infoWindow;  // 將 infoWindow 保存到陣列

                    // 在標記上添加點擊事件以顯示資訊窗口
                    marker.addListener('click', () => {
                        infoWindow.open(resultsMap, marker);
                    });

                    // 調整地圖視口以涵蓋所有標記
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
            // 滑鼠懸停事件
            listItem.addEventListener('mouseover', () => {
                infoWindows[index].open(map, markers[index]);
            });

            // 滑鼠離開事件
            listItem.addEventListener('mouseout', () => {
                infoWindows[index].close();
            });

            // 點擊事件
            // listItem.addEventListener('click', () => {
            //     infoWindows[index].open(map, markers[index]);
            // });
        });

        // 當checkbox變更時，自動提交表單
        document.querySelectorAll('#checkboxes input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                    document.getElementById('search-form').submit();
            });
        });
    </script>
</body>
</html>
