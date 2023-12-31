<?php
// Start the session
include "./dbconnsub.php";
session_start();

if ($_SESSION["role"] !== "cashier") {
    header("location: ./error/unauthorized.php");
    exit();
}

$role = $_SESSION["role"];
$username = $_SESSION["username"];

if(isset($_POST['submit'])) {
    $customerName = $_POST['customerName'];
    $itemSold = $_POST['customerSold'];
    $quantityperUnit = $_POST['quantityperUnit'];
    $totalPrice = $_POST['totalPrice'];
    $payment = $_POST['customerPayment'];
    $customerChange = $_POST['change'];
    $paymentMethod = $_POST['paymentMethod'];
    $transactionNo = $_POST['transactionNo'];
    $date = date('Y-m-d h:i A', strtotime($_POST['customerDate']));

    $sql = "INSERT INTO `customer`(`id`, `customerName`, `customerSold`, `quantityperUnit`, `totalPrice`, `customerPayment`, `customerChange`, `paymentMethod`, `transactionNo`, `customerDate`) 
    VALUES (NUll,'$customerName','$itemSold','$quantityperUnit','$totalPrice','$payment','$customerChange','$paymentMethod','$transactionNo', '$date')";

    $result = mysqli_query( $connect, $sql);
    if($result) {
        header("Location: ./customer.php");
        exit();
    } else {
        echo "Failed to add a customer in the customer table";
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
        <title>TPS | Table</title>
        <!-- Awesome Fonts -->
        <script src="https://kit.fontawesome.com/20fbad04b0.js" crossorigin="anonymous"></script>
        <link href="./css/dashboard.css" rel="stylesheet">
        <link rel="stylesheet" href="./css/removeArrowSpin.css">
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
                                <li class="breadcrumb-item active">Transaction Table</li>
                            </ol>
                            <div class="card mb-4">
                                <div class="card-body">
                                    You can add a Transaction and make it visible in the table. 
                                    <button onclick="openModal()" type="button" style="float: right; color: white;" class="btn btn-info">+ Add Transaction</button>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    List of the Transaction
                                </div>
                                <div class="card-body">
                                <table id="datatablesSimple" class="table table-sm">
                                        <thead>
                                            <tr>
                                            <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">Name</th>
                                                <th scope="col" class="text-center">Item Order</th>
                                                <th scope="col" class="text-center">Quantity per Unit</th>
                                                <th scope="col" class="text-center">Total Price</th>
                                                <th scope="col" class="text-center">Payment</th>
                                                <th scope="col" class="text-center">Change</th>
                                                <th scope="col" class="text-center">Payment Method</th>
                                                <th scope="col" class="text-center">Transaction No</th>
                                                <th scope="col" class="text-center">Date</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "./dbconnsub.php";
                                            $sql = "SELECT * FROM `customer`";
                                            $result = mysqli_query($connect, $sql);
    
                                            $totalPayment = 0;

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                // Update totals
                                                $totalPayment += $row['customerPayment'];

                                                ?>
                                                <tr>
                                                    <td><?php echo $row['id'] ?></td>
                                                    <td><?php echo $row['customerName'] ?></td>
                                                    <td><?php echo $row['customerSold'] ?></td>
                                                    <td><?php echo $row['quantityperUnit'] ?></td>
                                                    <td><?php echo $row['totalPrice'] ?></td>
                                                    <td><?php echo $row['customerPayment'] ?></td>
                                                    <td><?php echo $row['customerChange'] ?></td>
                                                    <td><?php echo $row['paymentMethod'] ?></td>
                                                    <td><?php echo $row['transactionNo'] ?></td>
                                                    <td><?php echo $row['customerDate'] ?></td>
                                                    <td>
                                                        <div class="d-flex" style="gap: 10px; justify-content: center;">
                                                            <a href="./editCustomer.php?id=<?php echo $row['id'] ?>" class="btn btn-primary me-3" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                <i class="far fa-pen-to-square fs-5"></i>
                                                            </a>
                                                            <a href="./viewCustomer.php?id=<?php echo $row['id'] ?>" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="View">
                                                                <i class="far fa-eye fs-5"></i>
                                                            </a>
                                                            <!-- Initialize tooltips -->
                                                            <script>
                                                                $(function () {
                                                                    $('[data-toggle="tooltip"]').tooltip();
                                                                });
                                                            </script>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot class="table-striped">
                                            <tr>
                                                <td colspan="10">Total</td>
                                                <td><?php echo $totalPayment; ?></td>
                                            </tr>
                                        </tfoot>
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
                            <p class="text-muted">Complete the form below to add a new Transaction<p>
                            <h5 class="modal-title">Add New Transaction</h5>
                            <button onclick="closeModal()" class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="container d-grid">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="">
                                        <div class="mb-2">
                                            <div class="form-label">Name:</div>
                                            <input type="text" class="form-control" name="customerName" value="Cash" required>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-2" style="display: none;">
                                                <div class="form-label">Price:</div>
                                                <input id="productPrice" type="number" class="form-control" name="productPrice" required readonly>
                                                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                                                <script>
                                                    function updatePrice() {
                                                        var selectedProductName = $("#spinnerType").val();

                                                        $.ajax({
                                                            type: 'POST',
                                                            url: './get_price.php',
                                                            data: { productName: selectedProductName },
                                                            success: function (response) {
                                                                $("#productPrice").val(response);
                                                                updateQuantityAndTotal();
                                                            }
                                                        });
                                                    }

                                                    function updateQuantityAndTotal() {
                                                        var quantity = $("#quantity").val();
                                                        var productPrice = $("#productPrice").val();
                                                        var totalPrice = quantity * productPrice;

                                                        $("#totalprice").val(totalPrice);
                                                    }

                                                    $(document).ready(function () {
                                                        updatePrice();

                                                        $("#spinnerType").change(function () {
                                                            updatePrice();
                                                        });

                                                        $("#quantity").on("input", function () {
                                                            updateQuantityAndTotal();
                                                        });
                                                    });
                                                </script>
                                            </div>      
                                            
                                            <div class="mb-3 col-7">
                                                <label for="spinnerType" class="form-label">Item Order:</label>
                                                <select class="form-select" name="customerSold" id="spinnerType" required>
                                                    <?php
                                                    $productData = getSpinnerTypesFromDatabase();

                                                    foreach ($productData as $product) {
                                                        $productName = $product['productName'];
                                                        $outOfStock = $product['productOutStock'];

                                                        // Check if the product is out of stock
                                                        $disabledAttribute = ($outOfStock) ? 'disabled' : '';

                                                        echo "<option value='$productName' $disabledAttribute>$productName</option>";
                                                    }

                                                    function getSpinnerTypesFromDatabase()
                                                    {
                                                        include "./dbconnsub.php";

                                                        $sql = "SELECT productName, productOutStock FROM `product`";

                                                        $result = mysqli_query($connect, $sql);

                                                        $productData = array();

                                                        if ($result->num_rows > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $productData[] = $row;
                                                            }
                                                        }

                                                        return $productData;
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="mb-3 col-2">
                                                <div class="form-label">Quantity:</div>
                                                <input id="quantity" type="number" class="form-control" name="quantityperUnit" required>
                                            </div>
                                            <div class="mb-3 col-3">
                                                <div class="form-label">Total Price:</div>
                                                <input id="totalprice" type="number" class="form-control" name="totalPrice" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col">
                                                <div class="form-label">Transaction No:</div>
                                                <input type="text" class="form-control" name="transactionNo" id="transactionNo" required readonly>
                                            </div>
                                            <div class="mb-3 col">
                                                <div class="form-label" style="visibility: hidden;">x</div>
                                                <button type="button" onclick="randomGeneration()" class="btn btn-primary">Generate a number:</button>
                                                    <script>
                                                        // 10 digit random generator
                                                        function randomGeneration() {
                                                            var generatedNumber = "",
                                                                digits = 10;

                                                            generatedNumber += Math.floor(Math.random() * 9) + 1;

                                                            for (var i = 1; i < digits; i++) {
                                                                generatedNumber += Math.floor(Math.random() * 10);
                                                            }
                                                            console.log("Generated Number: " + generatedNumber);
                                                            document.getElementById("transactionNo").value = generatedNumber;
                                                        }
                                                    </script>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col">
                                                <div class="form-label">Payment:</div>
                                                <input id="payment" type="number" class="form-control" name="customerPayment" required>
                                            </div>

                                            <div class="mb-3 col">
                                                <div class="form-label">Change:</div>
                                                <input id="change" type="number" class="form-control" name="change" readonly>
                                            </div>

                                            <div class="mb-3 col">
                                                <div class="form-label">Payment Method:</div>
                                                <input type="text" class="form-control" name="paymentMethod" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-label">Date:</div>
                                            <input type="datetime-local" class="form-control" name="customerDate" id="customerDate" required readonly>
                                            <script>
                                                function updateDateTime() {
                                                var now = new Date();
                                                
                                                var localOffset = now.getTimezoneOffset() * 60000;
                                                var localDateTime = new Date(now - localOffset);
                                                
                                                var formattedDateTime = localDateTime.toISOString().slice(0, 16);
                                                
                                                document.getElementById("customerDate").value = formattedDateTime;
                                            }

                                            updateDateTime();

                                            setInterval(updateDateTime, 1000);

                                            </script>
                                        </div>

                                        <div class="mb-3">
                                            <button type="reset" class="btn btn-danger float-right" name="Reset">Reset</button>
                                            <button type="submit" class="btn btn-success float-right" name="submit">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>  
                </div>
            </div>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script>
            $(document).ready(function() {
            $('#datatablesSimple').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy',
                    'pdf',
                    'excel',
                    {
                        extend: 'print',
                        title: 'Customers Sales Reports - By Admin',
                        customize: function(win) {
                            // Customize the heading
                            var header = $(win.document.body).find('h1');
                            if (header.length === 0) {
                                header = $('<h1>').appendTo($(win.document.body));
                            }
                            header.css({
                                'font-size': '14pt',
                                'color': '#333',
                                'text-align': 'center',
                                'margin': '15pt'
                            }).text('Customers Sales Reports');
                            $(win.document.body).find('table thead th').css({
                                'text-align': 'center'
                            });
                            // Customize the body
                            $(win.document.body).find('table thead th:last-child').remove();
                            $(win.document.body).find('table').find('td:last-child').remove();
                            $(win.document.body)
                                .css('font-size', '12pt')
                                .find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');

                            // Add a footer row with the sum of payments
                            var sum = 0;
                            $(win.document.body).find('table tbody tr').each(function() {
                                var payment = parseInt($(this).find('td:nth-child(6)').text(), 10);
                                if (!isNaN(payment)) {
                                    sum += payment;
                                }
                            });

                            var footerRow = $('<tr>').appendTo($(win.document.body).find('table tbody'));
                            $('<td>').text('Total').appendTo(footerRow);
                            var colspanValue = 11;
                            $('<td>').text(sum).attr('colspan', colspanValue).attr('style', 'text-align: right;').appendTo(footerRow);
                            footerRow.css({
                                'font-weight': 'bold',
                                'background-color': '#eee'
                            });
                        }
                    }
                ]
            });
        });
        </script>
        <!-- Bootstrap core JavaScript-->
        <script src="./js/dashboard.js"></script>
        <script src="./js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="./js/jquery.easing.min.js"></script>

        <!-- Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="./js/modalfunction.js"></script>
        <script src="./js/table.js"></script>

        <link href="./css/datatables.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.min.js"></script>

        <!-- Calculation Result -->
        <script src="./js/calcres.js"></script>
        <script src="./js/sidebarfuntion.js"></script>

        <!-- Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="./js/scripts.js"></script>
        <script src="./js/datatables-simple-demo.js"></script>

        <link href="./css/datatables.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-html5-2.4.2/b-print-2.4.2/datatables.min.js"></script>

        <!-- Calculation Result -->
        <script src="./js/calcres.js"></script>
    </body>
</html> 