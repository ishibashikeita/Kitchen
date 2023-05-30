<?php
// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// header("Cache-Control: post-check=0, pre-check=0", false);
// header("Pragma: no-cache");

require("./dbconnect.php");
session_start();
if(!empty($_SESSION['mise']['S_more'])){
    $id = $_SESSION['mise']['S_more'];
    $sql = "SELECT * FROM T_Shop WHERE F_Shop_ID = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id',$id);
    $stmt->execute();
    $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
     //print_r($record);
    $address = $record[0]['F_ShopAddress'];

    $sql = "SELECT * FROM T_product WHERE F_delete IS NULL AND F_Shop_ID = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id',$record[0]['F_Shop_ID']);
    $stmt->execute();
    $goods = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    

    

    // foreach($goods as $g){
    //     echo $g['F_ProductName'];
    //     echo $g['F_Shop_ID'];
    // }

}


    // POSTで受け取った場合
    if (isset($_POST['submit'])) {
        $product = $_POST['id'];
        $num = $_POST['num'];
        $_SESSION['cart'][$product] = $num;
    }

    $cart = array();

    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
    }




?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">

    <title>店ページ</title>
    
</head>
<body>
    <header>
        <?php require_once("header.php") ?>
    </header>

    <section class="mise_main">
        <div class="mise_main_box">
            <div class="mise_main_content">
                <div class="mise_image">
                    <?php
                        $sql = "SELECT F_ShopImageName FROM T_ShopImages WHERE F_Shopimage_ID = :id";
                        $stmt = $db->prepare($sql);
                        $stmt->bindValue(':id',$record[0]['F_Shopimage_ID']);
                        $stmt->execute();
                        $img = $stmt->fetch(PDO::FETCH_ASSOC);

                        echo '<img src="./image/' . $img['F_ShopImageName'] . '" alt="main">';
                    ?>
                </div>
            </div>

            <div class="mise_main_content">
                <div class="mise_shop">
                    <div class="mise_shopdetail">
                        <h1><?php echo $record[0]['F_ShopName'];?></h1>
                        <p><?php echo $record[0]['F_ShopAddress'];?></p>
                    </div>

                <section class="mise_map">
                    <iframe src="https://maps.google.co.jp/maps?q=<?php echo $record[0]['F_ShopAddress']; ?>&output=embed&t=m&z=16&hl=ja" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </section>
                    <!-- <a href="<//?php= get_googlemap_url($address) ?>" target="_blank">Google Mapで見る</a> -->
                </div>
            </div>
        </div>
    </section>

    <!-- <div class="Google_Map">
        <div class="Map">
            <?php
            // function get_googlemap_url($address){
            //     $address = urlencode($address);
            //     return "http://maps.google.co.jp/maps?q={$address}";
            //   }
            ?>
        </div>
    </div> -->

    <article class="menu_article">
        <div class="menu_wrapper">
            <?php foreach($goods as $key => $g){ ?>
            <div class="menu_box">
            <?php
            $sql = "SELECT F_ProductImage FROM T_ProductImages WHERE F_ProductImage_ID = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id',$g['F_ProductImage_ID']);
            $stmt->execute();
            $img = $stmt->fetch(PDO::FETCH_ASSOC);
            echo '<img src="./image/'.$img['F_ProductImage'].'" alt="">';
                ?>
                <form action="" method="post">
                    <div class="menu_content">
                        <div class="menu_text">
                            <div class="menu_title">
                                <h2><?php echo $g['F_ProductName']?></h2>
                            </div>
                            <p id="menu_price"><?php echo $g['F_Price']?>円</p>
                            <p id="menu_comment"><?php echo $g['F_ProductComment']?></p>
                        </div>

                    
                        <div class="order_btn">

                            <!-- <label for="">個数：</label> -->
                            <select name="num">
                                <?php for ($i = 1; $i < 10; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        
                            <input type="hidden" name="id" value="<?php echo $g["F_Product_ID"]?>">
                            <?php if (isset($cart[$g["F_Product_ID"]]) === TRUE): ?>
                            <p id="order_done">追加済み</p>
                            <?php else: ?>
                            <div class="menu_submit">
                                <input type="submit" name="submit" value="カートに入れる">
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </form>
                
            </div>
            <?php } ?>
        </div>
        
    </article>
    
    <footer>
    <?php require_once("footer.html") ?>
    </footer>
    
</body>
</html>