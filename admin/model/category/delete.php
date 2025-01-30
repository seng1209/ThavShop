<?php
    include("../database.php");
    $id = $_GET['id'];
    $sql = "DELETE FROM categories WHERE category_id = $id";
    if ($conn->query($sql) === TRUE) {
        // echo "Record updated successfully";
        header("location:category.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
?>  