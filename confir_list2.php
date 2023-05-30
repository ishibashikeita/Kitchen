<?php
require("./dbconnect.php");
session_start();
if (isset($_SESSION['id'])) {
    $sql = "SELECT * FROM T_Users WHERE F_UserMailaddress = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $_SESSION['id']);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT F_Shop_ID FROM T_Shop WHERE F_User_ID = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $record['F_User_ID']);
    $stmt->execute();
    $shop = $stmt->fetch(PDO::FETCH_ASSOC);
    //var_dump($shop);

    $sql = "SELECT * FROM T_reserve WHERE F_Check IS NULL AND F_Shop_ID = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $shop['F_Shop_ID']);
    $stmt->execute();
    $shop2 = $stmt->fetchALL(PDO::FETCH_ASSOC);

    //var_dump($shop2);
    // foreach($list as $key => $li){
    //     echo $li['F_Reserve_ID'];
    // }
    if($shop2 == null){
        $error['reserve'] = 'null';
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

    <title>予約履歴一覧ページ</title>
</head>
<body>
    <header>
        <?php require_once("header.php") ?>
    </header> 

    <section class="title">
        <h2>予約一覧</h2>
        <!-- スライドショー -->
    </section>

    <?php
        if(isset($error['reserve'])){
            echo '<div class="cart_none"><p>承り中のご予約はありません。</p></div>';
        }
    ?>
    
<?php foreach($shop2 as $key =>$li):?>
    <?php
        $sql = "SELECT * FROM T_Users WHERE F_User_ID = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $li['F_User_ID']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $date = ($li['F_ReserveDateTime']);
        
    ?>
       <?php
        $sql = "SELECT * FROM T_Shop WHERE F_Shop_ID = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $li['F_Shop_ID']);
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

    <article class="confir_list" id="">
    <section class='confir_list_shop'>

    <div class='confir_list_img'>
        <img src='./image/<?php echo $img['F_ShopImageName']?>' alt=''>
    </div>

    <div class='confir_list_reserve'>

        <div class='confir_list2_data'>
            <!-- <h2><?//php echo date('Y年n月j日', strtotime($date)); ?></h2> -->
            <p>お名前: <?php echo $user['F_LastName'],$user['F_FirstName']; ?>様</p>
            <p>予約日時: <?php echo $li['F_MeetDateTime']?></p>
        </div>
        
        <div class='confir_list_morebt'>
            <a href='reservation.php'>
                <form action='reservation2.php' method='post'>
                    <input type ="hidden" name ="R_id" value="<?php echo $li['F_Reserve_ID']; ?>">
                    <input type ="submit" value="詳細" class="confir_list_btn">
        
                </form>
            </a>
        </div>

    </div>


    </section>

    </article>
<?php endforeach ?>


    <footer>
        <?php require_once("footer.html") ?>
    </footer>

</body>
</html>