<?php include('includes/storeheader.php') ?>


<!-- BEGIN: Content-->

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">

        <div class="content-body"><!-- Basic Horizontal form layout section start -->
            <section id="basic-horizontal-layouts">
                <div class="row">
                    <div class="col-md-7 col-12">
                        <div class="card" id="error_loc">
                            <div class="card-header">
                                <h4 class="card-title">Products</h4>
                            </div>
                            <div class="card-body">
                                <div id="pageform_div"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Cart</h4>
                            </div>
                            <div class="card-body">
                                <div id="pagetable_div"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Basic Horizontal form layout section end -->



        </div>
    </div>
</div>

<!-- END: Content-->


<?php include('includes/footer.php') ?>


<script>
    //Load subcategory form
    $.ajax({
        url: "ajax/forms/productsaddcart.php",
        beforeSend: function() {
            $.blockUI({
                message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
            });
        },
        success: function(text) {
            $('#pageform_div').html(text);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + " " + thrownError);
        },
        complete: function() {
            $.unblockUI();
        },

    });


    //Load subcategory table
    $.ajax({
        url: "ajax/tables/viewcart.php",
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
</script>