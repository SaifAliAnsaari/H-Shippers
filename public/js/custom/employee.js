$(document).ready(function() {

    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    var segments = location.href.split('/');
    var action = segments[3];
    if (action == 'edit_profile'){

    }else{
        fetchEmployeesList();
    }
    
    var lastOp = "add";

    $(document).on('click', '.openDataSidebarForAddingEmployee', function() {
        $('#dataSidebarLoader').hide();
        if (lastOp == "update") {

            $('input[name="name"]').val("");
            $('input[name="name"]').blur();

            $('input[name="phone"]').val("");
            $('input[name="phone"]').blur();

            $('input[name="email"]').val("");
            $('input[name="email"]').blur();

            $('input[name="cnic"]').val("");
            $('input[name="cnic"]').blur();

            $('input[name="city"]').val("");
            $('input[name="city"]').blur();

            $('input[name="address"]').val("");
            $('input[name="address"]').blur();

            $('input[name="username"]').val("");
            $('input[name="username"]').blur();

            $('input[name="hiring"]').val("");

            $('input[name="salary"]').val("");
            $('input[name="salary"]').blur();

            $('input[name="home_phone"]').val("");
            $('input[name="home_phone"]').blur();

            $('input[name="ice_num"]').val("");
            $('input[name="ice_num"]').blur();

            $('input[name="base_station"]').val("");
            $('input[name="base_station"]').blur();

            $('select[name="designation"]').val(0).trigger('change');
            $('select[name="reporting"]').val(0).trigger('change');
        }
        lastOp = 'add';
        $('#operation').val('add');
        $('#product-cl-sec').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        $('body').toggleClass('no-scroll');
        $('#dropifyImgDiv').empty();
        $('#dropifyImgDiv').append('<input type="file" name="employeePicture" id="employeePicture" />');
        $('#employeePicture').dropify();
    });


    $(document).on('click', '.openDataSidebarForUpdateEmployee', function() {
        //$('#operation').val('update');
        $('input[name="operation"]').val('update');
        lastOp = 'update';
        $('#dataSidebarLoader').show();
        $('._cl-bottom').hide();
        $('.pc-cartlist').hide();

        $('#dropifyImgDiv').empty();
        $('#dropifyImgDiv').append('<input type="file" name="employeePicture" id="employeePicture" />');

        var id = $(this).attr('id');
        $('input[name="employee_updating_id"]').val(id)
        $.ajax({
            type: 'GET',
            url: '/Employee/' + id,
            success: function(response) {
                var response = JSON.parse(response);
                $('#dataSidebarLoader').hide();
                $('._cl-bottom').show();
                $('.pc-cartlist').show();
                $('#uploadedImg').remove();

                $('input[name="name"]').focus();
                $('input[name="name"]').val(response.employee.name);
                $('input[name="name"]').blur();

                $('input[name="phone"]').focus();
                $('input[name="phone"]').val(response.employee.phone);
                $('input[name="phone"]').blur();

                $('input[name="home_phone"]').focus();
                $('input[name="home_phone"]').val(response.employee.home_num);
                $('input[name="home_phone"]').blur();

                $('input[name="ice_num"]').focus();
                $('input[name="ice_num"]').val(response.employee.ice_num);
                $('input[name="ice_num"]').blur();

                $('input[name="base_station"]').focus();
                $('input[name="base_station"]').val(response.employee.base_station);
                $('input[name="base_station"]').blur();

                $('input[name="email"]').focus();
                $('input[name="email"]').val(response.employee.email);
                $('input[name="email"]').blur();

                $('input[name="cnic"]').focus();
                $('input[name="cnic"]').val(response.employee.cnic);
                $('input[name="cnic"]').blur();

                $('input[name="city"]').focus();
                $('input[name="city"]').val(response.employee.city);
                $('input[name="city"]').blur();

                $('input[name="state"]').focus();
                $('input[name="state"]').val(response.employee.state);
                $('input[name="state"]').blur();

                $('input[name="address"]').focus();
                $('input[name="address"]').val(response.employee.address);
                $('input[name="address"]').blur();

                $('input[name="username"]').focus();
                $('input[name="username"]').val(response.employee.username);
                $('input[name="username"]').blur();

                $('input[name="hiring"]').val(response.employee.hiring);

                $('input[name="salary"]').focus();
                $('input[name="salary"]').val(response.employee.salary);
                $('input[name="salary"]').blur();

                $('select[name="country"]').val(response.employee.country).trigger('change');
                $('select[name="designation"]').val(response.employee.designation).trigger('change');
                $('select[name="reporting"]').val(response.employee.reporting_to).trigger('change');
                $('select[name="department"]').val(response.employee.department_id).trigger('change');

                var imgUrl = response.base_url + response.employee.picture;
                $("#employeePicture").attr("data-height", '100px');
                $("#employeePicture").attr("data-default-file", imgUrl);
                $('#employeePicture').dropify();
            }
        });

        $('#product-cl-sec').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        $('body').toggleClass('no-scroll');
    });

    $(document).on('click', '#saveEmployee', function() {
        $(".validation_errors").remove();
        var verif = [];

        $('.required').css('border', '');
        $('.required').parent().css('border', '');

        $('.required').each(function () {
            if ($(this).val() == "") {
                $(this).css("border", "1px solid red");
                verif.push(false);
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please provide all the required information (*)');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }else if( $(this).val() == 0 || $(this).val() == null){
                $(this).parent().css("border", "1px solid red");
                verif.push(false);
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please provide all the required information (*)');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            } else {
                verif.push(true);
            }
        });

        if(verif.includes(false)){
            return;
        }


        if (!validateEmail($('input[name="email"]').val())) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Invalid email format');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        } 

        $('#saveEmployee').attr('disabled', 'disabled');
        $('#cancelEmployee').attr('disabled', 'disabled');
        $('#saveEmployee').text('Processing..');
        var ajaxUrl = "/register";

        if ($('#operation').val() !== "add") {
            ajaxUrl = "/UpdateEmployee/" + $('input[name="employee_updating_id"]').val();
        }

        $('#saveEmployeeForm').ajaxSubmit({
            type: "POST",
            url: ajaxUrl,
            data: $('#saveEmployeeForm').serialize(),
            cache: false,
            success: function(response) {
                //debugger;
                console.log(response);
                
                if (JSON.parse(response) == "success") {
                    fetchEmployeesList();
                    $('#saveEmployee').removeAttr('disabled');
                    $('#cancelEmployee').removeAttr('disabled');
                    $('#saveEmployee').text('Save');

                    if ($('#operation').val() !== "update") {
                        $('#saveEmployeeForm').find("input[type=text], textarea").val("");
                        $('#saveEmployeeForm').find("select").val("0").trigger('change');
                        $('.dropify-clear').click();
                    }

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Employee have been added successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else if(JSON.parse(response) == "email_exist") {
                    $('#saveEmployee').removeAttr('disabled');
                    $('#cancelEmployee').removeAttr('disabled');
                    $('#saveEmployee').text('Save');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Email already exist.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }else if(JSON.parse(response) == "updated") {
                    fetchEmployeesList();
                    $('#saveEmployee').removeAttr('disabled');
                    $('#cancelEmployee').removeAttr('disabled');
                    $('#saveEmployee').text('Save');
                    if ($('#operation').val() !== "update") {
                        $('#saveEmployeeForm').find("input[type=text], textarea").val("");
                        $('#saveEmployeeForm').find("select").val("0").trigger('change');
                        $('.dropify-clear').click();
                    }
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Employee have been updated successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }else {
                    $('#saveEmployee').removeAttr('disabled');
                    $('#cancelEmployee').removeAttr('disabled');
                    $('#saveEmployee').text('Save');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to add Employee at the moment......');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            },
            error: function(err) {
                $('#saveEmployee').removeAttr('disabled');
                $('#cancelEmployee').removeAttr('disabled');
                $('#saveEmployee').text('Save');
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Failed to add Employee at the moment');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function(i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<small class = "validation_errors" style="color: red; position: absolute; width:100%; text-align: right; margin-left: -30px">' + error[0] + '</small>'));
                    });
                }
            }
        });
    });

    $(document).on('click', '.activate_btn', function(){
        var id = $(this).attr('id');
        $(this).text('PROCESSING....');
        $(this).attr("disabled", "disabled");

        $.ajax({
            type: 'GET',
            url: '/activate_employee',
            data: {
                _token: '{!! csrf_token() !!}',
               id: id
           },
            success: function(response) {
                if(JSON.parse(response) == "success"){
                    fetchEmployeesList();
                    $(this).removeAttr('disabled');
                    $(this).text('Deactivate');
                    $(this).removeClass("activate_btn");
                    $(this).addClass("deactivate_btn");


                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Activated successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }else if(JSON.parse(response) == "failed"){
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to activate employee');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }    
            }
        });
    });

    $(document).on('click', '.deactivate_btn', function(){
        var id = $(this).attr('id');
        $(this).text('PROCESSING....');
        $(this).attr("disabled", "disabled");

        $.ajax({
            type: 'GET',
            url: '/deactivate_employee',
            data: {
                _token: '{!! csrf_token() !!}',
               id: id
           },
            success: function(response) {
                if(JSON.parse(response) == "success"){
                    fetchEmployeesList();
                    $(this).removeAttr('disabled');
                    $(this).text('Deactivate');
                    $(this).removeClass("deactivate_btn");
                    $(this).addClass("activate_btn");

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Deactivated successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }else if(JSON.parse(response) == "failed"){
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to deactivate employee');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }    
            }
        });
    });

    $(document).on('click', '#save_changes_userProfile', function(){
        if($('#current_password').val() == "" || $('#new_password').val() == "" || $('#confirm_password').val() == ""){
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please provide all the required information (*)');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }
        if($('#new_password').val() != $('#confirm_password').val()){
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('New Password and Confirm Password does not match!');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }
        if($('#new_password').val().length < 6 || $('#confirm_password').val().length < 6){
            //debugger;
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('New Password and Confirm Password should have atleast 6 characters');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }

        $(this).text('PROCESSING....');
        $(this).attr("disabled", "disabled");
        $('#saveEditProfileForm').ajaxSubmit({
            type: "POST",
            url: "/update_user_profile",
            data: $('#saveEditProfileForm').serialize(),
            cache: false,
            success: function(response) {
                if(JSON.parse(response) == "success"){
                    $("#save_changes_userProfile").removeAttr('disabled');
                    $("#save_changes_userProfile").text('Save Changes');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Updated successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    location.reload();
                }else if(JSON.parse(response) == "failed"){
                    $("#save_changes_userProfile").removeAttr('disabled');
                    $("#save_changes_userProfile").text('Save Changes');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to update');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }else{
                    $("#save_changes_userProfile").removeAttr('disabled');
                    $("#save_changes_userProfile").text('Save Changes');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Password does not match.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            }
        });
    });

});

function fetchEmployeesList() {
    $.ajax({
        type: 'GET',
        url: '/EmployeesList',
        success: function(response) {
            $('.body').empty();
            $('.body').append('<table class="table table-hover dt-responsive nowrap" id="employeesListTable" style="width:100%"><thead><tr><th>Emp ID</th><th>Employee Name</th><th>Phone</th><th>Designation</th><th>Email</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#employeesListTable tbody').empty();
            var response = JSON.parse(response);
            response.forEach(element => {
                //if Else
                // (a == "1") ? "YES" : "NO"
                $('#employeesListTable tbody').append('<tr><td>' + element['id'] + '</td><td>' + element['name'] + '</td><td>' + element['phone'] + '</td><td>' + element['designation'] + '</td><td>' + element['email'] + '</td><td><button id="' + element['id'] + '" class="btn btn-default btn-line openDataSidebarForUpdateEmployee">Edit</button>'+ (element["is_active"] ? '<button id="' + element['id'] + '" class="btn btn-default red-bg  deactivate_btn" title="View Detail">Deactivate</button>' : '<button id="' + element['id'] + '" class="btn btn-default activate_btn">Activete</button>') +'</td></tr>');
            });
            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#employeesListTable').DataTable();
        }
    });
}

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}