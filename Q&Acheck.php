<?php
require("./dbconnect.php");
session_start();

/* 会員登録の手続き以外のアクセスを飛ばす */
if (!isset($_SESSION['join'])) {
    header('Location: Q&A.php');
    exit();
}
$category = $_SESSION['join']['C_cate'];
$sql = "SELECT * FROM T_MailCategory WHERE F_Contactcat_ID = :id" ;
$stmt = $db -> prepare($sql);
$stmt -> bindValue(':id',$category);
$stmt->execute();
$record = $stmt->fetchAll(PDO::FETCH_ASSOC);
$cateName = $record[0]['F_ContactCatName'];

if (!empty($_POST['check'])) {
    $sql = "SELECT * FROM T_Contact";
    $sth = $db->query($sql);
    $count = $sth->rowCount();
    $id = 'C' . 101 + $count;

    if (!isset($_SESSION['id'])) {
        $u_id = "ゲスト";
    } else {
        $mail = $_COOKIE['id'];
        $sql = "SELECT * FROM T_Users WHERE F_UserMailaddress = :mail";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':mail',$mail);
        $stmt->execute();
        $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $u_id = $record[0]['F_User_ID'];
    }

    $c_date = date('Y-m-d H:i:s');
    $stmt = $db->prepare("INSERT INTO  T_Contact (F_Contact_ID, F_ContactName, F_User_ID, F_Mailaddress, F_ContactCat_ID, F_ContactContent, F_ContactDateTime) VALUES(:C_id, :C_name, :U_id, :C_email, :C_cate,:C_content, :C_date)");
    $stmt->bindValue(':C_id', $id);
    $stmt->bindValue(':C_name', $_SESSION['join']['cont_name']);
    $stmt->bindValue(':U_id', $u_id);
    $stmt->bindValue(':C_email', $_SESSION['join']['mail']);
    $stmt->bindValue(':C_cate', $_SESSION['join']['C_cate']);
    $stmt->bindValue(':C_content', $_SESSION['join']['content']);
    $stmt->bindValue(':C_date', $c_date);
    $stmt->execute();


    unset($_SESSION['join']);   // セッションを破棄
    header('Location: Q&Athank.php');   // thank.phpへ移動
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
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet"/>
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
                    <p>E-mail</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['mail'], ENT_QUOTES); ?></span></p>
                </div>

                <div class="check_control">
                    <p>件名</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['cont_name'], ENT_QUOTES); ?></span></p>
                </div>

                <div class="check_control">
                    <p>お問い合わせカテゴリ</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($cateName, ENT_QUOTES); ?></span></p>
                </div>

                <div class="check_control">
                    <p>内容</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['content'], ENT_QUOTES); ?></span></p>
                </div>

            </div>
           

            <div class="check_submit">
                <a href="Q&A.php" class="check_changebtn"><p>変更する</p></a>
                <button type="submit" class="check_registerbtn"><p>登録する</p></button>
            </div>

        </form>
    </div>
    <footer>
        <?php require_once("footer.html") ?>
    </footer>
</body>
</html>