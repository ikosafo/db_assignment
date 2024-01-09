<?php
include('../../config.php');
$random = rand(1, 10) . date("Y-m-d");

// $id_index contains the product number
$id_index = $_POST['id_index'];

// Define the SQL query with a parameter placeholder
$query = "SELECT * FROM dbo.Product WHERE productNo = ?";

// Prepare the SQL query
$stmt = sqlsrv_prepare($conn, $query, array(&$id_index));

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
    echo "No product found with the given ID.";
}
?>

<form autocomplete="off">

    <div class="row">
        <div class="mb-1 col-md-4">
            <label class="form-label" for="productname">Product Name</label>
            <input type="text" id="productname" class="form-control" placeholder="Product Name" value="<?php echo $row['productName']; ?>" />
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="quantity">Quantity on Hand</label>
            <input type="text" id="quantity" class="form-control" onkeypress="return isNumber(event)" placeholder="Quantity" value="<?php echo $row['quantityOnHand']; ?>" />
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="serialnumber">Serial Number</label>
            <input type="text" id="serialnumber" class="form-control" placeholder="Serial Number" value="<?php echo $row['serialNo']; ?>" />
        </div>
    </div>

    <div class="row">
        <div class="mb-1 col-md-4">
            <label class="form-label" for="reorderlevel">Reorder Level</label>
            <input type="text" id="reorderlevel" class="form-control" onkeypress="return isNumber(event)" placeholder="Reorder Level" value="<?php echo $row['reorderLevel']; ?>" />
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="reorderquantity">Reorder Quantity</label>
            <input type="text" id="reorderquantity" class="form-control" onkeypress="return isNumber(event)" placeholder="Reorder Quantity" value="<?php echo $row['reorderQuantity']; ?>" />
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="leadtime">Reorder Lead Time (in days):</label>
            <input type="number" min="1" id="leadtime" class="form-control" placeholder="Reorder Lead Time" value="<?php echo $row['reorderLeadTime']; ?>" />
        </div>
    </div>

    <div class="row">

        <!--  <div class="mb-1 col-md-4">
            <label class="form-label" for="expirydate">Expiry Date</label>
            <input type="text" id="expirydate" class="form-control" placeholder="Expiry Date" />
        </div> -->
        <div class="mb-1 col-md-4">
            <label class="form-label" for="variations">Variations</label>
            <input type="text" id="variations" class="form-control" placeholder="Specify Variations" value="<?php echo $row['productVariation']; ?>" />
        </div>
        <div class="mb-1 col-md-4">
            <label class="form-label" for="sellingprice">Unit Price </label>
            <input type="text" id="sellingprice" onkeypress="return isNumberKey(event)" class="form-control" placeholder="Unit Price" value="<?php echo $row['unitPrice']; ?>" />
        </div>

    </div>

    <div class="d-flex justify-content-between mt-2">
        <button class="btn btn-success btn-prev waves-effect" id="viewproductsbtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left align-middle me-sm-25 me-0">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span class="align-middle d-sm-inline-block d-none">Back to View Products</span>
        </button>
        <button id="productinfobtn" class="btn btn-warning waves-effect waves-float waves-light">
            <span class="align-middle d-sm-inline-block d-none">Edit Product</span>
        </button>
    </div>

</form>


<script>
    //$("#expirydate").flatpickr();

    $("#viewproductsbtn").click(function() {
        window.location.href = '/viewproducts';
    })

    //PRODUCT INFORMATION
    $("#productinfobtn").on("click", (function() {

        var productname = $("#productname").val();
        var quantity = $("#quantity").val();
        var serialnumber = $("#serialnumber").val();
        var reorderlevel = $("#reorderlevel").val();
        var reorderquantity = $("#reorderquantity").val();
        var leadtime = $("#leadtime").val();
        //var expirydate = $("#expirydate").val();
        var variations = $("#variations").val();
        var sellingprice = $("#sellingprice").val();
        var random = '<?php echo $random; ?>';
        var id_index = '<?php echo $id_index ?>';

        var error = '';

        if (productname == "") {
            error += 'Please enter product name \n';
            $("#productname").focus();
        }
        if (quantity == "") {
            error += 'Please enter quantity \n';
            $("#quantity").focus();
        }
        if (serialnumber == "") {
            error += 'Please enter serial number \n';
            $("#serialnumber").focus();
        }
        if (reorderlevel == "") {
            error += 'Please enter Reorder level \n';
            $("#reorderlevel").focus();
        }
        if (reorderquantity == "") {
            error += 'Please enter Reorder quantity \n';
            $("#reorderquantity").focus();
        }
        if (leadtime == "") {
            error += 'Please enter Reorder lead time \n';
            $("#leadtime").focus();
        }
        if (variations == "") {
            error += 'Please specify variations \n';
            $("#variations").focus();
        }
        if (sellingprice == "") {
            error += 'Please enter selling price \n';
            $("#sellingprice").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/edit/product.php",
                beforeSend: function() {
                    $.blockUI({
                        message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
                    });
                },
                data: {
                    id_index,
                    productname,
                    quantity,
                    serialnumber,
                    reorderlevel,
                    reorderquantity,
                    leadtime,
                    //expirydate,
                    variations,
                    sellingprice,
                    random
                },
                success: function(text) {
                    //alert(text);

                    if (text == 1) {
                        $.notify("Product Edited", "success", {
                            position: "top center"
                        });
                        $.ajax({
                            url: "ajax/tables/productsview.php",
                            success: function(text) {
                                $('#productsviewdiv').html(text);
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + " " + thrownError);
                            },
                        });
                        window.location.href = '/viewproducts';

                    } else {
                        $.notify("Product already exists", "error", {
                            position: "top center"
                        });
                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                },
                complete: function() {
                    $.unblockUI();
                },
            });
        } else {
            $.notify(error, {
                position: "top center"
            });
        }
        return false;

    }))
</script>