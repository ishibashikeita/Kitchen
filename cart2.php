<?php
    session_start();

    $cart = array();

    // POSTで受け取った場合
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product = $_POST['product'];
        $kind = $_POST['kind'];

        if ($kind === 'change') {
            $num = $_POST['num'];
            $_SESSION['cart'][$product] = $num;
        } elseif ($kind === 'delete') {
            unset($_SESSION['cart'][$product]);
        }

    }

    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
    }

    var_dump($cart);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>ショッピングカート</title>
</head>

<body>
<h1>ショッピングカート</h1>

<p><a href="main.php">商品一覧へ</a></p>
<p><a href="delete.php">カートをすべて空に</a></p>

<table style="text-align:center">
    <tr>
        <th>商品</th><th>個数</th><th>数量</th><th>変更ボタン</th><th>削除ボタン</th>
    </tr>
    <?php foreach($cart as $key => $var): ?>
    <tr>
        <td>
        <?php
        if ($key == 'pc_mouse') {
            echo 'マウス';

        } elseif ($key == 'pc_keyboard') {
            echo 'キーボード';
        }
        ?>
        </td>
        <td><?php echo $var ?>個</td>

        <!- 変更ボタン ->
        <form action="" method="post">
            <td>
                <select name="num">
                    <?php for($i = 1; $i <10; $i++):?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </td>
            <td>
                <input type="hidden" name="kind" value="change">
                <input type="hidden" name="product" value="<?php echo $key ?>">
                <input type="submit" value="変更">
            </td>
        </form>

        <!- 削除ボタン ->
        <form action="" method="post">
            <td>
                <input type="hidden" name="kind" value="delete">
                <input type="hidden" name="product" value="<?php echo $key ?>">
                <input type="submit" value="削除">
            </td>
        </form>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>