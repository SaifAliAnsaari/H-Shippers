//Dropzone.autoDiscover = false;

var acceptedFileTypes = "image/*"; //dropzone requires this param be a comma separated list
var fileList = new Array;
var i = 0;
var callForDzReset = false;

var myDropzone = new Dropzone("#dropzonewidgetclient", {
    url: "/client_docs",
    addRemoveLinks: true,
    maxFiles: 4,
    acceptedFiles: 'image/*',
    maxFilesize: 5,
    init: function () {
        this.on("success", function (file, serverFileName) {
            file.serverFn = serverFileName;
            fileList[i] = {
                "serverFileName": serverFileName,
                "fileName": file.name,
                "fileId": i
            };
            i++;
        });
    },
    removedfile: function (file) {
        if ($('.operation_docs').val() == "update") {
            $.ajax({
                type: 'GET',
                url: '/remove_client_docs/' + file.name.split('documents/')[1],
                data: {
                    _token: '{!! csrf_token() !!}',
                    cust_id: cust_id
                },
                success: function (data) {
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                }
            });
        } else {
            if (!callForDzReset) {
                var name = file.serverFn;
                var cust_id = $('.client_key_docs').val();
                //console.log(cust_id);
                $.ajax({
                    type: 'GET',
                    url: '/remove_client_docs/' + name,
                    data: {
                        _token: '{!! csrf_token() !!}',
                        cust_id: cust_id
                    },
                    success: function (data) {
                        console.log('success: ' + data);
                    }
                });
            }
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        }
    }
});





$(document).ready(function () {
    fetchClientsList();

    var lastOp = "add";
    var client_id = "";
    $(document).on('click', '.openDataSidebarForAddingClient', function () {
        //Form ki id wapis kr de hai
        $('#updateClientForm').prop('id', 'saveClientForm');

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
            $('select[name="pick_up_city"]').val("0").trigger('change');
            $('select[name="pick_up_province"]').val("0").trigger('change');
            $('.operation_docs').val('');
        }
        lastOp = 'add';
        var gen_id = makeid();
        setTimeout(function () {
            $('.client_key_docs').val(gen_id);
            $('.client_key_data').val(gen_id);
        }, 500);
        callForDzReset = false;
        $('.operation_docs').val('');

        if ($('#saveClientForm input[name="_method"]').length) {
            $('#saveClientForm input[name="_method"]').remove();
        }
        $('input[id="operation"]').val('add');
        $('#product-cl-sec').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        $('body').toggleClass('no-scroll');

        $('#saveClientForm').find("input[type=text]").val("");
        $('#saveClientForm').find("input[type=number]").val("");
        $('#saveClientForm').find("select").val("0").trigger('change');

        $('#dropifyImgDiv').empty();
        $('#dropifyImgDiv').append('<input type="file" name="compPicture" id="companyPic" class="dropify" />');
        $('#companyPic').dropify();
    });


    //Save
    $(document).on('click', '#saveClient', function () {
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
            } else if ($(this).val() == 0 || $(this).val() == null) {
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

        if (verif.includes(false)) {
            return;
        }

        $('#saveClient').attr('disabled', 'disabled');
        $('#cancelClient').attr('disabled', 'disabled');
        $('#saveClient').text('Processing..');

        // $('#saveClientForm').append('<input type="text" name="pick_up_city" value="'+$('select[name="pick_up_city"]').val()+'" hidden />');
        // $('#saveClientForm').append('<input type="text" name="pick_up_province" value="'+$('select[name="pick_up_province"]').val()+'" hidden />');
        //debugger;
        var ajaxUrl = "/Client_save";
        // if ($('#operation').val() !== "add") {
        //     ajaxUrl = "/Client/" + $('input[name="product_updating_id"]').val();
        // }
        $('#saveClientForm').ajaxSubmit({
            type: "POST",
            url: ajaxUrl,
            data: $('#saveClientForm').serialize(),
            cache: false,
            success: function (response) {
                //console.log(response);
                // $('input[name="pick_up_city"]').remove();
                // $('input[name="pick_up_province"]').remove();
                if (JSON.parse(response) == "success") {
                    fetchClientsList();
                    $('#saveClient').removeAttr('disabled');
                    $('#cancelClient').removeAttr('disabled');
                    $('#saveClient').text('Save');

                    // if ($('#operation').val() !== "update") {
                    //     $('#saveClientForm').find("input[type=text]").val("");
                    //     $('.dropify-clear').click();
                    // }
                    $('#saveClientForm').find("input[type=text]").val("");
                    $('#saveClientForm').find("input[type=number]").val("");
                    $('#saveClientForm').find("select").val("0").trigger('change');
                    $('.dropify-clear').click();

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Client have been added successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);

                    $('.client_key_docs').val("");
                    $('.client_key_data').val("");
                    $('#pl-close').click();


                } else if (JSON.parse(response) == "failed") {
                    $('#saveClient').removeAttr('disabled');
                    $('#cancelClient').removeAttr('disabled');
                    $('#saveClient').text('Save');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to add customer at the moment');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else if (JSON.parse(response) == "already exist") {
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

                callForDzReset = true;
                myDropzone.removeAllFiles(true);
            },
            error: function (err) {
                // $('input[name="pick_up_city"]').remove();
                // $('input[name="pick_up_province"]').remove();
                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<small style="color: red; position: absolute; width:100%; text-align: right; margin-left: -30px">' + error[0] + '</small>'));
                    });
                }
            }
        });

    });

    //Display update client data
    $(document).on('click', '.openDataSidebarForUpdate', function () {
        $('input[id="operation"]').val('update');
        lastOp = 'update';
        $('#dataSidebarLoader').show();
        $('._cl-bottom').hide();
        $('.pc-cartlist').hide();

        //Form ki id change kr de hai
        $('#saveClientForm').prop('id', 'updateClientForm');

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
            success: function (response) {
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

                // $('input[name="password"]').focus();
                // $('input[name="password"]').val(response.info.password);
                // $('input[name="password"]').blur();
                $('input[name="password"]').focus();
                $('input[name="password"]').val("*****");
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

                // var core_cities = response.info.pick_up_city;
                // var city = core_cities.split(",");
                $('select[name="pick_up_city"]').val(response.info.pick_up_city).trigger("change");

                // var core_provinces = response.info.pick_up_province;
                // var province = core_provinces.split(",");
                $('select[name="pick_up_province"]').val(response.info.pick_up_province).trigger("change");

                $('.client_key_data').val(response.info.client_key);
                $('.client_key_docs').val(response.info.client_key);
                $('.operation_docs').val('update');

                if(response.info.company_pic != null){
                    var imgUrl = response.base_url + response.info.company_pic;
                    $("#compPicture").attr("data-height", '100px');
                    $("#compPicture").attr("data-default-file", imgUrl);
                    $('#compPicture').dropify();
                }else{
                    $("#compPicture").attr("data-height", '100px');
                    $("#compPicture").attr("data-default-file", response.base_url+"profile-img--.jpg");
                    $('#compPicture').dropify();
                }
                

                // debugger;
                var mockFile = "";
                response.documents.forEach(element => {
                    mockFile = {
                        name: response.doc_url + element.client_document,
                        size: 12345
                    };
                    myDropzone.options.addedfile.call(myDropzone, mockFile);
                    // And to show the thumbnail of the file:
                    myDropzone.options.thumbnail.call(myDropzone, mockFile, response.doc_url + element.client_document);
                });

                setTimeout(function () {
                    $('.dz-image').find('img').css('width', '100%');
                    $('.dz-image').find('img').css('height', '100%');
                }, 500)

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
    $(document).on('click', '#updateClient', function () {

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
            } else if ($(this).val() == 0 || $(this).val() == null) {
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

        if (verif.includes(false)) {
            return;
        }
        
        lastOp = "update";
        $('#updateClient').attr('disabled', 'disabled');
        $('#updateClient').text('Processing..');
        var ajaxUrl = "/client_update";
        $('#updateClientForm').ajaxSubmit({
            type: "POST",
            url: ajaxUrl,
            data: $('#updateClientForm').serialize(),
            cache: false,
            success: function (response) {
                 console.log(response);
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
                    $('.operation_docs').val('');
                } else if (JSON.parse(response) == "failed") {
                    $('#updateClient').removeAttr('disabled');
                    $('#updateClient').text('Update');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to update Client at the moment');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            },
            error: function (err) {
                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<small style="color: red; position: absolute; width:100%; text-align: right; margin-left: -30px">' + error[0] + '</small>'));
                    });
                }
            }
        });

    });

    //Delete
    // $(document).on('click', '.deleteClient', function(){
    //     $(this).text('PROCESSING....');
    //     $(this).attr("disabled", "disabled");
    //     var id = $(this).attr('id');
    //     $.ajax({
    //         type: 'GET',
    //         url: '/DeleteClient',
    //         data: {
    //             _token: '{!! csrf_token() !!}',
    //             id: id
    //         },
    //         success: function(response) {
    //             if(JSON.parse(response) == "success"){
    //                 fetchClientsList();
    //                 // $('#deleteClient').removeAttr('disabled');
    //                 // $('#deleteClient').text('Delete');

    //                 $('#notifDiv').fadeIn();
    //                 $('#notifDiv').css('background', 'green');
    //                 $('#notifDiv').text('Client deleted successfully');
    //                 setTimeout(() => {
    //                     $('#notifDiv').fadeOut();
    //                 }, 3000);
    //             }else if(JSON.parse(response) == "failed"){
    //                 $('#notifDiv').fadeIn();
    //                 $('#notifDiv').css('background', 'red');
    //                 $('#notifDiv').text('Unable to delete client');
    //                 setTimeout(() => {
    //                     $('#notifDiv').fadeOut();
    //                 }, 3000);
    //             }

    //         }
    //     });
    // });

    //Activate Client
    $(document).on('click', '.activate_btn', function () {
        var id = $(this).attr('id');
        $(this).text('PROCESSING....');
        $(this).attr("disabled", "disabled");
        var thisRef = $(this);

        $.ajax({
            type: 'GET',
            url: '/activate_client',
            data: {
                _token: '{!! csrf_token() !!}',
                id: id
            },
            success: function (response) {
                if (JSON.parse(response) == "success") {
                    //fetchCompaniesList();
                    thisRef.removeAttr('disabled');
                    thisRef.text('Deactivate');
                    thisRef.removeClass("activate_btn");
                    thisRef.addClass("deactivate_btn");
                    thisRef.addClass('red-bg');

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Activated successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else if (JSON.parse(response) == "failed") {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to activate client');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }
            }
        });
    });

    //Deactivate Client
    $(document).on('click', '.deactivate_btn', function () {
        var id = $(this).attr('id');
        $(this).text('PROCESSING....');
        $(this).attr("disabled", "disabled");
        var thisRef = $(this);

        $.ajax({
            type: 'GET',
            url: '/deactivate_client',
            data: {
                _token: '{!! csrf_token() !!}',
                id: id
            },
            success: function (response) {
                if (JSON.parse(response) == "success") {
                    //fetchCompaniesList();
                    thisRef.removeAttr('disabled');
                    thisRef.text('Activate');
                    thisRef.removeClass("deactivate_btn");
                    thisRef.removeClass('red-bg');
                    thisRef.addClass("activate_btn");

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Deactivated successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else if (JSON.parse(response) == "failed") {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to deactivate client');
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
        success: function (response) {
            //console.log(response);
            $('.body').empty();
            $('.body').append('<table class="table table-hover dt-responsive nowrap" id="clientsListTable" style="width:100%;"><thead><tr><th>ID</th><th>Company Name</th><th>POC Name</th><th>Username</th><th>Phone#</th><th>Customer Type</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#clientsListTable tbody').empty();
            var response = JSON.parse(response);
            response.forEach(element => {
                $('#clientsListTable tbody').append('<tr><td>' + element['id'] + '</td><td>' + element['company_name'] + '</td><td>' + element['poc_name'] + '</td><td>' + element['username'] + '</td><td>' + element['phone'] + '</td><td>' + element['customer_type'] + '</td><td><button id="' + element['id'] + '" class="btn btn-default btn-line openDataSidebarForUpdateCustomer openDataSidebarForUpdate">Edit</button><a href="/CustomerProfile/' + element['id'] + '" id="' + element['id'] + '" class="btn btn-default">Profile</a>' + (element["is_active"] == 1 ? '<button id="' + element['id'] + '" class="btn btn-default red-bg  deactivate_btn" title="View Detail">Deactivate</button>' : '<button id="' + element['id'] + '" class="btn btn-default activate_btn">Activate</button>') + '</td></tr>');
            });
            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#clientsListTable').DataTable();
        }
    });
}

function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 50; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}
