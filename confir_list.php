<?php
require("./dbconnect.php");
session_start();
if (isset($_SESSION['id'])) {
    $sql = "SELECT * FROM T_Users WHERE F_UserMailaddress = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $_SESSION['id']);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT F_Reserve_ID FROM T_reserve WHERE F_User_ID = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $record['F_User_ID']);
    $stmt->execute();
    $list = $stmt->fetchALL(PDO::FETCH_ASSOC);
    if($list == null){
        $error['reserve'] = 'null';
    }
    //var_dump($list);
    // foreach($list as $key => $li){
    //     echo $li['F_Reserve_ID'];
    // }
    
}else{
    header('Location: login.php');
    exit();
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">

    <title>予約履歴一覧ページ</title>
</head>
<body>
    <header>
        <?php require_once("header.php") ?>
    </header> 

    <section class="title">
        <h2>予約履歴</h2>
        <!-- スライドショー -->
    </section>
    
    <article class="confir_list" id="">
        <?php
            if(isset($error['reserve'])){
                echo '<div class="cart_none"><p>履歴がありません。</p></div>';
            }
        ?>

    
        <?php foreach($list as $key =>$li):?>
            <?php
                $sql = "SELECT * FROM T_Reserve WHERE F_Reserve_ID = :id";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':id', $li['F_Reserve_ID']);
                $stmt->execute();
                $rsv = $stmt->fetch(PDO::FETCH_ASSOC);
                $date = ($rsv['F_ReserveDateTime']);
            ?>
            <?php
                $sql = "SELECT * FROM T_Shop WHERE F_Shop_ID = :id";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':id', $rsv['F_Shop_ID']);
                $stmt->execute();
                $s = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <?php
                $sql = "SELECT F_ShopImageName FROM T_Shopimages WHERE F_Shopimage_ID = :id";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':id', $s['F_Shopimage_ID']);
                $stmt->execute();
                $img = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>

    
        <section class='confir_list_shop'>

            <div class="confir_list_info">
                <div class='confir_list_img'>
                    <img src='./image/<?php echo $img['F_ShopImageName']?>' alt=''>
                </div>
            </div>

            <div class='confir_list_info'>
                <div class="confir_list_detail">
                    <div class='confir_list_data'>
                        <p class="confir_list_shopname"><?php echo $s['F_ShopName']; ?></p>
                        <p class="confir_list_date"><?php echo date('Y-n-j　H:i', strtotime($date)); ?></p>
                        <!-- <h3>場所: <?php //echo $s['F_ShopAddress']; ?></h3> -->
                    </div>
                    <div class='confir_list_morebt'>
                        <a href='reservation.php'>
                            <form action='reservation.php' method='post'>
                                <input type ="hidden" name ="R_id" value="<?php echo $rsv['F_Reserve_ID']; ?>">
                                <input type ="submit" value="もっと見る" class="confir_list_btn">
                            </form>
                        </a>
                    </div>
                </div>    
            </div>


        </section>

    
        <?php endforeach ?>

    </article>
    <footer>
        <?php require_once("footer.html") ?>
    </footer>

</body>
</html>