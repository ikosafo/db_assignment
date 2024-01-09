<?php
include('../../config.php');
include('../../system_functions.php');

@$neworderid = $_POST['neworderid'];

if ($neworderid == "") {
    echo "No product available in cart";
} else {
    // Fetch records from the database
    $query = "SELECT * FROM dbo.tempOrder where genNo = '$neworderid'";
    $result = sqlsrv_query($conn, $query);

    if ($result === false) {
        echo "Error fetching data: </br>";
        die(print_r(sqlsrv_errors(), true));
    }

    // Check if there are any products in the cart
    if (sqlsrv_has_rows($result)) {
?>
        <style>
            .tempsales_table td {
                font-size: 14px;
            }
        </style>
        <div class="table-responsive">
            <table class="table table-sm tempsales_table">
                <tbody>
                    <?php
                    // Initialize total variable
                    $total = 0;

                    // Fetch records from the database
                    $query = "SELECT * FROM dbo.tempOrder where genNo = '$neworderid'";
                    $result = sqlsrv_query($conn, $query);

                    if ($result === false) {
                        echo "Error fetching data: </br>";
                        die(print_r(sqlsrv_errors(), true));
                    }

                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        // Calculate individual total price
                        $totalprice = getProductPrice($conn, $row['productNo']) * $row['quantity'];
                        $total += $totalprice; // Accumulate the total
                    ?>
                        <tr>
                            <td>
                                <?php echo getProductName($conn, $row['productNo']); ?>
                            </td>
                            <td>
                                <?php echo number_format($totalprice, 2); ?>
                            </td>
                            <td>
                                <div class="text-center">
                                    <a href="#" class="removefromcart" title="Remove from cart" i_index=<?php echo $row['temSalesNo'] ?>>
                                        Remove
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                    <!-- Display total after the loop -->
                    <tr>
                        <td><b>TOTAL</b></td>
                        <td colspan=" 2">
                            <strong>
                                GHS <?php echo number_format($total, 2); ?>
                            </strong>
                        </td>
                    </tr>


                </tbody>
            </table>
        </div>
        <a id="proceedtocheckout" class="mt-2 btn btn-primary w-100 waves-effect waves-float waves-light" href="#">Proceed to Checkout</a>
<?php
    } else {
        echo "No product available in cart";
    }
}
?>



<script>
    $(document).off('click', '.removefromcart').on('click', '.removefromcart', function() {
        var theindex = $(this).attr('i_index');
        //alert(theindex);

        $.confirm({
            title: 'Remove from cart?',
            content: 'Are you sure to continue?',
            buttons: {
                no: {
                    text: 'No',
                    keys: ['enter', 'shift'],
                    backdrop: 'static',
                    keyboard: false,
                    action: function() {
                        $.alert('Data is safe');
                    }
                },
                yes: {
                    text: 'Yes, Remove it!',
                    btnClass: 'btn-blue',
                    action: function() {
                        $.ajax({
                            type: "POST",
                            url: "ajax/queries/delete/removefromcart.php",
                            data: {
                                i_index: theindex
                            },
                            dataType: "html",
                            success: function(text) {
                                $.ajax({
                                    type: "POST",
                                    url: "ajax/tables/viewcart.php",
                                    data: {
                                        neworderid: '<?php echo $neworderid; ?>'
                                    },
                                    beforeSend: function() {
                                        $.blockUI({
                                            message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
                                        });
                                    },
                                    success: function(text) {
                                        $('#pagetable_div').html(text);
                                    },
                                    error: function(xhr, ajaxOptions, thrownError) {
                                        alert(xhr.status + " " + thrownError);
                                    },
                                    complete: function() {
                                        $.unblockUI();
                                    },

                                });
                            },

                            complete: function() {},
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            }
                        });
                    }
                }
            }
        });


    });

    $("#proceedtocheckout").click(function() {
        var total = '<?php echo $total ?>';
        var neworderid = '<?php echo $neworderid ?>';
        //alert(total + ' ' + neworderid);

        $.ajax({
            url: "ajax/forms/customerorder.php",
            data: {
                total: total,
                neworderid: neworderid
            },
            beforeSend: function() {
                $.blockUI({
                    message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
                });
            },
            success: function(text) {
                // Update the text within the .card-title element
                $('.card-title').text('Customer Details');
                $('#pageform_div').html(text);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>