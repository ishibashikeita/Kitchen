<?php
require("./dbconnect.php");
session_start();
        $stmt = $db->prepare('SELECT * FROM T_Users WHERE F_UserMailaddress = :id');
        $stmt->bindValue(':id', $_SESSION['id']);
        $stmt->execute();
        $place = $stmt->fetch(PDO::FETCH_ASSOC);

if(!empty($_POST)){
    $flg = 0;
    foreach ($_POST as $key => $value) {
	if (!empty($value)) {
		$flg = 1;
	}
    }
    if ($flg == 0) {
	    $error['empty'] = "error";
    }
    if(!empty($_POST['name_last']) OR !empty($_POST['name_first'])){
        if(empty($_POST['name_last']) OR empty($_POST['name_first'])){
            $error['name_null'] = "error";  
        }
        $stmt = $db->prepare('SELECT F_LastName FROM T_Users WHERE F_UserMailaddress = :id');
        $stmt->bindValue(':id', $_SESSION['id']);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        $name = $record['F_LastName'];
        $stmt = $db->prepare('SELECT F_FirstName FROM T_Users WHERE F_UserMailaddress = :id');
        $stmt->bindValue(':id', $_SESSION['id']);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        $name .=  $record['F_FirstName'];
        
        //var_dump($name);

        $name2 = $_POST['name_last'] . $_POST['name_first'];
        
        //var_dump($name2);
        if($name == $name2){
            $error['name_simi'] = "error";
        }
    }

    if(!empty($_POST['postcode']) OR !empty($_POST['address']) OR !empty($_POST['add_num']) ){
        if(empty($_POST['postcode']) OR empty($_POST['address']) OR empty($_POST['add_num'])){
            $error['postcode_null'] = "error";  
        }
        $stmt = $db->prepare('SELECT F_UserPostcode FROM T_Users WHERE F_UserMailaddress = :id');
        $stmt->bindValue(':id', $_SESSION['id']);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        $post = $record['F_UserPostcode'];
        $stmt = $db->prepare('SELECT F_UserAddress FROM T_Users WHERE F_UserMailaddress = :id');
        $stmt->bindValue(':id', $_SESSION['id']);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        $post .=  $record['F_UserAddress'];
        
        //var_dump($name);

        $post2 = $_POST['postcode'] . $_POST['address'] . $_POST['add_num'];
        
        //var_dump($name2);
        if($post == $post2){
            $error['postcode_simi'] = "error";
        }
    }
    
    if(isset($_POST['email'])){
        $stmt = $db->prepare('SELECT F_UserMailaddress FROM T_Users WHERE F_UserMailaddress = :id');
        $stmt->bindValue(':id', $_SESSION['id']);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($record);
        if($_POST['email'] == $record['F_UserMailaddress']){
            $error['email'] = "error";
        }
        $member = $db->prepare('SELECT COUNT(*) as cnt FROM T_Users WHERE F_UserMailaddress=?');
        $member->execute(array(
        $_POST['email']
        ));
        $record = $member->fetch();
        if ($record['cnt'] > 0) {
            $error['email_simi'] = 'error';
        }
    }
    if(isset($_POST['phone'])){
        $stmt = $db->prepare('SELECT F_UserPhonenumber FROM T_Users WHERE F_UserMailaddress = :id');
        $stmt->bindValue(':id', $_SESSION['id']);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($record);
        if($_POST['phone'] == $record['F_UserPhonenumber']){
            $error['phone'] = "error";
        }
    }
    if(isset($_POST['birthday'])){
        $stmt = $db->prepare('SELECT F_BirthdayDate FROM T_Users WHERE F_UserMailaddress = :id');
        $stmt->bindValue(':id', $_SESSION['id']);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($record);
        if($_POST['birthday'] == $record['F_BirthdayDate']){
            $error['birthday'] = "error";
        }
    }
    if (!isset($error)) {
        $_SESSION['join'] = $_POST;   // フォームの内容をセッションで保存
        header('Location: a.php');   // check.phpへ移動
        //exit();
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

    <title>アカウント情報編集ページ</title>

</head>
<body>
    <header>
    <?php require_once("header.php") ?>
    </header>

    <article class="acc_change">
        <div class="title">
            <h2>アカウント情報編集</h2>
        </div>
<form action="" method="post">
        <table class="formtable">


            <tr>
            <td colspan="3">
                <p>※変更したい項目のみ記入してください。</p>
            </td>

            </tr>

            <tr>
            <th><p>名前</p></th>
            <!--空白はダメ-->
            <td>
                <p class="form_detail">姓</p>
                <input id="name_last" type="text" name="name_last"pattern=".*\S+.*" placeholder="<?php echo $place['F_LastName']?>">
                <?php if (isset($error['name_null'])){
                    echo "<p class='error'><span class='red'>※</span>空の項目があります</p>";
                    }
                      if (isset($error['name_simi'])){
                    echo "<p class='error'>※変更されていません</p>";
                    }
                ?>
            </td>
            <!--空白はダメ-->
            <td>
                <p class="form_detail">名</p>
                <input id="name_first" type="text" name="name_first"pattern=".*\S+.*" placeholder="<?php echo $place['F_FirstName']?>">
            </td>
            </tr>

            <tr>
            <th><p>メールアドレス</p></th>
            <td>
                <input id="email" type="email" name="email" placeholder="<?php echo $place['F_UserMailaddress']?>">
                <?php if (isset($error['email'])){
                        echo "<p class='error'><span class='red'>※</span>変更されていません</p>";
                        }
                      if (isset($error['email_simi'])){
                        echo "<p class='error'><span class='red'>※</span>このメールアドレスは既に使用されています</p>";
                        }
                ?>
            </td>
            </tr>

            <tr>
            <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
            <th rowspan="3"><p>住所</p></th>
            <!--ハイフンの省略可能3桁、4桁-->
            <td>
                <p class="form_detail">郵便番号　[ハイフン(-)省略可能]</p>
                <input type="text" id="postcode" name ="postcode" pattern="\d{3}-?\d{4}" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" placeholder="<?php echo $place['F_UserPostcode']?>" >
                <?php if (isset($error['postcode_null'])){
                        echo "<p class='error'><span class='red'>※</span>空の項目があります</p>";
                        }
                      if (isset($error['postcode_simi'])){
                        echo "<p class='error'><span class='red'>※</span>変更されていません</p>";
                        }
                ?>
            </td>
            </tr>

            <tr>
            <!--空白はダメ-->
            <td>
                <p class="form_detail">住所</p>
                <input id="address" type="text" name="address"pattern=".*\S+.*" >
            </td>
            </tr>

            <tr>
            <!--空白はダメ-->
            <td>
                <p class="form_detail">番地</p>
                <input id="add_num" type="text" name="add_num"pattern=".*\S+.*" >
            </td>
            </tr>

            <tr>
            <th><p>電話番号</p></th>
            <!--ハイフン省略可能(2-3桁,2-4桁,3-4桁)-->
            <td>
                <p class="form_detail">[ハイフン(-)省略可能]</p>
                <input id="phone" type="int" name="phone" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" placeholder="<?php echo $place['F_UserPhonenumber']?>" >
                <?php if (isset($error['phone'])){
                        echo "<p class='error'><span class='red'>※</span>変更されていません</p>";
                    }
                ?>
            </td>
            </tr>

            <tr>
            <th><p>生年月日</p></th>
            <!--空白はダメ、未来はダメ-->
            <td>
                <input id="birthday" type="date" name="birthday" pattern=".*\S+.*" placeholder="<?php echo $place['F_BirthdayDate']?>">
                <?php if (isset($error['birthday'])){
                    echo "<p class='error'><span class='red'>※</span>変更されていません</p>";
                    }
                ?>
            </td>
            </tr>


            </td>
            </tr>

        </table>




<?php if (isset($error['empty'])){
    echo "<p class='error'>※入力してください</p>";
} ?>




    <div class="submitbtn">
        <input type="submit" value="編集する"></button>
    </div>
</form>
    </article>

    <footer>
        <?php require_once("footer.html") ?>
    </footer>

</body>
</html>