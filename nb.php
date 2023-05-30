<?php
require("./dbconnect.php");
    session_start();

    $sql ="UPDATE t_product SET F_delete = NULL";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $sql ="UPDATE t_product SET F_delete = NULL";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    
    header("Location: index.php");  
?>