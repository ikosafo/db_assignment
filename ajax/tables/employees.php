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
                        <th width="20%">Full Name</th>
                        <th width="10%">Phone Numbers</th>
                        <th width="10%">Email Address</th>
                        <th width="10%">Social Security</th>
                        <th width="10%">Date of Birth</th>
                        <th width="10%">Position</th>
                        <th width="10%">Sex</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php

                    // Fetch records from the database
                    $query = "SELECT * FROM dbo.Employee";
                    $result = sqlsrv_query($conn, $query);

                    if ($result === false) {
                        echo "Error fetching data: </br>";
                        die(print_r(sqlsrv_errors(), true));
                    }

                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row['title'] . " " . $row['firstName'] . " " . $row["lastName"] . " " . $row['middleName'] . "</td>";
                        echo "<td>" . $row['workTelExt'] . "<br/>" . $row['homeTelNo'] . "</td>";
                        echo "<td>" . $row['empEmailAddress'] . "</td>";
                        echo "<td>" . $row['socialSecurityNumber'] . "</td>";
                        echo "<td>" . $row['DOB']->format('Y-m-d') . "</td>";
                        echo "<td>" . $row['position'] . "</td>";
                        echo "<td>" . $row['sex'] . "</td>";
                        echo "<td>" . getUserDetails($row['employeeNo']) . "</td>";
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