var acceptedFileTypes = "image/*"; //dropzone requires this param be a comma separated list
var fileList = new Array;
var i = 0;
var myDropzone = new Dropzone("#dropzonewidget", {
    url: "/test-upload",
    addRemoveLinks: true,
    maxFiles: 4,
    acceptedFiles: 'image/*',
    maxFilesize: 5,
    init: function() {
        this.on("success", function(file, serverFileName) {
            file.serverFn = serverFileName;
            fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i };
            i++;
        });
    },
    removedfile: function(file) {
        var name = file.serverFn; 
        $.ajax({
          type: 'GET',
          url: '/testingRoute/'+name,
          sucess: function(data){
             console.log('success: ' + data);
          }
        });
        var _ref;
         return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
      }
});


$(document).ready(function () {
    //debugger;
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });



    var ancCounter = 0;
    var currentLayout = 'start_date';

    $('#v-pills-tab a').each(function () {
        if (ancCounter != 0) {
            $(this).css('pointer-events', 'none');
        }
        ancCounter++;
    });

    $(document).on('click', '.saveCurrentData', function () {

        // currentLayout = 'contract_copy';
        // $('#v-pills-tab a:eq(10)').css("pointer-events", "");
        // $('#v-pills-tab a').removeClass("active");
        // $('#v-pills-tab a:eq(10)').addClass("active");
        // $('#v-pills-10').removeClass('active show');
        // $('#v-pills-11').addClass('active show');
        // $('#gst_txt').text($('#gst_tax').val());
        // return;

        if (currentLayout == 'start_date') {
            if ($('#datepicker').val() == "") {
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
        } else if (currentLayout == 'same_day_delivery_rate') {
            // debugger;
            if ($('#with_in_city_twentyfive').val() == "" || $('#with_in_city_fifty').val() == "" || $('#with_in_city_six').val() == "" || $('#with_in_city_additional').val() == "" || $('#with_in_province_twentyfive').val() == "" || $('#with_in_province_fifty').val() == "" || $('#with_in_province_six').val() == "" || $('#with_in_province_additional').val() == "" || $('#prov_to_prov_twentyfive').val() == "" || $('#prov_to_prov_fifty').val() == "" || $('#prov_to_prov_six').val() == "" || $('#prov_to_prov_additional').val() == "") {
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

        } else if (currentLayout == 'over_night_delivery') {
            //debugger;
            if ($('#on_with_in_city_twentyfive').val() == "" || $('#on_with_in_city_fifty').val() == "" || $('#on_with_in_city_six').val() == "" || $('#on_with_in_city_additional').val() == "" || $('#on_with_in_prov_twentyfive').val() == "" || $('#on_with_in_prov_fifty').val() == "" || $('#on_with_in_prov_six').val() == "" || $('#on_with_in_prov_additional').val() == "" || $('#on_provience_to_prov_twentyfive').val() == "" || $('#on_provience_to_prov_fifty').val() == "" || $('#on_provience_to_prov_six').val() == "" || $('#on_provience_to_prov_additional').val() == "") {
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


        } else if (currentLayout == 'second_day_delivery') {
            if ($('#second_day_delivery_upto_3kg').val() == "" || $('#second_day_delivery_additional_1KG').val() == "" || $('#second_day_delivery_prov_to_prov_upto3KG').val() == "" || $('#second_day_delivery_prov_to_prov_additional1KG').val() == "" || $('#second_day_delivery_prov_to_prov_6to1KG').val() == "" || $('#second_day_delivery_prov_to_prov_additionalpointFiveKg').val() == "") {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please enter membership fee.');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }
            currentLayout = 'over_land_service';
            $('#v-pills-tab a:eq(4)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(4)').addClass("active");
            $('#v-pills-04').removeClass('active show');
            $('#v-pills-05').addClass('active show');
            //$('.membership_sidebar').text(numberWithCommas($('#membership_fee').val()));

        } else if (currentLayout == 'over_land_service') {
            //debugger;   
            if ($('#over_land_upto10KG').val() == "" || $('#over_land_additional1KG').val() == "" || $('#over_land_prov_to_prov_upto10KG').val() == "" || $('#over_land_prov_to_prov_additionalpoint5KG').val() == "") {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please fill all fields');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }
            currentLayout = 'fragile_item_cost';
            $('#v-pills-tab a:eq(5)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(5)').addClass("active");
            $('#v-pills-05').removeClass('active show');
            $('#v-pills-06').addClass('active show');


        } else if (currentLayout == 'fragile_item_cost') {
            if ($('#fragile_cost_price').val() == "") {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please fill required fields');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }
            currentLayout = 'insurance_on_consignment';
            $('#v-pills-tab a:eq(6)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(6)').addClass("active");
            $('#v-pills-06').removeClass('active show');
            $('#v-pills-07').addClass('active show');
            $('#cost_txt').text($('#fragile_cost_price').val());

        } else if (currentLayout == 'insurance_on_consignment') {
            if ($('#insurance_for_fragile').val() == "" || $('#insurance_for_non_fragile').val() == "" || $('#insurance_for_electronics').val() == "") {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please enter consmuption');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }
            currentLayout = 'supplementary_services';
            $('#v-pills-tab a:eq(7)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(7)').addClass("active");
            $('#v-pills-07').removeClass('active show');
            $('#v-pills-08').addClass('active show');
            $('#f_insurance_txt').text($('#insurance_for_fragile').val());
            $('#e_insurance_txt').text($('#insurance_for_electronics').val());

        } else if (currentLayout == 'supplementary_services') {
            if ($('#supplementary_services_holiday').val() == "" || $('#supplementary_services_special_holiday').val() == "" || $('#supplementary_services_time_specified').val() == "" || $('#supplementary_services_passport').val() == "") {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please fill required fields');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }
            //delivery_detail = $("input[name='txt-rate']:checked").val();

            currentLayout = 'fuel_charges';
            $('#v-pills-tab a:eq(8)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(8)').addClass("active");
            $('#v-pills-08').removeClass('active show');
            $('#v-pills-09').addClass('active show');

        } else if (currentLayout == 'fuel_charges') {
            if ($('#fuel_charges').val() == "") {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please check asset Issuance');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }
            currentLayout = 'government_taxes';
            $('#v-pills-tab a:eq(9)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(9)').addClass("active");
            $('#v-pills-09').removeClass('active show');
            $('#v-pills-10').addClass('active show');
            $('#fuel_txt').text($('#fuel_charges').val());

        } else if (currentLayout == 'government_taxes') {
            if ($('#gst_tax').val() == "") {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text('Please check asset Issuance');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
                return;
            }
            currentLayout = 'contract_copy';
            $('#v-pills-tab a:eq(10)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(10)').addClass("active");
            $('#v-pills-10').removeClass('active show');
            $('#v-pills-11').addClass('active show');
            $('#gst_txt').text($('#gst_tax').val());

        }
    });

    $(document).on('click', '.cancel_btn', function () {
        // debugger;
        if (currentLayout == 'contract_copy') {
            currentLayout = 'government_taxes';
            $('#v-pills-tab a:eq(10)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(9)').addClass("active");
            $('#v-pills-11').removeClass('active show');
            $('#v-pills-10').addClass('active show');
        } else if (currentLayout == 'government_taxes') {
            currentLayout = 'fuel_charges';
            $('#v-pills-tab a:eq(9)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(8)').addClass("active");
            $('#v-pills-10').removeClass('active show');
            $('#v-pills-09').addClass('active show');
        } else if (currentLayout == 'fuel_charges') {
            currentLayout = 'supplementary_services';
            $('#v-pills-tab a:eq(8)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(7)').addClass("active");
            $('#v-pills-09').removeClass('active show');
            $('#v-pills-08').addClass('active show');
        } else if (currentLayout == 'supplementary_services') {
            currentLayout = 'insurance_on_consignment';
            $('#v-pills-tab a:eq(7)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(6)').addClass("active");
            $('#v-pills-08').removeClass('active show');
            $('#v-pills-07').addClass('active show');
        } else if (currentLayout == 'insurance_on_consignment') {
            currentLayout = 'fragile_item_cost';
            $('#v-pills-tab a:eq(6)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(5)').addClass("active");
            $('#v-pills-07').removeClass('active show');
            $('#v-pills-06').addClass('active show');
        } else if (currentLayout == 'fragile_item_cost') {
            currentLayout = 'over_land_service';
            $('#v-pills-tab a:eq(5)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(4)').addClass("active");
            $('#v-pills-06').removeClass('active show');
            $('#v-pills-05').addClass('active show');
        } else if (currentLayout == 'over_land_service') {
            currentLayout = 'second_day_delivery';
            $('#v-pills-tab a:eq(4)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(3)').addClass("active");
            $('#v-pills-05').removeClass('active show');
            $('#v-pills-04').addClass('active show');
        } else if (currentLayout == 'second_day_delivery') {
            currentLayout = 'over_night_delivery';
            $('#v-pills-tab a:eq(3)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(2)').addClass("active");
            $('#v-pills-04').removeClass('active show');
            $('#v-pills-03').addClass('active show');
        } else if (currentLayout == 'over_night_delivery') {
            currentLayout = 'same_day_delivery_rate';
            $('#v-pills-tab a:eq(2)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(1)').addClass("active");
            $('#v-pills-03').removeClass('active show');
            $('#v-pills-02').addClass('active show');
        } else if (currentLayout == 'same_day_delivery_rate') {
            currentLayout = 'start_date';
            $('#v-pills-tab a:eq(1)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(0)').addClass("active");
            $('#v-pills-02').removeClass('active show');
            $('#v-pills-01').addClass('active show');
        } else if (currentLayout == 'start_date') {

        }
    });

    $(document).on('click', '.nav-link', function () {
        if ($(this).text() == "Start Date") {
            currentLayout = 'start_date';
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(0)').addClass("active");
        } else if ($(this).text() == "Sell Same Day Delivery Rate") {
            currentLayout = 'same_day_delivery_rate';
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(1)').addClass("active");
        } else if ($(this).text() == "Over Night Delivery") {
            currentLayout = 'over_night_delivery';
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(2)').addClass("active");
        } else if ($(this).text() == "Second Day Delivery") {
            currentLayout = 'second_day_delivery';
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(3)').addClass("active");
        } else if ($(this).text() == "Over Land Service") {
            currentLayout = 'over_land_service';
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(4)').addClass("active");
        } else if ($(this).text() == "Fragile Items Cost") {
            currentLayout = 'fragile_item_cost';
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(5)').addClass("active");
        } else if ($(this).text() == "Insurance on Consignment") {
            currentLayout = 'insurance_on_consignment';
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(6)').addClass("active");
        } else if ($(this).text() == "Supplementary Services") {
            currentLayout = 'supplementary_services';
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(7)').addClass("active");
        } else if ($(this).text() == "Fuel Charges") {
            currentLayout = 'fuel_charges';
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(8)').addClass("active");
        } else if ($(this).text() == "Government Taxes") {
            currentLayout = 'government_taxes';
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(9)').addClass("active");
        } else if ($(this).text() == "Contract Copy") {
            currentLayout = 'contract_copy';
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(10)').addClass("active");
        }
    });

    $(document).on('click', '.saveWholeForm', function () {
        console.log($('.documents').files[0].name);
        // $('.saveWholeForm').attr('disabled', 'disabled');
        // $('.cancel_btn').attr('disabled', 'disabled');
        // $(this).text('Processing..');

        // var start_date = $('#datepicker').val();
        // var with_in_city_twentyfive = $('#with_in_city_twentyfive').val();
        // var with_in_city_fifty = $('#with_in_city_fifty').val();
        // var with_in_city_six = $('#with_in_city_six').val();
        // var with_in_city_additional = $('#with_in_city_additional').val();
        // var with_in_province_twentyfive = $('#with_in_province_twentyfive').val();
        // var with_in_province_fifty = $('#with_in_province_fifty');
        // var with_in_province_six = $('#with_in_province_six').val();
        // var with_in_province_additional = $('#with_in_province_additional').val();
        // var prov_to_prov_twentyfive = $('#prov_to_prov_twentyfive').val();
        // var prov_to_prov_fifty = $('#prov_to_prov_fifty').val();
        // var prov_to_prov_six = $('#prov_to_prov_six').val();
        // var prov_to_prov_additional = $('#prov_to_prov_additional');
        // var on_with_in_city_twentyfive = $('#on_with_in_city_twentyfive').val();
        // var on_with_in_city_fifty = $('#on_with_in_city_fifty').val();
        // var on_with_in_city_six = $('#on_with_in_city_six').val();
        // var on_with_in_city_additional = $('#on_with_in_city_additional').val();
        // var on_with_in_prov_twentyfive = $('#on_with_in_prov_twentyfive').val();
        // var on_with_in_prov_fifty = $('#on_with_in_prov_fifty').val();
        // var on_with_in_prov_six = $('#on_with_in_prov_six').val();
        // var on_with_in_prov_additional = $('#on_with_in_prov_additional').val();
        // var on_provience_to_prov_twentyfive = $('#on_provience_to_prov_twentyfive').val();
        // var on_provience_to_prov_fifty = $('#on_provience_to_prov_fifty').val();
        // var on_provience_to_prov_six = $('#on_provience_to_prov_six').val();
        // var on_provience_to_prov_additional = $('#on_provience_to_prov_additional').val();
        // var second_day_delivery_upto_3kg = $('#second_day_delivery_upto_3kg').val();
        // var second_day_delivery_additional_1KG = $('#second_day_delivery_additional_1KG').val();
        // var second_day_delivery_prov_to_prov_upto3KG = $('#second_day_delivery_prov_to_prov_upto3KG').val();
        // var second_day_delivery_prov_to_prov_additional1KG = $('#second_day_delivery_prov_to_prov_additional1KG').val();
        // var second_day_delivery_prov_to_prov_6to1KG = $('#second_day_delivery_prov_to_prov_6to1KG').val();
        // var second_day_delivery_prov_to_prov_additionalpointFiveKg = $('#second_day_delivery_prov_to_prov_additionalpointFiveKg').val();
        // var over_land_upto10KG = $('#over_land_upto10KG').val();
        // var over_land_additional1KG = $('#over_land_additional1KG').val();
        // var over_land_prov_to_prov_upto10KG = $('#over_land_prov_to_prov_upto10KG').val();
        // var over_land_prov_to_prov_additionalpoint5KG = $('#over_land_prov_to_prov_additionalpoint5KG').val();
        // var fragile_cost_price = $('#fragile_cost_price').val();
        // var insurance_for_fragile = $('#insurance_for_fragile').val();
        // var insurance_for_non_fragile = $('#insurance_for_non_fragile').val();
        // var insurance_for_electronics = $('#insurance_for_electronics').val();
        // var supplementary_services_holiday = $('#supplementary_services_holiday').val();
        // var supplementary_services_special_holiday = $('#supplementary_services_special_holiday').val();
        // var supplementary_services_time_specified = $('#supplementary_services_time_specified').val();
        // var supplementary_services_passport = $('#supplementary_services_passport').val();
        // var fuel_charges = $('#fuel_charges').val();
        // var gst_tax = $('#gst_tax').val();
        // //var documents = $('#documents').val();
        // $('#my-awesome-dropzone').append('<input hidden name="datepicker" value="'+$('#datepicker').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="with_in_city_twentyfive" value="'+$('#with_in_city_twentyfive').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="with_in_city_fifty" value="'+$('#with_in_city_fifty').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="with_in_city_six" value="'+$('#with_in_city_six').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="with_in_city_additional" value="'+$('#with_in_city_additional').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="with_in_province_twentyfive" value="'+$('#with_in_province_twentyfive').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="with_in_province_fifty" value="'+$('#with_in_province_fifty').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="with_in_province_six" value="'+$('#with_in_province_six').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="with_in_province_additional" value="'+$('#with_in_province_additional').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="prov_to_prov_twentyfive" value="'+$('#prov_to_prov_twentyfive').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="prov_to_prov_fifty" value="'+$('#prov_to_prov_fifty').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="prov_to_prov_six" value="'+$('#prov_to_prov_six').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="prov_to_prov_additional" value="'+$('#prov_to_prov_additional').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="on_with_in_city_twentyfive" value="'+$('#on_with_in_city_twentyfive').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="on_with_in_city_fifty" value="'+$('#on_with_in_city_fifty').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="on_with_in_city_six" value="'+$('#on_with_in_city_six').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="on_with_in_city_additional" value="'+$('#on_with_in_city_additional').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="on_with_in_prov_twentyfive" value="'+$('#on_with_in_prov_twentyfive').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="on_with_in_prov_fifty" value="'+$('#on_with_in_prov_fifty').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="on_with_in_prov_six" value="'+$('#on_with_in_prov_six').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="on_with_in_prov_additional" value="'+$('#on_with_in_prov_additional').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="on_provience_to_prov_twentyfive" value="'+$('#on_provience_to_prov_twentyfive').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="on_provience_to_prov_fifty" value="'+$('#on_provience_to_prov_fifty').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="on_provience_to_prov_six" value="'+$('#on_provience_to_prov_six').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="on_provience_to_prov_additional" value="'+$('#on_provience_to_prov_additional').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="second_day_delivery_upto_3kg" value="'+$('#second_day_delivery_upto_3kg').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="second_day_delivery_additional_1KG" value="'+$('#second_day_delivery_additional_1KG').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="second_day_delivery_prov_to_prov_upto3KG" value="'+$('#second_day_delivery_prov_to_prov_upto3KG').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="second_day_delivery_prov_to_prov_additional1KG" value="'+$('#second_day_delivery_prov_to_prov_additional1KG').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="second_day_delivery_prov_to_prov_6to1KG" value="'+$('#second_day_delivery_prov_to_prov_6to1KG').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="second_day_delivery_prov_to_prov_additionalpointFiveKg" value="'+$('#second_day_delivery_prov_to_prov_additionalpointFiveKg').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="over_land_upto10KG" value="'+$('#over_land_upto10KG').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="over_land_additional1KG" value="'+$('#over_land_additional1KG').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="over_land_prov_to_prov_upto10KG" value="'+$('#over_land_prov_to_prov_upto10KG').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="over_land_prov_to_prov_additionalpoint5KG" value="'+$('#over_land_prov_to_prov_additionalpoint5KG').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="fragile_cost_price" value="'+$('#fragile_cost_price').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="insurance_for_fragile" value="'+$('#insurance_for_fragile').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="insurance_for_non_fragile" value="'+$('#insurance_for_non_fragile').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="insurance_for_electronics" value="'+$('#insurance_for_electronics').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="supplementary_services_holiday" value="'+$('#supplementary_services_holiday').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="supplementary_services_special_holiday" value="'+$('#supplementary_services_special_holiday').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="supplementary_services_time_specified" value="'+$('#supplementary_services_time_specified').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="supplementary_services_passport" value="'+$('#supplementary_services_passport').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="fuel_charges" value="'+$('#fuel_charges').val()+'" />');
        // $('#my-awesome-dropzone').append('<input hidden name="gst_tax" value="'+$('#gst_tax').val()+'" />');


        // $('#my-awesome-dropzone').ajaxSubmit({
        //     type: "POST",
        //     url: '/SaveBilling',
        //     data: $('#my-awesome-dropzone').serialize(),
        //     cache: false,
        //     success: function(response) {
        //         //console.log(response);
        //         //return;
        //         if (JSON.parse(response) == "success") {
        //            // fetchClientsList();
        //             $('.saveWholeForm').removeAttr('disabled');
        //             $('.cancel_btn').removeAttr('disabled');
        //             $('.saveWholeForm').text('Save');
        //             $('#notifDiv').fadeIn();
        //             $('#notifDiv').css('background', 'green');
        //             $('#notifDiv').text('Billing have been added successfully');
        //             setTimeout(() => {
        //                 $('#notifDiv').fadeOut();
        //             }, 3000);
        //         } else if(JSON.parse(response) == "failed"){
        //             $('.saveWholeForm').removeAttr('disabled');
        //             $('.cancel_btn').removeAttr('disabled');
        //             $('.saveWholeForm').text('Save');
        //             $('#notifDiv').fadeIn();
        //             $('#notifDiv').css('background', 'red');
        //             $('#notifDiv').text('Failed to add billing at the moment');
        //             setTimeout(() => {
        //                 $('#notifDiv').fadeOut();
        //             }, 3000);
        //         }
        //     },
        //     error: function(err) {
        //         if (err.status == 422) {
        //             $.each(err.responseJSON.errors, function(i, error) {
        //                 var el = $(document).find('[name="' + i + '"]');
        //                 el.after($('<small style="color: red; position: absolute; width:100%; text-align: right; margin-left: -30px">' + error[0] + '</small>'));
        //             });
        //         }
        //     }
        // });


    });

});
