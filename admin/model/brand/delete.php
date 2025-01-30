<?php
    include("../database.php");
    $id = $_GET['id'];
    $sql = "DELETE FROM brands WHERE brand_id = $id";
    try{
        if($conn->query($sql) === TRUE){
            header("Location: brand.php");
        }
    }catch(Exception $e){
        echo $e;
    }
?>