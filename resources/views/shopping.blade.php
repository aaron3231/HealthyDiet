<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>主題網頁</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            text-align: center;
        }

        .main-title {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 20px;
        }

        .full-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="main-title">掃碼即可點餐</h1>
        <img src="{{ asset('圖片/shopping.jpg') }}" alt="一整張圖" class="full-image">
    </div>
</body>
</html>
