$(document).ready(function() {
    $('#example').DataTable();
    $('#pl-close, .overlay').on('click', function() {
        $('#product-cl-sec').removeClass('active');
        $('.overlay').removeClass('active');
        $('body').toggleClass('no-scroll')
    });

    $('#dp3').datepicker();
        var checkout = $('#dpd3').datepicker({
          onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');
        
    var segments = location.href.split('/');
    if(segments[3] == 'dashboard'){
        $('.container').addClass('container-1240 _dashboard');
    }else if(segments[3] == 'invoice'){
        $.ajax({
            type: 'GET',
            url: '/barcode/generate.php?cnn=' + segments[4],
            data: {
                _token: '{!! csrf_token() !!}'
            },
            success: function (response) {
                $('.barcode_area').html(response);
            }
        });
    }


     //Dashboard Reporting
     $(document).on('change', '.select_report_time_period', function(){
        $.ajax({
            type: 'GET',
            url: '/get_dashboard_reports',
            data: {
                _token: $('input[name="_token"]').val(),
                time_period: $(this).val()
            },
            success: function (response) {
                var response = JSON.parse(response);
                //console.log(response);
                $('.total_rev_dashboard').text("Rs."+(response.data.total_revenue ? addCommas(Math.round(response.data.total_revenue)) : '0'));
                $('.total_bookings_dashboard').text(addCommas(Math.round(response.data.total_bookings)));
                $('.active_cust_dashboard').text(addCommas(Math.round(response.data.active_custs)));
                $('.avg_rev_cust_dashboard').text("Rs."+(response.data.total_revenue && response.data.active_custs != "0" ? addCommas(Math.round(parseFloat(response.data.total_revenue) / parseFloat(response.data.active_custs))) : '0'));

                $('.outstanding_dashboard').text('Rs.'+(response.life_time_rev.life_time_revenus ? addCommas(Math.round(response.life_time_rev.life_time_revenus)) : '0'));
                $('.amount_rec_dashboard').text('Rs.'+(response.data.amount_recieved ? addCommas(Math.round(response.data.amount_recieved)) : '0'));
                
                $('.remaining_amount_dashboard').text('Rs.'+(response.life_time_rev.life_time_revenus ? (response.data.amount_recieved ? addCommas(Math.round(parseFloat(response.life_time_rev.life_time_revenus) - parseFloat(response.data.amount_recieved))) : addCommas(Math.round(parseFloat(response.life_time_rev.life_time_revenus) - parseFloat(0)))): '0'));


                $('.avg_rev_day_dashboard').text("Rs."+(response.life_time_rev.life_time_revenus ? addCommas(Math.round(parseFloat(response.life_time_rev.life_time_revenus) / parseFloat(response.totalDays))) : '0'));
                $('.avg_rev_shipment_dashboard').text('Rs.'+(response.life_time_data != null ? addCommas(Math.round(parseFloat(response.life_time_rev.life_time_revenus) / parseFloat(response.life_time_data.life_time_consignments))) : "0"));

                $('.avg_shipment_day_dashboard').text((response.life_time_data != null ? addCommas(Math.round(parseFloat(response.life_time_data.life_time_consignments) / parseFloat(response.totalDays))) : "0"));
                
                $('.avg_weight_shipment_dashboard').text((response.life_time_data != null ? addCommas(Math.round(parseFloat(response.life_time_data.total_weight) / parseFloat(response.life_time_data.life_time_consignments))) : '0') +".KG(s)");
                $('.avg_delivery_time_dashboard').text('NA');

                $('.consignments_by_dest_dashboard').empty();
                $('.consignments_by_dest_dashboard').append('<h2 class="_head03 border-0">Consignments <span>By Destinations</span></h2>');
                
                if(response.consignments_by_destinations != null){
                    response.consignments_by_destinations.forEach(element => {
                        $('.consignments_by_dest_dashboard').append('<div class="_dash-prog "><h5>'+ element['consignment_dest_city'] +'</h5><div class="progress-w-percent"><span class="progress-value">'+ Math.round((parseFloat(element['quantity']) / parseFloat(element['total_counts'])) * 100) +'% </span><div class="progress"><div class="progress-bar" role="progressbar"style="width:'+ Math.round((parseFloat(element['quantity']) / parseFloat(element['total_counts'])) * 100) +'%;"aria-valuenow="'+ Math.round((parseFloat(element['quantity']) / parseFloat(element['total_counts'])) * 100) +'" aria-valuemin="0"aria-valuemax="100"></div></div></div></div>');
                    });
                }
                

                $('.day_wise_report_dashboard').empty();
                $('.day_wise_report_dashboard').append('<table class="table table-hover"><thead> <tr> <th>SERVICE</th><th>QUANTITY</th><th>WEIGHT</th> <th>RATE</th></tr></thead> <tbody>');

                if(response.consignments_by_days != null){
                    response.consignments_by_days.forEach(element => {
                        $('.day_wise_report_dashboard table tbody').append('<tr><td> '+ element['day'] +' </td><td> '+ addCommas(Math.round(element['quantity'])) +' </td><td> '+ addCommas(Math.round(element['weight'])) +' KG(s) </td><td> Rs.'+ addCommas(Math.round(element['rate'])) +' </td></tr>');
                    });
                }
                

                $('.day_wise_report_dashboard').append('</tbody></table>');
            }
        });
    });



		

    var notif_ids = [];
    //Employees Four Notifications
    $(document).on('click', '#NotiFications', function(){
        $('.notifications_list').each(function (){
            notif_ids.push($(this).attr('id'));
        });
        
        $.ajax({
        type: 'POST',
        url: '/read_notif_four',
        data: {
            _token: $('input[name="_token"]').val(),
            notif_ids: notif_ids
        },
        success: function (response) {
            var response = JSON.parse(response);
            //console.log(response);
        }
        });
    });


    //Clients Four Notifications
    $(document).on('click', '#NotiFications_client', function(){
        $('.notifications_list_client').each(function (){
            notif_ids.push($(this).attr('id'));
        });
        
        $.ajax({
        type: 'POST',
        url: '/read_notif_four',
        data: {
            _token: $('input[name="_token"]').val(),
            notif_ids: notif_ids
        },
        success: function (response) {
            //var response = JSON.parse(response);
            //console.log(response);
        }
        });
    });


    if($('#check_cnno').val() == 1){
       
    }else{
        $('#detail_div').show();
    }
    $(document).on('click', '#search_shipment_button', function(){
         var segments = location.href.split('/');
       
        if($('.search_shipment_field').val() != ""){
            var id = $('.search_shipment_field').val();
            $('#loader').show();
           $.ajax({
                type: 'GET',
                url: '/GetCNNOData',
                data: {
                    _token: '{!! csrf_token() !!}',
                    id: id
                },
                success: function(response) {
                   $('#loader').hide();
                   
                    if(JSON.parse(response) == 'error'){
                        if(segments[3] == 'shipment_tracking'){
                            $('#detail_div').hide();
                            //$('#error_layout').show();
                            $('.error_text').text('Invalid CNNO');
                            $('.error_heading').text('Error:');
                            $('#shipment_cnno').text("----");
                            $('#shipment_consignee_name').text("----");
                        }else{
                            $('#detail_div').hide();
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'red');
                            $('#notifDiv').text('Invalid CNNO');
                            setTimeout(() => {
                                $('#notifDiv').fadeOut();
                            }, 3000);
                        }
                    }else{
                        
                        if(segments[3] == 'shipment_tracking'){
                            JSON.parse(response).forEach(element => {
                                $('#detail_div').show();
                                $('.error_text').text('');
                                $('.error_heading').text('');
                                //console.log(response);
                                $('#shipment_cnno').text(element.core.cnic);
                                $('#shipment_consignee_name').text(element.core.consignee_name);
                                $('#shipment_destination').text(element.core.consignment_dest_city);
                                $('#shipment_bookin_date').text(element.core.booking_date);
                                $('#shipment_consignment_status').text((element.core.current_status != null ? element.core.current_status : "NA"));
                                $('#shipment_consignment_status_date').text((element.core.status_date != null ? element.core.status_date : "NA"));
                                $('#shipment_shippername').text((element.core.company_name != null ? element.core.company_name : element.core.username));
                                $('#shipment_origin').text(element.core.city);

                                $('.table_body').empty();
                                $('.table_body').append('<table class="table table-hover dt-responsive nowrap" id="statusListTable" style="width:100%;"><thead><tr><th>Date</th><th>Status</th><th>Remarks</th></tr></thead><tbody></tbody></table>');
                                $('#statusListTable tbody').empty();
                                
                                element.statuses.forEach(element => {
                                    $('#statusListTable tbody').append('<tr><td>' + element['date'] + '</td><td>' + element['status'] + '</td><td>' + element['remarks'] + '</td></tr>');
                                });
                                $('.table_body').fadeIn();
                                $('#statusListTable').DataTable();
                            });

                        }else{
                            window.location.href = "/shipment_tracking/"+id;
                        }
                    }
                }
            });
        }
    });




    //Print Consignment Invoice
    $(document).on('click', '.print_consignment_invoice', function(){
        printInvoice();
    });



});


//Print Consignment Invoice
function printInvoice() {
    var printContents = document.getElementById('print_consignment_invoice_div').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}



$('.form-control').on('focus blur', function(e) {
        $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
    })
    .trigger('blur');
$(".formselect").select2();
$('.sd-type').select2({
    createTag: function(params) {
        var term = $.trim(params.term);
        if (term === '') {
            return null;
        }
        return {
            id: term,
            text: term,
            newTag: true // add additional parameters
        }
    }
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