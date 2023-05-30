<?php
require("./dbconnect.php");
session_start();

/* 会員登録の手続き以外のアクセスを飛ばす */
if (!isset($_SESSION['join'])) {
    header('Location: entory.php');
    exit();
}
$address = $_SESSION['join']['address'].$_SESSION['join']['add_num'];
$cate = $_SESSION['join']['U_cate'];
$sql = "SELECT * FROM t_users WHERE F_user_ID LIKE '%$cate%'";
    $sth = $db -> query($sql);
    
    $count = $sth -> rowCount();
    $id = $_SESSION['join']['U_cate'].(101+$count);

if (!empty($_POST['check'])) {
    // パスワードを暗号化
    $hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT);
    
    // 入力情報をデータベースに登録
    $stmt = $db->prepare("INSERT INTO t_users (F_User_ID, F_LastName, F_FirstName, F_UserPostcode, F_UserAddress, F_UserPhonenumber, F_BirthdayDate, F_UserMailaddress, F_UserPass) VALUES(:id, :name_last, :name_first, :postcode, :address, :phone, :date, :email, :password)");
    $stmt->bindValue(':id',$id);
    $stmt->bindValue(':name_last', $_SESSION['join']['name_last']);
    $stmt->bindValue(':name_first', $_SESSION['join']['name_first']);
    $stmt->bindValue(':postcode', $_SESSION['join']['postcode']);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':phone', $_SESSION['join']['phone']);
    $stmt->bindValue(':date',$_SESSION['join']['birthday']);
    $stmt->bindValue(':email',$_SESSION['join']['email']);
    $stmt->bindValue(':password',$hash);

    // 実行
    $stmt->execute();

    


    unset($_SESSION['join']);   // セッションを破棄
    header('Location: thank.php');   // thank.phpへ移動
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
            
                <div class="check_control">
                    <p>【郵便番号】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['postcode'], ENT_QUOTES); ?></span></p>
                </div>

                <div class="check_control">
                    <p>【住所】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($address, ENT_QUOTES); ?></span></p>
                </div>

                <div class="check_control">
                    <p>【電話番号】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['phone'], ENT_QUOTES); ?></span></p>
                </div>

                <div class="check_control">
                    <p>【生年月日】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['birthday'], ENT_QUOTES); ?></span></p>
                </div>

                <div class="check_control">
                    <p>【メールアドレス】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES); ?></span></p>
                </div>

            </div>
            
            <div class="check_submit">
                <a href="entory.php" class="check_changebtn"><p>変更する</p></a>
                <button type="submit" class="check_registerbtn"><p>登録する</p></button>
            </div>
        </form>
    </div>
    <footer>
        <?php require_once("footer.html") ?>
    </footer>
</body>
</html>