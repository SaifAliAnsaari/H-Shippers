$(document).ready(function() { 
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    var ancCounter = 0;
    var currentLayout = 'start_date';

    $('#v-pills-tab a').each(function(){
        if(ancCounter != 0){
            $(this).css('pointer-events', 'none');
        }
        ancCounter++;
    });

    $(document).on('click', '.saveCurrentData', function(){
        if(currentLayout == 'start_date'){
            if($('#datepicker').val() == ""){
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please enter start date.');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }
            currentLayout = 'same_day_delivery_rate';
            $('#v-pills-tab a:eq(1)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(1)').addClass("active");
            $('#v-pills-01').removeClass('active show');
            $('#v-pills-02').addClass('active show');
        }else if(currentLayout == 'same_day_delivery_rate'){
           // debugger;
            if($('#with_in_city_twentyfive').val() == "" || $('#with_in_city_fifty').val() == "" || $('#with_in_city_six').val() == "" || $('#with_in_city_additional').val() == "" || $('#with_in_province_twentyfive').val() == "" || $('#with_in_province_fifty').val() == "" || $('#with_in_province_six').val() == "" || $('#with_in_province_additional').val() == "" || $('#prov_to_prov_twentyfive').val() == "" || $('#prov_to_prov_fifty').val() == "" || $('#prov_to_prov_six').val() == "" || $('#prov_to_prov_additional').val() == ""){
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please fill all required fields.');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }
                
            currentLayout = 'over_night_delivery';
            $('#v-pills-tab a:eq(2)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(2)').addClass("active");
            $('#v-pills-02').removeClass('active show');
            $('#v-pills-03').addClass('active show');
           
        }else if(currentLayout == 'over_night_delivery'){
            //debugger;
            if($('#with_in_city_twentyfive').val() == "" || $('#with_in_city_fifty').val() == "" || $('#with_in_city_six').val() == "" || $('#with_in_city_additional').val() == "" || $('#with_in_prov_twentyfive').val() == "" || $('#with_in_prov_fifty').val() == "" || $('#with_in_prov_six').val() == "" || $('#with_in_prov_additional').val() == "" || $('#provience_to_prov_twentyfive').val() == "" || $('#provience_to_prov_fifty').val() == "" || $('#provience_to_prov_six').val() == "" || $('#provience_to_prov_additional').val() == ""){
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please fill all required fields.');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }
                
            currentLayout = 'second_day_delivery';
            $('#v-pills-tab a:eq(3)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(3)').addClass("active");
            $('#v-pills-03').removeClass('active show');
            $('#v-pills-04').addClass('active show');
            
           
        }
        // else if(currentLayout == 'second_day_delivery'){
        //     if($('#membership_fee').val() == ""){4
        //         $('#notifDiv').fadeIn();
        //         $('#notifDiv').css('background', 'red');
        //         $('#notifDiv').text('Please enter membership fee.');
        //         setTimeout(() => {
        //             $('#notifDiv').fadeOut();
        //         }, 3000);
        //         return;
        //     }
        //     currentLayout = 'security_deposit';
        //     $('#v-pills-tab a:eq(4)').css("pointer-events", "");
        //     $('#v-pills-tab a').removeClass("active");
        //     $('#v-pills-tab a:eq(4)').addClass("active");
        //     $('#v-pills-04').removeClass('active show');
        //     $('#v-pills-05').addClass('active show');
        //     //$('.membership_sidebar').text(numberWithCommas($('#membership_fee').val()));
           
        // }else if(currentLayout == 'security_deposit'){
        //     //debugger;
        //     if(!$('#securitydeposit').prop("checked") && !$('#againstproducts').prop("checked")){
        //         $('#notifDiv').fadeIn();
        //         $('#notifDiv').css('background', 'red');
        //         $('#notifDiv').text('Please enter security deposit');
        //         setTimeout(() => {
        //             $('#notifDiv').fadeOut();
        //         }, 3000);
        //         return;
        //     }else{
                
        //         if($('#securitydeposit').prop("checked")){
        //             if($('#flat_deposit_field').val() == ""){
        //                 $('#notifDiv').fadeIn();
        //                 $('#notifDiv').css('background', 'red');
        //                 $('#notifDiv').text('Please fill flat deposit field');
        //                 setTimeout(() => {
        //                     $('#notifDiv').fadeOut();
        //                 }, 3000);
        //                 return;
        //             }
        //             currentLayout = 'credit_limit';
        //             $('#v-pills-tab a:eq(5)').css("pointer-events", "");
        //             $('#v-pills-tab a').removeClass("active");
        //             $('#v-pills-tab a:eq(5)').addClass("active");
        //             $('#v-pills-05').removeClass('active show');
        //             $('#v-pills-06').addClass('active show');
        //         }else{
        //             if(!security_deposite_against_pro){
        //                 if($('#select_products').val() == 0 || $('#product_quantity').val() == "" || $('#deposite').val() == ""){
        //                     $('#notifDiv').fadeIn();
        //                     $('#notifDiv').css('background', 'red');
        //                     $('#notifDiv').text('Please fill all fields');
        //                     setTimeout(() => {
        //                         $('#notifDiv').fadeOut();
        //                     }, 3000);
        //                     return;
        //                 }else if(!security_deposite_against_pro){
        //                     $('#notifDiv').fadeIn();
        //                     $('#notifDiv').css('background', 'red');
        //                     $('#notifDiv').text('First add any item');
        //                     setTimeout(() => {
        //                         $('#notifDiv').fadeOut();
        //                     }, 3000);
        //                     return;
        //                 }
        //             }
        //             currentLayout = 'credit_limit';
        //             $('#v-pills-tab a:eq(5)').css("pointer-events", "");
        //             $('#v-pills-tab a').removeClass("active");
        //             $('#v-pills-tab a:eq(5)').addClass("active");
        //             $('#v-pills-05').removeClass('active show');
        //             $('#v-pills-06').addClass('active show');
        //         }
        //     } 
           
        // }else if(currentLayout == 'credit_limit'){
        //     if($('#total_amount').val() == "" || $('#no_of_days').val() == ""){
        //         $('#notifDiv').fadeIn();
        //         $('#notifDiv').css('background', 'red');
        //         $('#notifDiv').text('Please fill required fields');
        //         setTimeout(() => {
        //             $('#notifDiv').fadeOut();
        //         }, 3000);
        //         return;
        //     }
        //     currentLayout = 'comsumption';
        //     $('#v-pills-tab a:eq(6)').css("pointer-events", "");
        //     $('#v-pills-tab a').removeClass("active");
        //     $('#v-pills-tab a:eq(6)').addClass("active");
        //     $('#v-pills-06').removeClass('active show');
        //     $('#v-pills-07').addClass('active show');
        //     $('.total_amount_sidebar').text(numberWithCommas($('#total_amount').val()));
        //     $('.no_of_days_sidebar').text(numberWithCommas($('#no_of_days').val()));
           
        // }else if(currentLayout == 'comsumption'){
        //     if($('#comsmuption').val() == ""){
        //         $('#notifDiv').fadeIn();
        //         $('#notifDiv').css('background', 'red');
        //         $('#notifDiv').text('Please enter consmuption');
        //         setTimeout(() => {
        //             $('#notifDiv').fadeOut();
        //         }, 3000);
        //         return;
        //     }
        //     currentLayout = 'delivery_details';
        //     $('#v-pills-tab a:eq(7)').css("pointer-events", "");
        //     $('#v-pills-tab a').removeClass("active");
        //     $('#v-pills-tab a:eq(7)').addClass("active");
        //     $('#v-pills-07').removeClass('active show');
        //     $('#v-pills-08').addClass('active show');
        //     $('.consumption_sidebar').text(numberWithCommas($('#comsmuption').val()));
           
        // }else if(currentLayout == 'delivery_details'){
        //     if(!$('#weekly').prop("checked") && !$('#biweekly').prop("checked") && !$('#monthly').prop("checked") || $('#select_days').val()==0){
        //         $('#notifDiv').fadeIn();
        //         $('#notifDiv').css('background', 'red');
        //         $('#notifDiv').text('Please fill required fields');
        //         setTimeout(() => {
        //             $('#notifDiv').fadeOut();
        //         }, 3000);
        //         return;
        //     }
        //     delivery_detail = $("input[name='txt-rate']:checked").val();

        //     currentLayout = 'assets_issuance';
        //     $('#v-pills-tab a:eq(8)').css("pointer-events", "");
        //     $('#v-pills-tab a').removeClass("active");
        //     $('#v-pills-tab a:eq(8)').addClass("active");
        //     $('#v-pills-08').removeClass('active show');
        //     $('#v-pills-09').addClass('active show');
           
        // }else if(currentLayout == 'assets_issuance'){
        //     if(!$('#assetsY').prop("checked") && !$('#assetsN').prop("checked")){
        //         $('#notifDiv').fadeIn();
        //         $('#notifDiv').css('background', 'red');
        //         $('#notifDiv').text('Please check asset Issuance');
        //         setTimeout(() => {
        //             $('#notifDiv').fadeOut();
        //         }, 3000);
        //         return;
        //     }
        //     currentLayout = 'contract_copy';
        //     $('#v-pills-tab a:eq(9)').css("pointer-events", "");
        //     $('#v-pills-tab a').removeClass("active");
        //     $('#v-pills-tab a:eq(9)').addClass("active");
        //     $('#v-pills-09').removeClass('active show');
        //     $('#v-pills-10').addClass('active show');
           
        // }
    });

});