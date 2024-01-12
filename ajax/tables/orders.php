<?php
## Database configuration
include('../../config.php');
include("../../system_functions.php");

?>
<section id="order-datatable">

    <form class="faq-search-input mb-1">
        <div class="input-group input-group-merge">
            <div class="input-group-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
            <input type="text" class="form-control" id="order-searchtxt" placeholder="Search ...">
        </div>
    </form>

    <div class="row">
        <div class="col-12 ml-5 mr-5">
            <table class="table mt-2 table-md" id="order-table-data">
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
                <tbody id="order-tableBody">
                    <?php

                    // Execute the stored procedure
                    $execProcedure = "EXEC GetOrderData";
                    $execStmt = sqlsrv_query($conn, $execProcedure);

                    if ($execStmt === false) {
                        echo "Error executing stored procedure: </br>";
                        foreach (sqlsrv_errors() as $error) {
                            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                            echo "Code: " . $error['code'] . "<br />";
                            echo "Message: " . $error['message'] . "<br />";
                        }
                        die();
                    }

                    while ($row = sqlsrv_fetch_array($execStmt, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . getProductName($conn, $row['productNo']) . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['unitPrice'] . "</td>";
                        echo "<td>" . number_format($row['quantity'] * $row['unitPrice'], 2) . "</td>";
                        echo "<td>" . $row['customerName'] . "</td>";
                        echo "<td>" . $row['custTelNo'] . "</td>";
                        echo "<td>" . processOrder($row['genNo']) . "</td>";
                        echo "</tr>";
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
        var oTable = $('#order-table-data').DataTable({
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
        $('#order-searchtxt').on('keyup', function() {
            oTable.search($(this).val()).draw();
        });
    });
</script>