<?php
require("./dbconnect.php");
session_start();

if (!isset($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

if (isset($_SESSION['id'])) {
    $sql = "SELECT * FROM T_Users WHERE F_UserMailaddress = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $_SESSION['id']);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header('Location: login.php');
    exit;
}
// var_dump($_SESSION['id']);
// var_dump($_SESSION['cart']);
// var_dump($_SESSION['mise']);
if (isset($_POST['buy'])) {
    if ($_POST['time'] == "") {
        $error['time'] = "empty";
    }
    if (!isset($error)) {

        $sql = "SELECT * FROM T_Reserve";
        $sth = $db->query($sql);
        $count = $sth->rowCount();
        $id = 'R' . 101 + $count;

        $key3 = array_keys($_SESSION['cart']);
        $sql = "SELECT F_Shop_ID FROM T_Product WHERE F_Product_ID = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $key3[0]);
        $stmt->execute();
        $sid = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $db->prepare("INSERT INTO  T_Reserve (F_Reserve_ID, F_Shop_ID, F_User_ID, F_ReserveDateTime, F_MeetDateTime, F_Totalprice) VALUES(:R_ID, :S_ID, :U_ID, :ReserveDatetime, :MeetDateTime, :Total)");
        $stmt->bindValue(':R_ID', $id);
        $stmt->bindValue(':S_ID', $sid['F_Shop_ID']);
        $stmt->bindValue(':U_ID', $record['F_User_ID']);
        $datetime = date('Y-m-d H:i');
        $stmt->bindValue(':ReserveDatetime', $datetime);
        $stmt->bindValue(':MeetDateTime', $datetime);
        $stmt->bindValue(':Total', $_SESSION['sum2']);
        $stmt->execute();
        unset($_SESSION['sum2']);




        foreach ($_SESSION['cart'] as $key2 => $c2) {
            $stmt = $db->prepare("INSERT INTO  T_ReserveProduct (F_Product_ID, F_ProductCount, F_Reserve_ID) VALUES(:P_ID, :P_count, :R_ID)");
            $stmt->bindValue(':P_ID', $key2);
            $stmt->bindValue(':P_count', $c2);
            $stmt->bindValue(':R_ID', $id);
            $stmt->execute();
        }

        unset($_SESSION['cart']);
        header('Location: mypage.php');
    }
}
$sum2 = 0;
$key3 = array_keys($_SESSION['cart']);
// var_dump($key3[0]);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">

    <title>予約内容確認ページ</title>
</head>

<body>
    <header>
        <?php require_once("header.php") ?>
    </header>

    <section class="title">
        <h2>予約内容</h2>
    </section>

    <article class="confir_art">
        <div class="confir_name_box">
            <div class="confir_user_name">
                <p><?php if (!isset($_SESSION['id'])) {
                        echo "ゲスト";
                    } else {
                        echo $record['F_LastName'] . $record['F_FirstName'];
                    }
                    ?> 様</p>
            </div>
        </div>

        <table class="confir_table">


            <tr class="confir_shopdetail">
                <td id="left">
                    <p>店舗名</p>
                </td>
                <td id="right">

                    <?php
                    $sql = "SELECT F_Shop_ID FROM T_Product WHERE F_Product_ID = :id";
                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(':id', $key3[0]);
                    $stmt->execute();
                    $sid = $stmt->fetch(PDO::FETCH_ASSOC);

                    $sql = "SELECT * FROM T_Shop AS a INNER JOIN T_Product AS b ON a.F_Shop_ID = b.F_Shop_ID WHERE a.F_Shop_ID = :id";
                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(':id', $sid['F_Shop_ID']);
                    $stmt->execute();
                    $record = $stmt->fetch(PDO::FETCH_ASSOC);

                    echo $record['F_ShopName'];
                    ?>

                </td>
            </tr>



            <?php foreach ($_SESSION['cart'] as $key => $c) : ?>
                <tr class="confir_productdetail">
                    <td id="left">
                        <p>・商品名</p>
                    </td>
                    <td id="right">
                        <?php
                        $stmt = $db->prepare($sql = "SELECT * FROM T_Product WHERE F_Product_ID = :id");
                        $stmt->bindValue(':id', $key);
                        $stmt->execute();
                        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                        // var_dump($rec);
                        ?>

                        <p>
                            <?php echo $rec["F_ProductName"]; ?>　　<?php echo $rec['F_Price']; ?>円×<?php echo $c; ?>個
                        </p>
                    </td>

                    <?php
                    $sum = $rec['F_Price'] * $c;
                    $sum2 += $sum;
                    ?>

                </tr>
            <?php endforeach; ?>



            <tr class="confir_coupon">
                <td id="left">
                    <p>クーポン</p>
                </td>
                <td id="right">
                    <?php if (isset($_POST['coupon']) && $_POST['coupon'] != null) {
                        $sql = "SELECT f_coupon_value FROM t_coupon WHERE f_coupon_code = :code";
                        $stmt = $db->prepare($sql);
                        $stmt->bindValue(':code', $_POST['coupon']);
                        $stmt->execute();
                        $coupon = $stmt->fetch(PDO::FETCH_ASSOC);
                        if (isset($coupon['f_coupon_value'])) {
                            $sum2 *= (100 - $coupon['f_coupon_value']) / 100;
                        } else {
                            $alert = "<script type='text/javascript'>alert('クーポンコードが間違っています。');</script>";
                            echo $alert;
                        }
                    } ?>

                    <form action="confirmation.php" method="post">
                        <input type="text" name="coupon" value="" placeholder="クーポンコードを入力してください">
                        <button type="submit">適用</button>
                    </form>

                </td>
            </tr>



            <tr class="confir_total">
                <td id="left">
                    <p>合計金額</p>
                </td>
                <td id="right">
                    <p><?php echo $sum2;
                        $_SESSION['sum2'] = $sum2;
                        ?>円</p>

                </td>
            </tr>



            <tr class="confir_meettime">

                <td id="left">
                    <p>お受け取り時間</p>
                </td>

                <td id="right">

                    <?php if (!empty($error['time'])) : ?>
                        <p class="error"><span class='red'>＊</span>時間を選択してください。</p>
                    <?php endif ?>

                    <form action="" method="post">

                        <select class="time" name="time">
                            <option value=""></option>
                            <option value="9:00">9:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="12:00">12:00</option>
                            <option value="13:00">13:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                            <option value="17:00">17:00</option>
                            <option value="18:00">18:00</option>
                            <option value="19:00">19:00</option>
                            <option value="20:00">20:00</option>
                        </select>



                </td>
            </tr>

        </table>




    </article>

    <section class="confir_map">
        <p>Googleマップ</p>
        <iframe src="https://maps.google.co.jp/maps?q=<?php echo $record['F_ShopAddress']; ?>&output=embed&t=m&z=16&hl=ja" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
    </section>
    <!-- エラー -->

    <!-- ** -->

    <section class="confir_top">
        <div class="confir_submit">
            <input type="submit" value="予約する" name="buy">
        </div>
    </section>
    </form>


    <footer>
        <?php require_once("footer.html") ?>
    </footer>

</body>

</html>