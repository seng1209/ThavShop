<!doctype html>
<html lang="en">

<?php
    include("../database.php");
    include("../../uuid.php");
    include("../../components/head.php");
    $id = $_GET['id'];
    $image = "";
    $product_name = "";
    $price = "";
    $category_id = "";
    $brand_id = "";
    $description = "";
    $inStock = true;

    // $category = "";
    // $brand = "";

    $sqlCategories = "SELECT * FROM categories";
    $sqlBrands = "SELECT * FROM brands";
    $sql = "SELECT * FROM products WHERE product_id = $id";
    $resul = $conn->query($sql);
    $row = $resul->fetch_assoc();
    if($resul->num_rows > 0){
        $image = $row['image'];
        $product_name = $row['product_name'];
        $price = $row['price'];
        $category_id = $row['category_id'];
        $brand_id = $row['brand_id'];
        $description = $row['description'];
        $inStock = $row['in_stock'];
    }
    if(isset($_POST['submit'])){
      $product_name = $_POST['product_name'];
      $price = $_POST['price'];
      $category_id = $_POST['category'];
      $brand_id = $_POST['brand'];
      $description = $_POST['description'];
      $file_name = $_FILES['image']['name'];
      if($file_name == null){
        $name = $row['image'];
      }else{
        $temp_name = $_FILES['image']['tmp_name'];
        $extension = explode(".", $file_name);
        $uuid = gen_uuid();
        $name = $uuid . "." . $extension[1];
        $folder = "../../uploads/product_image/" . $name;
        $imageFileType = strtolower(pathinfo($folder, PATHINFO_EXTENSION));
        if ($_FILES['image']['size'] > 5000000) {
          echo "Sorry, your file is too large.";
          return;
        }
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          return;
        }
        if (!move_uploaded_file($temp_name, $folder)) {
          die("Failed to upload image.");
        }
      }

      if($category_id == 0 || $category_id == null){
        $category_id = $row['category_id'];
      }

      if($brand_id == 0 || $brand_id == null){
        $brand_id = $row['brand_id'];
      }

      $sqlUpdate = "UPDATE products SET image='$name', product_name='$product_name', price='$price', category_id='$category_id', brand_id='$brand_id', description='$description' WHERE product_id=$id";

      if($conn->query($sqlUpdate)){
        header('Location:product.php');
      }else{
        echo "Update fial.";
      }
      
      if(file_exists($image))
        if(unlink($image));
    }
?>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <?php
        include("../../components/sidebar.php");
    ?>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <?php
        include("../../components/header.php");
      ?>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Product</h5>
              <div class="card">
                <div class="card-body">
                    <form action="update.php?id=<?=$id?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload Image</label>
                            <input class="form-control" type="file" name="image" id="formFile" require>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Product Name</label>
                            <input type="text" name="product_name" value="<?=$product_name?>" class="form-control" id="exampleFormControlInput1" placeholder="Product Name" require>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Price</label>
                            <input type="number" name="price" value="<?=$price?>" class="form-control" id="exampleFormControlInput1" placeholder="Price" require>
                        </div>
                        <select class="form-select mb-3" name="category" value="<?=$category_id?>"  aria-label="Default select example">
                            <option selected disabled>Categories</option>
                        <?php
                                $result = $conn->query($sqlCategories);
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
                        <select class="form-select mb-3" name="brand" value="<?=$brand_id?>" aria-label="Default select example">
                            <option selected disabled>Brands</option>
                            <?php
                                $result = $conn->query($sqlBrands);
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
                            <textarea class="form-control" name="description"  id="exampleFormControlTextarea1" rows="3"><?=$description?>"</textarea>
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary" />
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<?php
  $conn->close();
?>