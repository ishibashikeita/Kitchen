<?php
require("./dbconnect.php");
session_start();

$sql = "SELECT F_User_ID FROM T_Users WHERE F_UserMailaddress = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id',$_SESSION['id']);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    $member = $db->prepare('SELECT COUNT(*) as cnt FROM T_Shop WHERE F_User_ID=?');
    $member->execute(array(
        $record['F_User_ID']
    ));
    $count = $member->fetch();
    if ($count['cnt'] > 0) {
        $exist = '1';

        $sql = "SELECT F_Shop_ID FROM T_Shop WHERE F_User_ID = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id',$record['F_User_ID']);
        $stmt->execute();
        $record2 = $stmt->fetch(PDO::FETCH_ASSOC);

        $member = $db->prepare('SELECT COUNT(*) as cnt FROM T_Product WHERE F_Shop_ID=?');
        $member->execute(array(
            $record2['F_Shop_ID']
        ));
        $count2 = $member->fetch();
        
        if ($count2['cnt'] > 0) {
          $exist2 = '1';
        }




    }



if(isset($_POST['id'])){
    $sql ="UPDATE t_product SET F_delete = 1 WHERE F_product_ID = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $_POST['id']);
    $stmt->execute();
}
if(isset($exist)){
    $sql = "SELECT F_User_ID FROM T_Users WHERE F_UserMailaddress = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id',$_SESSION['id']);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
//echo $record['F_User_ID'];

    $sql = "SELECT * FROM T_Shop WHERE F_User_ID = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id',$record['F_User_ID']);
    $stmt->execute();
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

// print_r($rec);

    $sql = "SELECT * FROM T_product WHERE F_delete IS NULL AND F_Shop_ID = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id',$rec['F_Shop_ID']);
    $stmt->execute();
    $goods = $stmt->fetchAll(PDO::FETCH_ASSOC);

//print_r($goods);
// foreach($goods as $key => $g){
//     echo $g['F_ProductName'];
//     echo $key;
//     echo "\n\n";
// }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>商品管理</title>
</head>
<body>

  <header>
    <?php require_once("header.php");?>
  </header>

  <div class="title">
    <h2>商品一覧</h2>   
  </div>
<?php if(isset($exist)):?>
  <!-- 店名 -->
  <div class="product_shopname">
    <p><?php echo $rec['F_ShopName']?></p>
  </div>
    
<?php if(isset($exist2)):?>
  <table class="product_table">
      <tr id="p_th">
        <th><p>商品画像</p></th>
        <th><p>商品名</p></th>
        <th><p>商品コメント</p></th>
        <th><p>値段</p></th>
        <th><p>追加した日付</p></th>
        <th><p>操作</p></th>
      </tr>
      <?php foreach ($goods as $key =>$g) { ?>
      
      <tr>
          <!-- 商品画像 -->
        <td id="p_image">
          <?php
            $sql = "SELECT F_ProductImage_ID FROM T_Product WHERE F_Product_ID = :id";
                  $stmt = $db->prepare($sql);
                  $stmt->bindValue(':id',$g['F_Product_ID']);
                  $stmt->execute();
                  $img = $stmt->fetch(PDO::FETCH_ASSOC);
                  $sql = "SELECT F_ProductImage FROM T_ProductImages WHERE F_ProductImage_ID = :id";
                  $stmt = $db->prepare($sql);
                  $stmt->bindValue(':id',$img['F_ProductImage_ID']);
                  $stmt->execute();
                  $img2 = $stmt->fetch(PDO::FETCH_ASSOC);
              
            echo '<img src="./image/'.$img2['F_ProductImage'].'" alt="" width="100">'
          ?>
        </td>


        <!-- 商品名 -->
        <td id="p_name">
          <p><?php echo $g['F_ProductName'] ?></p>
        </td>


        <!-- 商品コメント -->
        <td id="p_comment">
          <p><?php echo nl2br($g['F_ProductComment']) ?></p>
        </td>


        <!-- 値段 -->
        <td id="p_price">
          <p><?php echo $g['F_Price'] ?>円</p>
        </td>


        <!-- 追加した日付 -->
        <td id="p_date">
          <p><?php echo $g['F_ProductDate']?></p>
        </td>

        <form action="" method="post">
        <td id="p_operate">
          <input type="hidden" name ="id" value="<?php echo $g['F_Product_ID'];?>">
          <button type="submit">削除</button>
        </td>
        </form>

      </tr>
    <?php } ?>
  </table>
  <?php endif ?>
<?php endif ?>

    <?php
    if(isset($exist)){
        if(!isset($exist2)){
          echo '<div class="cart_none"><p>出品中の商品はありません。</p></div>';
          }
    }else{
      echo '<div class="cart_none"><p>出店中のお店がありません。</p></div>';
    }
        
    ?>

  <div class="product_btn">
    <?php if(isset($exist)):?>
      <a href="add_product.php" class="product_addbtn">新規追加</a>
      <?php else :?>
        <a href="misetouroku.php" class="product_addbtn">店舗登録へ</a>
    <?php endif?>
    
    <a href="mypage.php" class="product_backbtn">マイページに戻る</a>
  </div>
</body>
<footer>
        <?php require_once("footer.html") ?>
    </footer>
</html>