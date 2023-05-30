<?php
require("./dbconnect.php");
session_start();
$sql = "SELECT * FROM t_coupon";
$stmt = $db->prepare($sql);
$stmt->execute();
$record = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/main.js" defer></script>
    <title>kitchen</title>
</head>

<body>
    <header>
        <?php require_once("header.php") ?>
    </header>

    <div class="title">
        <h2>クーポン情報</h2>
    </div>

    <div class="board_list_wrapper">
        <?php
        for ($i = 0; $i < count($record); $i++) {
            $sql = "SELECT F_CouponImage FROM t_coupon AS a INNER JOIN t_couponimages AS b ON a.F_Coupon_ID = b.F_Coupon_ID WHERE a.F_Coupon_ID = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $record[$i]['F_Coupon_ID']);
            $stmt->execute();
            $img = $stmt->fetch(PDO::FETCH_ASSOC); ?>
            <?php foreach ($img as $key => $c) : ?>
                <div class='board_list'>
                    <div class="board_mainvisual">
                        <img src="image/<?php echo $c ?>" alt="">
                    </div>
                    <?php endforeach; ?>
                    <?php echo
                    "<div class='board_text'>
                            <h3>{$record[$i]['F_Coupon_Title']}</h3>
                            <p>{$record[$i]['F_Coupon_Article']}</p>
                            <p>クーポンコード：{$record[$i]['F_Coupon_Code']}</p>
                            <p>利用期限：{$record[$i]['F_Coupon_Date']}</p>
                        </div>
                </div>";
        } ?>
    </div>

        <footer>
            <?php require_once("footer.html") ?>
        </footer>
</body>

</html>