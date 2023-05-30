<?php
require("./dbconnect.php");
session_start();
if (isset($_POST['R_id'])) {
    $_SESSION['R_id'] = $_POST['R_id'];
}
$sql = "SELECT * FROM T_reserveproduct WHERE F_Reserve_ID = :id";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $_SESSION['R_id']);
$stmt->execute();
$list = $stmt->fetchALL(PDO::FETCH_ASSOC);
//var_dump($list);


$sql = "SELECT * FROM T_reserve WHERE F_Reserve_ID = :id";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $_SESSION['R_id']);
$stmt->execute();
$s = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM T_Shop WHERE F_Shop_ID = :id";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $s['F_Shop_ID']);
$stmt->execute();
$c = $stmt->fetch(PDO::FETCH_ASSOC);
// echo $c['F_ShopName'];

$sum = 0;

if (isset($_POST['fin'])) {
    $sql = "UPDATE t_reserve SET F_Check = 1 WHERE F_Reserve_ID = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $_SESSION['R_id']);
    $stmt->execute();
    unset($_SESSION['R_id']);
    header('Location: mypage.php');
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

    <title>予約確認</title>
</head>

<body>
    <header>
        <?php require_once("header.php") ?>
    </header>

    <section>
        <div class="title">
            <h2>依頼詳細</h2>
        </div>
    </section>

    <article>

        <div class="reserve_shopname">
            <p>店舗名　　<?php echo $c['F_ShopName'] ?></p>
        </div>

        <table class="reserve_table">




            <?php foreach ($list as $key => $c) : ?>
                <?php
                $sql = "SELECT * FROM T_Product WHERE F_Product_ID = :id";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':id', $c['F_Product_ID']);
                $stmt->execute();
                $list2 = $stmt->fetch(PDO::FETCH_ASSOC);
                //var_dump($list2);
                ?>
                <tr class="reserve_product">
                    <td id="re_left">
                        <p>商品名</p>
                    </td>
                    <td id="re_right">
                        <p><?php echo $list2['F_ProductName'] ?>　　<?php echo $c['F_ProductCount']; ?>個</p>
                    </td>
                </tr>
                <?php
                $sum += $list2['F_Price'] * $c['F_ProductCount'];
                ?>
            <?php endforeach ?>



            <tr class="reserve_total">
                <td id="re_left">
                    <p>合計金額</p>
                </td>
                <td id="re_right">
                    <p><?php echo $s['F_Totalprice']; ?>円</p>
                </td>
            </tr>


        </table>


    </article>
    <section class="reserve_btn">
        <form action="" method="post">
            <input type="hidden" name="fin" value="1">
            <input type="submit" value="受け渡し完了">
        </form>
        <!-- <a href="mypage.php"><button class="confir_top_btn">マイページへ戻る</button></a> -->
    </section>

    <footer>
        <?php require_once("footer.html") ?>
    </footer>

</body>

</html>