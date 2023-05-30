<?php
require("./dbconnect.php");
session_start();



if($_POST){
    if(empty($_FILES['img']) || empty($_POST['name']) || empty($_POST['price']) ||  empty($_POST['comment'])){
        $error['empty'] = "empty";
    }

    if(!isset($error)){
        $stmt = $db->prepare('SELECT * FROM T_Users WHERE F_UserMailaddress = :id');
        $stmt->bindValue(':id', $_SESSION['id']);
        $stmt->execute();
        $place = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $db->prepare('SELECT * FROM T_Shop WHERE F_User_ID = :id');
        $stmt->bindValue(':id', $place['F_User_ID']);
        $stmt->execute();
        $shop = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql = "SELECT * FROM T_Product";
        $sth = $db -> query($sql);
        $count = $sth -> rowCount();
        $id = 'P'. 101 + $count;
        
        $sql = "SELECT * FROM T_ProductImages";
        $sth = $db -> query($sql);
        $Icount = $sth -> rowCount();
        $img  = 'I'. 101 + $Icount;
        $iname = sprintf('%03d', $Icount + 1);

        $file = $_FILES['img'];
        move_uploaded_file($file['tmp_name'], './image/' .'Product'.$iname.'.png');
        
        $date = date('Y-m-d');


        $stmt = $db->prepare("INSERT INTO T_ProductImages (F_ProductImage_ID, F_ProductImage) VALUES(:P_id, :P_name)");
        $stmt->bindValue(':P_id',$img);
        $stmt->bindValue(':P_name', "Product".$iname.".png");
        $stmt->execute();

        $stmt = $db->prepare("INSERT INTO T_Product (F_Product_ID, F_ProductName, F_ProductImage_ID, F_Category_ID, F_Shop_ID, F_ProductDate, F_ProductComment, F_Price) VALUES(:P_id, :P_name, :I_id, :C_id, :S_id, :p_date, :p_com, :price)");
        $stmt->bindValue(':P_id',$id);
        $stmt->bindValue(':P_name', $_POST['name']);
        $stmt->bindValue(':I_id', $img);
        $stmt->bindValue(':C_id', $shop['F_Category_ID']);
        $stmt->bindValue(':S_id', $shop['F_Shop_ID']);
        $stmt->bindValue(':p_date', $date);
        $stmt->bindValue(':p_com', $_POST['comment']);
        $stmt->bindValue(':price', $_POST['price']);
        $stmt->execute();
        
        header('Location: product.php');   // thank.phpへ移動
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

    <title>商品登録</title>
</head>
<body>
    <header>
        <?php require_once("header.php") ?>
    </header>

    <div class="title">
        <h2>商品登録</h2>
    </div>

    <article>
        <form action ="" method="post" enctype="multipart/form-data">

            <table class="formtable">

                <tr>
                    <th><p>商品画像</p></th>
                    <td>
                        <p class="select_box">
                            <input type="file" class="select_image" name="img"accept="image/*">
                        </p>
                    </td>
                </tr>

                <tr>
                    <th><p>商品名</p></th>
                    <td>
                        <input type="text" name="name" id="add_productname" maxlength="30" placeholder="30文字まで" require>
                    </td>
                </tr>


                <tr>
                    <th><p>価格</p></th>
                    <td>
                        <input type="number" name="price" id="add_productprice"  require>
                    </td>
                </tr>

                <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

                <tr>
                    <th><p>コメント</p></th>
                    <td>
                    <input type="text" name="comment" id="add_productcom" maxlength="50" require>
                    </td>
                </tr>

                

            </table>
            <?php if (!empty($error['empty'])){
                    echo "<p class='error'><span class='red'>※</span>空の項目があります</p>";
                    }
                    
                ?>


                <div class="submitbtn">
                    <button type="submit"><p>登録する</p></button>
                </div>
        </form>
    </article>
    <footer>    
        <?php require_once("footer.html") ?>
    </footer>
</body>
</html>