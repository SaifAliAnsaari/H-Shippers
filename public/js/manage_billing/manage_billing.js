var acceptedFileTypes = "image/*, .psd"; //dropzone requires this param be a comma separated list
var fileList = new Array;
var i = 0;
var callForDzReset = false;

var myDropzone = new Dropzone("#dropzonewidget", {
    url: "/test-upload",
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
        var segments = location.href.split('/');
        var name = file.serverFn;
        var cust_id = segments[4];
        //debugger;
        if ($('#operation').val() == "update") {
            var img_url = (file.name.includes('uploads')) ? file.name.split('uploads/')[1] : file.serverFn;
            $.ajax({
                type: 'GET',
                url: '/testingRoute/' + img_url,
                data: {
                    _token: '{!! csrf_token() !!}',
                    cust_id: cust_id
                },
                sucess: function (data) {
                    console.log('success: ' + data);
                }
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        } else {
            $.ajax({
                type: 'GET',
                url: '/testingRoute/' + name,
                data: {
                    _token: '{!! csrf_token() !!}',
                    cust_id: cust_id
                },
                sucess: function (data) {
                    console.log('success: ' + data);
                }
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

        }
    }

});



$(document).ready(function () {
    // var segments = location.href.split('/');
    // var action = segments[3];
    // if(action == "select_customer"){
    //     fetchCustomersList();
    // }
    check_billing_addedOrNot();

    var sider_bar_open = false;
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
            var verif = [];
            $('.required_date').css('border', '');
            $('.required_date').parent().css('border', '');

            $('.required_date').each(function () {
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
                } else {
                    verif.push(true);
                }
            });

            if (verif.includes(false)) {
                return;
            }

            currentLayout = 'same_day_delivery_rate';
            $('#v-pills-tab a:eq(1)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(1)').addClass("active");
            $('#v-pills-01').removeClass('active show');
            $('#v-pills-02').addClass('active show');

            setTimeout(function () {
                //debugger;
                $('#with_in_city_twentyfive').focus();
                $('#with_in_city_fifty').focus();
                $('#with_in_city_six').focus();
                $('#with_in_city_additional').focus();

                $('#with_in_province_twentyfive').focus();
                $('#with_in_province_fifty').focus();
                $('#with_in_province_six').focus();
                $('#with_in_province_additional').focus();

                $('#prov_to_prov_twentyfive').focus();
                $('#prov_to_prov_fifty').focus();
                $('#prov_to_prov_six').focus();
                $('#prov_to_prov_additional').focus();

            }, 500);
        } else if (currentLayout == 'same_day_delivery_rate') {
            var verif = [];
            $('.required_same_day').css('border', '');
            $('.required_same_day').parent().css('border', '');
            $('.required_same_day').each(function () {
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
                } else {
                    verif.push(true);
                }
            });
            if (verif.includes(false)) {
                return;
            }

            currentLayout = 'over_night_delivery';
            $('#v-pills-tab a:eq(2)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(2)').addClass("active");
            $('#v-pills-02').removeClass('active show');
            $('#v-pills-03').addClass('active show');

            setTimeout(function () {
                $('#on_with_in_city_twentyfive').focus();
                $('#on_with_in_city_fifty').focus();
                $('#on_with_in_city_six').focus();
                $('#on_with_in_city_additional').focus();

                $('#on_with_in_prov_twentyfive').focus();
                $('#on_with_in_prov_fifty').focus();
                $('#on_with_in_prov_six').focus();
                $('#on_with_in_prov_additional').focus();

                $('#on_provience_to_prov_twentyfive').focus();
                $('#on_provience_to_prov_fifty').focus();
                $('#on_provience_to_prov_six').focus();
                $('#on_provience_to_prov_additional').focus();
            }, 500);

        } else if (currentLayout == 'over_night_delivery') {
            var verif = [];
            $('.required_over_night').css('border', '');
            $('.required_over_night').parent().css('border', '');
            $('.required_over_night').each(function () {
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
                } else {
                    verif.push(true);
                }
            });
            if (verif.includes(false)) {
                return;
            }

            currentLayout = 'second_day_delivery';
            $('#v-pills-tab a:eq(3)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(3)').addClass("active");
            $('#v-pills-03').removeClass('active show');
            $('#v-pills-04').addClass('active show');

            setTimeout(function () {
                $('#second_day_delivery_upto_3kg').focus();
                $('#second_day_delivery_additional_1KG').focus();
                $('#second_day_delivery_prov_to_prov_upto3KG').focus();
                $('#second_day_delivery_prov_to_prov_additional1KG').focus();
            }, 500);


        } else if (currentLayout == 'second_day_delivery') {
            var verif = [];
            $('.required_second_day').css('border', '');
            $('.required_second_day').parent().css('border', '');
            $('.required_second_day').each(function () {
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
                } else {
                    verif.push(true);
                }
            });

            if (verif.includes(false)) {
                return;
            }
            currentLayout = 'over_land_service';
            $('#v-pills-tab a:eq(4)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(4)').addClass("active");
            $('#v-pills-04').removeClass('active show');
            $('#v-pills-05').addClass('active show');
            //$('.membership_sidebar').text(numberWithCommas($('#membership_fee').val()));

            setTimeout(function () {
                $('#over_land_upto10KG').focus();
                $('#over_land_additional1KG').focus();
                $('#over_land_prov_to_prov_upto10KG').focus();
                $('#over_land_prov_to_prov_additionalpoint5KG').focus();
            }, 500);

        } else if (currentLayout == 'over_land_service') {
            var verif = [];
            $('.required_over_land').css('border', '');
            $('.required_over_land').parent().css('border', '');
            $('.required_over_land').each(function () {
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
                } else {
                    verif.push(true);
                }
            });
            if (verif.includes(false)) {
                return;
            }
            currentLayout = 'fragile_item_cost';
            $('#v-pills-tab a:eq(5)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(5)').addClass("active");
            $('#v-pills-05').removeClass('active show');
            $('#v-pills-06').addClass('active show');

            setTimeout(function () {
                $('#fragile_cost_price').focus();
            }, 500);


        } else if (currentLayout == 'fragile_item_cost') {
            var verif = [];
            $('.required_cost').css('border', '');
            $('.required_cost').parent().css('border', '');
            $('.required_cost').each(function () {
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
                } else {
                    verif.push(true);
                }
            });
            if (verif.includes(false)) {
                return;
            }
            currentLayout = 'insurance_on_consignment';
            $('#v-pills-tab a:eq(6)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(6)').addClass("active");
            $('#v-pills-06').removeClass('active show');
            $('#v-pills-07').addClass('active show');
            $('#cost_txt').text($('#fragile_cost_price').val());

            setTimeout(function () {
                $('#insurance_for_fragile').focus();
                $('#insurance_for_non_fragile').focus();
                $('#insurance_for_electronics').focus();
            }, 500);

        } else if (currentLayout == 'insurance_on_consignment') {
            var verif = [];
            $('.required_insurance').css('border', '');
            $('.required_insurance').parent().css('border', '');
            $('.required_insurance').each(function () {
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
                } else {
                    verif.push(true);
                }
            });
            if (verif.includes(false)) {
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
            setTimeout(function () {
                $('#supplementary_services_holiday').focus();
                $('#supplementary_services_special_holiday').focus();
                $('#supplementary_services_time_specified').focus();
                $('#supplementary_services_passport').focus();
            }, 500);

        } else if (currentLayout == 'supplementary_services') {
            var verif = [];
            $('.required_supplementary').css('border', '');
            $('.required_supplementary').parent().css('border', '');
            $('.required_supplementary').each(function () {
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
                } else {
                    verif.push(true);
                }
            });

            if (verif.includes(false)) {
                return;
            }
            currentLayout = 'fuel_charges';
            $('#v-pills-tab a:eq(8)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(8)').addClass("active");
            $('#v-pills-08').removeClass('active show');
            $('#v-pills-09').addClass('active show');
            setTimeout(function () {
                $('#fuel_charges').focus();
            }, 500);

        } else if (currentLayout == 'fuel_charges') {
            var verif = [];
            $('.required_fuel').css('border', '');
            $('.required_fuel').parent().css('border', '');
            $('.required_fuel').each(function () {
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
                } else {
                    verif.push(true);
                }
            });
            if (verif.includes(false)) {
                return;
            }
            currentLayout = 'government_taxes';
            $('#v-pills-tab a:eq(9)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(9)').addClass("active");
            $('#v-pills-09').removeClass('active show');
            $('#v-pills-10').addClass('active show');
            $('#fuel_txt').text($('#fuel_charges').val()+"%");
            setTimeout(function () {
                $('#gst_tax').focus();
            }, 500);

        } else if (currentLayout == 'government_taxes') {
            var verif = [];
            $('.required_tax').css('border', '');
            $('.required_tax').parent().css('border', '');
            $('.required_tax').each(function () {
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
                } else {
                    verif.push(true);
                }
            });

            if (verif.includes(false)) {
                return;
            }
            currentLayout = 'contract_copy';
            $('#v-pills-tab a:eq(10)').css("pointer-events", "");
            $('#v-pills-tab a').removeClass("active");
            $('#v-pills-tab a:eq(10)').addClass("active");
            $('#v-pills-10').removeClass('active show');
            $('#v-pills-11').addClass('active show');
            $('#gst_txt').text($('#gst_tax').val()+"%");

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
        //console.log($('.documents').files[0].name);
        $('.saveWholeForm').attr('disabled', 'disabled');
        $('.cancel_btn').attr('disabled', 'disabled');
        $(this).text('Processing..');

        $('#billing_form').append('<input hidden name="operation" value="' + $('#operation').val() + '" />');
        $('#billing_form').append('<input hidden name="billing_id_hidden" value="' + $('#billing_id_hidden').val() + '" />');
        $('#billing_form').append('<input hidden name="datepicker" value="' + $('#datepicker').val() + '" />');
        $('#billing_form').append('<input hidden name="with_in_city_twentyfive" value="' + $('#with_in_city_twentyfive').val() + '" />');
        $('#billing_form').append('<input hidden name="with_in_city_fifty" value="' + $('#with_in_city_fifty').val() + '" />');
        $('#billing_form').append('<input hidden name="with_in_city_six" value="' + $('#with_in_city_six').val() + '" />');
        $('#billing_form').append('<input hidden name="with_in_city_additional" value="' + $('#with_in_city_additional').val() + '" />');
        $('#billing_form').append('<input hidden name="with_in_province_twentyfive" value="' + $('#with_in_province_twentyfive').val() + '" />');
        $('#billing_form').append('<input hidden name="with_in_province_fifty" value="' + $('#with_in_province_fifty').val() + '" />');
        $('#billing_form').append('<input hidden name="with_in_province_six" value="' + $('#with_in_province_six').val() + '" />');
        $('#billing_form').append('<input hidden name="with_in_province_additional" value="' + $('#with_in_province_additional').val() + '" />');
        $('#billing_form').append('<input hidden name="prov_to_prov_twentyfive" value="' + $('#prov_to_prov_twentyfive').val() + '" />');
        $('#billing_form').append('<input hidden name="prov_to_prov_fifty" value="' + $('#prov_to_prov_fifty').val() + '" />');
        $('#billing_form').append('<input hidden name="prov_to_prov_six" value="' + $('#prov_to_prov_six').val() + '" />');
        $('#billing_form').append('<input hidden name="prov_to_prov_additional" value="' + $('#prov_to_prov_additional').val() + '" />');
        $('#billing_form').append('<input hidden name="on_with_in_city_twentyfive" value="' + $('#on_with_in_city_twentyfive').val() + '" />');
        $('#billing_form').append('<input hidden name="on_with_in_city_fifty" value="' + $('#on_with_in_city_fifty').val() + '" />');
        $('#billing_form').append('<input hidden name="on_with_in_city_six" value="' + $('#on_with_in_city_six').val() + '" />');
        $('#billing_form').append('<input hidden name="on_with_in_city_additional" value="' + $('#on_with_in_city_additional').val() + '" />');
        $('#billing_form').append('<input hidden name="on_with_in_prov_twentyfive" value="' + $('#on_with_in_prov_twentyfive').val() + '" />');
        $('#billing_form').append('<input hidden name="on_with_in_prov_fifty" value="' + $('#on_with_in_prov_fifty').val() + '" />');
        $('#billing_form').append('<input hidden name="on_with_in_prov_six" value="' + $('#on_with_in_prov_six').val() + '" />');
        $('#billing_form').append('<input hidden name="on_with_in_prov_additional" value="' + $('#on_with_in_prov_additional').val() + '" />');
        $('#billing_form').append('<input hidden name="on_provience_to_prov_twentyfive" value="' + $('#on_provience_to_prov_twentyfive').val() + '" />');
        $('#billing_form').append('<input hidden name="on_provience_to_prov_fifty" value="' + $('#on_provience_to_prov_fifty').val() + '" />');
        $('#billing_form').append('<input hidden name="on_provience_to_prov_six" value="' + $('#on_provience_to_prov_six').val() + '" />');
        $('#billing_form').append('<input hidden name="on_provience_to_prov_additional" value="' + $('#on_provience_to_prov_additional').val() + '" />');
        $('#billing_form').append('<input hidden name="second_day_delivery_upto_3kg" value="' + $('#second_day_delivery_upto_3kg').val() + '" />');
        $('#billing_form').append('<input hidden name="second_day_delivery_additional_1KG" value="' + $('#second_day_delivery_additional_1KG').val() + '" />');
        $('#billing_form').append('<input hidden name="second_day_delivery_prov_to_prov_upto3KG" value="' + $('#second_day_delivery_prov_to_prov_upto3KG').val() + '" />');
        $('#billing_form').append('<input hidden name="second_day_delivery_prov_to_prov_additional1KG" value="' + $('#second_day_delivery_prov_to_prov_additional1KG').val() + '" />');
        // $('#billing_form').append('<input hidden name="second_day_delivery_prov_to_prov_6to1KG" value="'+$('#second_day_delivery_prov_to_prov_6to1KG').val()+'" />');
        // $('#billing_form').append('<input hidden name="second_day_delivery_prov_to_prov_additionalpointFiveKg" value="'+$('#second_day_delivery_prov_to_prov_additionalpointFiveKg').val()+'" />');
        $('#billing_form').append('<input hidden name="over_land_upto10KG" value="' + $('#over_land_upto10KG').val() + '" />');
        $('#billing_form').append('<input hidden name="over_land_additional1KG" value="' + $('#over_land_additional1KG').val() + '" />');
        $('#billing_form').append('<input hidden name="over_land_prov_to_prov_upto10KG" value="' + $('#over_land_prov_to_prov_upto10KG').val() + '" />');
        $('#billing_form').append('<input hidden name="over_land_prov_to_prov_additionalpoint5KG" value="' + $('#over_land_prov_to_prov_additionalpoint5KG').val() + '" />');
        $('#billing_form').append('<input hidden name="fragile_cost_price" value="' + $('#fragile_cost_price').val() + '" />');
        $('#billing_form').append('<input hidden name="insurance_for_fragile" value="' + $('#insurance_for_fragile').val() + '" />');
        $('#billing_form').append('<input hidden name="insurance_for_non_fragile" value="' + $('#insurance_for_non_fragile').val() + '" />');
        $('#billing_form').append('<input hidden name="insurance_for_electronics" value="' + $('#insurance_for_electronics').val() + '" />');
        $('#billing_form').append('<input hidden name="supplementary_services_holiday" value="' + $('#supplementary_services_holiday').val() + '" />');
        $('#billing_form').append('<input hidden name="supplementary_services_special_holiday" value="' + $('#supplementary_services_special_holiday').val() + '" />');
        $('#billing_form').append('<input hidden name="supplementary_services_time_specified" value="' + $('#supplementary_services_time_specified').val() + '" />');
        $('#billing_form').append('<input hidden name="supplementary_services_passport" value="' + $('#supplementary_services_passport').val() + '" />');
        $('#billing_form').append('<input hidden name="fuel_charges" value="' + $('#fuel_charges').val() + '" />');
        $('#billing_form').append('<input hidden name="gst_tax" value="' + $('#gst_tax').val() + '" />');


        $('#billing_form').ajaxSubmit({
            type: "POST",
            url: '/SaveBilling',
            data: $('#billing_form').serialize(),
            // data: {
            //     _token: '{!! csrf_token() !!}',
            //     start_date 
            // with_in_city_twentyfive 
            // with_in_city_fifty 
            // with_in_city_six 
            // with_in_city_additional 
            // with_in_province_twentyfive 
            // with_in_province_fifty 
            // with_in_province_six 
            // with_in_province_additional 
            // prov_to_prov_twentyfive 
            // prov_to_prov_fifty 
            // prov_to_prov_six 
            // prov_to_prov_additional 
            // on_with_in_city_twentyfive 
            // on_with_in_city_fifty 
            // on_with_in_city_six 
            // on_with_in_city_additional 
            // on_with_in_prov_twentyfive 
            // on_with_in_prov_fifty 
            // on_with_in_prov_six 
            // on_with_in_prov_additional 
            // on_provience_to_prov_twentyfive 
            // on_provience_to_prov_fifty 
            // on_provience_to_prov_six 
            // on_provience_to_prov_additional 
            // second_day_delivery_upto_3kg 
            // second_day_delivery_additional_1KG 
            // second_day_delivery_prov_to_prov_upto3KG 
            // second_day_delivery_prov_to_prov_additional1KG 
            // second_day_delivery_prov_to_prov_6to1KG 
            // second_day_delivery_prov_to_prov_additionalpointFiveKg 
            // over_land_upto10KG 
            // over_land_additional1KG 
            // over_land_prov_to_prov_upto10KG = $('#over_land_prov_to_prov_upto10KG').val();
            // over_land_prov_to_prov_additionalpoint5KG = $('#over_land_prov_to_prov_additionalpoint5KG').val();
            // fragile_cost_price = $('#fragile_cost_price').val();
            // insurance_for_fragile = $('#insurance_for_fragile').val();
            // insurance_for_non_fragile = $('#insurance_for_non_fragile').val();
            // insurance_for_electronics = $('#insurance_for_electronics').val();
            // supplementary_services_holiday = $('#supplementary_services_holiday').val();
            // supplementary_services_special_holiday = $('#supplementary_services_special_holiday').val();
            // supplementary_services_time_specified = $('#supplementary_services_time_specified').val();
            // supplementary_services_passport = $('#supplementary_services_passport').val();
            // fuel_charges = $('#fuel_charges').val();
            // gst_tax = $('#gst_tax').val();

            // },
            cache: false,
            success: function (response) {
                //console.log(response);
                //return;
                if (JSON.parse(response) == "success") {
                    // fetchClientsList();
                    $('.saveWholeForm').removeAttr('disabled');
                    $('.cancel_btn').removeAttr('disabled');
                    $('.saveWholeForm').text('Save');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Billing have been added successfully');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    window.location.href = '/select_customer';
                } else if (JSON.parse(response) == "failed") {
                    $('.saveWholeForm').removeAttr('disabled');
                    $('.cancel_btn').removeAttr('disabled');
                    $('.saveWholeForm').text('Save');
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Failed to add billing at the moment');
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

    $(document).on('click', '.Doclink', function () {

        if (sider_bar_open) {
            $('#pl-close').click();
            sider_bar_open = false;
            $('.Doclink').removeAttr('disabled');
        } else {
            $('#product-cl-sec').addClass('active');
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            $('body').toggleClass('no-scroll');
            $('#product-cl-sec').css('z-index', 2000);
            setTimeout(function () {
                sider_bar_open = true;
                $('.Doclink').attr('disabled', 'disabled');
            }, 500);
        }

        // 
    });

    $(document).on('click', '#exampleModal', function () {
        if (sider_bar_open) {
            $('#pl-close').click();
            sider_bar_open = false;
            $('.Doclink').removeAttr('disabled');
        }
    });

    // var acceptedFileTypes = "image/*"; //dropzone requires this param be a comma separated list
    // var fileList = new Array;
    // var i = 0;
    // var myDropzone = new Dropzone("#dropzonewidget", {
    //     url: "/test-upload",
    //     addRemoveLinks: true,
    //     maxFiles: 4,
    //     acceptedFiles: 'image/*',
    //     maxFilesize: 5,
    //     init: function() {
    //         this.on("success", function(file, serverFileName) {
    //             file.serverFn = serverFileName;
    //             fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i };
    //             i++;
    //         });
    //     },
    //     removedfile: function(file) {
    //         var name = file.serverFn;
    //         $.ajax({
    //         type: 'GET',
    //         url: '/testingRoute/'+name,
    //         sucess: function(data){
    //             console.log('success: ' + data);
    //         }
    //         });
    //         var _ref;
    //         return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
    //     }
    // });

});

// function fetchCustomersList() {
//     $.ajax({
//         type: 'GET',
//         url: '/GetCustomersListForBilling',
//         success: function(response) {
//             $('.body').empty();
//             $('.body').append('<table class="table table-hover dt-responsive nowrap" id="companiesListTable" style="width:100%;"><thead><tr><th>ID</th><th>Customer Name</th><th>POC</th><th>Country</th><th>City</th><th>Action</th></tr></thead><tbody></tbody></table>');
//             $('#companiesListTable tbody').empty();
//             var response = JSON.parse(response);
//             response.forEach(element => {
//                 $('#companiesListTable tbody').append('<tr><td>' + element['id'] + '</td><td>' + element['company_name'] + '</td><td>' + element['company_poc'] + '</td><td>' + element['country'] + '</td><td>' + element['city'] + '</td><td><a href="/billing/' + element['id'] +'"><button id="' + element['id'] + '" class="btn btn-default btn-line">Create Billing</button></a></td></tr>');
//             });
//             $('#tblLoader').hide();
//             $('.body').fadeIn();
//             $('#companiesListTable').DataTable();
//         }
//     });
// }
function check_billing_addedOrNot() {
    var segments = location.href.split('/');
    var id = segments[4];

    $.ajax({
        type: 'GET',
        url: '/checkBillinAddedOrNot/' + id,
        success: function (response) {
            $('#tblLoader').hide();
            $('#container_layout').show();
            if (JSON.parse(response) == "not_added") {
                $('#operation').val('add');
                $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                });
            } else {
                var myDate = new Date("2019-02-02");
                var date = myDate.getFullYear() + '-' + ('0' + myDate.getMonth() + 1).slice(-2) + '-' + ('0' + myDate.getDate()).slice(-2);
                $("#datepicker").val(date);
                //$('.preview_modal_btn').show();
                $('#operation').val('update');
                var response = JSON.parse(response);
                var counter = 0;
                console.log(response['docs']);
                response['billing'].forEach(element => {
                    $('#billing_id_hidden').val(element['id']);
                    // $("#datepicker").datepicker({
                    //     format: 'yyyy-mm-dd',
                    // }).on("show", function() {
                    //     $(this).val(element['start_date']).datepicker('update');
                    // });
                    $('#datepicker').datepicker("setDate", new Date(element['start_date']));
                    $('#modal_start_date_div').text('Start Date: ' + element['start_date']);

                    $('#fragile_cost_price').val(element['fragile_cost']);
                    $('#cost_txt').text(element['fragile_cost']);
                    $('#modal_fragile_cost').text(element['fragile_cost']);

                    $('#insurance_for_fragile').val(element['insurance_for_fragile']);
                    $('#f_insurance_txt').text(element['insurance_for_fragile']);
                    $('#modal_insurance_fragile').text(element['insurance_for_fragile']);

                    $('#insurance_for_non_fragile').val(element['insurance_for_non_fragile']);
                    $('#modal_insurance_non_fragile').text(element['insurance_for_non_fragile']);

                    $('#insurance_for_electronics').val(element['insurance_for_electronics']);
                    $('#e_insurance_txt').text(element['insurance_for_electronics']);
                    $('#modal_insurance_electronics').text(element['insurance_for_electronics']);

                    $('#supplementary_services_holiday').val(element['holiday']);
                    $('#modal_supplementary_holiday').text(element['holiday']);

                    $('#supplementary_services_special_holiday').val(element['special_handling']);
                    $('#modal_supplementary_special_handling').text(element['special_handling']);

                    $('#supplementary_services_time_specified').val(element['time_specified']);
                    $('#modal_supplementary_time_specified').text(element['time_specified']);

                    $('#supplementary_services_passport').val(element['passport']);
                    $('#modal_supplementary_passport').text(element['passport']);

                    $('#fuel_charges').val(element['fuel_charges']);
                    $('#fuel_txt').text(element['fuel_charges']+"%");
                    $('#modal_fuel').text(element['fuel_charges'] + "%");

                    $('#gst_tax').val(element['tax']);
                    $('#gst_txt').text(element['tax']+"%");
                    $('#modal_tax').text(element['fuel_charges'] + "%");
                    //console.log(element['id']);
                });

                response['criteria'].forEach(element => {

                    //Same Day
                    if (element['type'] == 'within city' && element['criteria'] == 0) {
                        $('#with_in_city_twentyfive').val(element['upto_025']);
                        $('#modal_withinCity_sameDay_025').text(element['upto_025']);

                        $('#with_in_city_fifty').val(element['upto_05']);
                        $('#modal_withinCity_sameDay_50').text(element['upto_05']);

                        $('#with_in_city_six').val(element['zero_five_1KG']);
                        $('#modal_withinCity_sameDay_051').text(element['zero_five_1KG']);

                        $('#with_in_city_additional').val(element['additionals_05']);
                        $('#modal_withinCity_sameDay_additional').text(element['additionals_05']);
                    }
                    if (element['type'] == 'within province' && element['criteria'] == 0) {
                        $('#with_in_province_twentyfive').val(element['upto_025']);
                        $('#modal_withinProvince_sameDay_025').text(element['upto_025']);

                        $('#with_in_province_fifty').val(element['upto_05']);
                        $('#modal_withinProv_sameDay_50').text(element['upto_05']);

                        $('#with_in_province_six').val(element['zero_five_1KG']);
                        $('#modal_withinProv_sameDay_051').text(element['zero_five_1KG']);

                        $('#with_in_province_additional').val(element['additionals_05']);
                        $('#modal_withinProv_sameDay_additional').text(element['additionals_05']);
                    }
                    if (element['type'] == 'province to province' && element['criteria'] == 0) {
                        $('#prov_to_prov_twentyfive').val(element['upto_025']);
                        $('#modal_ProvToProv_sameDay_025').text(element['upto_025']);

                        $('#prov_to_prov_fifty').val(element['upto_05']);
                        $('#modal_ProvToProv_sameDay_50').text(element['upto_05']);

                        $('#prov_to_prov_six').val(element['zero_five_1KG']);
                        $('#modal_ProvToProv_sameDay_051').text(element['zero_five_1KG']);

                        $('#prov_to_prov_additional').val(element['additionals_05']);
                        $('#modal_ProvToProv_sameDay_additional').text(element['additionals_05']);
                    }

                    //Over Night
                    if (element['type'] == 'within city' && element['criteria'] == 1) {
                        $('#on_with_in_city_twentyfive').val(element['upto_025']);
                        $('#modal_withinCity_overNight_025').text(element['upto_025']);

                        $('#on_with_in_city_fifty').val(element['upto_05']);
                        $('#modal_withinCity_overNight_50').text(element['upto_05']);

                        $('#on_with_in_city_six').val(element['zero_five_1KG']);
                        $('#modal_withinCity_overNight_051').text(element['zero_five_1KG']);

                        $('#on_with_in_city_additional').val(element['additionals_05']);
                        $('#modal_withinCity_overNight_additional').text(element['additionals_05']);
                    }
                    if (element['type'] == 'within province' && element['criteria'] == 1) {
                        $('#on_with_in_prov_twentyfive').val(element['upto_025']);
                        $('#modal_withinProv_overNight_025').text(element['upto_025']);

                        $('#on_with_in_prov_fifty').val(element['upto_05']);
                        $('#modal_withinProv_overNight_50').text(element['upto_05']);

                        $('#on_with_in_prov_six').val(element['zero_five_1KG']);
                        $('#modal_withinProv_overNight_051').text(element['zero_five_1KG']);

                        $('#on_with_in_prov_additional').val(element['additionals_05']);
                        $('#modal_withinProv_overNight_additional').text(element['additionals_05']);
                    }
                    if (element['type'] == 'province to province' && element['criteria'] == 1) {
                        $('#on_provience_to_prov_twentyfive').val(element['upto_025']);
                        $('#modal_ProvToProv_overNight_025').text(element['upto_025']);

                        $('#on_provience_to_prov_fifty').val(element['upto_05']);
                        $('#modal_ProvToProv_overNight_50').text(element['upto_05']);

                        $('#on_provience_to_prov_six').val(element['zero_five_1KG']);
                        $('#modal_ProvToProv_overNight_051').text(element['zero_five_1KG']);

                        $('#on_provience_to_prov_additional').val(element['additionals_05']);
                        $('#modal_ProvToProv_overNight_additional').text(element['additionals_05']);
                    }

                    //Second Day
                    if (element['type'] == 'within province' && element['criteria'] == 2) {
                        $('#second_day_delivery_upto_3kg').val(element['upto_3KG']);
                        $('#modal_withinProv_secondDay_upto3Kg').text(element['upto_3KG']);

                        $('#second_day_delivery_additional_1KG').val(element['additional_1KG']);
                        $('#modal_withinProv_secondDay_additional').text(element['additional_1KG']);
                    }
                    if (element['type'] == 'province to province' && element['criteria'] == 2) {
                        $('#second_day_delivery_prov_to_prov_upto3KG').val(element['upto_3KG']);
                        $('#modal_ProvToProv_secondDay_upto3Kg').text(element['upto_3KG']);

                        $('#second_day_delivery_prov_to_prov_additional1KG').val(element['additional_1KG']);
                        $('#modal_ProvToProv_secondDay_additional').text(element['additional_1KG']);
                    }

                    //Over Land
                    if (element['type'] == 'within province' && element['criteria'] == 3) {
                        $('#over_land_upto10KG').val(element['upto_10KG']);
                        $('#modal_withinProv_overLand_upto3Kg').text(element['upto_10KG']);

                        $('#over_land_additional1KG').val(element['additional_1KG']);
                        $('#modal_withinProv_overLand_additional').text(element['additional_1KG']);
                        $('#modal_withinProv_overLand_additional05').text('-');
                    }
                    if (element['type'] == 'province to province' && element['criteria'] == 3) {
                        $('#over_land_prov_to_prov_upto10KG').val(element['upto_10KG']);
                        $('#modal_ProvToProv_overLand_upto3Kg').text(element['upto_10KG']);

                        $('#over_land_prov_to_prov_additionalpoint5KG').val(element['additionals_05']);
                        $('#modal_ProvToProv_overLand_additional').text('-');
                        $('#modal_ProvToProv_overLand_additional05').text(element['additionals_05']);
                    }

                });

                // setTimeout(function(){
                //     $('#on_with_in_city_twentyfive').focus();
                //     $('#on_with_in_city_fifty').focus();
                //     $('#on_with_in_city_six').focus();
                //     $('#on_with_in_city_additional').focus();

                //     $('#on_with_in_prov_twentyfive').focus();
                //     $('#on_with_in_prov_fifty').focus();
                //     $('#on_with_in_prov_six').focus();
                //     $('#on_with_in_prov_additional').focus();

                //     $('#on_provience_to_prov_twentyfive').focus();
                //     $('#on_provience_to_prov_fifty').focus();
                //     $('#on_provience_to_prov_six').focus();
                //     $('#on_provience_to_prov_additional').focus();
                // }, 2000);



                response['docs'].forEach(element => {
                    $('.test_images_modal').prepend('<img src="' + response['pic_url'] + element['billing_docs'] + '" style="max-width:250px; max-height:250px; padding:20px;"/>');
                });

                $('#modal_poc_name').text('POC Name: ' + response['customer_detail'].poc_name);
                $('#modal_client_name').text('Name: ' + response['customer_detail'].username);
                $('#modal_address').text('Address: ' + response['customer_detail'].address);

                var mockFile = "";
                response.docs.forEach(element => {
                    mockFile = {
                        name: response['pic_url'] + element['billing_docs'],
                        size: 12345
                    };
                    myDropzone.options.addedfile.call(myDropzone, mockFile);
                    // And to show the thumbnail of the file:
                    myDropzone.options.thumbnail.call(myDropzone, mockFile, response['pic_url'] + element['billing_docs']);
                });

                setTimeout(function () {
                    $('.dz-image').find('img').css('width', '100%');
                    $('.dz-image').find('img').css('height', '100%');
                }, 500);

            }
        }
    });
}
