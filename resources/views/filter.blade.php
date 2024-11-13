<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    body {
        background-color: #f4f4f4;
        font-family: Arial, sans-serif;
    }
    
    .outer-container {
        width: 100%;
        background-color: #b49e9e;
        padding: 0 300px;
        box-sizing: border-box;
    }
    
    .container_1 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 5px 0;
    }
    
    .left-section,
    .right-section {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    
    .map_search a,
    .login-register a {
        color: white;
        text-decoration: none;
        font-size: 18px;
    }
    
    .Developer, .Publish {
        position: relative;
        display: flex;
        align-items: center;
        gap: 5px;
        color: white;
    }
    
    .Developer .icon, .Publish .icon {
        width: 1em;
        height: 1em;
        vertical-align: middle;
    }
    
    .dropdown_Developer, .dropdown_Publish {
        display: none;
        position: absolute;
        top: calc(100% + 5px);
        left: 0;
        background-color: white;
        padding: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-top: 1px solid #ccc;
    }
    
    .Developer:hover .dropdown_Developer,
    .Publish:hover .dropdown_Publish {
        display: block;
    }
    
    .dropdown_Developer table, .dropdown_Publish table {
        width: auto;
        font-size: inherit;
        border-collapse: collapse;
    }
    
    .dropdown_Developer td, .dropdown_Publish td {
        padding: 10px 0;
    }
    
    .dropdown_Developer a, .dropdown_Publish a {
        color: inherit;
        text-decoration: none;
        white-space: nowrap;
    }
    
    .login-register {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .container_Searching {
        position: relative;
        display: flex;
        align-items: center;
        gap: 50px;
        padding: 0 300px;
        margin-top: 20px;
    }
    
    /* 健康美食地圖的樣式 */
    .title {
        font-weight: bold;
        font-size: 40px;
    }
    
    /* 城市名稱和圖標的懸停效果 */
    .city, .icon {
        cursor: pointer;
    }
    
    /* 當滑鼠懸停在 "台北市" 或 icon 時顯示下拉內容 */
    .container_Searching .city:hover + .icon + .dropdown_County_and_city,
    .container_Searching .icon:hover + .dropdown_County_and_city {
        display: block;
    }
    
    /* 下拉內容樣式 */
    .dropdown_County_and_city {
        display: none;
        position: absolute;
        top: 100%;
        left:600px;
        background-color: white;
        padding: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #ccc;
        z-index: 10;
    }
    
    /* 表格樣式 */
    .dropdown_County_and_city table {
        font-size: 14px;
        width: auto;
        border-collapse: collapse;
    }
    
    .dropdown_County_and_city td {
        padding: 8px 12px;
    }
    
    .dropdown_County_and_city a {
        color: inherit;
        text-decoration: none;
        white-space: nowrap;
    }
    
    /* 搜尋容器樣式 */
    .search-container {
        display: flex;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 8px;
        overflow: hidden;
        width: 500px;
    }
    
    #searchInput {
        flex: 7;
        padding: 10px;
        border: none;
        outline: none;
        font-size: 16px;
    }
    
    .search-action {
        flex: 3;
        padding: 10px 15px;
        background-color: #007BFF;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    
    .search-action:hover {
        background-color: #0056b3;
    }
    
    .container_Searching .icon {
        width: 1em;
        height: 1em;
        vertical-align: middle;
    }
    
    /* container_Select_Option 樣式 */
    .container_Select_Option {
        margin-top: 20px;
        padding: 0 300px;
    }
    
    .container_Select_Option table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .container_Select_Option td {
        padding: 10px;
        font-size: 16px;
    }
    
    .container_Select_Option label {
        margin-right: 10px;
    }
    
    .container_Select_Option {
        background-color:#ccc;
    }
    </style>
</head>

<body>
    <form action="{{ route('restaurant.search') }}">
        <div class="outer-container">

            <div class="container_1">
                <div class="left-section">
                    <div class="map_search"><a href="./Home_Page.html">首頁</a></div>
                    <div class="map_search"><a
                            href="https://www.tgos.tw/MapSites/Web/Map/MS_Map.aspx?themeid=43184&type=edit&visual=point">地圖尋找</a>
                    </div>
                    <div class="map_search"><a href="mediterranean_restaurant.html">地中海餐廳</a></div>
                    <div class="map_search"><a href="fitness_meal.html">健身餐</a></div>
                    <div class="map_search"><a href="filter.html">條件篩選</a></div>
                    <div class="map_search"><a href="google_reviews.html">google 評論</a></div>
                    <div class="map_search"><a href="ai_recommendations.html">AI智能推薦</a></div>
                </div>

                <div class="right-section">
                    <div class="login-register">
                        <a href=".//Register.html" target="_blank">註冊</a>
                        <a>|</a>
                        <a href=".//LogIn.html" target="_blank">登入</a>
                    </div>
                    <div class="Developer">
                        <span>組員介紹</span>
                        <img src="{{ asset('圖片/down_rec-removebg-preview.png') }}" alt="圖標" class="icon">
                        <div class="dropdown_Developer">
                            <table>
                                <tbody>
                                    <tr>
                                        <td><a href="page1.html">組長:潘采宜</a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="page2.html">組員:陳政儀</a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="page3.html">組員:方禹傑</a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="page4.html">組員:莊智翔</a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="page5.html">組員:陳則睿</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="Publish">
                        <span>我要刊登</span>
                        <img src="圖片/down_rec-removebg-preview.png" alt="圖標" class="icon">
                        <div class="dropdown_Publish">
                            <table>
                                <tbody>
                                    <tr>
                                        <td><a href="page1.html">組長:潘采宜</a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="page2.html">組員:陳政儀</a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="page3.html">組員:方禹傑</a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="page4.html">組員:莊智翔</a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="page5.html">組員:陳則睿</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container_Searching">
            <div class="title">健康美食地圖</div>
            <span class="city">台北市</span>
            <img src="圖片/down_rec-removebg-preview.png" alt="圖標" class="icon">
            <div class="dropdown_County_and_city">
                <table>
                    <tbody>
                        <tr>
                            <td><a href="page1.html">北部|台北市 新北市 桃園市 新竹市 新竹縣 宜蘭縣 基隆市</a></td>
                        </tr>
                        <tr>
                            <td><a href="page2.html">中部|台中市 彰化縣 雲林縣 苗栗縣 南投縣</a></td>
                        </tr>
                        <tr>
                            <td><a href="page3.html">南部|高雄市 台南市 嘉義市 嘉義縣 屏東縣</a></td>
                        </tr>
                        <tr>
                            <td><a href="page4.html">東部|台東縣 花蓮縣 澎湖縣 金門縣 連江縣</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="請輸入地址" oninput="updateSearchAction()">
                <button class="search-action" onclick="searchFunction()">🔍 搜尋</button>
                <input type="submit" value="搜尋">

                <p id="demo" onclick="searchFunction()">Click me to change my text color.</p>
            </div>

            <script>
                function searchFunction(id) {
                    //    document.getElementById("abc").href="http://127.0.0.1/GraduationTopics/mysqli_oo.php?type=" + id.value; 
                }
            </script>
        </div>

        <div class="container_Select_Option">
            <table>
                <tr>
                    <td>
                        異國風情 |
                    </td>
                    <td>
                        <input type="checkbox" id="Japanese" name="Restaurant_Category[]" value="日式">
                        <label for="Japanese">日式</label>

                        <input type="checkbox" id="Korean" name="Restaurant_Category[]" value="韓式">
                        <label for="Korean">韓式</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="西式">
                        <label for="Western">西式</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="火鍋">
                        <label for="Western">火鍋</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="燒烤">
                        <label for="Western">燒烤</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="素食">
                        <label for="Western">素食</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="義式">
                        <label for="Western">義式</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="中西式">
                        <label for="Western">中西式</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="泰式">
                        <label for="Western">泰式</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="健康餐">
                        <label for="Western">健康餐</label><br><br>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="日式燒烤">
                        <label for="Western">日式燒烤</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="甜點">
                        <label for="Western">甜點</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="壽喜燒">
                        <label for="Western">壽喜燒</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="吃到飽">
                        <label for="Western">吃到飽</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="速食">
                        <label for="Western">速食</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="中式">
                        <label for="Western">中式</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="早餐">
                        <label for="Western">早餐</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="健康飲食">
                        <label for="Western">健康飲食</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="便利食品">
                        <label for="Western">便利食品</label><br><br>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="披薩">
                        <label for="Western">披薩</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="咖啡">
                        <label for="Western">咖啡</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="越式">
                        <label for="Western">越式</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="壽司">
                        <label for="Western">壽司</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="三明治">
                        <label for="Western">三明治</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="烘焙">
                        <label for="Western">烘焙</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="美式">
                        <label for="Western">美式</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="街頭美食">
                        <label for="Western">街頭美食</label>

                        <input type="checkbox" id="Western" name="Restaurant_Category[]" value="海鮮">
                        <label for="Western">海鮮</label>




                    </td>
                </tr>


                <tr>
                    <td>
                        外送平台 |
                    </td>
                    <td>
                        <input type="checkbox" id="UE" name="Delivery_Platform[]" value="Ubereat">
                        <label for="vehicle1">Uber Eat</label>

                        <input type="checkbox" id="FP" name="Delivery_Platform[]" value="Foodpanda">
                        <label for="vehicle2">Food Panda</label><br><br>
                    </td>
                </tr>

                <tr>
                    <td>
                        區域 |
                    </td>
                    <td>
                        <input type="checkbox" id="Zhongzheng" name="Town[]" value="中正區">
                        <label for="Zhongzheng">中正區</label>

                        <input type="checkbox" id="Datong" name="Town[]" value="大同區">
                        <label for="Datong">大同區</label>

                        <input type="checkbox" id="Zhongshan" name="Town[]" value="中山區">
                        <label for="Zhongshan">中山區</label>

                        <input type="checkbox" id="Songshan" name="Town[]" value="松山區">
                        <label for="Songshan">松山區</label>

                        <input type="checkbox" id="Daan" name="Town[]" value="大安區">
                        <label for="Daan">大安區</label>

                        <input type="checkbox" id="Wanhua" name="Town[]" value="萬華區">
                        <label for="Wanhua">萬華區</label>

                        <input type="checkbox" id="Xinyi" name="Town[]" value="信義區">
                        <label for="Xinyi">信義區</label>

                        <input type="checkbox" id="Shilin" name="Town[]" value="士林區">
                        <label for="Shilin">士林區</label>

                        <input type="checkbox" id="Beitou" name="Town[]" value="北投區">
                        <label for="Beitou">北投區</label><br><br>

                        <input type="checkbox" id="Neihu" name="Town[]" value="內湖區">
                        <label for="Neihu">內湖區</label>

                        <input type="checkbox" id="Nangang" name="Town[]" value="南港區">
                        <label for="Nangang">南港區</label>

                        <input type="checkbox" id="Wenshan" name="Town[]" value="文山區">
                        <label for="Wenshan">文山區</label>
                        <input type="checkbox" id="Banqiao" name="Town[]" value="板橋區">
                        <label for="Banqiao">板橋區</label>

                        <input type="checkbox" id="Sanchong" name="Town[]" value="三重區">
                        <label for="Sanchong">三重區</label>

                        <input type="checkbox" id="Zhonghe" name="Town[]" value="中和區">
                        <label for="Zhonghe">中和區</label>

                        <input type="checkbox" id="Yonghe" name="Town[]" value="永和區">
                        <label for="Yonghe">永和區</label>

                        <input type="checkbox" id="Xinzhuang" name="Town[]" value="新莊區">
                        <label for="Xinzhuang">新莊區</label>

                        <input type="checkbox" id="Xindian" name="Town[]" value="新店區">
                        <label for="Xindian">新店區</label><br><br>

                        <input type="checkbox" id="Shulin" name="Town[]" value="樹林區">
                        <label for="Shulin">樹林區</label>

                        <input type="checkbox" id="Yingge" name="Town[]" value="鶯歌區">
                        <label for="Yingge">鶯歌區</label>

                        <input type="checkbox" id="Sanxia" name="Town[]" value="三峽區">
                        <label for="Sanxia">三峽區</label>

                        <input type="checkbox" id="Tamsui" name="Town[]" value="淡水區">
                        <label for="Tamsui">淡水區</label>

                        <input type="checkbox" id="Xizhi" name="Town[]" value="汐止區">
                        <label for="Xizhi">汐止區</label>

                        <input type="checkbox" id="Ruifang" name="Town[]" value="瑞芳區">
                        <label for="Ruifang">瑞芳區</label>

                        <input type="checkbox" id="Tucheng" name="Town[]" value="土城區">
                        <label for="Tucheng">土城區</label>

                        <input type="checkbox" id="Luzhou" name="Town[]" value="蘆洲區">
                        <label for="Luzhou">蘆洲區</label>

                        <input type="checkbox" id="Wugu" name="Town[]" value="五股區">
                        <label for="Wugu">五股區</label><br><br>

                        <input type="checkbox" id="Taishan" name="Town[]" value="泰山區">
                        <label for="Taishan">泰山區</label>

                        <input type="checkbox" id="Linkou" name="Town[]" value="林口區">
                        <label for="Linkou">林口區</label>

                        <input type="checkbox" id="Shenkeng" name="Town[]" value="深坑區">
                        <label for="Shenkeng">深坑區</label>

                        <input type="checkbox" id="Shiding" name="Town[]" value="石碇區">
                        <label for="Shiding">石碇區</label>

                        <input type="checkbox" id="Pinglin" name="Town[]" value="坪林區">
                        <label for="Pinglin">坪林區</label>

                        <input type="checkbox" id="Sanzhi" name="Town[]" value="三芝區">
                        <label for="Sanzhi">三芝區</label>

                        <input type="checkbox" id="Shimen" name="Town[]" value="石門區">
                        <label for="Shimen">石門區</label>

                        <input type="checkbox" id="Bali" name="Town[]" value="八里區">
                        <label for="Bali">八里區</label>

                        <input type="checkbox" id="Pingxi" name="Town[]" value="平溪區">
                        <label for="Pingxi">平溪區</label><br><br>

                        <input type="checkbox" id="Shuangxi" name="Town[]" value="雙溪區">
                        <label for="Shuangxi">雙溪區</label>

                        <input type="checkbox" id="Gongliao" name="Town[]" value="貢寮區">
                        <label for="Gongliao">貢寮區</label>

                        <input type="checkbox" id="Jinshan" name="Town[]" value="金山區">
                        <label for="Jinshan">金山區</label>

                        <input type="checkbox" id="Wanli" name="Town[]" value="萬里區">
                        <label for="Wanli">萬里區</label>

                        <input type="checkbox" id="Wulai" name="Town[]" value="烏來區">
                        <label for="Wulai">烏來區</label>

                        <input type="checkbox" id="Zhongzheng" name="Town[]" value="中正區">
                        <label for="Zhongzheng">中正區</label>

                        <input type="checkbox" id="Qidu" name="Town[]" value="七堵區">
                        <label for="Qidu">七堵區</label>

                        <input type="checkbox" id="Nuannuan" name="Town[]" value="暖暖區">
                        <label for="Nuannuan">暖暖區</label>

                        <input type="checkbox" id="Renai" name="Town[]" value="仁愛區">
                        <label for="Renai">仁愛區</label><br><br>

                        <input type="checkbox" id="Zhongshan" name="Town[]" value="中山區">
                        <label for="Zhongshan">中山區</label>

                        <input type="checkbox" id="Anle" name="Town[]" value="安樂區">
                        <label for="Anle">安樂區</label>

                        <input type="checkbox" id="Xinyi" name="Town[]" value="信義區">
                        <label for="Xinyi">信義區</label>

                        <input type="checkbox" id="Taoyuan" name="Town[]" value="桃園區">
                        <label for="Taoyuan">桃園區</label>

                        <input type="checkbox" id="Zhongli" name="Town[]" value="中壢區">
                        <label for="Zhongli">中壢區</label>

                        <input type="checkbox" id="Pingzhen" name="Town[]" value="平鎮區">
                        <label for="Pingzhen">平鎮區</label>

                        <input type="checkbox" id="Bade" name="Town[]" value="八德區">
                        <label for="Bade">八德區</label>

                        <input type="checkbox" id="Yangmei" name="Town[]" value="楊梅區">
                        <label for="Yangmei">楊梅區</label>

                        <input type="checkbox" id="Luzhu" name="Town[]" value="蘆竹區">
                        <label for="Luzhu">蘆竹區</label><br><br>

                        <input type="checkbox" id="Daxi" name="Town[]" value="大溪區">
                        <label for="Daxi">大溪區</label>

                        <input type="checkbox" id="Longtan" name="Town[]" value="龍潭區">
                        <label for="Longtan">龍潭區</label>

                        <input type="checkbox" id="Guishan" name="Town[]" value="龜山區">
                        <label for="Guishan">龜山區</label>

                        <input type="checkbox" id="Dayuan" name="Town[]" value="大園區">
                        <label for="Dayuan">大園區</label>

                        <input type="checkbox" id="Guanyin" name="Town[]" value="觀音區">
                        <label for="Guanyin">觀音區</label>

                        <input type="checkbox" id="Xinwu" name="Town[]" value="新屋區">
                        <label for="Xinwu">新屋區</label>

                        <input type="checkbox" id="Fuxing" name="Town[]" value="復興區">
                        <label for="Fuxing">復興區</label>


                        <input type="checkbox" id="Central" name="Town[]" value="中區">
                        <label for="Central">中區</label>

                        <input type="checkbox" id="East" name="Town[]" value="東區">
                        <label for="East">東區</label><br><br>

                        <input type="checkbox" id="South" name="Town[]" value="南區">
                        <label for="South">南區</label>

                        <input type="checkbox" id="West" name="Town[]" value="西區">
                        <label for="West">西區</label>

                        <input type="checkbox" id="North" name="Town[]" value="北區">
                        <label for="North">北區</label>

                        <input type="checkbox" id="Beitun" name="Town[]" value="北屯區">
                        <label for="Beitun">北屯區</label>

                        <input type="checkbox" id="Xitun" name="Town[]" value="西屯區">
                        <label for="Xitun">西屯區</label>

                        <input type="checkbox" id="Nantun" name="Town[]" value="南屯區">
                        <label for="Nantun">南屯區</label>

                        <input type="checkbox" id="Taiping" name="Town[]" value="太平區">
                        <label for="Taiping">太平區</label>

                        <input type="checkbox" id="Dali" name="Town[]" value="大里區">
                        <label for="Dali">大里區</label>

                        <input type="checkbox" id="Wufeng" name="Town[]" value="霧峰區">
                        <label for="Wufeng">霧峰區</label><br><br>

                        <input type="checkbox" id="Wuri" name="Town[]" value="烏日區">
                        <label for="Wuri">烏日區</label>

                        <input type="checkbox" id="Fengyuan" name="Town[]" value="豐原區">
                        <label for="Fengyuan">豐原區</label>

                        <input type="checkbox" id="Houli" name="Town[]" value="后里區">
                        <label for="Houli">后里區</label>

                        <input type="checkbox" id="Shigang" name="Town[]" value="石岡區">
                        <label for="Shigang">石岡區</label>

                        <input type="checkbox" id="Dongshi" name="Town[]" value="東勢區">
                        <label for="Dongshi">東勢區</label>

                        <input type="checkbox" id="Heping" name="Town[]" value="和平區">
                        <label for="Heping">和平區</label>

                        <input type="checkbox" id="Xinshe" name="Town[]" value="新社區">
                        <label for="Xinshe">新社區</label>

                        <input type="checkbox" id="Tanzi" name="Town[]" value="潭子區">
                        <label for="Tanzi">潭子區</label>

                        <input type="checkbox" id="Daya" name="Town[]" value="大雅區">
                        <label for="Daya">大雅區</label><br><br>

                        <input type="checkbox" id="Shengang" name="Town[]" value="神岡區">
                        <label for="Shengang">神岡區</label>

                        <input type="checkbox" id="Dadu" name="Town[]" value="大肚區">
                        <label for="Dadu">大肚區</label>

                        <input type="checkbox" id="Shalu" name="Town[]" value="沙鹿區">
                        <label for="Shalu">沙鹿區</label>

                        <input type="checkbox" id="Longjing" name="Town[]" value="龍井區">
                        <label for="Longjing">龍井區</label>

                        <input type="checkbox" id="Wuqi" name="Town[]" value="梧棲區">
                        <label for="Wuqi">梧棲區</label>

                        <input type="checkbox" id="Qingshui" name="Town[]" value="清水區">
                        <label for="Qingshui">清水區</label>

                        <input type="checkbox" id="Dajia" name="Town[]" value="大甲區">
                        <label for="Dajia">大甲區</label>

                        <input type="checkbox" id="Waipu" name="Town[]" value="外埔區">
                        <label for="Waipu">外埔區</label>

                        <input type="checkbox" id="Daan" name="Town[]" value="大安區">
                        <label for="Daan">大安區</label><br><br>

                        <input type="checkbox" id="Changhua" name="Town[]" value="彰化市">
                        <label for="Changhua">彰化市</label>

                        <input type="checkbox" id="Fenyuan" name="Town[]" value="芬園鄉">
                        <label for="Fenyuan">芬園鄉</label>

                        <input type="checkbox" id="Huatan" name="Town[]" value="花壇鄉">
                        <label for="Huatan">花壇鄉</label>

                        <input type="checkbox" id="Xiushui" name="Town[]" value="秀水鄉">
                        <label for="Xiushui">秀水鄉</label>

                        <input type="checkbox" id="Lugang" name="Town[]" value="鹿港鎮">
                        <label for="Lugang">鹿港鎮</label>

                        <input type="checkbox" id="Fuxing" name="Town[]" value="福興鄉">
                        <label for="Fuxing">福興鄉</label>

                        <input type="checkbox" id="Xianxi" name="Town[]" value="線西鄉">
                        <label for="Xianxi">線西鄉</label>

                        <input type="checkbox" id="Hemei" name="Town[]" value="和美鎮">
                        <label for="Hemei">和美鎮</label>

                        <input type="checkbox" id="Shengang" name="Town[]" value="伸港鄉">
                        <label for="Shengang">伸港鄉</label>

                        <input type="checkbox" id="Dayuan" name="Town[]" value="大村鄉">
                        <label for="Dayuan">大村鄉</label>

                        <input type="checkbox" id="Puyan" name="Town[]" value="埔鹽鄉">
                        <label for="Puyan">埔鹽鄉</label>

                        <input type="checkbox" id="Puxin" name="Town[]" value="埔心鄉">
                        <label for="Puxin">埔心鄉</label>

                        <input type="checkbox" id="Yuanlin" name="Town[]" value="員林市">
                        <label for="Yuanlin">員林市</label>

                        <input type="checkbox" id="Shetou" name="Town[]" value="社頭鄉">
                        <label for="Shetou">社頭鄉</label>

                        <input type="checkbox" id="Yongjing" name="Town[]" value="永靖鄉">
                        <label for="Yongjing">永靖鄉</label>

                        <input type="checkbox" id="Tianwei" name="Town[]" value="田尾鄉">
                        <label for="Tianwei">田尾鄉</label>

                        <input type="checkbox" id="Beidou" name="Town[]" value="北斗鎮">
                        <label for="Beidou">北斗鎮</label>

                        <input type="checkbox" id="Tianzhong" name="Town[]" value="田中鎮">
                        <label for="Tianzhong">田中鎮</label>

                        <input type="checkbox" id="Erlin" name="Town[]" value="二林鎮">
                        <label for="Erlin">二林鎮</label>

                        <input type="checkbox" id="Dacun" name="Town[]" value="大城鄉">
                        <label for="Dacun">大城鄉</label>

                        <input type="checkbox" id="Fangyuan" name="Town[]" value="芳苑鄉">
                        <label for="Fangyuan">芳苑鄉</label>

                        <input type="checkbox" id="Ershui" name="Town[]" value="二水鄉">
                        <label for="Ershui">二水鄉</label>

                        <input type="checkbox" id="Nanzi" name="Town[]" value="楠梓區">
                        <label for="Nanzi">楠梓區</label>

                        <input type="checkbox" id="Zuoying" name="Town[]" value="左營區">
                        <label for="Zuoying">左營區</label>

                        <input type="checkbox" id="Gushan" name="Town[]" value="鼓山區">
                        <label for="Gushan">鼓山區</label>

                        <input type="checkbox" id="Sanmin" name="Town[]" value="三民區">
                        <label for="Sanmin">三民區</label>

                        <input type="checkbox" id="Yancheng" name="Town[]" value="鹽埕區">
                        <label for="Yancheng">鹽埕區</label>

                        <input type="checkbox" id="Qijin" name="Town[]" value="旗津區">
                        <label for="Qijin">旗津區</label>

                        <input type="checkbox" id="Qianjin" name="Town[]" value="前金區">
                        <label for="Qianjin">前金區</label>

                        <input type="checkbox" id="Xinxing" name="Town[]" value="新興區">
                        <label for="Xinxing">新興區</label>

                        <input type="checkbox" id="Lingya" name="Town[]" value="苓雅區">
                        <label for="Lingya">苓雅區</label>

                        <input type="checkbox" id="Qianzhen" name="Town[]" value="前鎮區">
                        <label for="Qianzhen">前鎮區</label>

                        <input type="checkbox" id="Xiaogang" name="Town[]" value="小港區">
                        <label for="Xiaogang">小港區</label>

                        <input type="checkbox" id="Fengshan" name="Town[]" value="鳳山區">
                        <label for="Fengshan">鳳山區</label>

                        <input type="checkbox" id="Linyuan" name="Town[]" value="林園區">
                        <label for="Linyuan">林園區</label>

                        <input type="checkbox" id="Daliao" name="Town[]" value="大寮區">
                        <label for="Daliao">大寮區</label>

                        <input type="checkbox" id="Dashe" name="Town[]" value="大社區">
                        <label for="Dashe">大社區</label>

                        <input type="checkbox" id="Dashu" name="Town[]" value="大樹區">
                        <label for="Dashu">大樹區</label>

                        <input type="checkbox" id="Renwu" name="Town[]" value="仁武區">
                        <label for="Renwu">仁武區</label>

                        <input type="checkbox" id="Niaosong" name="Town[]" value="鳥松區">
                        <label for="Niaosong">鳥松區</label>

                        <input type="checkbox" id="Gangshan" name="Town[]" value="岡山區">
                        <label for="Gangshan">岡山區</label>

                        <input type="checkbox" id="Qiaotou" name="Town[]" value="橋頭區">
                        <label for="Qiaotou">橋頭區</label>

                        <input type="checkbox" id="Yanchao" name="Town[]" value="燕巢區">
                        <label for="Yanchao">燕巢區</label>

                        <input type="checkbox" id="Tianliao" name="Town[]" value="田寮區">
                        <label for="Tianliao">田寮區</label>

                        <input type="checkbox" id="Alian" name="Town[]" value="阿蓮區">
                        <label for="Alian">阿蓮區</label>

                        <input type="checkbox" id="Luzhu" name="Town[]" value="路竹區">
                        <label for="Luzhu">路竹區</label>

                        <input type="checkbox" id="Hunei" name="Town[]" value="湖內區">
                        <label for="Hunei">湖內區</label>

                        <input type="checkbox" id="Qieding" name="Town[]" value="茄萣區">
                        <label for="Qieding">茄萣區</label>

                        <input type="checkbox" id="Yongan" name="Town[]" value="永安區">
                        <label for="Yongan">永安區</label>

                        <input type="checkbox" id="Mituo" name="Town[]" value="彌陀區">
                        <label for="Mituo">彌陀區</label>

                        <input type="checkbox" id="Ziguan" name="Town[]" value="梓官區">
                        <label for="Ziguan">梓官區</label>

                        <input type="checkbox" id="Qishan" name="Town[]" value="旗山區">
                        <label for="Qishan">旗山區</label>

                        <input type="checkbox" id="Meinong" name="Town[]" value="美濃區">
                        <label for="Meinong">美濃區</label>

                        <input type="checkbox" id="Liugui" name="Town[]" value="六龜區">
                        <label for="Liugui">六龜區</label>

                        <input type="checkbox" id="Jiaxian" name="Town[]" value="甲仙區">
                        <label for="Jiaxian">甲仙區</label>

                        <input type="checkbox" id="Shanlin" name="Town[]" value="杉林區">
                        <label for="Shanlin">杉林區</label>

                        <input type="checkbox" id="Neimen" name="Town[]" value="內門區">
                        <label for="Neimen">內門區</label>

                        <input type="checkbox" id="Maolin" name="Town[]" value="茂林區">
                        <label for="Maolin">茂林區</label>

                        <input type="checkbox" id="Taoyuan" name="Town[]" value="桃源區">
                        <label for="Taoyuan">桃源區</label>

                        <input type="checkbox" id="Namaxia" name="Town[]" value="那瑪夏區">
                        <label for="Namaxia">那瑪夏區</label>

                        <input type="checkbox" id="CentralWest" name="Town[]" value="中西區">
                        <label for="CentralWest">中西區</label>

                        <input type="checkbox" id="East" name="Town[]" value="東區">
                        <label for="East">東區</label>

                        <input type="checkbox" id="South" name="Town[]" value="南區">
                        <label for="South">南區</label>

                        <input type="checkbox" id="North" name="Town[]" value="北區">
                        <label for="North">北區</label>

                        <input type="checkbox" id="Anping" name="Town[]" value="安平區">
                        <label for="Anping">安平區</label>

                        <input type="checkbox" id="Annan" name="Town[]" value="安南區">
                        <label for="Annan">安南區</label>

                        <input type="checkbox" id="HualienCity" name="Town[]" value="花蓮市">
                        <label for="HualienCity">花蓮市</label>

                        <input type="checkbox" id="Xincheng" name="Town[]" value="新城鄉">
                        <label for="Xincheng">新城鄉</label>

                        <input type="checkbox" id="JiAn" name="Town[]" value="吉安鄉">
                        <label for="JiAn">吉安鄉</label>

                        <input type="checkbox" id="Shoufeng" name="Town[]" value="壽豐鄉">
                        <label for="Shoufeng">壽豐鄉</label>

                        <input type="checkbox" id="Fenglin" name="Town[]" value="鳳林鎮">
                        <label for="Fenglin">鳳林鎮</label>

                        <input type="checkbox" id="Guangfu" name="Town[]" value="光復鄉">
                        <label for="Guangfu">光復鄉</label>

                        <input type="checkbox" id="Fengbin" name="Town[]" value="豐濱鄉">
                        <label for="Fengbin">豐濱鄉</label>

                        <input type="checkbox" id="Ruisui" name="Town[]" value="瑞穗鄉">
                        <label for="Ruisui">瑞穗鄉</label>

                        <input type="checkbox" id="Wanrong" name="Town[]" value="萬榮鄉">
                        <label for="Wanrong">萬榮鄉</label>

                        <input type="checkbox" id="Yuli" name="Town[]" value="玉里鎮">
                        <label for="Yuli">玉里鎮</label>

                        <input type="checkbox" id="Zhuoxi" name="Town[]" value="卓溪鄉">
                        <label for="Zhuoxi">卓溪鄉</label>

                        <input type="checkbox" id="Fuli" name="Town[]" value="富里鄉">
                        <label for="Fuli">富里鄉</label>

                        <input type="checkbox" id="TaitungCity" name="Town[]" value="台東市">
                        <label for="TaitungCity">台東市</label>

                        <input type="checkbox" id="Luye" name="Town[]" value="鹿野鄉">
                        <label for="Luye">鹿野鄉</label>

                        <input type="checkbox" id="Chishang" name="Town[]" value="池上鄉">
                        <label for="Chishang">池上鄉</label>

                        <input type="checkbox" id="Donghe" name="Town[]" value="東河鄉">
                        <label for="Donghe">東河鄉</label>

                        <input type="checkbox" id="Guanshan" name="Town[]" value="關山鎮">
                        <label for="Guanshan">關山鎮</label>

                        <input type="checkbox" id="Haiduan" name="Town[]" value="海端鄉">
                        <label for="Haiduan">海端鄉</label>

                        <input type="checkbox" id="Changbin" name="Town[]" value="長濱鄉">
                        <label for="Changbin">長濱鄉</label>

                        <input type="checkbox" id="Daren" name="Town[]" value="達仁鄉">
                        <label for="Daren">達仁鄉</label>

                        <input type="checkbox" id="Jinfeng" name="Town[]" value="金峰鄉">
                        <label for="Jinfeng">金峰鄉</label>

                        <input type="checkbox" id="Beinan" name="Town[]" value="卑南鄉">
                        <label for="Beinan">卑南鄉</label>

                        <input type="checkbox" id="Taimali" name="Town[]" value="太麻里鄉">
                        <label for="Taimali">太麻里鄉</label>

                        <input type="checkbox" id="Lanyu" name="Town[]" value="蘭嶼鄉">
                        <label for="Lanyu">蘭嶼鄉</label>

                        <input type="checkbox" id="Chenggong" name="Town[]" value="成功鎮">
                        <label for="Chenggong">成功鎮</label>

                        <input type="checkbox" id="GreenIsland" name="Town[]" value="綠島鄉">
                        <label for="GreenIsland">綠島鄉</label>

                        <input type="checkbox" id="Magong" name="Town[]" value="馬公市">
                        <label for="Magong">馬公市</label>

                        <input type="checkbox" id="Huxi" name="Town[]" value="湖西鄉">
                        <label for="Huxi">湖西鄉</label>

                        <input type="checkbox" id="Baisha" name="Town[]" value="白沙鄉">
                        <label for="Baisha">白沙鄉</label>

                        <input type="checkbox" id="Xiyu" name="Town[]" value="西嶼鄉">
                        <label for="Xiyu">西嶼鄉</label>

                        <input type="checkbox" id="Qimei" name="Town[]" value="七美鄉">
                        <label for="Qimei">七美鄉</label>

                        <input type="checkbox" id="WangAn" name="Town[]" value="望安鄉">
                        <label for="WangAn">望安鄉</label>

                        <input type="checkbox" id="Jincheng" name="Town[]" value="金城鎮">
                        <label for="Jincheng">金城鎮</label>

                        <input type="checkbox" id="Jinhu" name="Town[]" value="金湖鎮">
                        <label for="Jinhu">金湖鎮</label>

                        <input type="checkbox" id="Jinning" name="Town[]" value="金寧鄉">
                        <label for="Jinning">金寧鄉</label>

                        <input type="checkbox" id="Lieyu" name="Town[]" value="烈嶼鄉">
                        <label for="Lieyu">烈嶼鄉</label>

                        <input type="checkbox" id="Wuqiu" name="Town[]" value="烏坵鄉">
                        <label for="Wuqiu">烏坵鄉</label>

                        <input type="checkbox" id="Nangan" name="Town[]" value="南竿鄉">
                        <label for="Nangan">南竿鄉</label>

                        <input type="checkbox" id="Beigan" name="Town[]" value="北竿鄉">
                        <label for="Beigan">北竿鄉</label>

                        <input type="checkbox" id="Juguang" name="Town[]" value="莒光鄉">
                        <label for="Juguang">莒光鄉</label>

                        <input type="checkbox" id="Dongyin" name="Town[]" value="東引鄉">
                        <label for="Dongyin">東引鄉</label>






                    </td>


                </tr>
                <tr>
                    <td>
                        支付方式 |
                    </td>
                    <td>
                        <input type="checkbox" id="IC" name="CarrierInvoice_Carrier[]" value="IC">
                        <label for="IC">載具</label>

                        <input type="checkbox" id="EP" name="Electronic_Payment[]" value="EP">
                        <label for="Payment method3">電子支付</label>

                        <input type="checkbox" id="CC" name="Credit_Card[]" value="CC">
                        <label for="Payment method4">信用卡</label><br><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        營業中 |
                    </td>
                    <td>
                        <input type="checkbox" id="Open" name="Open" value="Open">
                        <label for="Open1">營業中</label><br><br>
                    </td>
                </tr>



                <tr>
                    <td>吃到飽/單點</td>
                    <td>
                        <input type="checkbox" id="Buffet" name="Buffet_A_La_Carte[]" value="Buffet">
                        <label for="Buffet">吃到飽</label>
                        <input type="checkbox" id="Single" name="Buffet_A La_Carte[]" value="Single">
                        <label for="Single">單點</label><br><br>
                    </td>
                    </td>
                </tr>
                <tr>
                    <td>地中海/健身餐</td>
                    <td>
                        <input type="checkbox" id="MC" name="MC" value="MC">
                        <label for="mediterranean cuisine">地中海美食</label>
                        <input type="checkbox" id="fm" name="fm" value="fm">
                        <label for="fitness meal">健身餐</label><br><br>
                    </td>
                    </td>
                </tr>
                <tr>
                    <td>可否內用</td>
                    <td>
                        <input type="checkbox" id="IU" name="IU" value="IU">
                        <label for="Internal use">內用</label><br><br>
                    </td>
                    </td>
                </tr>
                <tr>
                    <td>人均價位</td>
                    <td>
                        <input type="text" id="Score" name="Average_Price_per_Person"><br><br>
                    </td>
                    </td>
                </tr>
                <tr>
                    <td>評分</td>

                    <td>
                        <input type="text" id="Score" name="Google_Rating">
                        <label for="Score">分以上</label>
                        , 多餘 <input type="text" id="NB" name="Number_of_Google_reviews">
                        <label for="Number of data items">評筆個數</label><br><br>
                    </td>
                </tr>
            </table>
        </div>
        <input type="submit" value="Submit">
    </form>

    @if ($restaurants->isEmpty())
        <p>No results found.</p>
    @else
        <table border="1" align="center">
            <tr align="center">
                @foreach ($restaurants->first() as $column => $value)
                    <td>{{ $column }}</td>
                @endforeach
            </tr>
            @foreach ($restaurants as $restaurant)
                <tr>
                    @foreach ($restaurant as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    @endif

</body>

</html>