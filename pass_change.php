<?php
require("./dbconnect.php");
session_start();
// var_dump($_SESSION);
// var_dump($_POST);
if (!empty($_POST)) {
    if ($_POST['new_pass'] != $_POST['pass_check']) {
        $error['pass_check'] = "error";
    }

    $sql = "SELECT F_UserPass FROM T_Users WHERE F_UserMailaddress = :id";
    $stmt = $db->prepare($sql);
    $id = $_SESSION['id'];
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($record);
    $pass = $_POST['old_pass'];
    $hash = password_hash($_POST['new_pass'], PASSWORD_BCRYPT);
    if (!password_verify($pass, $record['F_UserPass'])) {
        $error['old_check'] = "error";
    }
    if($_POST['new_pass'] == $pass){
        $error['pass_simi'] = "error";  
    }
    //var_dump($error);
    if(!isset($error)){
        $sql = 'UPDATE T_Users SET F_UserPass = :pass WHERE F_UserMailaddress = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':pass', $hash);
        $stmt->execute();
        unset($_SESSION['id']);
        header('Location: index.php');
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

    <title>パスワード変更ページ</title>

</head>
<body>
    <header>
    <?php require_once("header.php") ?>
    </header>

    <article class="pass_change">
        <div class="title">
            <h2>パスワード変更</h2>
        </div>

        <div class="change_errormes">
            <?php
                if (isset($error['old_check'])){
                        echo "<p class='error'><span class='red'>※</span>正しい現在のパスワードを入力してください</p>";
                    }
                if (isset($error['pass_simi'])){
                        echo "<p class='error'><span class='red'>※</span>更新されたパスワードを入力してください</p>";
                    }
                if (isset($error['pass_check'])){
                        echo "<p class='error'><span class='red'>※</span>新規パスワードと同じパスワードを入力してください</p>";
                    }
            ?>
        </div>

        <form action="" method="post">
            <table class="formtable">

                <tr>
                    <th><p>現在のパスワード</p></th>
                    <td>
                    <input type="text" id="old_pass" name ="old_pass" pattern="(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,}">

                    </td>
                </tr>
                <tr>
                    <th><p>新規パスワード</p></th>
                    <td>
                    <input type="text" id="new_pass" name ="new_pass" pattern="(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,}">

                    </td>
                </tr>
                <tr>
                    <th><p>新規パスワード(確認用)</p></th>
                    <td>
                    <input type="text" id="pass_check" name ="pass_check" pattern="(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,}">

                    </td>
                </tr>
                
            </table>

            <div class="submitbtn">
                <input type="submit" value="変更する">
            </div>

         </form>



    </article>

    <footer>
        <?php require_once("footer.html") ?>
    </footer>

</body>
</html>