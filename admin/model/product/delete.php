<?php
    include("../database.php");
    $id = $_GET['id'];
    $sql = "DELETE FROM products WHERE product_id = $id";
    if($conn->query($sql) === TRUE){
        header("Location:product.php");
    }else{
        echo "Process fail.";
    }
?>