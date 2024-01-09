<?php

include('config.php');
include("system_functions.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $neworderid = $_POST['neworderid'];
    $totalprice = $_POST['total'];

    $getCustomer = "SELECT * FROM dbo.Customer WHERE genNo = ?";
    $res = sqlsrv_prepare($conn, $getCustomer, array(&$neworderid));

    if ($res === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_execute($res)) {
        $row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC);
        if ($row !== null) {
            $customerName = $row['customerName'];
            $customerTel = $row['custTelNo'];
            // Use $customerName as needed
            //echo "Customer Name: " . $customerName;
        } else {
            echo "No customer found for the provided genNo";
        }
    } else {
        die(print_r(sqlsrv_errors(), true));
    }




    $getpm = "SELECT * FROM dbo.PaymentMethod WHERE genNo = ?";
    $respm = sqlsrv_prepare($conn, $getpm, array(&$neworderid));

    if ($respm === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_execute($respm)) {
        $row = sqlsrv_fetch_array($respm, SQLSRV_FETCH_ASSOC);
        if ($row !== null) {
            $paymentMethod = $row['paymentMethod'];
        } else {
            echo "No payment method found for the provided genNo";
        }
    } else {
        die(print_r(sqlsrv_errors(), true));
    }


    $query = "SELECT * FROM dbo.tempOrder WHERE genNo = ?";
    $stmt = sqlsrv_prepare($conn, $query, array(&$neworderid));

    if (!$stmt) {
        // Check for query preparation failure
        die(print_r(sqlsrv_errors(), true));
    }

    $result = sqlsrv_execute($stmt);

    if ($result === false) {
        // Check for query execution failure
        die(print_r(sqlsrv_errors(), true));
    }

    // Reset the pointer to the beginning of the result set
    // Fetch all rows into an array
    $rows = array();
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $temSalesNo = $row['temSalesNo'];
        $length = 5;
        $string = substr(str_repeat(0, $length) . $temSalesNo, -$length);
        $invoiceid = $string . '' . date('y');
        $rows[] = $row;
        $date = date('Y-m-d H:i:s');
    }
}
?>

<script>
    window.print();

    // Store the current URL before printing
    var originalUrl = window.location.href;

    // Add event listener for before printing
    window.onbeforeprint = function() {
        // Your code before printing, if needed
    };

    // Add event listener for after printing
    window.onafterprint = function() {
        // Redirect to a different page after printing
        window.location.href = "/product_store";
    };

    // Handle the case where the user cancels the print dialog
    // You can't directly detect this action using JavaScript
    // So, you can use a timeout to check if the URL is still the same
    var timeout = setTimeout(function() {
        if (window.location.href === originalUrl) {
            // Redirect if the URL is still the same (print dialog was cancelled)
            window.location.href = "/product_store";
        }
    }, 30500); // Adjust the timeout duration as needed
</script>



<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>Print Order</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.html">
    <link rel="shortcut icon" type="image/x-icon" href="">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/bordered-layout.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-wizard.min.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/dashboard-ecommerce.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/charts/chart-apex.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/extensions/ext-component-toastr.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/uploadifive/uploadifive.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/jquery-confirm.min.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Custom CSS-->

    <style>
        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }
    </style>


</head>

<body>

    <!-- BEGIN: Content-->
    <div class="app-content content" style="margin-left:0;padding:0">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">

            <div class="content-body">
                <div class="invoice-print p-3">

                    <div class="header mb-3">
                        <h2>Order Invoice</h2>
                    </div>
                    <div class="invoice-header d-flex justify-content-between flex-md-row flex-column pb-2">
                        <div>
                            <div class="d-flex" style="display: flex; gap:10px">


                                <div class="mt-1">
                                    <h4 class="text-primary fw-bold"><?php echo getCompanyName($conn); ?></h4>
                                    <p class="mb-25" style="margin-top: -9px;"><?php echo getCompanyTagline($conn); ?></p>
                                </div>
                            </div>

                            <div class="mt-1">
                                <p class="mb-0">Address: <?php echo getCompanyAddress($conn); ?></p>
                                <p class="mb-0">Tel: <?php echo getCompanyTelephone($conn); ?></p>
                                <p class="mb-0">Email: <?php echo getCompanyEmail($conn); ?></p>
                                <p class="mb-0">Whatsapp: <?php echo getCompanyWhatsapp($conn); ?></p>
                            </div>

                        </div>

                        <div class="mt-md-0 mt-1">
                            <h4 class="fw-bold mt-1">INVOICE <?php echo $invoiceid ?></h4>
                            <div class="invoice-date-wrapper mb-25">
                                <span class="invoice-date-title">Date Issued:</span>
                                <span class="fw-bold">
                                    <?php echo $convertedDate = date("d-M-Y", strtotime($date)); ?>
                                </span>
                            </div>
                            <div class="invoice-date-wrapper mb-25">
                                <span class="invoice-date-title">Attendant:</span>
                                <span class="fw-bold" style="text-transform: uppercase;">
                                    <!-- Customer here -->
                                </span>
                            </div>
                            <hr>
                            <p class="mb-25">Customer: <span class="fw-bold"><?php echo $customerName; ?></span></p>
                            <p class="mb-25">Telephone: <span class="fw-bold"><?php echo  $customerTel; ?></span></p>
                        </div>
                    </div>

                    <hr class="my-2">

                    <div class="table-responsive mt-2">
                        <table class="table m-0 table-sm">
                            <thead>
                                <tr>
                                    <th class="py-1 ps-4" width="5%">No.</th>
                                    <th class="py-1 ps-4">Item</th>
                                    <th class="py-1">Qty</th>
                                    <th class="py-1">Unit Price</th>
                                    <th class="py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $count = 1;
                                foreach ($rows as $row) { ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $count; ?></td>
                                        <td class="py-1 ps-4">
                                            <p class="fw-semibold" style="margin-bottom: 0rem;">
                                                <?php
                                                echo $productname = getProductName($conn, $row['productNo']);
                                                $cleaned_product = str_replace("'", "", $productname);
                                                ?>
                                            </p>
                                        </td>
                                        <td class="py-1"><?php echo $row['quantity']; ?></td>
                                        <td class="py-1"><?php echo getProductPrice($conn, $row['productNo']); ?></td>
                                        <td class="py-1">
                                            <?php echo "GHS " . $row['quantity'] * getProductPrice($conn, $row['productNo']); ?>
                                        </td>
                                    </tr>
                                <?php
                                    $count++;
                                }
                                ?>

                                <!-- Include the total price row here -->
                                <tr>
                                    <td colspan="4"></td>
                                    <td class="py-1">
                                        <strong><?php echo "GHS " . number_format($totalprice, 2); ?></strong>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            Payment Method: <?php echo $paymentMethod; ?>
                        </div>

                    </div>


                    <div class="row invoice-sales-total-wrapper mt-3">
                        <div class="col-md-4 order-md-1 order-2 mt-md-0 mt-3">
                            <p class="card-text mb-50">
                                <span class="fw-bold">CUSTOMER:</span> <br />
                            </p>
                            <p class="mb-25">Name: <?php echo $customerName ?></p>
                            <p class="mb-25">Sign:</p>
                            <p class="mb-0">Tel: </p>
                        </div>
                        <div class="col-md-4 order-md-1 order-2 mt-md-0 mt-3">
                            <p class="card-text mb-50">
                                <span class="fw-bold">DISPATCHED BY:</span> <br />
                            </p>
                            <p class="mb-25">Name:</p>
                            <p class="mb-25">Sign:</p>
                            <p class="mb-0">Tel: </p>
                        </div>
                        <div class="col-md-4 order-md-1 order-2 mt-md-0 mt-3">
                            <p class="card-text mb-50">
                                <span class="fw-bold">MANAGER:</span> <br />
                            </p>
                            <p class="mb-25">Name:</p>
                            <p class="mb-25">Sign:</p>
                            <p class="mb-0">Tel: </p>
                        </div>
                    </div>

                    <hr class="my-2">

                    <div class="row">
                        <div class="col-12">
                            <span class="fw-bold">Note: Goods sold are not refundable</span> <br />
                            <p class="mt-2">We appreciate your patronage at <?php echo getCompanyName($conn); ?>.
                                Your support means a lot to us. Thank you for choosing our products.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

<!-- END: Content-->


<!-- BEGIN: Vendor JS-->
<script src="../../../app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="../../../app-assets/vendors/js/charts/apexcharts.min.js"></script>
<script src="../../../app-assets/vendors/js/extensions/toastr.min.js"></script>
<script src="../../../app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
<script src="../../../app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
<script src="../../../app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
<script src="../../../app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js"></script>
<script src="../../../app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
<script src="../../../app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
<script src="../../../app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
<script src="../../../app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
<script src="../../../app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
<script src="../../../app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
<script src="../../../app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
<script src="../../../app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js"></script>
<script src="../../../app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
<script src="../../../app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="../../../app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
<script src="../../../app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script src="../../../app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="../../../app-assets/js/core/app-menu.min.js"></script>
<script src="../../../app-assets/js/core/app.min.js"></script>
<script src="../../../app-assets/js/scripts/customizer.min.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="../../../app-assets/js/scripts/pages/dashboard-ecommerce.min.js"></script>
<!-- END: Page JS-->
<script src="../../../app-assets/uploadifive/jquery.uploadifive.js"></script>
<script src="../../../app-assets/js/scripts/components/notify.js"></script>
<script src="../../../app-assets/js/scripts/components/jquery.blockUI.js"></script>

<script src="../../../app-assets/js/scripts/tables/table-datatables-basic.min.js"></script>
<script src="../../../app-assets/js/scripts/components/components-tooltips.min.js"></script>
<script src="../../../app-assets/js/scripts/jquery-confirm.min.js"></script>
<script src="../../../app-assets/js/scripts/forms/form-number-input.min.js"></script>

<!-- <script src="../../../app-assets/js/scripts/forms/form-wizard.min.js"></script> -->


<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
</body>
<!-- END: Body-->

</html>