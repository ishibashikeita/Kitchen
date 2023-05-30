<?php
require("./dbconnect.php");

session_start();
if (isset($_SESSION['id'])) {
    $sql = "SELECT * FROM T_Users WHERE F_UserMailaddress = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $_SESSION['id']);
    $stmt->execute();
    $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $both = $record[0]['F_User_ID'];
    if (strpos($both, 'S') !== false) {
        $shop['s'] = "shop";
    }
}
if (isset($_POST['logout'])) {
    unset($_SESSION['id']);
    unset($_SESSION['cart']);
    if (isset($shop['s'])) {
        unset($shop['s']);
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/jquery-3.6.0.min.js" defer></script>
    <script src="./js/q&a.js" defer></script>
    <title>kitchen</title>
</head>

<body>
    <header>
        <?php require_once("header.php");
        ?>
    </header>

    <div class="title">
        <h2>マイページ</h2>
    </div>

    <div class="mypage_contents">

        <!-- <div class="mypage_contents_btn"> -->
        <?php if (isset($_SESSION['id'])) {
            echo '<a href="accountinfo_change.php">
                <div class="mypage_contents_btn fadeIn">
                <div class="mypage_content_text"><p>会員情報変更</p></div>
                <div class="mypage_icon"><img src="./image/arrow.png" alt=""></div>
                </div>
                </a>';
        } else {
            echo '<a href="entory.php">
            <div class="mypage_contents_btn fadeIn">
            <div class="mypage_content_text"><p>新規会員登録</p></div>
            <div class="mypage_icon"><img src="./image/arrow.png" alt=""></div>
            </div>
            </a>';
        }
        ?>


        <?php
        if (isset($shop['s'])) {
            echo "<a href='product.php'><div class='mypage_contents_btn fadeIn'>
            <div class='mypage_content_text'><p>商品管理</p></div>
            <div class='mypage_icon'><img src='./image/arrow.png' alt=''></div>
            </div></a>";
        }
        ?>


        <!-- <div class="mypage_contents_btn">
        <a href="pass_change.php">
            <div class="mypage_content_text"><p>パスワード変更</p></div>
            <div class="mypage_icon"><img src="./image/arrow.png" alt=""></div>
        </a>
        </div> -->
        <?php
        if (isset($_SESSION['id'])) {
            echo '<a href="pass_change.php">
                <div class="mypage_contents_btn fadeIn">
                <div class="mypage_content_text"><p>パスワード変更</p></div>
                <div class="mypage_icon"><img src="./image/arrow.png" alt=""></div>
                </div>
                </a>';
        }
        ?>

        <!-- <div class="mypage_url"> -->
        <?php
        if (isset($shop['s'])) {
            $member = $db->prepare('SELECT COUNT(*) as cnt FROM T_Shop WHERE F_User_ID=?');
            $member->execute(array(
                $record[0]['F_User_ID']
            ));
            $count = $member->fetch();
            if ($count['cnt'] > 0) {
                $exist = '1';
                if (isset($exist)) {
                    echo "<a href='confir_list2.php'><div class='mypage_contents_btn fadeIn'>
                    <div class='mypage_content_text'><p>予約管理</p></div>
                    <div class='mypage_icon'><img src='./image/arrow.png' alt=''></div>
                    </div></a>";
                }
            }
        } else {
            echo '<a href="confir_list.php" class="mypage_url">
            <div class="mypage_contents_btn fadeIn">
                <div class="mypage_content_text"><p>予約履歴</p></div>
                <div class="mypage_icon"><img src="./image/arrow.png" alt=""></div>
            </div>
        </a>';
        }
        ?>

        <!-- </div> -->


        <a href="board.php">
            <div class="mypage_contents_btn fadeIn">
                <div class="mypage_content_text">
                    <p>クーポン情報</p>
                </div>
                <div class="mypage_icon"><img src="./image/arrow.png" alt=""></div>
            </div>
        </a>
    </div>
    <?php
    if (isset($_SESSION['id'])) {
        echo "<div class='mypage_session'>
        <form action=''method='post'>
        <button type='submit'name='logout'>ログアウト</button>
    </div>";
    }
    ?>
    <footer>
        <?php require_once("footer.html") ?>
    </footer>
</body>

</html>