$(document).ready(function(){

    fetchClientsList();

    var lastOp = "add";
    var client_id = "";
    $(document).on('click', '.openDataSidebarForAddingClient', function() {
        //Form ki id wapis kr de hai
        $('#updateClientForm').prop('id','saveClientForm');     

        if (lastOp == "update") {
            $('input[name="username"]').val("");
            $('input[name="username"]').blur();
            $('input[name="password"]').val("");
            $('input[name="password"]').blur();
            $('input[name="company_name"]').val("");
            $('input[name="company_name"]').blur();
            $('input[name="poc"]').val("");
            $('input[name="poc"]').blur();
            $('input[name="phone_number"]').val("");
            $('input[name="phone_number"]').blur();
            $('input[name="office_number"]').val("");
            $('input[name="office_number"]').blur();
            $('input[name="website"]').val("");
            $('input[name="website"]').blur();
            $('input[name="city"]').val("");
            $('input[name="city"]').blur();
            $('input[name="address"]').val("");
            $('input[name="address"]').blur();
            $('input[name="ntn"]').val("");
            $('input[name="ntn"]').blur();
            $('input[name="strn"]').val("");
            $('input[name="strn"]').blur();
            
            $('.dropify-clear').click();
            $('#saveClient').show();
            $('#updateClient').hide();
            $('select[name="customer_type"]').val("0").trigger('change');
            $('select[name="pick_up_city"]').val("-1").trigger('change');
            $('select[name="pick_up_province"]').val("-1").trigger('change');
        }
        lastOp = 'add';
        if ($('#saveClientForm input[name="_method"]').length) {
            $('#saveClientForm input[name="_method"]').remove();
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


    //Save
    $(document).on('click', '#saveClient', function() {

        if (!$('input[name="username"]').val() || !$('input[name="password"]').val() || !$('input[name="company_name"]').val() ) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please provide all the required information (*)');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }
        $('#saveClient').attr('disabled', 'disabled');
        $('#cancelClient').attr('disabled', 'disabled');
        $('#saveClient').text('Processing..');

        $('#saveClientForm').append('<input type="text" name="pick_up_city" value="'+$('select[name="pick_up_city"]').val()+'" hidden />');
        $('#saveClientForm').append('<input type="text" name="pick_up_province" value="'+$('select[name="pick_up_province"]').val()+'" hidden />');

        var ajaxUrl = "/Client_save";
        if ($('#operation').val() !== "add") {
            ajaxUrl = "/Client/" + $('input[name="product_updating_id"]').val();
        }
        $('#saveClientForm').ajaxSubmit({
            type: "POST",
            url: ajaxUrl,
            data: $('#saveClientForm').serialize(),
            cache: false,
            success: function(response) {
                //console.log(response);
                $('input[name="pick_up_city"]').remove();
                $('input[name="pick_up_province"]').remove();
                if (JSON.parse(response) == "success") {
                    fetchClientsList();
                    $('#saveClient').removeAttr('disabled');
                    $('#cancelClient').removeAttr('disabled');
                    $('#saveClient').text('Save');

                    if ($('#operation').val() !== "update") {
                        $('#saveClientForm').find("input[type=text]").val("");
                        $('.dropify-clear').click();
                    }

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Client have been added successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else if(JSON.parse(response) == "failed"){
                    $('#saveClient').removeAttr('disabled');
                    $('#cancelClient').removeAttr('disabled');
                    $('#saveClient').text('Save');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to add customer at the moment');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }else if(JSON.parse(response) == "already exist"){
                    $('#saveClient').removeAttr('disabled');
                    $('#cancelClient').removeAttr('disabled');
                    $('#saveClient').text('Save');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Client already exist');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            },
            error: function(err) {
                $('input[name="pick_up_city"]').remove();
                $('input[name="pick_up_province"]').remove();
                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function(i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<small style="color: red; position: absolute; width:100%; text-align: right; margin-left: -30px">' + error[0] + '</small>'));
                    });
                }
            }
        });

    });

    //Display update client data
    $(document).on('click', '.openDataSidebarForUpdate', function() {
        $('input[id="operation"]').val('update');
        lastOp = 'update';
        $('#dataSidebarLoader').show();
        $('._cl-bottom').hide();
        $('.pc-cartlist').hide();

        //Form ki id change kr de hai
        $('#saveClientForm').prop('id','updateClientForm');

        var id = $(this).attr('id');
        $('input[name="team_updating_id"]').val(id);
        if (!$('#saveClientForm input[name="_method"]').length) {
            $('#saveClientForm').append('<input name="_method" value="PUT" hidden />');
        }

        $('#dropifyImgDiv').empty();
        $('#dropifyImgDiv').append('<input type="file" name="compPicture" id="compPicture" />');

        $.ajax({
            type: 'GET',
            url: '/client_data/' + id,
            success: function(response) {
            var response = JSON.parse(response);
            //console.log(response);
            //debugger;
                $('#dataSidebarLoader').hide();
                $('._cl-bottom').show();
                $('.pc-cartlist').show();
                $('#uploadedImg').remove();

                $('input[name="username"]').focus();
                $('input[name="username"]').val(response.info.username);
                $('input[name="username"]').blur();

                $('input[name="password"]').focus();
                $('input[name="password"]').val(response.info.password);
                $('input[name="password"]').blur();

                $('input[name="company_name"]').focus();
                $('input[name="company_name"]').val(response.info.company_name);
                $('input[name="company_name"]').blur();

                $('input[name="poc"]').focus();
                $('input[name="poc"]').val(response.info.poc_name);
                $('input[name="poc"]').blur();

                $('input[name="phone_number"]').focus();
                $('input[name="phone_number"]').val(response.info.phone);
                $('input[name="phone_number"]').blur();

                $('input[name="office_number"]').focus();
                $('input[name="office_number"]').val(response.info.office_num);
                $('input[name="office_number"]').blur();

                $('input[name="website"]').focus();
                $('input[name="website"]').val(response.info.website);
                $('input[name="website"]').blur();

                $('input[name="city"]').focus();
                $('input[name="city"]').val(response.info.city);
                $('input[name="city"]').blur();

                $('input[name="address"]').focus();
                $('input[name="address"]').val(response.info.address);
                $('input[name="address"]').blur();

                $('input[name="ntn"]').focus();
                $('input[name="ntn"]').val(response.info.ntn);
                $('input[name="ntn"]').blur();

                $('input[name="strn"]').focus();
                $('input[name="strn"]').val(response.info.strn);
                $('input[name="strn"]').blur();

                $('select[name="customer_type"]').val(response.info.customer_type).trigger("change");
                
                var core_cities = response.info.pick_up_city;
                var city = core_cities.split(",");
                $('select[name="pick_up_city"]').val(city).trigger("change");

                var core_provinces = response.info.pick_up_province;
                var province = core_provinces.split(",");
                $('select[name="pick_up_province"]').val(province).trigger("change");

                // var document = [];
                // response.documents.forEach(element => {
                //     document.push(element["client_document"]);
                // });
                $(document).on('click', '.dropzone', function() {
                    alert('documents');
                });

                // $('input[name="documents[]"]').focus();
                // $('input[name="documents[]"]').val(document);
                // $('input[name="documents[]"]').blur();

                var imgUrl = response.base_url + response.info.company_pic;
                $("#compPicture").attr("data-height", '100px');
                $("#compPicture").attr("data-default-file", imgUrl);
                $('#compPicture').dropify();

                $('input[name="client_id"]').val(response.info.id);
                $('input[name="logo_hidden"]').val(response.info.company_pic);

                $('#saveClient').hide();
                $('#updateClient').show();

            }
        });

        $('#product-cl-sec').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        $('body').toggleClass('no-scroll');
        
    });

    //Update
    $(document).on('click', '#updateClient', function() {

        lastOp = "update";
        $('#updateClient').attr('disabled', 'disabled');
        $('#updateClient').text('Processing..');
        var ajaxUrl = "/client_update";
        $('#updateClientForm').ajaxSubmit({
            type: "POST",
            url: ajaxUrl,
            data: $('#updateClientForm').serialize(),
            cache: false,
            success: function(response) {
               // console.log(response);
                if (JSON.parse(response) == "success") {
                    fetchClientsList();
                    $('#updateClient').removeAttr('disabled');
                    $('#updateClient').text('Update');

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Client have been updated successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else if(JSON.parse(response) == "failed"){
                    $('#saveDeliveryTeam').removeAttr('disabled');
                    $('#cancelDeliveryTeam').removeAttr('disabled');
                    $('#saveDeliveryTeam').text('Update');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to update Client at the moment');
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

    //Delete
    $(document).on('click', '.deleteClient', function(){
        $('#deleteClient').text('PROCESSING....');
        $('#deleteClient').attr("disabled", "disabled");
        var id = $(this).attr('id');
        $.ajax({
            type: 'GET',
            url: '/DeleteClient',
            data: {
                _token: '{!! csrf_token() !!}',
                id: id
            },
            success: function(response) {
                if(JSON.parse(response) == "success"){
                    fetchClientsList();
                    $('#deleteClient').removeAttr('disabled');
                    $('#deleteClient').text('Delete');

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Client deleted successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }else if(JSON.parse(response) == "failed"){
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to delete client');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
                    
            }
        });
    });


});

function fetchClientsList() {
    $.ajax({
        type: 'GET',
        url: '/GetClientsList',
        success: function(response) {
            //console.log(response);
            $('.body').empty();
            $('.body').append('<table class="table table-hover dt-responsive nowrap" id="clientsListTable" style="width:100%;"><thead><tr><th>ID</th><th>Company Name</th><th>POC Name</th><th>Username</th><th>Phone#</th><th>Customer Type</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#clientsListTable tbody').empty();
            var response = JSON.parse(response);
            response.forEach(element => {
                $('#clientsListTable tbody').append('<tr><td>' + element['id'] + '</td><td>' + element['company_name'] + '</td><td>' + element['poc_name'] + '</td><td>' + element['username'] + '</td><td>' + element['phone'] + '</td><td>' + element['customer_type'] + '</td><td><button id="' + element['id'] + '" class="btn btn-default btn-line openDataSidebarForUpdateCustomer openDataSidebarForUpdate">Edit</button><a href="/CustomerProfile/' + element['id'] + '" id="' + element['id'] + '" class="btn btn-default">Profile</a><form id="deleteCustomerForm" style="display: inline-block"><input type="text" name="_method" value="DELETE" hidden /><input type="text" name="_token" value="' + $('input[name="tokenForAjaxReq"]').val() + '" hidden /><button type="button" id="' + element['id'] + '" class="btn btn-default red-bg deleteClient" title="Delete">Delete</button></form></td></tr>');
            });
            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#clientsListTable').DataTable();
        }
    });
}