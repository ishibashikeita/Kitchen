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
    <script src="./js/jquery-3.6.0.min.js" defer></script>
    <script src="./js/main.js" defer></script>
    <title>kitchen</title>
</head>

<body>
    <header>
        <?php require_once("header.php"); ?>
    </header>

    <div class="index_slider" style="background-image: url(./image/slider1.jpg);">
        <div class="index_jumpbtn">
            <a href="introduction.php">
                <p>検索する</p>
            </a>
        </div>
    </div>


    <div class="index_buy_process">
        <div class="title">
            <h2>購入手順</h2>
        </div>
        <div class="index_process">
            <div class="index_process_img fadeIn">
                <img src="./image/process1.png" alt="">
            </div>
            <div class="index_process_img fadeIn">
                <img src="./image/process2.png" alt="">
            </div>
            <div class="index_process_img fadeIn">
                <img src="./image/process3.png" alt="">
            </div>
        </div>

    </div>

    <!-- <div class="index_picup">
        <div class="title">
            <h2>掲示板</h2>
        </div>
        <div class="index_picup_article">
            <div class="index_picup_contents">
                <div class="index_picup_img"></div>
                <div class="index_picup_title"><p>TEST</p></div>
            </div>
            <div class="index_picup_contents">
                <div class="index_picup_img"></div>
                <div class="index_picup_title"><p>TEST</p></div>
            </div>
            <div class="index_picup_contents">
                <div class="index_picup_img"></div>
                <div class="index_picup_title"><p>TEST</p></div>
            </div>
        </div>
        <div class="more_btn" id="index_pu">
            <a href="board.php"><p>もっと見る</p></a>
        </div>
    </div> -->


    <footer>
        <?php require_once("footer.html") ?>
    </footer>
</body>

</html>