$(document).ready(function() { 
    var segments = location.href.split('/');
    var action = segments[3];
    if(action == "complaints_list_client"){
        fetchComplaintsClient();
    }else if (action == "suggestions_list_client"){
        fetchSuggestionsClient();
    }
    $(document).on('click', '#rb-complaint', function(){
        $('.header_suggestion').hide();
        $('.suggestions_div').hide();
        $('.header_complaint').show();
        $('.complaints_div').show();
    });

    $(document).on('click', '#rb-suggestione', function(){
        $('.header_complaint').hide();
        $('.complaints_div').hide();
        $('.header_suggestion').show();
        $('.suggestions_div').show();
    });

    $(document).on('click', '.save_btn', function(){
        if($('#rb-complaint').prop('checked')){
            var verif = [];
            $('.required_complain').css('border', '');
            $('.required_complain').parent().css('border', '');
            $('.required_complain').each(function () {
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

            if(verif.includes(false)){
                return;
            }

        $('.save_btn').attr('disabled', 'disabled');
        $('.save_btn').text('Processing..');

            $('#saveComplaints').ajaxSubmit({
                type: "POST",
                url: "/saveComplaints",
                data: $('#saveComplaints').serialize(),
                cache: false,
                success: function(response) {
                    // console.log(response);
                    // return;
                    if (JSON.parse(response) == "success") {
                        $('.save_btn').removeAttr('disabled');
                         $('.save_btn').text('Save');
                         $('#notifDiv').fadeIn();
                         $('#notifDiv').css('background', 'green');
                         $('#notifDiv').text('Complaint have been added successfully');
                         setTimeout(() => {
                             $('#notifDiv').fadeOut();
                         }, 3000);
                         $('#name_complaint').val("");
                         $('#cell_complaint').val("");
                         $('#email_complaint').val("");
                         $('#subject_complaint').val("");
                         $('#tracking_no_complaint').val("");
                         $('#description_complaint').val("");
                         $('#client_id').val("");
                    } else {
                        $('.save_btn').removeAttr('disabled');
                        $('.save_btn').text('Save');
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'red');
                        $('#notifDiv').text('Failed to add complaint at the moment');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                        $('#name_complaint').val("");
                        $('#cell_complaint').val("");
                        $('#email_complaint').val("");
                        $('#subject_complaint').val("");
                        $('#tracking_no_complaint').val("");
                        $('#description_complaint').val("");
                        $('#client_id').val("");
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

        }else{
            var verif = [];
            $('.required_suggestion').css('border', '');
            $('.required_suggestion').parent().css('border', '');

            $('.required_suggestion').each(function () {
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

            if(verif.includes(false)){
                return;
            }

            $('.save_btn').attr('disabled', 'disabled');
            $('.save_btn').text('Processing..');

            $('#saveSuggestions').ajaxSubmit({
                type: "POST",
                url: "/saveSuggestion",
                data: $('#saveSuggestions').serialize(),
                cache: false,
                success: function(response) {
                    if (JSON.parse(response) == "success") {
                        $('.save_btn').removeAttr('disabled');
                         $('.save_btn').text('Save');
                         $('#notifDiv').fadeIn();
                         $('#notifDiv').css('background', 'green');
                         $('#notifDiv').text('Suggestion have been added successfully');
                         setTimeout(() => {
                             $('#notifDiv').fadeOut();
                         }, 3000);
                         $('#name_suggestions').val("");
                         $('#call_suggestions').val("");
                         $('#email_suggestions').val("");
                         $('#city_suggestions').val("0").trigger('change');
                         $('#subject_suggestions').val("");
                         $('#description_suggestions').val("");
                         $('#client_id').val("");
                    } else {
                        $('.save_btn').removeAttr('disabled');
                        $('.save_btn').text('Save');
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'red');
                        $('#notifDiv').text('Failed to add suggestion at the moment');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                        $('#name_suggestions').val("");
                         $('#call_suggestions').val("");
                         $('#email_suggestions').val("");
                         $('#city_suggestions').val("0").trigger('change');
                         $('#subject_suggestions').val("");
                         $('#description_suggestions').val("");
                         $('#client_id').val("");
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

        }
    });

    //Delete
    var complain_id_glob = '';
    var glob_complain_ref = '';
    $(document).on('click', '.delete_complain', function(){
        complain_id_glob = $(this).attr('id');
        glob_complain_ref = $(this);
    });

    $(document).on('click', '.delete_suggestion', function(){
        //Complain and Suggestions ka table aik he hai is lya aik he Modal kam karay ga.
        complain_id_glob = $(this).attr('id');
        glob_complain_ref = $(this);
    });

    $(document).on('click', '#link_delete_complain', function(){
        glob_complain_ref.text('Processing...');
        glob_complain_ref.attr('disabled', 'disabled');
        $.ajax({
            type: 'GET',
            url: '/delete_complainOrSuggestion',
            data: {
                id: complain_id_glob,
                _token: '{!! csrf_token() !!}'
           },
            success: function(response) {
                if(JSON.parse(response) == 'success'){
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text('Deleted successfully.');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    if(action == "complaints_list_client"){
                        fetchComplaintsClient();
                    }else if (action == "suggestions_list_client"){
                        fetchSuggestionsClient();
                    }
                }else{
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

function fetchComplaintsClient(){
    $.ajax({
        type: 'GET',
        url: '/GetCompliantsListClient',
        success: function(response) {
            var response = JSON.parse(response);
            $('.body').empty();
            $('.body').append('<table class="table table-hover dt-responsive nowrap" id="complaintsListClient" style="width:100%;"><thead><tr><th>Date</th><th>Subject</th><th>Tracking No</th><th>Status</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#complaintsListClient tbody').empty();
            response["data"].forEach(element => {
                $('#complaintsListClient tbody').append('<tr><td>' + element['created_at'] + '</td><td>' + element['subject'] + '</td><td>' + element['tracking_num'] + '</td><td>' + element['status'] + '</td><td><button id="' + element['id'] + '" class="btn btn-default">View Detail</button>'+ (response["status"] == "admin" ? '<button id="' + element['id'] + '" class="btn btn-default red-bg delete_complain" data-toggle="modal" data-target="#exampleModal">Delete</button>' : '') +'</td></tr>');
            });
            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#complaintsListClient').DataTable();
        }
    });
}

function fetchSuggestionsClient(){
    $.ajax({
        type: 'GET',
        url: '/GetSuggestionsListClient',
        success: function(response) {
            var response = JSON.parse(response);
            $('.body').empty();
            $('.body').append('<table class="table table-hover dt-responsive nowrap" id="complaintsListClient" style="width:100%;"><thead><tr><th>Date</th><th>Subject</th><th>City</th><th>Status</th><th>Action</th></tr></thead><tbody></tbody></table>');
            $('#complaintsListClient tbody').empty();
            response["data"].forEach(element => {
                $('#complaintsListClient tbody').append('<tr><td>' + element['created_at'] + '</td><td>' + element['subject'] + '</td><td>' + element['city'] + '</td><td>' + element['status'] + '</td><td><button id="' + element['id'] + '" class="btn btn-default">View Detail</button>'+ (response["status"] == "admin" ? '<button id="' + element['id'] + '" class="btn btn-default red-bg delete_suggestion" data-toggle="modal" data-target="#exampleModal">Delete</button>' : '') +'</td></tr>');
            });
            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#complaintsListClient').DataTable();
        }
    });
}