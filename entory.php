<?php 
require("./dbconnect.php");
session_start();

if (!empty($_POST)) {
    /* 入力情報の不備を検知 */
    if ($_POST['email'] === "") {
        $error['email'] = "blank";
    }
    if ($_POST['password'] === "") {
        $error['password'] = "blank";
    }

    $date = date('Y-m-d');
    $birthday = $_POST['birthday'];
    if(strtotime($date) - strtotime($birthday) < 0){
        $error['birthday'] = "error";
    }
    /* メールアドレスの重複を検知 */

    $member = $db->prepare('SELECT COUNT(*) as cnt FROM T_Users WHERE F_UserMailaddress=?');
    $member->execute(array(
        $_POST['email']
    ));
    $record = $member->fetch();
    if ($record['cnt'] > 0) {
        $error['email'] = 'duplicate';
    }


    /* エラーがなければ次のページへ */
    if (!isset($error)) {
        $_SESSION['join'] = $_POST;   // フォームの内容をセッションで保存
        header('Location: check.php');   // check.phpへ移動
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>アカウント作成</title>
    <!-- <link href="https://unpkg.com/sanitize.css" rel="stylesheet"/> -->
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<header>
        <?php require_once("header.php") ?>
    </header>


        <form action="" method="POST">
            <div class="title">
            <h2>アカウント作成</h2>
            </div>
            

            <table class="formtable">

                <tr>
                <th colspan="3" id="entory_attention">
                <p>当サービスをご利用するために、次のフォームに必要事項をご記入ください。</p>
                <small>※全ての項目にご記入ください。</small>
                </th>

                </tr>

                <tr>
                <th><p>登録</p></th>
                <!--一般ユーザか店舗ユーザか-->
                <td>
                    <input type="radio" class="entory_radio" name="U_cate" value="U" required><label for="">一般</label>
                    <input type="radio" class="entory_radio" name="U_cate" value="S" required><label for="">店舗</label>

                </td>
                </tr>

                <tr>
                <th><p>名前</p></th>
                <!--空白はダメ-->
                <td>
                    <p class="form_detail">姓</p>
                    <input id="name_last" type="text" name="name_last"pattern=".*\S+.*" required>
                </td>

                <!--空白はダメ-->
                <td>
                    <p class="form_detail">名</p>
                    <input id="name_first" type="text" name="name_first"pattern=".*\S+.*" required>
                </td>
                </tr>

                <tr>
                <th><p>メールアドレス</p></th>
                <td><input id="email" type="email" name="email">
                <?php if (!empty($error["email"]) && $error['email'] === 'blank'): ?>
                    <p class="error"><span class="red">＊</span>メールアドレスを入力してください</p>
                    <!-- error css付ける -->
                <?php elseif (!empty($error["email"]) && $error['email'] === 'duplicate'): ?>
                    <p class="error"><span class="red">＊</span>このメールアドレスはすでに登録済みです</p>
                <?php endif ?>
                </td>
                </tr>

                <tr>
                <th><p>パスワード</p></th>
                <!--英数字8文字以上、大文字を1文字含む(追記)-->
                <td>
                    <p class="form_detail">英数字8文字以上、大文字を1文字含む</p>
                    <input id="password" type="password" name="password" pattern="(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,}" required>
                </td>
                </tr>


                <tr>
                <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
                <th rowspan="3"><p>住所</p></th>
                <!--ハイフンの省略可能3桁、4桁-->
                <td>
                    <p class="form_detail">郵便番号　[ハイフン(-)省略可能]</p>
                    <input type="text" id="postcode" name ="postcode" pattern="\d{3}-?\d{4}" onKeyUp="AjaxZip3.zip2addr(this,'','address','address');" required>
                </td>
                </tr>

                <tr>
                <!--空白はダメ-->
                <td>
                    <p class="form_detail">住所</p>
                    <input id="address" type="text" name="address"pattern=".*\S+.*" required>
                </td>
                </tr>

                <tr>
                <!--空白はダメ-->
                <td>
                    <p class="form_detail">番地</p>
                    <input id="add_num" type="text" name="add_num"pattern=".*\S+.*" required>
                </td>
                </tr>

                <tr>
                <th><p>電話番号</p></th>
                <!--ハイフン省略可能(2-3桁,2-4桁,3-4桁)-->
                <td>
                    <p class="form_detail">[ハイフン(-)省略可能]</p>
                    <input id="phone" type="int" name="phone" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" required>
                </td>
                </tr>

                <tr>
                <th><p>生年月日</p></th>
                <!--空白はダメ、未来はダメ-->
                <td><input id="birthday" type="date" name="birthday" pattern=".*\S+.*" required></td>
                <?php if (!empty($error['birthday']) && $error['birthday'] === 'error'): ?>
                    <p class="error"><span class="red">＊</span>正しい生年月日を入力してください。</p>
                    <?php endif ?>

                </tr>
 
            </table>


            <div class="submitbtn">
                <input type="submit" value="確認する">
            </div>
        </form>

    <footer>
        <?php require_once("footer.html") ?>
    </footer>
</body>
</html>