<?php
    include("../../uuid.php");

    $category = "";
    $description = "";
    $file_name = "";

    try{
        insertCategory();
    }catch(Exception $e){
        $conn->close();
    }

    function insertCategory(){
        global $conn;
        if(isset($_POST['submit'])){
            $category = $_POST['category'];
            $description = $_POST['description'];
            $file_name = $_FILES['image']['name'];
            $temp_name = $_FILES['image']['tmp_name'];
            $extension = explode(".", $file_name);
            $uuid = gen_uuid();
            $name = $uuid . "." . $extension[1];
            $folder = "../../uploads/category_image/" . $name;
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
                "INSERT INTO categories(image, category, description)
                VALUES (?, ?, ?)");
            
            if (!$stmt) {
                die("Preparation failed: " . $conn->error);
            }
    
            $stmt->bind_param("sss", $name, $category, $description);

            // Upload image to folder and check for success
            if (!move_uploaded_file($temp_name, $folder)) {
                die("Failed to upload image.");
            }
            
            // Execute and check for errors
            if (!$stmt->execute()) {
                die("Execution failed: " . $stmt->error);
            }
            
            $stmt->close();
        }
    }
    
?>

<form action="category.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="formFile" class="form-label">Upload Image</label>
        <input class="form-control" type="file" name="image" id="formFile">
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Category</label>
        <input type="text" name="category" value="<?=$category?>" class="form-control" id="category" placeholder="Category" require>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
        <textarea class="form-control" name="description" value="<?=$description?>" id="description" rows="3"></textarea>
    </div>
    <input type="submit" name="submit" class="btn btn-primary"/>
</form>