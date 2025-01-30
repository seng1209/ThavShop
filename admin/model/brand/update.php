<!doctype html>
<html lang="en">

<?php
    include("../database.php");
    include("../../uuid.php");
    $image = "";
    $brand = "";
    $description = "";
    $id = $_GET['id'];
    $sql = "SELECT * FROM brands WHERE brand_id = $id";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $image = $row['image'];
        $brand = $row['brand'];
        $description = $row["description"];
    }

    if(isset($_POST['submit'])){
        $brand = $_POST['brand'];
        $description = $_POST['description'];
        $file_name = $_FILES['image']['name'];
        if($file_name == null){
          $name = $row['image'];
        }else{
          $temp_name = $_FILES['image']['tmp_name'];
          $extension = explode(".", $file_name);
          $uuid = gen_uuid();
          $name = $uuid . "." . $extension[1];
          $folder = "../../uploads/brand_image/" . $name;
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

        $sqlUpdate = "UPDATE brands SET image='$name', brand='$brand', description='$description' WHERE brand_id=$id";

        if ($conn->query($sqlUpdate) === TRUE) {
            header("Location:brand.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }

        if(file_exists($image))
            if(unlink($image));
    }
?>

<?php
    include("../../components/head.php");
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
              <h5 class="card-title fw-semibold mb-4">Brand</h5>
              <div class="card">
                <div class="card-body">
                    <form action="update.php?id=<?=$id?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload Image</label>
                            <input class="form-control" type="file" name="image" id="formFile">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Brancd</label>
                            <input type="text" name="brand" value="<?=$brand?>" class="form-control" id="exampleFormControlInput1" placeholder="Brand" require>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"><?=$description?></textarea>
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
  <?php
    include("../../components/footer.php");
  ?>
</body>
</html>
<?php
  $conn->close();
?>