<?php
include('../../config.php');
include('../../system_functions.php');
$getneworderid = date('Ymdhis') . rand(1, 20);
@$newsaleid = $_POST['newsaleid'];

$query = sqlsrv_query($conn, "SELECT * FROM dbo.Product");

if ($query === false) {
    die(print_r(sqlsrv_errors(), true)); // Print the SQLSRV error message
}

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
            <input type="text" id="productsearch" class="form-control" autocomplete="off" placeholder="Search product name">
        </div>
    </form>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="table mt-2 table-sm" id="table-data">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Product</th>
                            <th style="width: 20%;">Quantity</th>
                            <th style="width: 20%;">Price</th>
                            <th style="width: 20%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td>
                                    <?php echo $result['productName']; ?>
                                </td>
                                <td>
                                    <div class="form-group input-group input-group-lg ui-badge cart-item-count">
                                        <input id="product<?php echo $result['productNo']; ?>" type="text" i_index="<?php echo $result['productNo']; ?>" value="1" data-unit-price="<?php echo $result['unitPrice']; ?>" name="quantity" class="form-control input-lg updatequantity" autocomplete="off" />
                                    </div>
                                </td>
                                <td>
                                    <span id="totalPrice"><?php echo $updateprice = $result['unitPrice']; ?></span>
                                </td>
                                </td>

                                <td>
                                    <a i_index="<?php echo $result['productNo']; ?>" href="#" class="addtocartbtn btn btn-primary btn-cart waves-effect waves-float waves-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                        </svg>
                                        <span class="add-to-cart">Add to cart</span>
                                    </a>
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
</section>

<script>
    $(document).ready(function() {
        // DataTable initialization
        var oTable = $('#table-data').DataTable({
            stateSave: true,
            "bLengthChange": false,
            "paging": false,
            'processing': true,
            'serverMethod': 'post'
        });

        // Enable search in the DataTable
        $('#productsearch').on('keyup', function() {
            oTable.search($(this).val()).draw();
        });
    });
    /*  $('#table-data').DataTable({
         "paging": false,
         "searching": false
     });
     // Enable search in the DataTable
     $('#searchtxt').on('keyup', function() {
         oTable.search($(this).val()).draw();
     }); */

    $(document).ready(function() {
        // Initialize TouchSpin for dynamically generated inputs
        $(".updatequantity").each(function() {
            $(this).TouchSpin({
                max: 100,
                min: 1,
                step: 1
            });
        });

        // Function to update price
        function updatePrice() {
            var quantity = parseInt($(this).val()) || 0; // Parse quantity as an integer or default to 0 if parsing fails
            var unitPrice = parseFloat($(this).data('unit-price')) || 0; // Retrieve unit price from the data attribute
            var totalPrice = quantity * unitPrice;
            if (!isNaN(totalPrice)) {
                $(this).closest('tr').find('td:eq(2)').text(totalPrice.toFixed(2)); // Update the product price in the corresponding <td>
            }
        }

        // Listen for changes in quantity input
        $(document).on('input', ".updatequantity", function() {
            updatePrice.call(this);
        });

        // Listen for TouchSpin changes
        $(document).on('change', ".updatequantity", function() {
            updatePrice.call(this);
        });
    });
</script>



<script>
    $(document).ready(function() {
        // Function to handle 'Add to cart' button clicks
        $(document).on('click', '.addtocartbtn', function(e) {
            e.preventDefault(); // Prevent the default action (if any)

            var $row = $(this).closest('tr');
            var productNo = $row.find('.updatequantity').attr('i_index'); // Product Number
            var quantity = $row.find('.updatequantity').val(); // Quantity
            var getneworderid = '<?php echo $getneworderid; ?>';

            $.ajax({
                type: "POST",
                url: "ajax/queries/save/addcart.php",
                data: {
                    productNo,
                    quantity,
                    getneworderid
                },
                dataType: "html",
                success: function(text) {
                    //alert(text);
                    $.ajax({
                        type: "POST",
                        url: "ajax/tables/viewcart.php",
                        data: {
                            neworderid: '<?php echo $getneworderid; ?>'
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


        });
    });
</script>




<script>
    /*    $("input[name='quantity']").on("touchspin.on.startspin", function() {
           var id_index = $(this).attr('i_index');
           var quantity = $("#product" + id_index).val();
           //alert(quantity);
           var newsaleid = '<?php echo $newsaleid; ?>';

           $.ajax({
               type: "POST",
               url: "ajaxscripts/queries/edit/tempsalesquantity.php",
               data: {
                   id_index: id_index,
                   quantity: quantity,
                   newsaleid: newsaleid
               },
               dataType: "html",
               success: function(text) {
                   //alert(text);
                   $.ajax({
                       type: "POST",
                       url: "ajax/tables/productsaddcart.php",
                       data: {
                           neworderid: '<?php echo $getneworderid; ?>'
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
       }); */

    //Temp order 
    /* $(document).on('click', '.addtocartbtn', function() {
        var id_index = $(this).attr('i_index');
        //alert(id_index);
        $.ajax({
            type: "POST",
            url: "ajax/queries/save/addcart.php",
            data: {
                productid: id_index,
                newsaleid: '<?php echo $getnewsaleid; ?>'
            },
            dataType: "html",
            success: function(text) {
                if (text == 2) {
                    $("#error_loc").notify("Item already exists", "error");
                } else {
                    $.ajax({
                        type: "POST",
                        url: "ajax/tables/viewcart.php",
                        data: {
                            id_index: id_index
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

                    $.ajax({
                        type: "POST",
                        url: "ajaxscripts/tables/tempsales.php",
                        data: {
                            newsaleid: '<?php echo $newsaleid; ?>'
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
                }
            },
            complete: function() {},
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + " " + thrownError);
            }
        });
    }); */
</script>