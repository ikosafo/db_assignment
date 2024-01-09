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
                        <th width="20%">Product Name</th>
                        <th width="10%">Serial NUmber</th>
                        <th width="10%">Quantity</th>
                        <th width="10%">Reorder Level</th>
                        <th width="10%">Reorder Quantity</th>
                        <th width="10%">Unit Price</th>
                        <th width="10%">Variation</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php

                    // Fetch records from the database
                    $query = "SELECT * FROM dbo.Product";
                    $result = sqlsrv_query($conn, $query);

                    if ($result === false) {
                        echo "Error fetching data: </br>";
                        die(print_r(sqlsrv_errors(), true));
                    }

                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row['productName'] . "</td>";
                        echo "<td>" . $row['serialNo'] . "</td>";
                        echo "<td>" . $row['quantityOnHand'] . "</td>";
                        echo "<td>" . $row['reorderLevel'] . "</td>";
                        echo "<td>" . $row['reorderQuantity'] . "</td>";
                        echo "<td>" . $row['unitPrice'] . "</td>";
                        echo "<td>" . $row['productVariation'] . "</td>";
                        echo "<td>" . getProductDetails($row['productNo']) . "</td>";
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