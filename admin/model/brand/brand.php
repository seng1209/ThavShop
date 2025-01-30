<?php
    include("../database.php");
?>

<!doctype html>
<html lang="en">

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
                  <?php
                    include("./insert.php");
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
        include("./findAll.php");
      ?>
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