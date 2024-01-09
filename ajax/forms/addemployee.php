<?php
$random = rand(1, 10) . date("Y-m-d");
?>
<p class="card-text font-small mb-2">
    Add Employee
</p>
<hr />
<section class="horizontal-wizard">
    <div class="bs-stepper horizontal-wizard-example">
        <div class="bs-stepper-header" role="tablist" id="error_loc">
            <div class="step" data-target="#personal-info" role="tab" id="personal-info-trigger">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-box">1</span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Personal Information</span>
                        <span class="bs-stepper-subtitle">Add Personal Info</span>
                    </span>
                </button>
            </div>
            <div class="line">
                <i data-feather="chevron-right" class="font-medium-2"></i>
            </div>
            <div class="step" data-target="#credentials-step" role="tab" id="credentials-step-trigger">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-box">2</span>
                    <span class="bs-stepper-label">
                        <span class="bs-stepper-title">Credentials</span>
                        <span class="bs-stepper-subtitle">Add Passwords</span>
                    </span>
                </button>
            </div>
        </div>
        <div class="bs-stepper-content">
            <div id="personal-info" class="content" role="tabpanel" aria-labelledby="personal-info-trigger">
                <div class="content-header">
                    <h5 class="mb-0">Personal Information</h5>
                    <small class="text-muted">Enter Your Account Details</small>
                </div>
                <form autocomplete="off">
                    <div class="row">
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="Title" />
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="firstname">First Name</label>
                            <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name" />
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="middlename">Middle Name</label>
                            <input type="text" id="middlename" name="middlename" class="form-control" placeholder="Middle Name" />
                        </div>

                    </div>
                    <div class="row">
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="lastname">Last Name</label>
                            <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last Name" />
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="worktelephone">Work Telephone</label>
                            <input type="text" id="worktelephone" name="worktelephone" onkeypress="return isNumber(event)" class="form-control" placeholder="Work Telephone" />
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="hometelephone">Home Telephone</label>
                            <input type="text" id="hometelephone" name="hometelephone" onkeypress="return isNumber(event)" class="form-control" placeholder="Home Telephone" />
                        </div>

                    </div>
                    <div class="row">
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="emailaddress">Email Address</label>
                            <input type="email" id="emailaddress" name="emailaddress" class="form-control" placeholder="Email Address" />
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="ssnitno">Social Security Number</label>
                            <input type="text" id="ssnitno" name="ssnitno" class="form-control" placeholder="Social Security Number" />
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="dateofbirth">Date of Birth</label>
                            <input type="text" id="dateofbirth" name="dateofbirth" class="form-control" placeholder="Date of Birth" />
                        </div>

                    </div>
                    <div class="row">
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="position">Position</label>
                            <input type="text" id="position" name="position" class="form-control" placeholder="Position" />
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="gender">Sex</label>
                            <div class="form-group" id="gender">
                                <div>
                                    <input type="radio" id="selectmale" name="gender" value="Male" class="custom-control-input">
                                    <label class="custom-control-label" for="selectmale">Male</label>

                                    <input type="radio" id="selectfemale" name="gender" value="Female" class="custom-control-input" style="margin-left:10px;margin-top:10px">
                                    <label class="custom-control-label" for="selectfemale">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="salary">Salary</label>
                            <input type="text" id="salary" name="salary" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Salary" />
                        </div>

                    </div>

                    <div class="row">

                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="datestarted">Date Started</label>
                            <input type="text" id="datestarted" name="datestarted" class="form-control" placeholder="Date Started" />
                        </div>
                        <div class="mb-1 col-md-8">
                            <label class="form-label" for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" placeholder="Address"></textarea>
                        </div>

                    </div>

                </form>

                <div class="d-flex justify-content-between">
                    <button class="btn btn-outline-secondary btn-prev" disabled>
                        <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <button class="btn btn-primary btn-next">
                        <span class="align-middle d-sm-inline-block d-none">Next</span>
                        <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                    </button>
                </div>
            </div>

            <div id="credentials-step" class="content" role="tabpanel" aria-labelledby="credentials-step-trigger">
                <div class="content-header">
                    <h5 class="mb-0">Credentials</h5>
                    <small>Enter your passwords</small>
                </div>
                <form>
                    <div class="row">
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Username" />
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="userpassword">Password</label>
                            <input type="password" id="userpassword" name="userpassword" class="form-control" placeholder="Password" />
                        </div>
                        <div class="mb-1 col-md-4">
                            <label class="form-label" for="confirmpassword">Confirm Password</label>
                            <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" placeholder="Confirm Password" />
                        </div>

                    </div>

                </form>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary btn-prev">
                        <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                    </button>
                    <button class="btn btn-success btn-submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    // Page jquery scripts
    $("#dateofbirth").flatpickr();
    $("#datestarted").flatpickr();


    // Add action on form submit
    $(function() {
        "use strict";
        var e = document.querySelectorAll(".bs-stepper"),
            n = $(".select2"),
            i = document.querySelector(".horizontal-wizard-example"),
            r = document.querySelector(".vertical-wizard-example"),
            t = document.querySelector(".modern-wizard-example"),
            o = document.querySelector(".modern-vertical-wizard-example");
        if (void 0 !== typeof e && null !== e)
            for (var l = 0; l < e.length; ++l)
                e[l].addEventListener("show.bs-stepper", function(e) {
                    for (var n = e.detail.indexStep, i = $(e.target).find(".step").length - 1, r = $(e.target).find(".step"), t = 0; t < n; t++) {
                        r[t].classList.add("crossed");
                        for (var o = n; o < i; o++) r[o].classList.remove("crossed");
                    }
                    if (0 == e.detail.to) {
                        for (var l = n; l < i; l++) r[l].classList.remove("crossed");
                        r[0].classList.remove("crossed");
                    }
                });
        if (
            (n.each(function() {
                    var e = $(this);
                    e.wrap('<div class="position-relative"></div>');
                }),
                void 0 !== typeof i && null !== i)
        ) {
            var d = new Stepper(i);
            $(i)
                .find("form")
                .each(function() {
                    $(this).validate({
                        rules: {

                            title: {
                                required: !0
                            },
                            firstname: {
                                required: !0
                            },
                            lastname: {
                                required: !0
                            },
                            worktelephone: {
                                required: !0,
                                digits: true,
                                minlength: 10,
                                maxlength: 10
                            },
                            hometelephone: {
                                required: !0,
                                digits: true,
                                minlength: 10,
                                maxlength: 10
                            },
                            emailaddress: {
                                required: !0,
                                email: !0
                            },
                            ssnitno: {
                                required: !0,
                            },
                            salary: {
                                required: !0,
                            },
                            datestarted: {
                                required: !0,
                            },
                            gender: {
                                required: !0
                            },
                            dateofbirth: {
                                required: !0
                            },
                            position: {
                                required: !0
                            },
                            address: {
                                required: !0
                            },
                            username: {
                                required: !0
                            },
                            password: {
                                required: true,
                                minlength: 6
                            },
                            confirmpassword: {
                                required: !0,
                                equalTo: "#userpassword"
                            },
                        },
                    });
                }),
                $(i)
                .find(".btn-next")
                .each(function() {
                    $(this).on("click", function(e) {
                        //alert('test')
                        $(this).parent().siblings("form").valid() ? d.next() : e.preventDefault();
                    });
                }),
                $(i)
                .find(".btn-prev")
                .on("click", function() {
                    d.previous();
                }),
                $(i)
                .find(".btn-submit")
                .on("click", function() {
                    $(this).parent().siblings("form").valid() && alert("Submitted..!!");
                    var title = $("#title").val();
                    var firstname = $("#firstname").val();
                    var middlename = $("#middlename").val();
                    var lastname = $("#lastname").val();
                    var gender = $('input[name=gender]:checked').val();
                    var worktelephone = $("#worktelephone").val();
                    var hometelephone = $("#hometelephone").val();
                    var emailaddress = $("#emailaddress").val();
                    var ssnitno = $("#ssnitno").val();
                    var dateofbirth = $("#dateofbirth").val();
                    var datestarted = $("#datestarted").val();
                    var address = $("#address").val();
                    var salary = $("#salary").val();
                    var position = $("#position").val();
                    var username = $("#username").val();
                    var password = $("#userpassword").val();
                    var confirmpassword = $("#confirmpassword").val();
                    var random = '<?php echo $random; ?>';
                    //alert(gender);
                    var error = '';
                    if (username == "") {
                        error += 'Please enter username \n';
                        $("#username").focus();
                    }
                    if (password == "") {
                        error += 'Please enter password \n';
                        $("#userpassword").focus();
                    }
                    if (password != "" && password.length < 6) {
                        error += 'Please enter a minimum of 6 characters \n';
                        $("#userpassword").focus();
                    }
                    if (password != "" && confirmpassword == "") {
                        error += 'Please confirm password \n';
                        $("#confirmpassword").focus();
                    }
                    if (password != confirmpassword) {
                        error += 'Please enter same password \n';
                        $("#confirmpassword").focus();
                    }

                    if (error == "") {
                        $.ajax({
                            type: "POST",
                            url: "ajax/queries/save/employee.php",
                            beforeSend: function() {
                                $.blockUI({
                                    message: '<h3 style="margin-top:6px"><img src="https://jquery.malsup.com/block/busy.gif" /> Just a moment...</h3>'
                                });
                            },
                            data: {
                                title,
                                firstname,
                                middlename,
                                lastname,
                                gender,
                                worktelephone,
                                hometelephone,
                                emailaddress,
                                ssnitno,
                                dateofbirth,
                                datestarted,
                                address,
                                salary,
                                position,
                                username,
                                password
                            },
                            success: function(text) {
                                //alert(text);

                                if (text == 1) {
                                    //Load user form
                                    $.ajax({
                                        url: "ajax/forms/addemployee.php",
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
                                    window.location.href = "/viewemployees";

                                } else {
                                    $("#error_loc").notify("Username already exists", {
                                        position: "top"
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
                        $("#error_loc").notify(error, {
                            position: "top"
                        });
                    }
                    return false;



                });
        }


    });
</script>