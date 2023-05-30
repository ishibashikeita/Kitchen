<?php
require("./dbconnect.php");
session_start();

    $cart = array();

    // POSTで受け取った場合
    if (isset($_POST['kind'])) {
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
    
    if(empty($_SESSION['cart'])){
    $_POST['error'] = "error";
    }
//var_dump($cart);
// $shop = [];
    if(!isset($_POST['error'])){
        foreach($cart as $key => $s){
            $sql = "SELECT F_Shop_ID FROM T_Product WHERE F_Product_ID = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id',$key);
            $stmt->execute();
            $s = $stmt->fetch(PDO::FETCH_ASSOC);
            $shop[] = $s['F_Shop_ID'];
        }
    
        $response = count(array_unique($shop)) == 1 ;
    
        if(!$response){
            $error['dubble'] = "dubble";
        }
    }
    





    if(isset($_POST['link2'])){
        echo $_POST['link2'];
        unset($_SESSION['mise']['S_more']);
        $_SESSION['mise']['S_more'] = $_POST['link2'];
        header('Location: misepage.php');   // misepage.phpへ移動
        exit();
    }
//var_dump($_SESSION['cart']);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>カート</title>
</head>
<body>

    <header>
        <?php require_once("header.php") ?>
    </header>

    <div class="title">
        <h2>カート</h2>
    </div>

    <?php
        if(isset($_POST['error'])){
            echo '<div class="cart_none"><p>カートに商品が入っていません</p></div>';
        }
    ?>

    
    <form name="link" method="post">
        <input type="hidden" id="link2" name="link2" value="">
    </form>

    <div class="cart_list">
    <?php foreach($cart as $key => $c): ?>
        <ul>

            <li>
                <div class="cart_list_content">
                    <div class="cart_productimg">
                    <?php
                    $sql = "SELECT F_ProductImage_ID FROM T_Product WHERE F_Product_ID = :id";
                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(':id',$key);
                    $stmt->execute();
                    $img1 = $stmt->fetch(PDO::FETCH_ASSOC);
                    $sql = "SELECT F_ProductImage FROM T_ProductImages WHERE F_ProductImage_ID = :id";
                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(':id',$img1['F_ProductImage_ID']);
                    $stmt->execute();
                    $img2 = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo '<img src="./image/'.$img2['F_ProductImage'].'" alt="">
                    </div>';
                    ?>
                    <div class="cart_product">
                    <?php   $stmt = $db->prepare("SELECT * FROM T_Product WHERE F_Product_ID = :id");
                            $stmt->bindValue(':id',$key);
                            $stmt->execute();
                            $record = $stmt->fetch(PDO::FETCH_ASSOC);
                            $stmt = $db->prepare("SELECT * FROM T_Shop WHERE F_Shop_ID = :id");
                            $stmt->bindValue(':id',$record['F_Shop_ID']);
                            $stmt->execute();
                            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                    <div class="cart_shopname">

                        <p class="link_<?=$key?>"><?php echo $rec['F_ShopName'] ?></p>
                               
                            <!-- ここmisepageに飛べれるようにできたらしたい -->
                    </div>
                    <div class="cart_productname">
                        <p><?php echo $record['F_ProductName'] ?></p>
                    </div>
                        <script>
                        document.querySelector(".link_<?=$key?>").addEventListener("click", () => {
                                document.getElementById("link2").value = "<?php echo $record['F_Shop_ID'];?>"
                                document.link.submit();

                        })
                        </script>
                    </div>
                    <div class="cart_detail">
                        <!-- 個数と価格この後にできる購入ページに回してもいいというかそっちのがいいかもしれない -->
                        <!-- ここに個数の変更と削除入れたから、購入ページで最終確認と購入するボタンだけつけようとおもったけどどう？？ -->
                        <ul>
                            <li>
                                <div class="cart_count">
                                    <small>個数</small>
                                    <p><?php echo $c; ?>個</p>
                                </div>
                            </li>
                            <li>
                                <div class="cart_price">
                                    <small>単価</small>
                                    <p>
                                        <span class="yen"><?php echo $record['F_Price']?>円<span>
                                    </p>
                                </div>
                            </li>
                            <li id="cart_select">

                                 <!-- 変更ボタン -->
                                <form action="" method="post">

                                    <select name="num">
                                        <?php for($i = 1; $i <10; $i++):?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>

                            </li>
                            <li>
                                    
                                
                                    <input type="hidden" name="kind" value="change">
                                    <input type="hidden" name="product" value="<?php echo $key ?>">
                                    <input type="submit" value="変更" class="cart_change">

                            

                                </form>

                            
                                <!-- 削除ボタン -->
                                 <form action="" method="post">

                                    <input type="hidden" name="kind" value="delete">
                                    <input type="hidden" name="product" value="<?php echo $key ?>">
                                    <input type="submit" value="削除" class="cart_delete">

                                </form>
                                

                        </li>
                        </ul>
                    </div>
                    
                </div>
            </li>



        </ul>
        <?php endforeach; ?>   
    </div>
    <?php
    if(!isset($_POST['error'])){
        if(!isset($error)){
            echo '<div class="cart_btn">
            <a href="confirmation.php"><button>購入へ</button></a>
            </div>';
        }else{
            echo '<div class="cart_btn">
            <p class="error">複数の店舗の商品が入っています。</p>
            </div>';
        }       
    }
    ?>
    <footer>
        <?php require_once("footer.html") ?>
    </footer>

</body>
</html>