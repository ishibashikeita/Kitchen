<?php
require("./dbconnect.php");
session_start();

/* 会員登録の手続き以外のアクセスを飛ばす */
if (!isset($_SESSION['join'])) {
    header('Location: addcheck.php');
    exit();
}
$address = $_SESSION['join']['S_address'];
if (!empty($_POST['check'])) {
    $sql = "SELECT F_User_ID FROM T_Users WHERE F_UserMailaddress = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $_SESSION['id']);
    $stmt->execute();
    $log = $stmt->fetch(PDO::FETCH_ASSOC);
    // パスワードを暗号化
     $sql = "SELECT * FROM T_Shop";
    $sth = $db -> query($sql);
    
    $count = $sth -> rowCount();
    $id = 'S'. 201 + $count;


    $sql = "SELECT * FROM T_ShopImages";
    $sth = $db -> query($sql);
    $Icount = $sth -> rowCount();
    $img  = 'I'. 301 + $Icount;
    $iname = sprintf('%03d', $Icount + 1);
    
    // 入力情報をデータベースに登録
    $stmt = $db->prepare("INSERT INTO T_shop (F_Shop_ID, F_ShopName, F_Category_ID, F_User_ID, F_ShopMailaddress, F_ShopPhonenumber, F_ShopPostcode, F_ShopAddress,F_ShopComment, F_ShopImage_ID) VALUES(:S_id, :S_name, :S_cate, :U_id, :S_email, :S_phone, :S_postcode, :S_address, :S_comment, :I_id)");
    $stmt->bindValue(':S_id',$id);
    $stmt->bindValue(':S_name', $_SESSION['join']['S_name']);
    $stmt->bindValue(':S_cate', $_SESSION['join']['S_cate']);
    $stmt->bindValue(':U_id', $log['F_User_ID']);
    $stmt->bindValue(':S_email', $_SESSION['join']['S_email']);
    $stmt->bindValue(':S_phone', $_SESSION['join']['S_phone']);
    $stmt->bindValue(':S_postcode', $_SESSION['join']['S_postcode']);
    $stmt->bindValue(':S_address', $address);
    $stmt->bindValue(':S_comment', $_SESSION['join']['S_comment']);
    $stmt->bindValue(':I_id', $img);
    
    // 実行
    $stmt->execute();

    $stmt = $db->prepare("INSERT INTO T_ShopImages (F_ShopImage_ID, F_ShopImageName) VALUES(:I_id, :I_name)");
    $stmt->bindValue(':I_id',$img);
    $stmt->bindValue(':I_name', "Shop".$iname.".png");
    $stmt->execute();


    unset($_SESSION['join']);   // セッションを破棄
    header('Location: addthank.php');   // thank.phpへ移動
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>確認画面</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <!-- <link href="https://unpkg.com/sanitize.css" rel="stylesheet"/> -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <?php require_once("header.php") ?>
    </header>

    <div class="check_content">
        <form action="" method="POST">
            <input type="hidden" name="check" value="checked">
            <div class="title">
                <h2>入力情報の確認</h2>
            </div>
            <p>ご入力情報に変更が必要な場合、下のボタンを押し、変更を行ってください。</p>
            <p>登録情報はあとから変更することもできます。</p>
            <?php if (!empty($error) && $error === "error"): ?>
                <p class="error"><span class='red'>＊</span>会員登録に失敗しました。</p>
            <?php endif ?>

            <div class="check_confirm">
            <div class="acheck_control">
                <p>【店名】</p>
                <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['S_name'], ENT_QUOTES); ?></span></p>
            </div>
            
            <div class="check_control">
                <p>【メールアドレス】</p>
                <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['S_email'], ENT_QUOTES); ?></span></p>
            </div>

            <div class="check_control">
                <p>【郵便番号】</p>
                <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['S_postcode'], ENT_QUOTES); ?></span></p>
            </div>

            <div class="check_control">
                <p>【住所】</p>
                <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($address, ENT_QUOTES); ?></span></p>
            </div>

            <div class="check_control">
                <p>【電話番号】</p>
                <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['S_phone'], ENT_QUOTES); ?></span></p>
            </div>
            <div class="check_control">
                <p>【コメント】</p>
                <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['S_comment'], ENT_QUOTES); ?></span></p>
            </div>

            </div>

            <div class="check_submit">
                <a href="misetouroku.php" class="check_changebtn"><p>変更する</p></a>
                <button type="submit" class="check_registerbtn"><p>登録する</p></button>
            </div>

            
            

        </form>
    </div>

    <footer>
        <?php require_once("footer.html") ?>
    </footer>

</body>
</html>