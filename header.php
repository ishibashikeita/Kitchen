<?php
require("./dbconnect.php");
if (!empty($_SESSION['id'])) {
    
    $sql = "SELECT * FROM T_Users WHERE F_UserMailaddress = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $_SESSION['id']);
    $stmt->execute();
    $log = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $location = "";
    $sql = 'SELECT COUNT(*) as cnt FROM T_Shop WHERE F_User_ID = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $log[0]['F_User_ID']);
    $stmt->execute();
    $loc = $stmt->fetch(PDO::FETCH_ASSOC);
    if($loc['cnt'] > 0){
        $location = "exist.php";
    }else{
        $location = "misetouroku.php";
    }
}
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    if (is_array($cart) && !empty($cart)) {
        $_POST['cart_Icon'] = "in";
    }
}
// var_dump($log);

//var_dump($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">

    <title>header</title>
</head>
<body>
    <header>
        <div class="header_logo">
            <a href="index.php"><img src="./image/logo.png" alt="ヘッダーロゴ"></a>
        </div>
        <div class="navigation">
            <ul>
                
                <?php
                if(!empty($_SESSION['id'])){
                   echo "<li><a>".$log[0]['F_FirstName']."様</a></li>";
                }else {
                    echo "<li><a href='entory.php'>会員登録</a></li>
                    <li><a href='login.php'>ログイン</a></li>";
                }
                ?>
                <?php
                if (!empty($_SESSION['id'])) {
                    if (strpos($log[0]['F_User_ID'], 'S') !== false) {
                        echo "<li><a href='$location'>店舗登録</a></li>";
                    }
                }
                ?>
                
                <li><a href="mypage.php">マイページ</a></li>
                <li><a href="Q&A.php">問い合わせ</a></li>
                <li><a href="introduction.php"><img src="./image/navi_icon.png" alt="検索"></a></li>
                <?php 
                if(isset($_SESSION['id'])){
                    if (strpos($log[0]['F_User_ID'], 'S') !== false) {
                        // echo "<li><a href='$location'>店舗登録</a></li>";
                    }else{
                        if(!empty($_POST['cart_Icon'])){
                            echo '<li><a href="cart.php"><img src="./image/cart_icon2.png" alt="カートを見る"></a></li>';
                            }else{
                                echo '<li><a href="cart.php"><img src="./image/cart_icon.png" alt="カートを見る"></a></li>';
                            }
                    }
                }else{
                    if(!empty($_POST['cart_Icon'])){
                    echo '<li><a href="cart.php"><img src="./image/cart_icon2.png" alt="カートを見る"></a></li>';
                    }else{
                        echo '<li><a href="cart.php"><img src="./image/cart_icon.png" alt="カートを見る"></a></li>';
                    }
                }
                
                ?>
            </ul>
            
        </div>
    </header>
    
</body>
</html>