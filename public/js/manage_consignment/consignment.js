var clients_array = [];
$(document).ready(function () {

    // $(document).on('click', '#date_calender', function(){
    //     $('#datepicker').click();
    // });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    var consignment_delete_Ref;
    var consignment_delete_id;
    var consignment_delete_name;

    var segments = location.href.split('/');
    var action = segments[3];
    if (action == "consignment_booked") {
        fetchConsignmentsList();
    } else if (action == 'consignment_statuses') {
        fetchConsignmentStatus();
    } else if (action == 'update_consignment_cc') {
        fetchccData();
    } else if (action == 'invoice') {
        
    } else if (action == 'confirmed_consignments') {
        //$('.select_status').val($('#hidden_cn_status').val()).trigger('change');
    } else if (action == 'shipment_tracking') {

    } else if(action == 'consignment_booking'){
        fetchClients();
    }
    

    var supplementary_services_admin = [];
    var supplementary_services_client = [];


    $(document).on('click', '.supplementary_services_client', function () {
        if (supplementary_services_client.includes($(this).val())) {
            supplementary_services_client.splice(supplementary_services_client.indexOf($(this).val()), 1);
            $('#updateConsignmentFormClient').find('input[name=hidden_supplementary_services]').val(" ");
            $('#updateConsignmentFormClient').find("input[name=hidden_supplementary_services]").val(supplementary_services_client);

            $('#saveConsignmentFormClient').find('input[name=hidden_supplementary_services]').val(" ");
            $('#saveConsignmentFormClient').find("input[name=hidden_supplementary_services]").val(supplementary_services_client);
        } else {
            supplementary_services_client.push($(this).val());
            $('#updateConsignmentFormClient').find('input[name=hidden_supplementary_services]').val("");
            $('#updateConsignmentFormClient').find("input[name=hidden_supplementary_services]").val(supplementary_services_client);

            $('#saveConsignmentFormClient').find('input[name=hidden_supplementary_services]').val("");
            $('#saveConsignmentFormClient').find("input[name=hidden_supplementary_services]").val(supplementary_services_client);
        }
    });

    $(document).on('click', '.insurance_selector', function () {
        if ($(this).val() != "none") {
            $('#insurance_yes').show();
        } else {
            $('#insurance_yes').hide();
        }
    });


    $(document).on('change', '#consignment_type', function () {
         //debugger;
         var thisRef = $(this);
        if (action == 'update_consignment_cc') {
            if (thisRef.val() == "Non Fragile") {
                $('#fragile_cost_hidden').val('0');
            } else {
                $.ajax({
                    type: 'GET',
                    url: '/get_price_if_consignmentTypeFragile',
                    data: {
                        id: $('#update_customer_id_client').val(),
                        _token: '{!! csrf_token() !!}'
                    },
                    success: function (response) {
                        if (JSON.parse(response)) {
                            var response = JSON.parse(response);
                            $('#loader').hide();
                            $('.update_consignment_client').removeAttr('disabled');
                            $('#fragile_cost_hidden').val(response);
                        } else {
                            $('#loader').hide();
                            $('.update_consignment_client').removeAttr('disabled');
                            $('#fragile_cost_hidden').val('0');
                        }

                    }
                });
            }
        } else {
            if (thisRef.val() == "Non Fragile") {
                $('#fragile_cost_hidden').val('0');
            } else {
                $('#loader').show();
                $('.update_consignment_client').attr('disabled', 'disabled');
                $.ajax({
                    type: 'GET',
                    url: '/get_price_if_consignmentTypeFragile',
                    data: {
                        _token: '{!! csrf_token() !!}',
                        id: (action == 'consignment_booking' ? $('#select_customer').val() : '')
                    },
                    success: function (response) {
                        if (JSON.parse(response)) {
                            var response = JSON.parse(response);
                            $('#loader').hide();
                            $('.update_consignment_client').removeAttr('disabled');
                            $('#fragile_cost_hidden').val(response);
                        } else {
                            $('#loader').hide();
                            $('.update_consignment_client').removeAttr('disabled');
                            $('#fragile_cost_hidden').val('0');
                        }

                    }
                });
            }
        }



    });

    $(document).on('click', '.save_consignment_client', function () {

        var verif = [];
        $('.required').css('border', '');
        $('.required').parent().css('border', '');
        $('.required').each(function () {
            if ($(this).val() == "") {
                $(this).css("border", "1px solid red");
                verif.push(false);
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please fill all required fields(*).');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            } else if ($(this).val() == 0 || $(this).val() == null) {
                $(this).parent().css("border", "1px solid red");
                verif.push(false);
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please fill all required fields(*).');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            } else {
                verif.push(true);
            }
        });
        // debugger;
        if (verif.includes(false)) {
            return;
        }



        if (!$("input[name=Fragile_Criteria]").is(":checked")) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please Select Fragile type.');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }

        if ($("input[name='Fragile_Criteria']:checked").val() != "none") {
            if ($('#product_price').val() == "") {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please Enter Product Price.');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }
        }

        $('.save_consignment_client').attr('disabled', 'disabled');
        $('.save_consignment_client').text('Processing..');

        var cnno = $('#cnic_client').val();

        $('#saveConsignmentFormClient').ajaxSubmit({
            type: "POST",
            url: "/SaveConsignmentClient",
            data: $('#saveConsignmentFormClient').serialize(),
            cache: false,
            success: function (response) {
                var response = JSON.parse(response);
                if (response == "failed") {
                    $('.save_consignment_client').removeAttr('disabled');
                    //$('#cancelCustomer').removeAttr('disabled');
                    $('.save_consignment_client').text('Save');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to add consignment at the moment');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    //$('#cnic_client').val('');
                    $('#region_client').val('');
                    $('#consignee_name_client').val('');
                    $('#consignee_ref_client').val('');
                    $('#consignee_cell_client').val('');
                    $('#consignee_email_client').val('');
                    $('#consignee_address_client').val('');
                    $('#consignment_city_client').val('');
                    $('#consignment_pieces_client').val('');
                    $('#consignment_weight_client').val('');
                    $('#consignment_description_client').val('');
                    //$('#consignment_dest_city_client').val('');
                    $('#Yes').prop("checked", false);
                    $('#No').prop("checked", false);
                    $('#Fragile').prop("checked", false);
                    $('#Non-Fragile').prop("checked", false);
                    $('#Electronics').prop("checked", false);
                    $('#none').prop("checked", false);
                    $('.supplementary_services_client').prop("checked", false);
                    $('#saveConsignmentFormClient').find("select").val("0").trigger('change');
                    $('#remarks_client').val('');

                } else {
                    //debugger;
                    //$('.test_total_price').text("Total Price : " + response.total_price + " / " + "Sub Total : " + response.sub_price + " / " + "Fuel Charges : " + response.fuel_price + " / " + "GST Charges : " + response.tax_price);
                    $('.save_consignment_client').removeAttr('disabled');
                    // $('#cancelCustomer').removeAttr('disabled');
                    $('.save_consignment_client').text('Save');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Consignment have been added successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    $('#cnic_client').val('');
                    $('#region_client').val('');
                    $('#consignee_name_client').val('');
                    $('#consignee_ref_client').val('');
                    $('#consignee_cell_client').val('');
                    $('#consignee_email_client').val('');
                    $('#consignee_address_client').val('');
                    $('#consignment_city_client').val('');
                    $('#consignment_pieces_client').val('');
                    $('#consignment_weight_client').val('');
                    $('#consignment_description_client').val('');
                    $('#Yes').prop("checked", false);
                    $('#No').prop("checked", false);
                    $('#Fragile').prop("checked", false);
                    $('#Non-Fragile').prop("checked", false);
                    $('#Electronics').prop("checked", false);
                    $('#none').prop("checked", false);
                    $('.supplementary_services_client').prop("checked", false);
                    $('#saveConsignmentFormClient').find("select").val("0").trigger('change');
                    $('#remarks_client').val('');
                    //window.location.replace("/invoice/"+JSON.parse(response));
                    window.open("/invoice/" + JSON.parse(response), '_blank');
                    location.reload();
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





    $(document).on('click', '.supplementary_services_admin', function () {


        // debugger;
        if (supplementary_services_admin.includes($(this).val())) {
            supplementary_services_admin.splice(supplementary_services_admin.indexOf($(this).val()), 1);
            $('#saveConsignmentForm').find('input[name=hidden_supplementary_services]').val(" ");
            $('#saveConsignmentForm').find("input[name=hidden_supplementary_services]").val(supplementary_services_admin);
        } else {
            supplementary_services_admin.push($(this).val());
            $('#saveConsignmentForm').find('input[name=hidden_supplementary_services]').val(" ");
            $('#saveConsignmentForm').find("input[name=hidden_supplementary_services]").val(supplementary_services_admin);
        }
    });


    $(document).on('click', '.save_consignment_admin', function () {
        var verif = [];
        $('.required').css('border', '');
        $('.required').parent().css('border', '');
        $('.required').each(function () {
            if ($(this).val() == "") {
                $(this).css("border", "1px solid red");
                verif.push(false);
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please fill all required fields(*).');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            } else if ($(this).val() == 0 || $(this).val() == null) {
                $(this).parent().css("border", "1px solid red");
                verif.push(false);
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please fill all required fields(*).');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            } else {
                verif.push(true);
            }
        });
        // debugger;
        if (verif.includes(false)) {
            return;
        }

        if (!$("input[name=Fragile_Criteria]").is(":checked")) {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please Select Fragile type.');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }

        if ($("input[name='Fragile_Criteria']:checked").val() != "none") {
            if ($('#product_price').val() == "") {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please Enter Product Price.');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }
        }


        $('.save_consignment_admin').attr('disabled', 'disabled');
        $('.save_consignment_admin').text('Processing..');

        $('#saveConsignmentForm').ajaxSubmit({
            type: "POST",
            url: "/SaveConsignmentAdmin",
            data: $('#saveConsignmentForm').serialize(),
            cache: false,
            success: function (response) {
                $('.save_consignment_admin').removeAttr('disabled');
                $('.save_consignment_admin').text('Save');
                if (JSON.parse(response) == "failed") {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to add consignment at the moment');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Consignment have been added successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    //window.location.replace("/invoice/"+JSON.parse(response));
                    window.open("/invoice/" + JSON.parse(response), '_blank');
                    location.reload();
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



    $(document).on('click', '.already_assigned', function () {
        $('#select_rider').val('0').trigger('change');
        $('.already_assigned').prop('checked', true);
    });
    $(document).on('change', '#select_rider', function () {
        $('.already_assigned').prop('checked', false);
    });
    var glob_cn_id = '';
    var glob_cn_ref = '';
    var glob_cn_type = '';
    $(document).on('click', '.process_hard_btn', function () {
        glob_cn_id = $(this).attr('id');
        glob_cn_ref = $(this);
        glob_cn_type = $(this).attr('name');
    });
    $(document).on('click', '.process_consignment', function () {

        if ($('#select_rider').val() == '0' || $('#select_rider').val() == null && $('.already_assigned').prop("checked") == false) {
            alert('Please select rider.');
        } else {
            var consignment_type = glob_cn_type;
            var id = glob_cn_id;
            glob_cn_ref.text('Processing...');
            glob_cn_ref.attr('disabled', 'disabled');
            $.ajax({
                type: 'GET',
                url: '/process_this_consignment',
                data: {
                    consignment_type: consignment_type,
                    rider: $('#select_rider').val(),
                    id: id,
                    _token: '{!! csrf_token() !!}'
                },
                success: function (response) {
                    // console.log(response);
                    $('.cancel_modal').click();
                    glob_cn_ref.text('Process');
                    glob_cn_ref.removeAttr('disabled', 'disabled');

                    if (JSON.parse(response) == 'success') {
                        glob_cn_ref.parent().parent().remove();
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'green');
                        $('#notifDiv').text('Procedded successfully.');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                    } else {
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'red');
                        $('#notifDiv').text('Unable to process at the moment!.');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                    }

                }
            });
        }
    });



    $(document).on('click', '.delete_pend_consignment', function () {
        consignment_delete_id = "";
        consignment_delete_name = "";
        consignment_delete_id = $(this).attr('id');
        consignment_delete_name = $(this).attr('name');
        $('#delete_customer_modal').click();
        consignment_delete_Ref = $(this);
    });

    $(document).on('click', '#link_delete_consignment', function () {
        var id = consignment_delete_id;
        var consignment_type = consignment_delete_name;

        consignment_delete_Ref.text('Processing...');
        consignment_delete_Ref.attr('disabled', 'disabled');
        $.ajax({
            type: 'GET',
            url: '/delete_pending_consignment',
            data: {
                consignment_type: consignment_type,
                id: id,
                _token: '{!! csrf_token() !!}'
            },
            success: function (response) {
                console.log(response);
                //consignment_delete_Ref.parent().parent().remove();

                if (JSON.parse(response) == 'success') {
                    consignment_delete_Ref.parent().parent().remove();
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Deleted successfully.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to delete at the moment!.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }

            }
        });
    });


    //Open side bar for adding STATUS
    $(document).on('click', '.openDataSidebarForAddingstatus', function () {
        $('#product-cl-sec').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        $('body').toggleClass('no-scroll');
        $('#operation_status').val('add');
        $('.save_status').show();
        $('.updatestatus').hide();
        $('#sidebarLayout').show();
        $('#status').val('');
    });

    //Open side bar for update STATUS
    $(document).on('click', '.edit_status', function () {
        $('#product-cl-sec').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        $('body').toggleClass('no-scroll');
        $('#operation_status').val('update');
        $('.save_status').hide();
        $('.updatestatus').show();
        $('#dataSidebarLoader').show();
        $('#sidebarLayout').hide();

        $.ajax({
            type: 'GET',
            url: '/get_custom_status_data',
            data: {
                status: $('#status').val(),
                id: $(this).attr('id'),
                _token: '{!! csrf_token() !!}'
            },
            success: function (response) {
                console.log(response);
                var response = JSON.parse(response);
                $('#dataSidebarLoader').hide();
                $('#sidebarLayout').show();
                $('#status').focus();
                $('#status').val(response.status);
                $('#status').blur();
                $('.updatestatus').attr('id', response.id);
            }
        });

    });

    //Save Custom Status
    $(document).on('click', '.save_status', function () {
        if ($('#status').val() == "") {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please Enter Status.');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }

        $('.save_status').text('Processing...');
        $('.save_status').attr('disabled', 'disabled');
        $.ajax({
            type: 'GET',
            url: '/save_consignment_statuses',
            data: {
                status: $('#status').val(),
                _token: '{!! csrf_token() !!}'
            },
            success: function (response) {
                $('.save_status').text('Save');
                $('.save_status').removeAttr('disabled');
                if (JSON.parse(response) == 'success') {
                    $('#status').val('');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Saved successfully.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    fetchConsignmentStatus();
                } else if (JSON.parse(response) == 'already_exist') {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('This status already exist.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                } else {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to save at the moment!.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }

            }
        });

    });

    //Update Custom STatus
    $(document).on('click', '.updatestatus', function () {
        if ($('#status').val() == "") {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please Enter Status.');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }
        var thisRef = $(this);

        thisRef.text('Processing...');
        thisRef.attr('disabled', 'disabled');
        $.ajax({
            type: 'GET',
            url: '/update_custom_status',
            data: {
                status: $('#status').val(),
                id: $(this).attr('id'),
                _token: '{!! csrf_token() !!}'
            },
            success: function (response) {
                thisRef.text('Update');
                thisRef.removeAttr('disabled');
                if (JSON.parse(response) == 'success') {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Saved successfully.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    fetchConsignmentStatus();
                } else {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to save at the moment!.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }

            }
        });

    });

    var status_id_glob = '';
    var glob_status_ref = '';
    //Delete Custom STATUS
    $(document).on('click', '.delete_custom_status', function () {
        status_id_glob = $(this).attr('id');
        glob_status_ref = $(this);
        $('#open_modal').click();
    });

    //Modal Delete Custom STATUS
    $(document).on('click', '#link_delete_custom_status', function () {
        glob_status_ref.text('Processing...');
        glob_status_ref.attr('disabled', 'disabled');
        $.ajax({
            type: 'GET',
            url: '/delete_custom_status',
            data: {
                id: status_id_glob,
                _token: '{!! csrf_token() !!}'
            },
            success: function (response) {
                if (JSON.parse(response) == 'success') {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Deleted successfully.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    fetchConsignmentStatus();
                } else {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to delete at the moment!.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }

            }
        });
    });


    //Save Status against consignment
    var glob_status_remarks = '';
    var glob_status_id = '';
    var glob_cn_if_for_status = '';
    var glob_update_btn_ref = '';
    $(document).on('click', '.update_cn_status', function () {
        //debugger;
        var data = $(this).attr('value').split('-');
        glob_status_remarks = data[0];
        glob_status_id = data[1];
        glob_cn_if_for_status = $(this).attr('id');
        glob_update_btn_ref = $(this);
        $('#select_status_modal').empty();
        $('#remarks_modal').val('');
        $('#select_status_modal').append('<option value="0">Please Wait...</option>');
        $.ajax({
            type: 'GET',
            url: '/GetStatusLogForModal',
            success: function (response) {
                var response = JSON.parse(response);
                $('#select_status_modal').empty();
                $('#select_status_modal').append('<option value="0">Select Status</option>');
                response.forEach(element => {
                    $('#select_status_modal').append('<option value="' + element.status + '">' + element.status + '</option>');
                });
                //setTimeout(() => {
                if (glob_status_id == "" || glob_status_id == null) {
                    $('#select_status_modal').val('0').trigger('change');
                } else {
                    $('#select_status_modal').val(glob_status_id).trigger('change');
                }
                $('#remarks_modal').val(glob_status_remarks);
                //}, 300);
            }
        });
    });

    $(document).on('click', '.save_status_modal', function () {
        var thisRef = $(this);
        var status_code = $('#select_status_modal').val();
        var remarks = $('#remarks_modal').val();
        var cnno = glob_cn_if_for_status;
        if (status_code == null || status_code == 0 || remarks == "") {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please select status and write remarks.');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }


        glob_update_btn_ref.text('Processing...');
        glob_update_btn_ref.attr('disabled', 'disabled');
        thisRef.text('Please Wait...');
        thisRef.attr('disabled', 'disabled');

        $.ajax({
            type: 'GET',
            url: '/update_status_log',
            data: {
                status_code: status_code,
                remarks: remarks,
                cnno: cnno,
                _token: '{!! csrf_token() !!}'
            },
            success: function (response) {
                glob_update_btn_ref.text('Update Status');
                glob_update_btn_ref.removeAttr('disabled');

                thisRef.text('Save');
                thisRef.removeAttr('disabled');

                $('.close_status_modal').click();

                if (JSON.parse(response) == 'failed') {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to save at the moment!.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);

                } else {
                    glob_update_btn_ref.parent().parent().find('td:eq(5)').html("<span style='color: #FBD536'>" + status_code + "</span>");
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Saved successfully.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    glob_update_btn_ref.attr('value', JSON.parse(response).remarks + "-" + JSON.parse(response).status);
                }

            }
        });
    });


    //Mark Consignment as Complete 
    var glob_opp_for_complete = '';
    var glob_id_for_complete = '';
    var glob_ref_for_complete = '';
    var glob_cnno_for_complete = '';
    var glob_data_for_complete = '';
    $(document).on('click', '.complete_consignment', function () {
        var data = $(this).parent().find('.update_cn_status').attr('value').split('-');
        var status_code = data[1];
        var remarks = data[0];
        glob_opp_for_complete = $(this).attr('name');
        glob_id_for_complete = $(this).attr('id');
        glob_ref_for_complete = $(this);
        glob_data_for_complete = data;
        glob_cnno_for_complete = $(this).parent().parent().find('td:eq(0)').text();
        if (status_code == null || status_code == 0 || remarks == "") {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please select status and write remarks.');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            this.removeAttr('data-toggle');
            return;
        }

        $('.open_complete_modal').click();
    });
    $(document).on('click', '.complete_cn_modal', function () {

        var status_code = glob_data_for_complete[1];
        var remarks = glob_data_for_complete[0];
        //return;
        glob_ref_for_complete.text('Processing');
        glob_ref_for_complete.attr('disabled', 'disabled');
        $.ajax({
            type: 'GET',
            url: '/mark_consignment_complete',
            data: {
                opp: glob_opp_for_complete,
                id: glob_id_for_complete,
                cnno: glob_cnno_for_complete,
                status_code: status_code,
                remarks: remarks,
                _token: '{!! csrf_token() !!}'
            },
            success: function (response) {
                $('.close_complete_modal').click();
                if (JSON.parse(response) == 'success') {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Completed successfully.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    glob_ref_for_complete.parent().parent().remove();
                } else {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Unable to complete at the moment!.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                }

            }
        });
    });





    //Edit Consignment Button Clicked
    $(document).on('click', '.edit_consignment', function () {
        if ($(this).attr('name') == 'admin') {
            //Admin
            alert('Admin Consignment');
            //window.location.href = '/update_consignment_ad/'+$(this).attr('id');
        } else {
            //Client
            window.location.href = '/update_consignment_cc/' + $(this).attr('id');
        }
    });

    $(document).on('click', '#hidden_btn_client', function () {
        // var supplementary_services_client =[];
        $.ajax({
            type: 'GET',
            url: '/GetCCData',
            data: {
                id: $('#hidden_ccno').val(),
                _token: '{!! csrf_token() !!}'
            },
            success: function (response) {
                //console.log(response);
                var response = JSON.parse(response);
                $('#dataLoader').hide();
                $('#updateConsignmentFormClient').show();

                $('#dp3').data({
                    date: response.booking_date
                });
                $('#dp3').datepicker('update');
                $('#dp3').datepicker().children('input').val(response.booking_date);

                $('#update_cnic_client').val(response.cnic);
                $('#update_customer_id_client').val(response.customer_id);
                $('#update_region_client').val(response.origin_city).trigger('change');
                $('#consignee_name_client').val(response.consignee_name);
                $('#consignee_name_client').focus();
                $('#consignee_name_client').blur();

                $('#consignee_ref_client').val(response.consignee_ref);
                $('#consignee_ref_client').focus();
                $('#consignee_ref_client').blur();

                $('#consignee_cell_client').val(response.consignee_cell);
                $('#consignee_cell_client').focus();
                $('#consignee_cell_client').blur();

                $('#consignee_email_client').val(response.consignee_email);
                $('#consignee_email_client').focus();
                $('#consignee_email_client').blur();

                $('#consignee_address_client').val(response.consignee_address);
                $('#consignee_address_client').focus();
                $('#consignee_address_client').blur();

                $('#consignment_type').val(response.consignment_type).trigger('change');
                $('#consignment_service_type_client').val(response.consignment_service_type).trigger('change');
                $('#consignment_pieces_client').val(response.consignment_pieces);
                $('#consignment_pieces_client').focus();
                $('#consignment_pieces_client').blur();

                $('#consignment_weight_client').val(response.consignment_weight);
                $('#consignment_weight_client').focus();
                $('#consignment_weight_client').blur();

                $('#consignment_description_client').val(response.consignment_description);
                $('#consignment_description_client').focus();
                $('#consignment_description_client').blur();

                $('#consignment_dest_city_client').val(response.consignment_dest_city).trigger('change');
                $('#product_price').val(response.product_price);
                $('#product_price').focus();
                $('#product_price').blur();

                $('#remarks_client').val(response.remarks);

                $('#fragile_cost_hidden').val(response.fragile_cost);
                $('.update_consignment_client').attr('id', response.cnic);
                $('#hiddenconsignment_id').val(response.id);
                $('.test_total_price').text(response.total_price);

                if ($('#Fragile').val() == response.fragile_criteria) {
                    setTimeout(() => {
                        $('#Fragile').prop('checked', true);
                        $('#insurance_yes').show();
                    }, 300);
                }
                if ($('#Non-Fragile').val() == response.fragile_criteria) {
                    setTimeout(() => {
                        $('#Non-Fragile').prop('checked', true);
                        $('#insurance_yes').show();
                    }, 300);
                }
                if ($('#Electronics').val() == response.fragile_criteria) {
                    setTimeout(() => {
                        $('#Electronics').prop('checked', true);
                        $('#insurance_yes').show();
                    }, 300);
                }
                if ($('#none').val() == response.fragile_criteria) {
                    setTimeout(() => {
                        $('#none').prop('checked', true);
                        $('#insurance_yes').hide();
                    }, 300);
                }

                if (response.supplementary_services != null) {
                    var services = response.supplementary_services.split(',');
                    $.each(services, function (i, val) {
                        if ($('#id001').val() == services[i]) {
                            $('#id001').prop('checked', true);
                        } else if ($('#id002').val() == services[i]) {
                            $('#id002').prop('checked', true);
                        } else if ($('#id003').val() == services[i]) {
                            $('#id003').prop('checked', true);
                        } else if ($('#id004').val() == services[i]) {
                            $('#id004').prop('checked', true);
                        }

                        setTimeout(() => {
                            supplementary_services_client.push(services[i]);
                            $('#hidden_supplementary_services').val("");
                            $('#hidden_supplementary_services').val(supplementary_services_client);
                        }, 300);

                    });
                    //console.log(supplementary_services_client);
                }

                $('.select2-container').css("width", "100%");
            }
        });
    });

    //Update Client Consignment
    $(document).on('click', '.update_consignment_client', function () {


        $('.update_consignment_client').attr('disabled', 'disabled');
        $('.update_consignment_client').text('Processing..');

        $('#updateConsignmentFormClient').ajaxSubmit({
            type: "POST",
            url: "/UpdateConsignmentClient",
            data: $('#saveConsignmentFormClient').serialize(),
            cache: false,
            success: function (response) {
                console.log(response);


                // if (JSON.parse(response) == "success") {
                //     $('.update_consignment_client').removeAttr('disabled');
                //     // $('#cancelCustomer').removeAttr('disabled');
                //     $('.update_consignment_client').text('Update');
                //     $('#notifDiv').fadeIn();
                //     $('#notifDiv').css('background', 'green');
                //     $('#notifDiv').text('Consignment have been updated successfully');
                //     setTimeout(() => {
                //         $('#notifDiv').fadeOut();
                //     }, 3000);

                // } 
                if (JSON.parse(response) == "failed") {
                    $('.update_consignment_client').removeAttr('disabled');
                    //$('#cancelCustomer').removeAttr('disabled');
                    $('.update_consignment_client').text('Update');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to update consignment at the moment');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);

                } else {
                    var response = JSON.parse(response);
                    $('.update_consignment_client').removeAttr('disabled');
                    // $('#cancelCustomer').removeAttr('disabled');
                    $('.update_consignment_client').text('Update');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Consignment have been updated successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    $('.update_total_price').text("Total Price : " + response.total_price + " / " + "Sub Total : " + response.sub_price + " / " + "Fuel Charges : " + response.fuel_price + " / " + "GST Charges : " + response.tax_price);
                    
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


    //Print Invoices 
    $(document).on('click', '.print_invoices', function () {
        printDiv();
    });




});

function fetchConsignmentsList() {
    $.ajax({
        type: 'GET',
        url: '/GetConsignmentsList',
        success: function (response) {
            // console.log(response);
            // return;
            $('.body').empty();
            $('.body').append('<table class="table table-hover dt-responsive nowrap" id="BookedConsignments" style="width:100%;"><thead><tr><th>Booking Date</th><th>Sender</th><th>Phone</th><th>Shipper City</th><th>Reciver</th><th>Phone</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#BookedConsignments tbody').empty();
            var response = JSON.parse(response);
            response.forEach(element => {
                $('#BookedConsignments tbody').append('<tr><td>' + element['booking_date'] + '</td><td>' + element['shipper_name'] + '</td><td>' + element['shipper_cell'] + '</td><td>' + element['shipper_city'] + '</td><td>' + element['consignee_name'] + '</td><td>' + element['consignee_cell'] + '</td><td><button id="' + element['id'] + '" class="btn btn-default">View Detail</button></td></tr>');
            });
            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#BookedConsignments').DataTable();
        }
    });
}

function fetchConsignmentStatus() {
    $.ajax({
        type: 'GET',
        url: '/GetStatusList',
        success: function (response) {
            // console.log(response);
            //return;
            $('.body').empty();
            $('.body').append('<table class="table table-hover dt-responsive nowrap" id="BookedConsignments" style="width:100%;"><thead><tr><th>Id</th><th>Status</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#BookedConsignments tbody').empty();
            var response = JSON.parse(response);
            response.forEach(element => {
                $('#BookedConsignments tbody').append('<tr><td>' + element['id'] + '</td><td>' + element['status'] + '</td><td><button id="' + element['id'] + '" class="btn btn-default btn-line edit_status">Edit</button><button id="' + element['id'] + '" class="btn btn-default red-bg delete_custom_status">Delete</button></td></tr>');
            });
            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#BookedConsignments').DataTable();
        }
    });
}

function fetchccData() {
    setTimeout(function () {
        $('#hidden_btn_client').click();
    }, 100);
}

function fetchClients(){
    $.ajax({
        type: 'GET',
        url: '/GetClientsListForConsignment',
        success: function (response) {
            //console.log(response);
            clients_array = JSON.parse(response);
            $('.body').empty();
            $('.body').append('<table class="table table-hover dt-responsive nowrap" id="clientsListTable" style="width:100%;"><thead><tr><th>ID</th><th>Company Name</th><th>POC Name</th><th>Username</th><th>Phone#</th><th>Customer Type</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#clientsListTable tbody').empty();
            var response = JSON.parse(response);
            response.forEach(element => {
                $('#clientsListTable tbody').append('<tr><td>' + element['id'] + '</td><td>' + element['company_name'] + '</td><td>' + element['poc_name'] + '</td><td>' + element['username'] + '</td><td>' + element['phone'] + '</td><td>' + element['customer_type'] + '</td><td><a href="consignment_booking/'+element['id']+'" class="btn btn-default btn-line">Create Consignment</a></td></tr>');
            });
            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#clientsListTable').DataTable();

            var segments = location.href.split('/');
            var id = segments[4];
            var customer_data = clients_array.filter(x => x.id == id);

            $('#shipper_name').val(customer_data[0]['company_name']);
            $('#select_city_shipper').val(customer_data[0]['pick_up_city']);
            // $('#shipper_area').val(customer_data[0]['company_name']);
            $('#shipper_cell_num').val(customer_data[0]['phone']);
            $('#shipper_land_line').val(customer_data[0]['office_num']);
            // $('#shipper_email').val(customer_data[0]['company_name']);
            $('#shipper_address').val(customer_data[0]['address']);
            $('#select_customer').val(id);

            $('.form-control').focus();


        }
    });
}




function printDiv() {
    var printContents = document.getElementById('printResult').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}


