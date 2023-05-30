<?php
require("./dbconnect.php");
session_start();



?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">

    <title>出店済みです</title>
</head>
<body>
    <header>
        <?php require_once("header.php") ?>
    </header> 

    <section class="title">
        <h2>出店状況</h2>
    </section>

   
        <div class="cart_none">
            <p>お客様のアカウントは既に出店されています。</p>
        </div>
    
        <div class="product_btn">
            <a href="index.php" class="product_backbtn">ホームに戻る</a>
        </div>

    <footer>
        <?php require_once("footer.html") ?>
    </footer>

</body>
</html>