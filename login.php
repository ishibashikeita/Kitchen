<?php 
require("./dbconnect.php");
session_start();
// if(!empty($_POST['login'])){
//     if($_POST['email'] == "" || $_POST['password'] == ""){
//         $error = "aaa";
//         // exit();
//     }
// }
// if(!isset($error)){


if(!empty($_POST)){
    function h($s) {//入力内容を無害化するセキュリティ対策
        return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
    
    }
    $id = h($_POST['email']);
    $pass = h($_POST['password']);

    // if($id == "" || $pass = ""){
    //     $error['empty'] = "＊メールアドレスまたはパスワードが違います。"; 
    // }
    

    $sql = "select * from t_users where F_UserMailaddress=:id";
    $stmt = $db->prepare($sql);
    $params = array(':id' => $id);
    $res=$stmt->execute($params);
    if($res){
        $user_data = $stmt->fetch();
    }
    
    if(!$user_data){
        $error =  "＊メールアドレスまたはパスワードが違います。";
    }else{
        if(password_verify($pass,$user_data["F_UserPass"])){
            //ログイン成功
            unset($_SESSION['cart']);
            $_SESSION['id'] = $id;
            setcookie('id', $id, time() + 60 * 60 * 24 * 1);
            header('Location: index.php');
        } else {
            $error = "＊メールアドレスまたはパスワードが違います。";
        }
    
    }    
    }



if(isset($_POST['user'])){
$id = "syouko@hal.ac.jp";
$pass = "Syouko0000";

$sql = "select * from t_users where F_UserMailaddress=:id";
$stmt = $db->prepare($sql);
$params = array(':id' => $id);
$res=$stmt->execute($params);
if($res){
	$user_data = $stmt->fetch();
}
if(password_verify($pass,$user_data["F_UserPass"])){
	//ログイン成功
    unset($_SESSION['cart']);
	$_SESSION['id'] = $id;
	setcookie('id', $id, time() + 60 * 60 * 24 * 1);
    header('Location: index.php');
} 

}
if(isset($_POST['shop'])){
    $id = "tsuru@hal.ac.jp";
    $pass = "Tsuru0000";
    
    $sql = "select * from t_users where F_UserMailaddress=:id";
    $stmt = $db->prepare($sql);
    $params = array(':id' => $id);
    $res=$stmt->execute($params);
    if($res){
        $user_data = $stmt->fetch();
    }
    if(password_verify($pass,$user_data["F_UserPass"])){
        //ログイン成功
        unset($_SESSION['cart']);
        $_SESSION['id'] = $id;
        setcookie('id', $id, time() + 60 * 60 * 24 * 1);
        header('Location: index.php');
    } 
    
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/main.js" defer></script>
    <title>ログインページ</title>
</head>
<body>
    <header>
        <?php require_once("header.php") ?>
    </header>

    <div class="title">
        <h2>ログイン</h2>
    </div>

    <form action="" method="POST">
        <div class="login">
            <div class="login_input">

                <div id="login_id">
                    <p>メールアドレス</p>
                    <input id="login_form" type="email" name="email">
                </div>

                <div id="login_id">
                    <p>パスワード</p>
                    <input id="login_form" type="password" name="password">
                        <p class="error"><?= @$error ?></p>
                </div>

                <div class="submitbtn">
                    <input type="submit" value="ログイン" name="login">
                </div>
                
            </div>

            <div class="login_abbreviation">

                <div class="login_abb_text">
                    <p>※省略用</p>
                </div>

                <div class="submitbtn">
                    <input type="submit"name="user" value="一般">
                    <input type="submit"name="shop" value="店舗">
                </div>
                
            </div>

    
        </div>


    </form>



</body>

</html>