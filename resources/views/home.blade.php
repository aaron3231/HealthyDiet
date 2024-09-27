<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>首頁</title>
</head>
<body>
    <h1>產品搜尋</h1>
    <form action="{{ route('home') }}" method="GET">
        @csrf
        <input type="text" name="query" placeholder="輸入餐廳名稱" required>
        <button type="submit">搜尋</button>
    </form>

    @if(isset($restaurants))
        <h2>搜尋結果：</h2>
        @if($restaurants->isEmpty())
            <p>沒有產品符合條件。</p>
        @else
            <ul>
                @foreach($restaurants as $restaurant)
                    <li>{{ $restaurant->food_name }}</li>
                @endforeach
            </ul>
        @endif
    @endif
</body>
</html>
