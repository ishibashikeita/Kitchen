<?php
require("./dbconnect.php");
session_start();

if (!empty($_POST)) {
    /* 入力情報の不備を検知 */
    if ($_POST['S_email'] === "") {
        $error['S_email'] = "blank";
    }
    if(!isset($_POST['S_cate'])){
        $error['S_cate'] = "error";
    }
    // // var_dump($_POST['InputText1']);
    // if(empty($_POST['InputText1'])){
    //     if($_POST['InputText1'] == ""){
    //         $error['InputText1'] = "error";
    //     }
    // }
        
    
    /* メールアドレスの重複を検知 */
    if (!isset($error)) {
        $member = $db->prepare('SELECT COUNT(*) as cnt FROM T_Shop WHERE F_ShopMailaddress =?');
        $member->execute(array(
            $_POST['S_email']
        ));
        $record = $member->fetch();
        if ($record['cnt'] > 0) {
            $error['S_email'] = 'duplicate';
        }
    }

    /* エラーがなければ次のページへ */
    if (!isset($error)) {
        $sql = "SELECT * FROM T_ShopImages";
        $sth = $db -> query($sql);
        $Icount = $sth -> rowCount();
        $img  = 'I'. 301 + $Icount;
        $iname = sprintf('%03d', $Icount + 1);

        $file = $_FILES['InputText1'];
        move_uploaded_file($file['tmp_name'], './image/' .'Shop'.$iname.'.png');


        $_SESSION['join'] = $_POST;   // フォームの内容をセッションで保存
        header('Location: addcheck.php');   // check.phpへ移動
        exit();
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

    <title>店舗登録</title>
</head>
<body>
    <header>
        <?php require_once("header.php") ?>
    </header>

    <div class="title">
        <h2>店舗登録</h2>
    </div>

    <article>
        <form action ="" method="post" enctype="multipart/form-data">

            <table class="formtable">

                <tr>
                    <th><p>メイン画像</p></th>
                    <td>
                        <p class="select_box">
                            <input id="image" type="file" name="InputText1" required>
                        </p>
                    </td>
                </tr>

                <tr>
                    <th><p>店名</p></th>
                    <td>
                        <input type="text" name="S_name" id="s_name">
                    </td>
                </tr>

                <tr>
                    <th><p>ジャンル</p></th>
                    <td>
                    <input type="radio" name="S_cate" value="C101">和食
                    <input type="radio" name="S_cate" value="C103">洋食
                    <input type="radio" name="S_cate" value="C102">パン・サンドイッチ
                    <input type="radio" name="S_cate" value="C104">ファストフード
                    <input type="radio" name="S_cate" value="C105">飲み物
                    <?php if (!empty($error['S_cate'])){
                        echo "<p class='error'><span class='red'>※</span>選択してください</p>";
                    } ?>
                    <?php if (!empty($error['InputText1'])){
                        echo "<p class='error'><span class='red'>※</span>画像を選択してください</p>";
                    } ?>
                    </td>
                </tr>

                <tr>
                    <th><p>メールアドレス</p></th>
                    <td>
                        <input type="text" name="S_email" id="s_email">
                        <?php if (!empty($error["S_email"]) && $error['S_email'] === 'blank'): ?>
                        <p class="error">＊メールアドレスを入力してください</p>
                        <?php elseif (!empty($error["S_email"]) && $error['S_email'] === 'duplicate'): ?>
                        <p class="error"><span class='red'>＊</span>このメールアドレスはすでに登録済みです</p>
                        <?php endif ?>
                    </td>
                </tr>

                <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

                <tr>
                    <th rowspan="2"><p>住所</p></th>
                    <td>
                        <p class="form_detail">郵便番号　[ハイフン(-)省略可能]</p>
                        <input type="text" name="S_postcode" id="s_postcode" pattern="\d{3}-?\d{4}" onKeyUp="AjaxZip3.zip2addr(this,'','S_address','S_address');">
                    </td>
                </tr>

                <tr>
                    <td>
                    <p class="form_detail">住所</p>
                    <input type="text" name="S_address" id="s_address">
                    </td>
                </tr>

                <tr>
                    <th><p>電話番号</p></th>
                    <td>
                    <input type="text" name="S_phone" id="s_phone" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}">
                    </td>
                </tr>

                <tr>
                    <th><p>コメント</p><span>※このコメントは一般ユーザーに公開されます。</span></th>
                    <td>
                        <textarea cols="50" rows="10" name ="S_comment" id="s_comment"></textarea>
                    </td>
                </tr>
                
            </table>

            <div class="submitbtn">
                <input type="submit" value="登録する">
            </div>

        </form>
    </article>

    <footer>
        <?php require_once("footer.html") ?>
    </footer>
</body>
</html>