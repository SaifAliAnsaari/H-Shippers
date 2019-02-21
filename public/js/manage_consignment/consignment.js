$(document).ready(function() {   

    var segments = location.href.split('/');
    var action = segments[3];
    if(action == "consignment_booked"){
        fetchConsignmentsList();
    }

    var supplementary_services_admin = [];
    var supplementary_services_client = [];

    $(document).on('click', '.supplementary_services_client', function(){
    
            if(supplementary_services_client.includes($(this).val())){
                supplementary_services_client.splice(supplementary_services_client.indexOf($(this).val()), 1);
                $('#saveConsignmentFormClient').find('input[name=hidden_supplementary_services]').val(" ");
                $('#saveConsignmentFormClient').find("input[name=hidden_supplementary_services]").val(supplementary_services_client);
            }else{
                supplementary_services_client.push($(this).val());
                $('#saveConsignmentFormClient').find('input[name=hidden_supplementary_services]').val("");
                $('#saveConsignmentFormClient').find("input[name=hidden_supplementary_services]").val(supplementary_services_client);
            }
    });

    $(document).on('click', '.insurance_selector', function(){
        if($(this).val() != "none"){
            $('#insurance_yes').show();
        }else{
            $('#insurance_yes').hide();
        }
    });

    $(document).on('change', '#consignment_type', function(){
        if($('#consignment_type').val() == "Non Fragile"){
            $('#fragile_cost_hidden').val('0');
        }else{
            $('#loader').show();
            $('.save_consignment_client').attr('disabled', 'disabled');
            $.ajax({
                type: 'GET',
                url: '/get_price_if_consignmentTypeFragile',
                data: {
                    _token: '{!! csrf_token() !!}'
               },
                success: function(response) {
                    if(JSON.parse(response)){
                        var response = JSON.parse(response);
                        $('#loader').hide();
                        $('.save_consignment_client').removeAttr('disabled');
                        $('#fragile_cost_hidden').val(response);
                    }else{
                        $('#loader').hide();
                        $('.save_consignment_client').removeAttr('disabled');
                        $('#fragile_cost_hidden').val('0');
                    }
                        
                }
            });
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
            }else if( $(this).val() == 0 || $(this).val() == null){
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
        if(verif.includes(false)){
            return;
        }

        

        if(!$("input[name=Fragile_Criteria]").is(":checked")){
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please Select Fragile type.');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }

        if($("input[name='Fragile_Criteria']:checked").val() != "none"){
            if($('#product_price').val() == ""){
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

        $('#saveConsignmentFormClient').ajaxSubmit({
            type: "POST",
            url: "/SaveConsignmentClient",
            data: $('#saveConsignmentFormClient').serialize(),
            cache: false,
            success: function(response) {
                 console.log(response);
                // return;
                $('.save_consignment_client').removeAttr('disabled');
                $('.save_consignment_client').text('Save');
                $('.test_total_price').text("Total Price : " + response);
                return;

                //return;
                if (JSON.parse(response) == "success") {
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
                    $('.save_consignment_client').removeAttr('disabled');
                    //$('#cancelCustomer').removeAttr('disabled');
                    $('.save_consignment_client').text('Save');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to add consignment at the moment');
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




    $(document).on('click', '.supplementary_services_admin', function(){


       // debugger;
        if(supplementary_services_admin.includes($(this).val())){
            supplementary_services_admin.splice(supplementary_services_admin.indexOf($(this).val()), 1);
            $('#saveConsignmentForm').find('input[name=hidden_supplementary_services]').val(" ");
            $('#saveConsignmentForm').find("input[name=hidden_supplementary_services]").val(supplementary_services_admin);
        }else{
            supplementary_services_admin.push($(this).val());
            $('#saveConsignmentForm').find('input[name=hidden_supplementary_services]').val(" ");
            $('#saveConsignmentForm').find("input[name=hidden_supplementary_services]").val(supplementary_services_admin);
        }
    });


    $(document).on('click', '.save_consignment_admin', function () {

        // if($('#cnic').val() == "" || $('#shipper_name').val() == "" || $('#select_city_shipper').val() == 0 || $('#shipper_area').val() == "" || $('#shipper_cell_num').val() == "" || $('#shipper_land_line').val() == "" || $('#shipper_email').val() == "" || $('#shipper_address').val() == "" || $('#consignee_name').val() == "" || $('#consignee_ref_num').val() == "" || $('#consignee_cell_num').val() == "" || $('#consignee_email').val() == "" || $('#consignee_address').val() == "" || $('#consignment_regin_city').val() == "" || $('#service_type').val() == 0 || $('#consignment_pieces').val() == "" || $('#consignment_weight').val() == "" || $('#consignment_description').val() == "" || $('#consignment_price').val() == "" || $('#consignment_dest_city').val() == 0 || $('#consignment_dest_city').val() == null || $('#consignment_remarks').val() == "" || !$("input[name=inlineRadioOptions]").is(":checked")){
        //     $('#notifDiv').fadeIn();
        //     $('#notifDiv').css('background', 'red');
        //     $('#notifDiv').text('Please fill all required fields(*).');
        //     setTimeout(() => {
        //         $('#notifDiv').fadeOut();
        //     }, 3000);
        //     return;
        // }
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
            }else if( $(this).val() == 0 || $(this).val() == null){
                $(this).parent().css("border", "1px solid red");
                verif.push(false);
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please fill all required fields(*).');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }else {
                verif.push(true);
            }
        });
       // debugger;
        if(verif.includes(false)){
            return;
        }

        if(!$("input[name=inlineRadioOptions]").is(":checked")){
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please Check Consignment Type.');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }

        
        $('.save_consignment_admin').attr('disabled', 'disabled');
         $('.save_consignment_admin').text('Processing..');
 
         $('#saveConsignmentForm').ajaxSubmit({
             type: "POST",
             url: "/SaveConsignmentAdmin",
             data: $('#saveConsignmentForm').serialize(),
             cache: false,
             success: function(response) {
                 if (JSON.parse(response) == "success") {
                     $('.save_consignment_admin').removeAttr('disabled');
                      $('.save_consignment_admin').text('Save');
                      $('#notifDiv').fadeIn();
                      $('#notifDiv').css('background', 'green');
                      $('#notifDiv').text('Consignment have been added successfully');
                      setTimeout(() => {
                          $('#notifDiv').fadeOut();
                      }, 3000);
                    $('#saveConsignmentForm').find('input').val('');
                    $('#saveConsignmentForm').find('select').val('0').trigger('change');
                    $('#saveConsignmentForm').find('textarea').val('');
                    $('#Domestic').prop("checked", false);
                    $('#International').prop("checked", false);
                    $('.supplementary_services_admin').prop("checked", false);
                 } else {
                     $('.save_consignment_admin').removeAttr('disabled');
                     $('.save_consignment_admin').text('Save');
                     $('#notifDiv').fadeIn();
                     $('#notifDiv').css('background', 'red');
                     $('#notifDiv').text('Failed to add consignment at the moment');
                     setTimeout(() => {
                         $('#notifDiv').fadeOut();
                     }, 3000);
                     $('#saveConsignmentForm').find('input').val('');
                     $('#saveConsignmentForm').find('select').val('0').trigger('change');
                     $('#saveConsignmentForm').find('textarea').val('');
                     $('#Domestic').prop("checked", false);
                     $('#International').prop("checked", false);
                     $('.supplementary_services_admin').prop("checked", false);
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
});

function fetchConsignmentsList(){
    $.ajax({
        type: 'GET',
        url: '/GetConsignmentsList',
        success: function(response) {
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