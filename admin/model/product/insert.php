<?php
    include("../../uuid.php");
    $product_name = "";
    $price = "";
    $category_id = "";
    $brand_id = "";
    $description = "";
    $inStock = true;

    $sqlCategory = "SELECT * FROM categories";
    $sqlBrand = "SELECT * FROM brands";

    // if($_SERVER['REQUEST_METHOD'] == $_POST){
        if(isset($_POST['submit'])){
            $product_name = $_POST['product_name'];
            $price = $_POST['price'];
            $category_id = $_POST['category'];
            $brand_id = $_POST['brand'];
            $description = $_POST['description'];
            $file_name = $_FILES['image']['name'];
            $temp_name = $_FILES['image']['tmp_name'];
            $extension = explode(".", $file_name);
            $uuid = gen_uuid();
            $name = $uuid . "." . $extension[1];
            $folder = "../../uploads/product_image/" . $name;
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
            if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif', 'webp'])) {
                echo "Sorry, only JPG, JPEG, PNG, WEBP & GIF files are allowed.";
                return;
            }

            // prepare and bind
            $stmt = $conn->prepare(
                "INSERT INTO products(image, product_name, price, category_id, brand_id, description, in_stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            if (!$stmt) {
                die("Preparation failed: " . $conn->error);
            }

            $stmt->bind_param("ssiiisb", $name, $product_name, $price, $category_id, $brand_id, $description, $inStock);
            
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
    // }
?>

<form action="product.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="formFile" class="form-label">Upload Image</label>
        <input class="form-control" type="file" name="image" id="formFile" require>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Product Name</label>
        <input type="text" name="product_name" class="form-control" id="exampleFormControlInput1" placeholder="Product Name" require>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Price</label>
        <input type="number" name="price" class="form-control" id="exampleFormControlInput1" placeholder="Price" require>
    </div>
    <select class="form-select mb-3" name="category" aria-label="Default select example">
        <option selected disabled>Category</option>
       <?php
            $result = $conn->query($sqlCategory);
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc()){
        ?>
                    <option value="<?=$row['category_id']?>"><?=$row['category']?></option>
        <?php
                }
            }
        ?>
    </select>
    <select class="form-select mb-3" name="brand" aria-label="Default select example">
        <option selected disabled>Brand</option>
        <?php
            $result = $conn->query($sqlBrand);
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc()){
        ?>
                    <option value="<?=$row['brand_id']?>"><?=$row['brand']?></option>
        <?php
                }
            }
        ?>
    </select>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    <input type="submit" name="submit" class="btn btn-primary" />
</form>