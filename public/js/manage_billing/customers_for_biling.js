$(document).ready(function () { 
    fetchCustomersList();
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
                $('#companiesListTable tbody').append('<tr><td>' + element['id'] + '</td><td>' + element['company_name'] + '</td><td>' + element['poc_name'] + '</td><td>' + element['city'] + '</td><td>' + element['phone'] + '</td><td><a href="/billing/' + element['id'] +'"><button id="' + element['id'] + '" class="btn btn-default btn-line">Create Billing</button></a></td></tr>');
            });
            $('#tblLoader').hide();
            $('.body').fadeIn();
            $('#companiesListTable').DataTable();
        }
    });
}