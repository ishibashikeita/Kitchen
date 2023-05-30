<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">

    <title>予約完了ページ</title>
</head>
<body>
    <header>
        <?php require_once("header.php") ?>
    </header> 

    <section class="booking_is_done">
        <h2>予約が完了しました</h2>
    </section>

    <section class="booking_info">
        <h4>日時</h4>
        <p>XXXX年XX月XX日 XX：XX</p>
    </section>

    <section class="booking_info">
        <h4>店舗情報</h4>
        <p>店名</p>
        <p>電話番号</p>
    </section>

    <footer>
        <?php require_once("footer.html") ?>
    </footer>

</body>
</html>