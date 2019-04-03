$(document).ready(function () {
    var segments = location.href.split('/');
    var action = segments[3];

    $(document).on('click', '.view_detail_current_month', function(){
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
                $('#gst_heading').text('GST('+ response.gst +'%)');
                $('#gst_modal').text("Rs." + Math.round(response.total_tax));
                //debugger;
                var grandtotal = response.price_same_day + response.price_over_night + response.price_second_day + response.price_over_land;
                $('#grand_total_modal').text(Math.round(grandtotal));
            }
        });
    });
    
});

function addCommas(nStr)
{
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

