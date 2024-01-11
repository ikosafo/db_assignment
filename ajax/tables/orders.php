<?php
## Database configuration
include('../../config.php');
include("../../system_functions.php");

?>
<section id="datatable">

    <form class="faq-search-input mb-1">
        <div class="input-group input-group-merge">
            <div class="input-group-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
            <input type="text" class="form-control" id="searchtxt" placeholder="Search ...">
        </div>
    </form>

    <div class="row">
        <div class="col-12 ml-5 mr-5">
            <table class="table mt-2 table-md" id="table-data">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Customer Name</th>
                        <th>Customer Telephone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php

                    // Fetch records from the database
                    $query = "SELECT T.*, C.customerName, C.custTelNo
                    FROM dbo.tempOrder T
                    INNER JOIN dbo.Customer C ON T.genNo = C.genNo
                    WHERE T.status IS NULL
                    ORDER BY T.genNo";
                    $result = sqlsrv_query($conn, $query);

                    if ($result === false) {
                        echo "Error fetching data: </br>";
                        die(print_r(sqlsrv_errors(), true));
                    }

                    $prevGenNo = null; // To track the change in genNo

                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . getProductName($conn, $row['productNo']) . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . getProductPrice($conn, $row['productNo']) . "</td>";
                        echo "<td>" . number_format($row['quantity'] * getProductPrice($conn, $row['productNo']), 2) . "</td>";

                        // Display customer-related information only once for each group
                        if ($prevGenNo !== $row['genNo']) {
                            $orderCount = getOrderCountForGenNo($conn, $row['genNo']);

                            echo "<td rowspan='" . $orderCount . "'>" . $row['customerName'] . "</td>";
                            echo "<td rowspan='" . $orderCount . "'>" . $row['custTelNo'] . "</td>";
                            echo "<td rowspan='" . $orderCount . "'>" . processOrder($row['genNo']) . "</td>";
                        }

                        echo "</tr>";

                        // Update prevGenNo
                        $prevGenNo = $row['genNo'];
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<!--/ Basic table -->

<script>
    $(document).ready(function() {
        // DataTable initialization
        var oTable = $('#table-data').DataTable({
            stateSave: true,
            "bLengthChange": false,
            dom: "Bfrtip",
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "sDom": '<"top"ip>rt<"bottom"fl><"clear">',
            'processing': true,
            'serverMethod': 'post'
        });

        // Enable search in the DataTable
        $('#searchtxt').on('keyup', function() {
            oTable.search($(this).val()).draw();
        });
    });
</script>