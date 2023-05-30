<?php
require("./dbconnect.php");
session_start();

if (!empty($_POST)) {
    if (!isset($_POST['C_cate'])) {
        $error['C_cate'] = "blank";
    }
    if (!isset($error)) {
        $_SESSION['join'] = $_POST;   // フォームの内容をセッションで保存
        header('Location: Q&Acheck.php');   // check.phpへ移動
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
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/q&a_scroll.js"></script>

    <title>よくあるお問い合わせ</title>
</head>

<body>
    <header>
        <?php require_once("header.php");
        ?>
    </header>

    <div class="title">
        <h2>よくある質問</h2>
    </div>

    <div class="qa_faq_box">

        <div class="question_list">
            <div class="question_content fadeIn">
                <h4>アカウント情報を変更したい場合はどうすればよいですか</h4>
                <p>▷アカウント情報の変更は下記URLから可能です。</p>
                <a href="accountinfo_change.php">アカウント情報更新ページ:accountinfo_change.php</a>
            </div>
            <div class="question_content fadeIn">
                <h4>利用可能な決済方法は何ですか</h4>
                <p>▷コンビニ支払い・クレジットカード決済がご利用頂けます。</p>
            </div>
            <div class="question_content fadeIn">
                <h4>パスワードは変更できますか</h4>
                <p>▷パスワードの変更は下記URLから可能です。</p>
                <a href="pass_change.php">アカウント情報更新ページ:accountpass_change.php</a>
            </div>
            <div class="question_content fadeIn">
                <h4>予約履歴はどこから確認できますか</h4>
                <p>▷マイページの予約履歴から可能です。</p>
            </div>
            <div class="more_btn">
                <!-- <a href="#"><p>もっと見る</p></a> -->
            </div>
        </div>

    </div>

    <!-- <section class="qa_faq_box">
        <div class="qa_faq_title"><h1>よくある質問</h1></div>
        <div class="qa_faq"><p>質問内容</p></div>
        <section class="qa_more"><button class="qa_more_but">もっとみる↓</button></section>
    </section> -->

    <article class="qa_inquiry">
        <form action="" method="post">
            <div class="title">
                <h2>お問い合わせ</h2>
            </div>
            <div class="qa_inq_form">
                <table class="formtable">

                    <tr>
                        <th>
                            <p>メールアドレス</p>
                        </th>
                        <td>
                            <input type="text" size="40" name="mail" id="mail">
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <p>件名</p>
                        </th>
                        <td>
                            <input type="text" size="40" name="cont_name" id="cont_name">
                        </td>

                    </tr>

                    <tr>
                        <th>
                            <p>問い合わせ概要</p>
                        </th>
                        <td>
                            <input type="radio" size="40" name="C_cate" value="T101">予約
                            <input type="radio" size="40" name="C_cate" value="T102">お店
                            <input type="radio" size="40" name="C_cate" value="T103">サイト
                            <?php if (!empty($error['C_cate'])) {
                                echo "<p class='error'><span class='red'>※</span>選択してください</p>";
                            } ?>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <p>問い合わせ内容</p>
                        </th>
                        <td>
                            <textarea cols="50" rows="10" placeholder="お問い合わせ内容を入力してください。" name="content"></textarea>
                        </td>
                    </tr>

                </table>

                <div class="submitbtn">
                    <input type="submit" name="submit" value="送信する">
                </div>
            </div>
        </form>
    </article>
    <footer>
        <?php require_once("footer.html") ?>
    </footer>

</body>

</html>