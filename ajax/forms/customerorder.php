<?php
include('../../config.php');

$total = $_GET['total'];
$neworderid = $_GET['neworderid'];
?>

<form autocomplete="off">

    <div class="row">
        <div class="mb-1 col-md-12">
            <label class="form-label" for="customername">Customer Full Name</label>
            <input type="text" id="customername" name="customername" class="form-control" placeholder="Customer Name" />
        </div>
        <div class="mb-1 col-md-6">
            <label class="form-label" for="customerstreet">Street Address</label>
            <input type="text" id="customerstreet" name="customerstreet" class="form-control" placeholder="Street Address" />
        </div>
        <div class="mb-1 col-md-6">
            <label class="form-label" for="customercity">City</label>
            <input type="text" id="customercity" name="customercity" class="form-control" placeholder="City" />
        </div>
        <div class="mb-1 col-md-6">
            <label class="form-label" for="customerstate">State</label>
            <input type="text" id="customerstate" name="customerstate" class="form-control" placeholder="State" />
        </div>
        <div class="mb-1 col-md-6">
            <label class="form-label" for="customerzipcode">Zip Code</label>
            <input type="text" id="customerzipcode" onkeypress="return isNumber(event)" name="customerzipcode" class="form-control" placeholder="Zip Code" />
        </div>
        <div class="mb-1 col-md-6">
            <label class="form-label" for="custtelno">Telephone Number</label>
            <input type="tel" id="custtelno" onkeypress="return isNumber(event)" name="custtelno" class="form-control" placeholder="Telephone Number" />
        </div>
        <div class="mb-1 col-md-6">
            <label class="form-label" for="custfaxno">Fax Number</label>
            <input type="tel" id="custfaxno" onkeypress="return isNumber(event)" name="custfaxno" class="form-control" placeholder="Fax Number" />
        </div>
        <div class="mb-1 col-md-6">
            <label class="form-label" for="customerdob">Date of Birth</label>
            <input type="text" id="customerdob" name="customerdob" class="form-control" placeholder="Select Date of birth" />
        </div>
        <div class="mb-1 col-md-6">
            <label class="form-label" for="customermaritalstatus">Marital Status</label>
            <select class="form-select" id="customermaritalstatus">
                <option></option>
                <option value="Married">Married</option>
                <option value="Single">Single</option>
                <option value="Divorced">Divorced</option>
                <option value="Separated">Separated</option>
            </select>

        </div>
    </div>

    <hr>

    <div class="row">

        <div class="mb-1 col-md-12">
            <label class="form-label" for="payment_method">Payment Method</label>
            <select class="form-select" id="payment_method">
                <option></option>
                <option value="Credit/Debit Card">Credit/Debit Card</option>
                <option value="Mobile Wallet">Mobile Wallet</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Cash">Cash</option>
                <option value="Other">Other</option>
            </select>

        </div>
    </div>

    <div class="d-flex justify-content-between mt-2">
        <button class="btn btn-warning btn-prev waves-effect" id="viewcart">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left align-middle me-sm-25 me-0">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span class="align-middle d-sm-inline-block d-none">Back to Cart</span>
        </button>
        <button id="customerorderbtn" class="btn btn-primary waves-effect waves-float waves-light">
            <span class="align-middle d-sm-inline-block d-none">Complete Order</span>
        </button>
    </div>

</form>


<script>
    //$("#expirydate").flatpickr();

    $("#payment_method").select2({
        placeholder: "Select Method",
        allowClear: true
    });

    $("#customermaritalstatus").select2({
        placeholder: "Select Marital Status",
        allowClear: true
    });

    $("#customerdob").flatpickr();


    $("#customerorderbtn").on("click", (function() {
        var customername = $("#customername").val();
        var customerstreet = $("#customerstreet").val();
        var customercity = $("#customercity").val();
        var customerstate = $("#customerstate").val();
        var customerzipcode = $("#customerzipcode").val();
        var custtelno = $("#custtelno").val();
        var custfaxno = $("#custfaxno").val();
        var customerdob = $("#customerdob").val();
        var customermaritalstatus = $("#customermaritalstatus").val();
        var payment_method = $("#payment_method").val();
        var neworderid = '<?php echo $neworderid; ?>';
        var total = '<?php echo $total; ?>';

        var error = '';

        if (customername.trim() === "") {
            error += 'Please enter customer name\n';
            $("#customername").focus();
        }
        if (customerstreet.trim() === "") {
            error += 'Please enter street\n';
            $("#customerstreet").focus();
        }
        if (customercity.trim() === "") {
            error += 'Please enter city\n';
            $("#customercity").focus();
        }
        if (customerstate.trim() === "") {
            error += 'Please enter state\n';
            $("#customerstate").focus();
        }
        if (customerzipcode.trim() === "") {
            error += 'Please enter zip\n';
            $("#customerzipcode").focus();
        }
        if (custtelno.trim() === "") {
            error += 'Please enter telephone number\n';
            $("#custtelno").focus();
        }
        if (custfaxno.trim() === "") {
            error += 'Please enter fax number\n';
            $("#custfaxno").focus();
        }
        if (customerdob.trim() === "") {
            error += 'Please enter date of birth\n';
            $("#customerdob").focus();
        }
        if (customermaritalstatus.trim() === "") {
            error += 'Please select marital status\n';
            $("#customermaritalstatus").focus();
        }
        if (payment_method.trim() === "") {
            error += 'Please select payment method\n';
            $("#payment_method").focus();
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/save/customerorder.php",
                beforeSend: function() {
                    $.blockUI({
                        message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
                    });
                },
                data: {
                    customername,
                    customerstreet,
                    customercity,
                    customerstate,
                    customerzipcode,
                    custtelno,
                    custfaxno,
                    customerdob,
                    customermaritalstatus,
                    payment_method,
                    neworderid,
                    total

                },
                success: function(text) {
                    //alert(text);

                    var form = $('<form action="printorderinvoice.php" method="POST"></form>');
                    form.append('<input type="hidden" name="neworderid" value="' + neworderid + '">');
                    form.append('<input type="hidden" name="total" value="' + total + '">'); // Adding total as a hidden input


                    // Append the form to the body and submit it
                    $('body').append(form);
                    form.submit();

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

    }));
</script>