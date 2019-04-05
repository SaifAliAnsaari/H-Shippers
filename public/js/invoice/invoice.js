$(document).ready(function () {
    var segments = location.href.split('/');
    var action = segments[3];
    var consignment_delete_Ref;
    var consignment_delete_id;
    var consignment_delete_name;

    $(document).on('click', '.view_detail_current_month', function () {
        var id = $(this).attr('id');
        $('#billed_to_modal').text('');
        $('#address_modal').text('');
        $('#ntn_modal').text('');
        $('#strn_modal').text('');
        $('#account_id_modal').text('');

        $('#quantity_one').text('');
        $('#quantity_two').text('');
        $('#quantity_three').text('');
        $('#quantity_four').text('');

        $('#weight_one').text('');
        $('#weight_two').text('');
        $('#weight_three').text('');
        $('#weight_four').text('');

        $('#rate_one').text('');
        $('#rate_two').text('');
        $('#rate_three').text('');
        $('#rate_four').text('');

        $('#total_one').text("");
        $('#total_two').text("");
        $('#total_three').text("");
        $('#total_four').text("");

        $('#fuel_modal').text('');
        $('#gst_heading').text('');
        $('#gst_modal').text('');
        $.ajax({
            type: 'GET',
            url: '/get_current_month_data_for_invoice',
            data: {
                _token: '{!! csrf_token() !!}',
                id: id
            },
            success: function (response) {
                //console.log(response);
                var response = JSON.parse(response);
                $('#billed_to_modal').text(response.company_name);
                $('#address_modal').text(response.address);
                $('#ntn_modal').text("NTN # " + response.ntn);
                $('#strn_modal').text("STRN # " + response.strn);
                $('#account_id_modal').text(response.account_id);

                $('#quantity_one').text(response.counts_same_day);
                $('#quantity_two').text(response.counts_over_night);
                $('#quantity_three').text(response.counts_second_day);
                $('#quantity_four').text(response.counts_over_land);

                $('#weight_one').text(response.weight_same_day);
                $('#weight_two').text(response.weight_over_night);
                $('#weight_three').text(response.weight_second_day);
                $('#weight_four').text(response.weight_over_land);

                $('#rate_one').text(Math.round(response.sub_price_same_day));
                $('#rate_two').text(Math.round(response.sub_price_over_nigth));
                $('#rate_three').text(Math.round(response.sub_price_second_day));
                $('#rate_four').text(Math.round(response.sub_price_over_land));

                $('#total_one').text(Math.round(response.price_same_day));
                $('#total_two').text(Math.round(response.price_over_night));
                $('#total_three').text(Math.round(response.price_second_day));
                $('#total_four').text(Math.round(response.price_over_land));

                $('#fuel_modal').text("Rs." + Math.round(response.fuel_charges));
                $('#gst_heading').text('GST(' + response.gst + '%)');
                $('#gst_modal').text("Rs." + Math.round(response.total_tax));
                //debugger;
                var grandtotal = response.price_same_day + response.price_over_night + response.price_second_day + response.price_over_land;
                $('#grand_total_modal').text(Math.round(grandtotal));
            }
        });
    });

    $(document).on('click', '.generateInvBtn', function () {
        var data = $(this).parent().find('#invStat').val();
        var thisRef = $(this);
        thisRef.text('Generating..');
        thisRef.attr('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: '/GenerateInvoice',
            data: {
                postData: data,
                _token: $('meta[name="csrf_token"]').attr('content')
            },
            success: function (response) {
                if (response == "true") {
                    thisRef.parent().parent().remove();
                } else {
                    console.log(response);
                    thisRef.text('Generate Invoice');
                    thisRef.removeAttr('disabled');
                }
            }
        });
    });


    //Delete Consignmnet from generated invoice detail page
    $(document).on('click', '.delete_cn_modal', function(){
        consignment_delete_id = "";
        consignment_delete_name = "";
        consignment_delete_id = $(this).attr('id');
        consignment_delete_name = $(this).attr('name');
        //$('#delete_customer_modal').click();
        consignment_delete_Ref = $(this);
    });

    $(document).on('click', '#link_delete_consignment_modal', function(){
       // alert('here');return;
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

});

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
