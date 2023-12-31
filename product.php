<?php
// Start the session
include "./dbconnsub.php";
session_start();

if ($_SESSION["role"] !== "manager") {
    header("location: ./error/unauthorized.php");
    exit();
}

$role = $_SESSION["role"];
$username = $_SESSION["username"];

if(isset($_POST['submit'])) {
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productSauce = $_POST['productSauce'];
    $productFlavor = $_POST['productFlavor'];
    $productOutStock = isset($_POST['productOutStock']) ? 1 : 0;


    $sql = "INSERT INTO `product`(`id`, `productName`, `productPrice`, `productSauce`, `productFlavor`, `productOutStock`) 
    VALUES (NULL,'$productName','$productPrice','$productSauce','$productFlavor','$productOutStock')";

    $result = mysqli_query($connect , $sql);
    if($result) {
        header("Location: ./product.php");
        exit();
    } else {
        echo "Failed to add a product in the table";
    }
} 

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Control Panel">
        <meta name="author" content="Argie Delgado">
        <title>Stock Control System | Product</title>
        <!-- Awesome Fonts -->
        <script src="https://kit.fontawesome.com/20fbad04b0.js" crossorigin="anonymous"></script>
        <link href="./css/dashboard.css" rel="stylesheet">
    </head>
    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            <?php
                include "./include/sidebarEmployees.php";
            ?>
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <?php
                        include "./include/topbar.php";
                    ?>
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item"><a href="./index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Product Table</li>
                            </ol>
                            <div class="card mb-4">
                                <div class="card-body">
                                    You can add a product and make it visible in the table. 
                                    <button onclick="openModal()" type="button" style="float: right; color: white;" class="btn btn-info">+ Add Products</button>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    List of the products
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple" class="table text-center table-striped table-bordered rounded">
                                        <thead class="bg-dark" style="color: #fff;">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">Name</th>
                                                <th scope="col" class="text-center">Price</th>
                                                <th scope="col" class="text-center">Sauce</th>
                                                <th scope="col" class="text-center">Flavor</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                include "./dbconnsub.php";
                                                $sql = "SELECT * FROM `product`";
                                                $result = mysqli_query($connect, $sql);
                            
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                        <tr class="<?php echo $row['productOutStock'] ? 'table-danger text-muted' : ''; ?>">
                                                            <td><?php echo $row['id'] ?></td>
                                                            <td><?php echo $row['productName'] ?></td>
                                                            <td><?php echo $row['productPrice'] ?></td>
                                                            <td><?php echo $row['productSauce'] ?></td>
                                                            <td><?php echo $row['productFlavor'] ?></td>
                                                            <td><?php echo $row['productOutStock'] ? 'Out of Stock' : 'On Stock'; ?></td>
                                                            <td>
                                                                <a href="./editProduct.php?id=<?php echo $row['id'] ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                    <!-- End of Page Content -->
                </div>
                <!-- End of Main Content -->
                <?php
                    include "./include/footer.php";
                ?>
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
        <?php
            include "./include/logout.php";
        ?>
        <!-- Modal View Insert-->
        <div id="modal" class="modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="text-muted">Complete the form below to add a new Administrator<p>
                            <h5 class="modal-title">Add New Administrator</h5>
                            <button onclick="closeModal()" class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="container d-grid">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="">
                                    <div class="mb-2">
                                        <div class="form-label">Name:</div>
                                        <input type="text" class="form-control" name="productName" required>
                                    </div>
            
                                    <div class="mb-3">
                                        <div class="form-label">Price:</div>
                                        <input type="number" class="form-control" name="productPrice" required>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-label">Sauce:</div>
                                        <input type="text" class="form-control" name="productSauce" required>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-label">Flavor:</div>
                                        <input type="text" class="form-control" name="productFlavor" required>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="productOutStock" id="productOutStock">
                                            <label class="form-check-label" for="productOutStock">Out of Stock</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="reset" class="btn btn-danger" name="Reset">Reset</button>
                                        <button type="submit" class="btn btn-success" name="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>  
                </div>
            </div>
        <!-- Bootstrap core JavaScript-->
        <script src="./js/dashboard.js"></script>
        <script src="./js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="./js/jquery.easing.min.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="./js/sidebarfuntion.js"></script>
        <script src="./js/modalfunction.js"></script>
    </body>
</html> 