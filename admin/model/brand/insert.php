<?php
    include("../../uuid.php");

    $brand = "";
    $description = "";
    $file_name = "";

    try{
        insertBrand();
    }catch(Exception $e){
        echo $e;
        $conn->close();
    }

    function insertBrand(){
        global $conn;
        if(isset($_POST['submit'])){
            $brand = $_POST['brand'];
            $description = $_POST['description'];
            $file_name = $_FILES['image']['name'];
            $temp_name = $_FILES['image']['tmp_name'];
            $extension = explode(".", $file_name);
            $uuid = gen_uuid();
            $name = $uuid . "." . $extension[1];
            $folder = "../../uploads/brand_image/" . $name;
            $imageFileType = strtolower(pathinfo($folder, PATHINFO_EXTENSION));

            // Check file size (optional, e.g., 5MB limit)
            if ($_FILES['image']['size'] > 5000000) {
                echo "Sorry, your file is too large.";
                return;
            }
        
            // check if already exist
            if(file_exists($folder)){
                echo "Sorry, file already exists.";
                return;
            }

            // Allow certain file formats
            if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                return;
            }

            // prepare and bind
            $stmt = $conn->prepare(
                "INSERT INTO brands(image, brand, description)
                VALUES (?, ?, ?)");
            
            if (!$stmt) {
                die("Preparation failed: " . $conn->error);
            }

            $stmt->bind_param("sss", $name, $brand, $description);
            
            // Execute and check for errors
            if (!$stmt->execute()) {
                die("Execution failed: " . $stmt->error);
            }
            
            // Upload image to folder and check for success
            if (!move_uploaded_file($temp_name, $folder)) {
                die("Failed to upload image.");
            }
            $stmt->close();
        }
    }
?>

<form action="brand.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="formFile" class="form-label">Upload Image</label>
        <input class="form-control" type="file" name="image" id="formFile">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Brancd</label>
        <input type="text" name="brand" class="form-control" id="exampleFormControlInput1" placeholder="Brand" require>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    <input type="submit" name="submit" class="btn btn-primary" />
</form>