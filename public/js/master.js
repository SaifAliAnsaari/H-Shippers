$(document).ready(function() {
    $('#example').DataTable();
    $('#pl-close, .overlay').on('click', function() {
        $('#product-cl-sec').removeClass('active');
        $('.overlay').removeClass('active');
        $('body').toggleClass('no-scroll')
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
        // if(segments[3] == 'shipment_tracking'){
        //     //Shipment wala page he hai
        // }else{
        //     //yaha shipment walat page pay redirect kra do 
        // }
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


});
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