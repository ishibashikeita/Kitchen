<?php

require("./dbconnect.php");
session_start();

// セレクトボックスで選択された値を受け取る
if (!empty($_POST['cate'])) {
    $cate = $_POST['cate'];
    $sql = "SELECT * FROM T_Shop WHERE F_Category_ID = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $cate);
    $stmt->execute();
    $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "SELECT * FROM T_Shop";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (!empty($_POST['S_more'])) {
    $_SESSION['mise'] = $_POST;
    header('Location: misepage.php');   // misepage.phpへ移動
    exit();
}



//検索にヒットした個数のセクションを生成


?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/introduction_scroll.js"></script>

    <title>店舗紹介ページ</title>
</head>

<body>
    <header>
        <?php require_once("header.php") ?>
    </header>

    <!-- <section class="intro_banner">

    </section> -->

    <form action="" method="post">
        <section class="intro_search">
            <!-- 検索条件プルダウン -->
            <select class="conditions" name="cate">
                <option value="">検索条件を選択</option>
                <option value="C101">和食</option>
                <option value="C102">パン・サンドイッチ</option>
                <option value="C103">洋食</option>
                <option value="C104">ファストフード</option>
                <option value="C105">飲みもの</option>
            </select>
            <!-- <select class="conditions">
            <option value="">検索条件を検索</option>
            <option value="">5km</option>
            <option value="">7km</option>
            <option value="">10km</option>
            <option value="">15km</option>
            <option value="">15km～</option>
        </select> -->
        </section>
        <div class="intro_search_bt">
            <button type="submit" value="検索">検索</button>
        </div>
    </form>
    <article class="intro" id="intro">
        <?php
        for ($i = 0; $i < count($record); $i++) {
            $sql = "SELECT F_ShopImageName FROM T_ShopImages WHERE F_Shopimage_ID = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $record[$i]['F_Shopimage_ID']);
            $stmt->execute();
            $img = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<section class='intro_shop fadeIn'>
    <div class='intro_shop_img'>
        <img src='./image/" . $img['F_ShopImageName'] . "' alt=''>
    </div>
    <div class='intro_shop_info'>
        <div class='intro_shop_data'>
            <div class='intro_shopname'><p>" . $record[$i]['F_ShopName'] . "</p></div>
            <div class='intro_shopdetail'>
                <small>〒" . $record[$i]['F_ShopPostcode'] . "</small>
                <p>" . $record[$i]['F_ShopAddress'] . "</p>
                <p>営業時間: " . date('G:i', strtotime($record[$i]['F_OpenTime'])) . "～" . date('G:i', strtotime($record[$i]['F_CloseTime'])) . "</p>
            </div>
            <div class='intro_morebtn'><a href='misepage.php'>
            <form action='' method='post'>
            <button type='submit' name='S_more' value =" . $record[$i]['F_Shop_ID'] . ">もっと見る</button>
            </form>
            </a>
            </div>    
    
        </div>
    </div>
    </section>";
        }
        ?>
    </article>



    <footer>
        <?php require_once("footer.html") ?>
    </footer>

</body>

</html>