<?php
include('../../config.php');
?>
<p class="card-text font-small mb-2">
    Add Permission
</p>
<hr />
<form class="form form-horizontal">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <div class="col-sm-3">
                    <label class="col-form-label" for="user">Select Employee/Staff</label>
                </div>
                <div class="col-sm-9">
                    <select class="form-select" id="user">
                        <option></option>
                        <?php

                        $query = "SELECT * FROM dbo.Employee";
                        $getuser = sqlsrv_query($conn, $query);

                        if ($getuser === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        while ($resuser = sqlsrv_fetch_array($getuser, SQLSRV_FETCH_ASSOC)) { ?>
                            <option value="<?php echo $resuser['employeeNo'] ?>"><?php echo $resuser['firstName'] . ' ' . $resuser['middleName'] . ' ' . $resuser['lastName'] ?></option>
                        <?php }

                        sqlsrv_free_stmt($getuser);
                        sqlsrv_close($conn);
                        ?>
                    </select>

                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="mb-1 row">
                <div class="col-sm-3">
                    <label class="col-form-label" for="permissions">Permissions</label>
                </div>
                <div class="col-sm-9">
                    <select class="form-select" id="permissions" multiple>
                        <option value="View and Process Orders">View and Process Orders</option>
                        <option value="Package Order">Package Order</option>
                    </select>

                </div>
            </div>
        </div>

        <div class="col-sm-9 offset-sm-3">
            <button type="button" id="permissionbtn" class="btn btn-primary me-1">Submit</button>
        </div>
    </div>
</form>



<script>
    //Jquery plugins
    $("#user").select2({
        placeholder: "Select Employee",
        allowClear: true
    });

    $("#permissions").select2({
        placeholder: "Select permission(s)",
        allowClear: true
    });

    // Add action on form submit
    $("#permissionbtn").click(function() {

        var permission = $("#permissions").val();
        var user = $("#user").val();
        //alert(permission);


        var error = '';
        if (user == "") {
            error += 'Please select employee \n';
        }
        if (permission == "") {
            error += 'Please select permission \n';
        }

        if (error == "") {
            $.ajax({
                type: "POST",
                url: "ajax/queries/save/permission.php",
                beforeSend: function() {
                    $.blockUI({
                        message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
                    });
                },
                data: {
                    user: user,
                    permission: permission
                },
                success: function(text) {

                    $.ajax({
                        url: "ajax/forms/addpermission.php",
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

                    $.ajax({
                        url: "ajax/tables/permissions.php",
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
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + " " + thrownError);
                },
                complete: function() {
                    $.unblockUI();
                },
            });
        } else {
            $("#error_loc").notify(error, {
                position: "right"
            });
        }
        return false;

    });
</script>