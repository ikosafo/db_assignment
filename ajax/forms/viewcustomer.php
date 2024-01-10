<?php
include('../../config.php');
include('../../system_functions.php');
$theid = $_POST['id_index'];

// Define the SQL query with a parameter placeholder
$query = "SELECT * FROM dbo.Customer WHERE customerNo = ?";

// Prepare the SQL query
$stmt = sqlsrv_prepare($conn, $query, array(&$theid));

// Execute the prepared statement
$result = sqlsrv_execute($stmt);

if ($result === false) {
    echo "Error fetching data: </br>";
    die(print_r(sqlsrv_errors(), true));
}

// Check if any row is returned
if (sqlsrv_has_rows($stmt)) {
    // Fetch the row
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
} else {
    echo "No customer found with the given ID.";
}

$neworderid = $row['genNo'];
$queryTable = "SELECT * FROM dbo.tempOrder WHERE genNo = ?";
$stmtTable = sqlsrv_prepare($conn, $queryTable, array(&$neworderid));

if (!$stmtTable) {
    // Check for query preparation failure
    die(print_r(sqlsrv_errors(), true));
}

$resultTable = sqlsrv_execute($stmtTable);

if ($resultTable === false) {
    // Check for query execution failure
    die(print_r(sqlsrv_errors(), true));
}
$rows = array();


?>

<div class="card">
    <div class="card-body">

        <h4 class="fw-bolder border-bottom pb-50 mb-1">View Customer Details</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="info-container">
                    <ul class="list-unstyled">
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Customer Name:</span>
                            <span><?php echo $row['customerName']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Street:</span>
                            <span><?php echo $row['customerStreet']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">City:</span>
                            <span><?php echo $row['customerCity']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">State:</span>
                            <span><?php echo $row['customerState']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Zip Code:</span>
                            <span><?php echo $row['customerZipCode']; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-container">
                    <ul class="list-unstyled">
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Telephone:</span>
                            <span><?php echo $row['custTelNo']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Fax Number:</span>
                            <span><?php echo $row['custFaxNo']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Date of Birth:</span>
                            <span><?php echo $row['DOB']->format('Y-m-d'); ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Marital Status:</span>
                            <span><?php echo $row['maritalStatus']; ?></span>
                        </li>
                        <li class="mb-75">
                            <span class="fw-bolder me-25">Credit Rating:</span>
                            <span><?php echo $row['creditRating']; ?></span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>


        <div class="invoice-print">

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
                        $totalprice = 0; // Initialize total price variable
                        $count = 1;
                        while ($rowTable = sqlsrv_fetch_array($stmtTable, SQLSRV_FETCH_ASSOC)) {
                            // Push each fetched row into the $rows array
                            $rows[] = $rowTable;
                            // Calculate individual total for each row
                            $individualTotal = $rowTable['quantity'] * getProductPrice($conn, $rowTable['productNo']);
                            // Add individual total to the total price
                            $totalprice += $individualTotal;
                        ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $count; ?></td>
                                <td class="py-1 ps-4">
                                    <p class="fw-semibold" style="margin-bottom: 0rem;">
                                        <?php
                                        echo $productname = getProductName($conn, $rowTable['productNo']);
                                        $cleaned_product = str_replace("'", "", $productname);
                                        ?>
                                    </p>
                                </td>
                                <td class="py-1"><?php echo $rowTable['quantity']; ?></td>
                                <td class="py-1"><?php echo getProductPrice($conn, $rowTable['productNo']); ?></td>
                                <td class="py-1">
                                    <?php echo "GHS " . $rowTable['quantity'] * getProductPrice($conn, $rowTable['productNo']); ?>
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
                                <strong>Total : <?php echo "GHS " . number_format($totalprice, 2); ?></strong>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>


        </div>

        <div class="row">
            <div class="col-sm-12 offset-sm-12 mt-2">
                <button type="button" id="backtocustomers" class="btn btn-outline-primary waves-effect">
                    Back to customers</button>
            </div>
        </div>

    </div>
</div>


<script>
    $("#backtocustomers").click(function() {
        window.location.href = "/viewcustomers";
    });
</script>