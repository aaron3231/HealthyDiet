<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthy Diet</title>
    <style>
        #map {
            height: 70vh;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>餐廳搜尋</h1>
        <form action="{{ route('home') }}" method="GET">
            @csrf
            <input type="text" name="query" placeholder="輸入餐廳名稱" required value="{{ request('query') }}">
            <button type="submit">搜尋</button>
        </form>

    @if(isset($restaurants))
        <h2>搜尋結果：</h2>
        @if($restaurants->isEmpty())
            <p>沒有餐廳符合條件。</p>
        @else
            <ul>
                @foreach($restaurants as $restaurant)
                    <li>{{ $restaurant->food_name }}</li>
                @endforeach
            </ul>
        @endif
    @endif

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
        }
    </script>
</body>
</html>
