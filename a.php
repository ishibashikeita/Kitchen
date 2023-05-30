<?php
require("./dbconnect.php");
session_start();
/* 会員登録の手続き以外のアクセスを飛ばす */
if (!isset($_SESSION['join'])) {
    header('Location: accountinfo_change.php');
    exit();
}

// if(!empty($_SESSION['join']['name_last'])){
//     echo "ok";
// }else{
//    echo "no";
// }
$address = $_SESSION['join']['address'].$_SESSION['join']['add_num'];
    $sql = "SELECT * FROM T_Users WHERE F_UserMailaddress = :id";
    $stmt = $db->prepare($sql);
    $id = $_SESSION['id'];
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($_POST['check'])) {
    // 元データを呼び出す
    //var_dump($record);
    // 入力情報をデータベースに登録
    $stmt = $db->prepare("UPDATE  t_users  SET F_LastName = :name_last, F_FirstName = :name_first, F_UserPostcode = :postcode, F_UserAddress = :addrss, F_UserPhonenumber = :phone, F_BirthdayDate = :dat, F_UserMailaddress = :email WHERE F_UserMailaddress = :id");
    $stmt->bindValue(':id', $id);
    if(!empty($_SESSION['join']['name_last'])){
        $stmt->bindValue(':name_last', $_SESSION['join']['name_last']);
    }
    else{
        $stmt->bindValue(':name_last', $record['F_LastName']);
    }
    if(!empty($_SESSION['join']['name_first'])){
        $stmt->bindValue(':name_first', $_SESSION['join']['name_first']);
    }else{
        $stmt->bindValue(':name_first', $record['F_FirstName']);
    }
    if(!empty($_SESSION['join']['postcode'])){
        $stmt->bindValue(':postcode', $_SESSION['join']['postcode']);
    }else{
        $stmt->bindValue(':postcode', $record['F_UserPostcode']);
    }
    if(!empty($_SESSION['join']['address'])){
        $stmt->bindValue(':addrss', $address);
    }else{
        $stmt->bindValue(':addrss', $record['F_UserAddress']);
    }
    if(!empty($_SESSION['join']['phone'])){
        $stmt->bindValue(':phone', $_SESSION['join']['phone']);
    }else{
        $stmt->bindValue(':phone', $record['F_UserPhonenumber']);
    }
    if(!empty($_SESSION['join']['birthday'])){
        $stmt->bindValue(':dat', $_SESSION['join']['birthday']);
    }else{
        $stmt->bindValue(':dat', $record['F_BirthdayDate']);
    }
    if(!empty($_SESSION['join']['email'])){
        $stmt->bindValue(':email', $_SESSION['join']['email']);
    }else{
        $stmt->bindValue(':email', $record['F_UserMailaddress']);
    }
    // // $stmt->bindValue(':name_last', $_SESSION['join']['name_last']);
    // // $stmt->bindValue(':name_first', $_SESSION['join']['name_first']);
    // // $stmt->bindValue(':postcode', $_SESSION['join']['postcode']);
    // // $stmt->bindValue(':address', $address);
    // // $stmt->bindValue(':phone', $_SESSION['join']['phone']);
    // // $stmt->bindValue(':date',$_SESSION['join']['birthday']);
    // // $stmt->bindValue(':email',$_SESSION['join']['email']);

    // // 実行
    $stmt->execute();

    


    unset($_SESSION['join']);   // セッションを破棄
    header('Location: mypage.php');   // thank.phpへ移動
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
                <h2>変更内容の確認</h2>
            </div>
            
            <p>ご入力情報に変更が必要な場合、下のボタンを押し、変更を行ってください。</p>
            <p>登録情報はあとから変更することもできます。</p>
            <?php if (!empty($error) && $error === "error"): ?>
                <p class="error">＊会員登録に失敗しました。</p>
            <?php endif ?>

            <div class="check_confirm">
            <?php
                if(!empty($_SESSION['join']['name_last'])){
                echo '<div class="check_control">
                    <p>【現在のお名前】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info">'. htmlspecialchars($record['F_LastName']).htmlspecialchars($record['F_FirstName'], ENT_QUOTES).'</span></p>
                    </div>';
                echo '<div class="check_control">
                    <p>【変更後のお名前】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info">'. htmlspecialchars($_SESSION["join"]["name_last"]).htmlspecialchars($_SESSION["join"]["name_first"], ENT_QUOTES).'</span></p>
                    </div>';
                }
                ?> 
                <?php
                if(!empty($_SESSION['join']['postcode'])){
                    echo '<div class="check_control">
                    <p>【現在の郵便番号】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info">'. htmlspecialchars($record['F_UserPostcode'],ENT_QUOTES).'</span></p>
                    </div>';
                    echo '<div class="check_control">
                    <p>【変更後の郵便番号】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info">'.htmlspecialchars($_SESSION['join']['postcode'], ENT_QUOTES).'</span></p>
                    </div>';
                 }
                ?>    
                
                <?php
                if(!empty($_SESSION['join']['postcode'])){
                    echo '<div class="check_control">
                    <p>【現在の住所】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info">'. htmlspecialchars($record['F_UserAddress'],ENT_QUOTES).'</span></p>
                    </div>';
                    echo '<div class="check_control">
                    <p>【変更後の住所】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info">'.htmlspecialchars($address, ENT_QUOTES).'</span></p>
                    </div>';
                 }
                ?>
                
                <?php
                if(!empty($_SESSION['join']['phone'])){
                    echo '<div class="check_control">
                    <p>【現在の電話番号】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info">'. htmlspecialchars($record['F_UserPhonenumber'],ENT_QUOTES).'</span></p>
                    </div>';
                    echo '<div class="check_control">
                    <p>【変更後の電話番号】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info">'.htmlspecialchars($_SESSION['join']['phone'], ENT_QUOTES).'</span></p>
                    </div>';
                 }
                ?>
                
                <?php
                if(!empty($_SESSION['join']['birthday'])){
                    echo '<div class="check_control">
                    <p>【現在の生年月日】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info">'. htmlspecialchars($record['F_BirthdayDate'],ENT_QUOTES).'</span></p>
                    </div>';
                    echo '<div class="check_control">
                    <p>【変更後の生年月日】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info">'.htmlspecialchars($_SESSION['join']['birthday'], ENT_QUOTES).'</span></p>
                    </div>';
                 }
                ?>
                
                <?php
                if(!empty($_SESSION['join']['email'])){
                    echo '<div class="check_control">
                    <p>【現在のメールアドレス】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info">'. htmlspecialchars($record['F_UserMailaddress'],ENT_QUOTES).'</span></p>
                    </div>';
                    echo '<div class="check_control">
                    <p>【変更後のメールアドレス】</p>
                    <p>　<span class="fas fa-angle-double-right"></span> <span class="check-info">'.htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES).'</span></p>
                    </div>';
                 }
                ?>
                
            </div>
            
            <div class="check_submit">
                <a href="accountinfo_change.php" class="check_changebtn"><p>変更する</p></a>
                <button type="submit" class="check_registerbtn"><p>登録する</p></button>
            </div>
        </form>
    </div>
    <footer>
        <?php require_once("footer.html") ?>
    </footer>
</body>
</html>