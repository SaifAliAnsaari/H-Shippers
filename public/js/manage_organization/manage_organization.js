$(document).ready(function(){

    var segments = location.href.split('/');
    var action = segments[3];
    if(action == "company_profile"){
        fetchCompaniesList();
    }else if(action == "pick_up_and_delivery"){
        fetchPickupDeliveryList();
    }


    var lastOp = "add";
    $(document).on('click', '.openDataSidebarForAddingCompany', function() {
        //alert('here');
        if (lastOp == "update") {
           
            if(action == "company_profile"){
                $('#updateCompanyForm').prop('id','saveCompanyForm');
                $('input[name="company_name"]').val("");
                $('input[name="company_name"]').blur();
                $('input[name="company_website"]').val("");
                $('input[name="company_website"]').blur();
                $('input[name="contact_num"]').val("");
                $('input[name="contact_num"]').blur();
                $('input[name="ceo"]').val("");
                $('input[name="ceo"]').blur();
                $('input[name="address"]').val("");
                $('input[name="address"]').blur();
                $('.dropify-clear').click();
                $('#saveCompany').show();
                $('#updateCompany').hide();
            }else if(action == "pick_up_and_delivery"){
                $('#updatePickUpForm').prop('id','savePickUpForm');
                $('input[name="city_name"]').val("");
                $('input[name="city_name"]').blur();
                $('input[name="province"]').val("");
                $('input[name="province"]').blur();
                $('input[name="city_short_code"]').val("");
                $('input[name="city_short_code"]').blur();
                $('#savePickUpForm').find("select").val("-1").trigger('change')
                $('#savePickUp').show();
                $('#PickUp').hide();
            }
           
           
        }
        lastOp = 'add';
        if ($('#saveCompanyForm input[name="_method"]').length) {
            $('#saveCompanyForm input[name="_method"]').remove();
        }
        $('input[id="operation"]').val('add');
        $('#product-cl-sec').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        $('body').toggleClass('no-scroll');

        $('#dropifyImgDiv').empty();
        $('#dropifyImgDiv').append('<input type="file" name="compPicture" id="companyPic" class="dropify" />');
        $('#companyPic').dropify();
    });

     //Update button
     $(document).on('click', '.openDataSidebarForUpdate', function() {
       
        if(action == "company_profile"){
            $('input[id="operation"]').val('update');
            lastOp = 'update';
            $('#dataSidebarLoader').show();
            $('._cl-bottom').hide();
            $('.pc-cartlist').hide();

            //Form ki id change kr de hai
            $('#saveCompanyForm').prop('id','updateCompanyForm');

            var id = $(this).attr('id');
            //alert('profile' + id);
            $('input[name="team_updating_id"]').val(id);
            if (!$('#saveCompanyForm input[name="_method"]').length) {
                $('#saveCompanyForm').append('<input name="_method" value="PUT" hidden />');
            }

            $('#dropifyImgDiv').empty();
            $('#dropifyImgDiv').append('<input type="file" name="compPicture" id="compPicture" />');

            $.ajax({
                type: 'GET',
                url: '/company_data/' + id,
                success: function(response) {
                    //console.log(response);
                    var response = JSON.parse(response);
               // debugger;
                $('#dataSidebarLoader').hide();
                    $('._cl-bottom').show();
                    $('.pc-cartlist').show();
                    $('#uploadedImg').remove();

                    $('input[name="company_name"]').focus();
                    $('input[name="company_name"]').val(response.info.company_name);
                    $('input[name="company_name"]').blur();

                    $('input[name="company_website"]').focus();
                    $('input[name="company_website"]').val(response.info.company_website);
                    $('input[name="company_website"]').blur();

                    $('input[name="contact_num"]').focus();
                    $('input[name="contact_num"]').val(response.info.contact_number);
                    $('input[name="contact_num"]').blur();

                    $('input[name="ceo"]').focus();
                    $('input[name="ceo"]').val(response.info.ceo);
                    $('input[name="ceo"]').blur();

                    $('input[name="address"]').focus();
                    $('input[name="address"]').val(response.info.address);
                    $('input[name="address"]').blur();

                    //debugger;
                    var imgUrl = response.base_url + response.info.company_logo;
                    $("#compPicture").attr("data-height", '100px');
                    $("#compPicture").attr("data-default-file", imgUrl);
                    $('#compPicture').dropify();

                    $('input[name="company_id"]').val(response.info.id);

                    $('#saveCompany').hide();
                    $('#updateCompany').show();

                }
            });

            $('#product-cl-sec').addClass('active');
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            $('body').toggleClass('no-scroll');
        } 
        if(action == "pick_up_and_delivery"){
            var id = $(this).attr('id');
            $('input[id="operation"]').val('update');
            lastOp = 'update';
            $('#dataSidebarLoader').show();
            $('._cl-bottom').hide();
            $('.pc-cartlist').hide();

            //Form ki id change kr de hai
            $('#savePickUpForm').prop('id','updatePickUpForm');

            var id = $(this).attr('id');
            $('input[name="team_updating_id"]').val(id);
            if (!$('#savePickUpForm input[name="_method"]').length) {
                $('#savePickUpForm').append('<input name="_method" value="PUT" hidden />');
            }

            $.ajax({
                type: 'GET',
                url: '/pickUp_data/' + id,
                success: function(response) {
                    //console.log(response);
                    var response = JSON.parse(response);
                    $('#dataSidebarLoader').hide();
                    $('._cl-bottom').show();
                    $('.pc-cartlist').show();
                    $('#uploadedImg').remove();

                    $('input[name="city_name"]').focus();
                    $('input[name="city_name"]').val(response.info.city_name);
                    $('input[name="city_name"]').blur();

                    $('input[name="province"]').focus();
                    $('input[name="province"]').val(response.info.province);
                    $('input[name="province"]').blur();

                    $('input[name="city_short_code"]').focus();
                    $('input[name="city_short_code"]').val(response.info.city_short);
                    $('input[name="city_short_code"]').blur();

                    $('input[name="delivery_id"]').val(response.info.id);

                    var locations = [];
                    response.locations.forEach(element => {
                        locations.push(element["location_service"]);
                    });

                    $('select[name="location"]').val(locations).trigger("change");

                    $('#savePickUp').hide();
                    $('#updatePickUp').show();

                }
            });

            $('#product-cl-sec').addClass('active');
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            $('body').toggleClass('no-scroll');
        }
        
    });


    $(document).on('click', '#saveCompany', function() {

        if (!$('input[name="company_name"]').val() || !$('input[name="company_website"]').val() || !$('input[name="contact_num"]').val() || !$('input[name="ceo"]').val() || !$('input[name="address"]').val()) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please provide all the required information (*)');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }

        $('#saveCompany').attr('disabled', 'disabled');
        $('#cancelCompany').attr('disabled', 'disabled');
        $('#saveCompany').text('Processing..');

        // $('input[name="document_types"]').val($('select[name="documentTypes"]').val());
        // $('input[name="delivery_ports"]').val($('select[name="deliveryPorts"]').val());

        var ajaxUrl = "/Company_save";


        $('#saveCompanyForm').ajaxSubmit({
            type: "POST",
            url: ajaxUrl,
            data: $('#saveCompanyForm').serialize(),
            cache: false,
            success: function(response) {
                if (JSON.parse(response) == "success") {
                    fetchCompaniesList();
                    $('#saveCompany').removeAttr('disabled');
                    $('#cancelCompany').removeAttr('disabled');
                    $('#saveCompany').text('Save');

                    if ($('#operation').val() !== "update") {
                        $('#saveCompanyForm').find("input[type=text], textarea").val("");
                        $('.dropify-clear').click();
                    }

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Company have been added successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else {
                    $('#saveCompany').removeAttr('disabled');
                    $('#cancelCompany').removeAttr('disabled');
                    $('#saveCompany').text('Save');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to add customer at the moment');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            },
            error: function(err) {
                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function(i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<small style="color: red; position: absolute; width:100%; text-align: right; margin-left: -30px">' + error[0] + '</small>'));
                    });
                }
            }
        });

    });


    $(document).on('click', '#savePickUp', function() {

        if (!$('input[name="city_name"]').val() || !$('input[name="province"]').val() || !$('input[name="city_short_code"]').val() || $('select[name="location"]').val() == 0) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please provide all the required information (*)');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }

        $('#savePickUp').attr('disabled', 'disabled');
        $('#cancelPickUp').attr('disabled', 'disabled');
        $('#savePickUp').text('Processing..');

        $('#savePickUpForm').append('<input type="text" name="location_service" value="'+$('select[name="location"]').val()+'" hidden />');

        var ajaxUrl = "/PickUp_save";


        $('#savePickUpForm').ajaxSubmit({
            type: "POST",
            url: ajaxUrl,
            data: $('#savePickUpForm').serialize(),
            cache: false,
            success: function(response) {
                if (JSON.parse(response) == "success") {
                    $('input[name="location_service"]').remove();
                    fetchPickupDeliveryList();

                    $('#savePickUp').removeAttr('disabled');
                    $('#cancelPickUp').removeAttr('disabled');
                    $('#savePickUp').text('Save');

                    if ($('#operation').val() !== "update") {
                        $('#savePickUpForm').find("input[type=text], textarea").val("");
                        $('#savePickUpForm').find("select").val("0").trigger('change');
                        $('.dropify-clear').click();
                    }

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Location Service have been added successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else {
                    $('#savePickUp').removeAttr('disabled');
                    $('#cancelsavePickUp').removeAttr('disabled');
                    $('#savePickUp').text('Save');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to add location service at the moment');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            },
            error: function(err) {
                $('input[name="location_service"]').remove();
                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function(i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<small style="color: red; position: absolute; width:100%; text-align: right; margin-left: -30px">' + error[0] + '</small>'));
                    });
                }
            }
        });

    });

     //Update Company
     $(document).on('click', '#updateCompany', function() {

        $('#updateCompany').attr('disabled', 'disabled');
        $('#updateCompany').text('Processing..');
        var ajaxUrl = "/company_update";
        $('#updateCompanyForm').ajaxSubmit({
            type: "POST",
            url: ajaxUrl,
            data: $('#updateCompanyForm').serialize(),
            cache: false,
            success: function(response) {
               // console.log(response);
                if (JSON.parse(response) == "success") {
                    fetchCompaniesList();
                    $('#updateCompany').removeAttr('disabled');
                    $('#updateCompany').text('Update');

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Company have been updated successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else if(JSON.parse(response) == "failed"){
                    $('#saveDeliveryTeam').removeAttr('disabled');
                    $('#cancelDeliveryTeam').removeAttr('disabled');
                    $('#saveDeliveryTeam').text('Update');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to update company at the moment');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            },
            error: function(err) {
                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function(i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<small style="color: red; position: absolute; width:100%; text-align: right; margin-left: -30px">' + error[0] + '</small>'));
                    });
                }
            }
        });

    });

    $(document).on('click', '#updatePickUp', function() {

        $('#updatePickUp').attr('disabled', 'disabled');
        $('#updatePickUp').text('Processing..');
        $('#updatePickUpForm').append('<input type="text" name="location_service" value="'+$('select[name="location"]').val()+'" hidden />');

        var ajaxUrl = "/pickUp_update";
        $('#updatePickUpForm').ajaxSubmit({
            type: "POST",
            url: ajaxUrl,
            data: $('#updatePickUpForm').serialize(),
            cache: false,
            success: function(response) {
               // console.log(response);
                if (JSON.parse(response) == "success") {
                    fetchPickupDeliveryList();
                    $('#updatePickUp').removeAttr('disabled');
                    $('#updatePickUp').text('Update');

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Company have been updated successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else if(JSON.parse(response) == "failed"){
                    $('#saveDeliveryTeam').removeAttr('disabled');
                    $('#cancelDeliveryTeam').removeAttr('disabled');
                    $('#saveDeliveryTeam').text('Update');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to update company at the moment');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            },
            error: function(err) {
                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function(i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<small style="color: red; position: absolute; width:100%; text-align: right; margin-left: -30px">' + error[0] + '</small>'));
                    });
                }
            }
        });

    });

    $(document).on('click', '.deletebtn', function(){
        if(action == "company_profile"){
            $(this).text('PROCESSING....');
            $(this).attr("disabled", "disabled");
            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                url: '/DeleteCompany',
                data: {
                    _token: '{!! csrf_token() !!}',
                   id: id
               },
                success: function(response) {
                    if(JSON.parse(response) == "success"){
                        fetchCompaniesList();
                        // $('#deletebtn').removeAttr('disabled');
                        // $('#deletebtn').text('Delete');
    
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'green');
                        $('#notifDiv').text('Company deleted successfully');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                    }else if(JSON.parse(response) == "failed"){
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'red');
                        $('#notifDiv').text('Unable to delete company');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                    }
                        
                }
            });
        }else if(action == "pick_up_and_delivery"){
            $(this).text('PROCESSING....');
            $(this).attr("disabled", "disabled");
            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                url: '/DeletepickUp',
                data: {
                    _token: '{!! csrf_token() !!}',
                   id: id
               },
                success: function(response) {
                    console.log(response);
                    if(JSON.parse(response) == "success"){
                        fetchPickupDeliveryList();
                        // $('#deletebtn').removeAttr('disabled');
                        // $('#deletebtn').text('Delete');
    
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'green');
                        $('#notifDiv').text('Area deleted successfully');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                    }else if(JSON.parse(response) == "failed"){
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'red');
                        $('#notifDiv').text('Unable to delete area');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                    }
                        
                }
            });
        }
    });


});

function fetchCompaniesList() {
    $.ajax({
        type: 'GET',
        url: '/GetCompaniesList',
        success: function(response) {
            //console.log(response);
            $('.body').empty();
            $('.body').append('<table class="table table-hover dt-responsive nowrap" id="clientsListTable" style="width:100%;"><thead><tr><th>ID</th><th>Company Name</th><th>Address</th><th>Contact#</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#clientsListTable tbody').empty();
            var response = JSON.parse(response);
            response.forEach(element => {
                $('#clientsListTable tbody').append('<tr><td>' + element['id'] + '</td><td>' + element['company_name'] + '</td><td>' + element['address'] + '</td><td>' + element['contact_number'] + '</td><td><button id="' + element['id'] + '" class="btn btn-default btn-line openDataSidebarForUpdate edit_city_btn">Edit</button><form id="deleteCustomerForm" style="display: inline-block"><input type="text" name="_method" value="DELETE" hidden /><input type="text" name="_token" value="' + $('input[name="tokenForAjaxReq"]').val() + '" hidden /><button type="button" id="' + element['id'] + '" class="btn btn-default red-bg deletebtn" title="Delete">Delete</button></form></td></tr>');
            });
            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#clientsListTable').DataTable();
        }
    });
}

function fetchPickupDeliveryList() {
    $.ajax({
        type: 'GET',
        url: '/GetPickUpList',
        success: function(response) {
            //console.log(response);
            $('.body').empty();
            $('.body').append('<table class="table table-hover dt-responsive nowrap" id="clientsListTable" style="width:100%;"><thead><tr><th>ID</th><th>City Name</th><th>Province</th><th>City Short</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#clientsListTable tbody').empty();
            var response = JSON.parse(response);
            response.forEach(element => {
                $('#clientsListTable tbody').append('<tr><td>' + element['id'] + '</td><td>' + element['city_name'] + '</td><td>' + element['province'] + '</td><td>' + element['city_short'] + '</td><td><button id="' + element['id'] + '" class="btn btn-default btn-line openDataSidebarForUpdate edit_city_btn">Edit</button><form id="deleteCustomerForm" style="display: inline-block"><input type="text" name="_method" value="DELETE" hidden /><input type="text" name="_token" value="' + $('input[name="tokenForAjaxReq"]').val() + '" hidden /><button type="button" id="' + element['id'] + '" class="btn btn-default red-bg deletebtn" title="Delete">Delete</button></form></td></tr>');
            });
            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#clientsListTable').DataTable();
        }
    });
}