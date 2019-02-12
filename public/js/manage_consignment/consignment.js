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

    $(document).on('click', '.save_consignment_client', function () {
        // alert($("input[name='inlineRadioOptions']:checked").val());
        // return;
        if($('#cnic_client').val() == "" || $('#customer_id_client').val() == "" || $('#region_client').val() == "" || $('#consignee_name_client').val() == "" || $('#consignee_ref_client').val() == "" || $('#consignee_cell_client').val() == "" || $('#consignee_email_client').val() == "" || $('#consignee_address_client').val() == "" || $('#consignment_city_client').val() == "" || $('#consignment_service_type_client').val() == 0 || $('#consignment_pieces_client').val() == "" || $('#consignment_weight_client').val() == "" || $('#consignment_description_client').val() == "" || $('#consignment_price_client').val() == "" || $('#consignment_dest_city_client').val() == 0 || $('#remarks_client').val() == "" || !$("input[name=inlineRadioOptions]").is(":checked")){
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please fill all required fields(*).');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }
        
        $('.save_consignment_client').attr('disabled', 'disabled');
       // $('#cancelCustomer').attr('disabled', 'disabled');
        $('.save_consignment_client').text('Processing..');

        $('#saveConsignmentFormClient').ajaxSubmit({
            type: "POST",
            url: "/SaveConsignmentClient",
            data: $('#saveCustomerForm').serialize(),
            cache: false,
            success: function(response) {
                // console.log(response);
                // return;
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
                    $('#consignment_price_client').val('');
                    $('#consignment_dest_city_client').val('');
                    $('#Domestic').prop("checked", false);
                    $('#International').prop("checked", false);
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
                    $('#consignment_price_client').val('');
                    $('#consignment_dest_city_client').val('');
                    $('#Domestic').prop("checked", false);
                    $('#International').prop("checked", false);
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

    // supplementary_services = [];
    // $('.supplementary_services').each(function(){
    //     if($(this).is(':checked')){
    //         supplementary_services.push({"service": $(this).val()});
    //     }
    // });

        debugger;
        if(supplementary_services_admin.includes($(this).val())){
            supplementary_services_admin.splice(supplementary_services_admin.indexOf($(this).val()), 1);
        }else{
            supplementary_services_admin.push($(this).val());
        }
    });


    $(document).on('click', '.save_consignment_admin', function () {
        //alert($('input[name="supplementary_services"]:checked'));
        // console.log(supplementary_services);
        // return;

        if($('#cnic').val() == "" || $('#shipper_name').val() == "" || $('#select_city_shipper').val() == 0 || $('#shipper_area').val() == "" || $('#shipper_cell_num').val() == "" || $('#shipper_land_line').val() == "" || $('#shipper_email').val() == "" || $('#shipper_address').val() == "" || $('#consignee_name').val() == "" || $('#consignee_ref_num').val() == "" || $('#consignee_cell_num').val() == "" || $('#consignee_email').val() == "" || $('#consignee_address').val() == "" || $('#consignment_regin_city').val() == "" || $('#service_type').val() == 0 || $('#consignment_pieces').val() == "" || $('#consignment_weight').val() == "" || $('#consignment_description').val() == "" || $('#consignment_price').val() == "" || $('#consignment_dest_city').val() == "" || $('#consignment_remarks').val() == "" || !$("input[name=inlineRadioOptions]").is(":checked")){
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text('Please fill all required fields(*).');
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 3000);
            return;
        }
        
            alert('All Ok');
        
    });
});

function fetchConsignmentsList(){
    $.ajax({
        type: 'GET',
        url: '/GetConsignmentsList',
        success: function(response) {
            $('.body').empty();
            $('.body').append('<table class="table table-hover dt-responsive nowrap" id="BookedConsignments" style="width:100%;"><thead><tr><th>Booking Date</th><th>Sender</th><th>Phone</th><th>Area</th><th>Reciver</th><th>Phone</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#BookedConsignments tbody').empty();
            var response = JSON.parse(response);
            response.forEach(element => {
                $('#BookedConsignments tbody').append('<tr><td>' + element['booking_date'] + '</td><td>' + element['sender_name'] + '</td><td>' + element['sender_phone'] + '</td><td>' + element['region'] + '</td><td>' + element['consignee_name'] + '</td><td>' + element['consignee_cell'] + '</td><td><button id="' + element['id'] + '" class="btn btn-default">View Detail</button></td></tr>');
            });
            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#BookedConsignments').DataTable();
        }
    });
}