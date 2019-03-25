$(document).ready(function () { 
    var segments = location.href.split('/');
    var action = segments[3];
    var sider_bar_open = false;
    if(action == "select_customer"){
        fetchCustomersList();
    }else{
        fetchCustomersListBillingAdded();
    }

    $(document).on('click', '.preview_from_list', function(){
        $('#modal_start_date_div').text('--');
        $('#modal_fragile_cost').text('--');
        $('#modal_insurance_fragile').text('--');
        $('#modal_insurance_non_fragile').text('--');
        $('#modal_insurance_electronics').text('--');
        $('#modal_supplementary_holiday').text('--');
        $('#modal_supplementary_special_handling').text('--');
        $('#modal_supplementary_time_specified').text('--');
        $('#modal_supplementary_passport').text('--');
        $('#modal_fuel').text('--');
        $('#modal_tax').text('--');
        $('#modal_withinCity_sameDay_025').text('--');
        $('#modal_withinCity_sameDay_50').text('--');
        $('#modal_withinCity_sameDay_051').text('--');
        $('#modal_withinCity_sameDay_additional').text('--');
        $('#modal_withinProvince_sameDay_025').text('--');
        $('#modal_withinProv_sameDay_50').text('--');
        $('#modal_withinProv_sameDay_051').text('--');
        $('#modal_withinProv_sameDay_additional').text('--');
        $('#modal_ProvToProv_sameDay_025').text('--');
        $('#modal_ProvToProv_sameDay_50').text('--');
        $('#modal_ProvToProv_sameDay_051').text('--');
        $('#modal_ProvToProv_sameDay_additional').text('--');
        $('#modal_withinCity_overNight_025').text('--');
        $('#modal_withinCity_overNight_50').text('--');
        $('#modal_withinCity_overNight_051').text('--');
        $('#modal_withinCity_overNight_additional').text('--');
        $('#modal_withinProv_overNight_025').text('--');
        $('#modal_withinProv_overNight_50').text('--');
        $('#modal_withinProv_overNight_051').text('--');
        $('#modal_withinProv_overNight_additional').text('--');
        $('#modal_ProvToProv_overNight_025').text('--');
        $('#modal_ProvToProv_overNight_50').text('--');
        $('#modal_ProvToProv_overNight_051').text('--');
        $('#modal_ProvToProv_overNight_additional').text('--');
        $('#modal_withinProv_secondDay_upto3Kg').text('--');
        $('#modal_withinProv_secondDay_additional').text('--');
        $('#modal_ProvToProv_secondDay_upto3Kg').text('--');
        $('#modal_ProvToProv_secondDay_additional').text('--');
        $('#modal_withinProv_overLand_upto3Kg').text('--');
        $('#modal_withinProv_overLand_additional').text('--');
        $('#modal_ProvToProv_overLand_upto3Kg').text('--');
        $('#modal_ProvToProv_overLand_additional').text('--');
        $('#modal_poc_name').text('--');
        $('#modal_client_name').text('--');
        $('#modal_address').text('--'); 
        $('.test_images_modal').empty();

        $.ajax({
            type: 'GET',
            url: '/checkBillinAddedOrNot/' + $(this).attr('id'),
            success: function (response) {
                if (JSON.parse(response) == "not_added") {
                   //if billing not_added
                } else {
                    var myDate = new Date("2019-02-02");
                    var date = myDate.getFullYear() + '-' + ('0' + myDate.getMonth() + 1).slice(-2) + '-' + ('0' + myDate.getDate()).slice(-2);
                    var response = JSON.parse(response);
                    var counter = 0;
                   // console.log(response['docs']);
                    response['billing'].forEach(element => {
                        $('#modal_start_date_div').text('Start Date: ' + element['start_date']);
                        $('#modal_fragile_cost').text(element['fragile_cost']);
                        $('#modal_insurance_fragile').text(element['insurance_for_fragile']);
                        $('#modal_insurance_non_fragile').text(element['insurance_for_non_fragile']);
                        $('#modal_insurance_electronics').text(element['insurance_for_electronics']);
                        $('#modal_supplementary_holiday').text(element['holiday']);
                        $('#modal_supplementary_special_handling').text(element['special_handling']);
                        $('#modal_supplementary_time_specified').text(element['time_specified']);
                        $('#modal_supplementary_passport').text(element['passport']);
                        $('#modal_fuel').text(element['fuel_charges'] + "%");
                        $('#modal_tax').text(element['fuel_charges'] + "%");
                    });
    
                    response['criteria'].forEach(element => {
    
                        //Same Day
                        if (element['type'] == 'within city' && element['criteria'] == 0) {
                            $('#modal_withinCity_sameDay_025').text(element['upto_025']);
    
                            $('#modal_withinCity_sameDay_50').text(element['upto_05']);
    
                            $('#modal_withinCity_sameDay_051').text(element['zero_five_1KG']);
    
                            $('#modal_withinCity_sameDay_additional').text(element['additionals_05']);
                        }
                        if (element['type'] == 'within province' && element['criteria'] == 0) {
                            $('#modal_withinProvince_sameDay_025').text(element['upto_025']);
    
                            $('#modal_withinProv_sameDay_50').text(element['upto_05']);
    
                            $('#modal_withinProv_sameDay_051').text(element['zero_five_1KG']);
    
                            $('#modal_withinProv_sameDay_additional').text(element['additionals_05']);
                        }
                        if (element['type'] == 'province to province' && element['criteria'] == 0) {
                            $('#modal_ProvToProv_sameDay_025').text(element['upto_025']);
    
                            $('#modal_ProvToProv_sameDay_50').text(element['upto_05']);
    
                            $('#modal_ProvToProv_sameDay_051').text(element['zero_five_1KG']);

                            $('#modal_ProvToProv_sameDay_additional').text(element['additionals_05']);
                        }
    
                        //Over Night
                        if (element['type'] == 'within city' && element['criteria'] == 1) {
                            $('#modal_withinCity_overNight_025').text(element['upto_025']);
    
                            $('#modal_withinCity_overNight_50').text(element['upto_05']);
    
                            $('#modal_withinCity_overNight_051').text(element['zero_five_1KG']);
    
                            $('#modal_withinCity_overNight_additional').text(element['additionals_05']);
                        }
                        if (element['type'] == 'within province' && element['criteria'] == 1) {
                            $('#modal_withinProv_overNight_025').text(element['upto_025']);
    
                            $('#modal_withinProv_overNight_50').text(element['upto_05']);
    
                            $('#modal_withinProv_overNight_051').text(element['zero_five_1KG']);
    
                            $('#modal_withinProv_overNight_additional').text(element['additionals_05']);
                        }
                        if (element['type'] == 'province to province' && element['criteria'] == 1) {
                            $('#modal_ProvToProv_overNight_025').text(element['upto_025']);
    
                            $('#modal_ProvToProv_overNight_50').text(element['upto_05']);

                            $('#modal_ProvToProv_overNight_051').text(element['zero_five_1KG']);
    
                            $('#modal_ProvToProv_overNight_additional').text(element['additionals_05']);
                        }
    
                        //Second Day
                        if (element['type'] == 'within province' && element['criteria'] == 2) {
                            $('#modal_withinProv_secondDay_upto3Kg').text(element['upto_3KG']);
    
                            $('#modal_withinProv_secondDay_additional').text(element['additional_1KG']);
                        }
                        if (element['type'] == 'province to province' && element['criteria'] == 2) {
                            $('#modal_ProvToProv_secondDay_upto3Kg').text(element['upto_3KG']);
    
                            $('#modal_ProvToProv_secondDay_additional').text(element['additional_1KG']);
                        }
    
                        //Over Land
                        if (element['type'] == 'within province' && element['criteria'] == 3) {
                            $('#modal_withinProv_overLand_upto3Kg').text(element['upto_10KG']);
    
                            $('#modal_withinProv_overLand_additional').text(element['additional_1KG']);
                            $('#modal_withinProv_overLand_additional05').text('-');
                        }
                        if (element['type'] == 'province to province' && element['criteria'] == 3) {
                            $('#modal_ProvToProv_overLand_upto3Kg').text(element['upto_10KG']);
    
                            $('#modal_ProvToProv_overLand_additional').text('-');
                            $('#modal_ProvToProv_overLand_additional05').text(element['additionals_05']);
                        }
    
                    });
    
                    response['docs'].forEach(element => {
                        $('.test_images_modal').prepend('<img src="' + response['pic_url'] + element['billing_docs'] + '" style="max-width:250px; max-height:250px; padding:20px;"/>');
                    });
    
                    $('#modal_poc_name').text('POC Name: ' + response['customer_detail'].poc_name);
                    $('#modal_client_name').text('Name: ' + response['customer_detail'].username);
                    $('#modal_address').text('Address: ' + response['customer_detail'].address); 
    
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
    
});

function fetchCustomersList() {
    $.ajax({
        type: 'GET',
        url: '/GetCustomersListForBilling',
        success: function(response) {
            $('.body').empty();
            $('.body').append('<table class="table table-hover dt-responsive nowrap" id="companiesListTable" style="width:100%;"><thead><tr><th>ID</th><th>Company Name</th><th>POC</th><th>City</th><th>Phone#</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#companiesListTable tbody').empty();
            var response = JSON.parse(response);

            response.forEach(element => {
                $('#companiesListTable tbody').append('<tr><td>' + element['id'] + '</td><td>' + element['company_name'] + '</td><td>' + element['poc_name'] + '</td><td>' + element['city'] + '</td><td>' + element['phone'] + '</td><td>'+ '<a href="/billing/' + element['id'] +'"><button id="' + element['id'] + '" class="btn btn-default btn-line">Create Billing</button></a>' +'</td></tr>');
            });


            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#companiesListTable').DataTable();
        }
    });
}

function fetchCustomersListBillingAdded(){
    $.ajax({
        type: 'GET',
        url: '/GetCustomersListOfAddedBilling',
        success: function(response) {
            $('.body').empty();
            $('.body').append('<table class="table table-hover dt-responsive nowrap" id="companiesListTable" style="width:100%;"><thead><tr><th>ID</th><th>Company Name</th><th>POC</th><th>City</th><th>Phone#</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#companiesListTable tbody').empty();
            var response = JSON.parse(response);

            response.forEach(element => {
                $('#companiesListTable tbody').append('<tr><td>' + element['id'] + '</td><td>' + element['company_name'] + '</td><td>' + element['poc_name'] + '</td><td>' + element['city'] + '</td><td>' + element['phone'] + '</td><td>'+ '<button id="' + element['id'] + '" class="btn btn-default preview_from_list"data-toggle="modal"  data-target="#exampleModal">Preview</button><a href="/billing/' + element['id'] +'"><button id="' + element['id'] + '" class="btn btn-default btn-line">Manage Billing</button></a>' +'</td></tr>');
            });


            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#companiesListTable').DataTable();
        }
    });
}