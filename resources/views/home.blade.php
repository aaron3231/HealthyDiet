<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthy Diet</title>
    <style>
        /* 搜尋標題 */
        #search-title {
            font-size: 24px; /* 字體大小 */
            font-weight: bold; /* 字體粗細 */
            margin-bottom: 10px; /* 下邊距 */
            color: #333; /* 字體顏色 */
        }

        /* 搜尋欄位 */
        #search-input {
            width: 300px; /* 欄位寬度 */
            padding: 10px; /* 內邊距 */
            border: 1px solid #ccc; /* 邊框顏色 */
            border-radius: 4px; /* 邊框圓角 */
            font-size: 16px; /* 字體大小 */
            margin-right: 10px; /* 右邊距 */
        }

        /* 按鈕 */
        #search-button {
            padding: 10px 20px; /* 內邊距 (上下, 左右) */
            background-color: #007bff; /* 按鈕背景顏色 */
            color: white; /* 字體顏色 */
            border: none; /* 移除邊框 */
            border-radius: 4px; /* 邊框圓角 */
            cursor: pointer; /* 鼠標指標變為手型 */
            font-size: 16px; /* 字體大小 */
        }

        /* 按鈕懸停效果 */
        #search-button:hover {
            background-color: #0056b3; /* 懸停時的背景顏色 */
        }

        /* 提示訊息 */
        #no-results {
            margin-top: 10px; /* 與搜尋區域的間距 */
        }

        /* 地圖 */
        #map {
            height: 80vh; /* 地圖高度 */
            margin-top: 20px; /* 與搜尋區域的間距 */
        }
    </style>
</head>
<body>
    <div id="info-box">
        <h2 id="search-title">餐廳搜尋</h2>
        <form action="{{ route('home') }}" method="GET">
            <input type="text" id="search-input" name="query" placeholder="輸入餐廳名稱..." required value="{{ request('query') }}">
            <button id="search-button">搜尋</button>
        </form>
    </div>

    <!-- 提示訊息區域 -->
    <!-- <div id="no-results" style="display: none; color: red;">未找到符合的餐廳。</div> -->

    <div id="map"></div>

    <script src="https://maps.googleapis.com/maps/api/js?key=API_KEY&language=zh-TW&callback=initMap" async defer></script>
    <script>
        function initMap() {
            // 初始化
            const map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 23.6432, lng: 121.0730 },
                zoom: 7.2,
                language: 'zh-TW'
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
            locations.forEach((location) => {
                geocodeAddress(geocoder, map, location, bounds);
            });
        }

        // 使用 Geocoding API 將地址轉換為經緯度並新增標記
        function geocodeAddress(geocoder, resultsMap, location, bounds) {
            geocoder.geocode({ address: location.address }, (results, status) => {
                if (status === "OK") {
                    const marker = new google.maps.Marker({
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
                    infoWindow.open(resultsMap, marker);

                    // 在標記上添加點擊事件以顯示資訊窗口
                    marker.addListener('click', () => {
                        infoWindow.open(resultsMap, marker);
                    });

                    // 調整地圖視口以涵蓋所有標記
                    resultsMap.fitBounds(bounds);
                } else {
                    console.error("Geocode 失敗，原因: " + status);
                }
            });
        }
    </script>
</body>
</html>
