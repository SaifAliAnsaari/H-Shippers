<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();
Route::Resource('/Customer', 'Customer');

Route::Resource('/ProspectCustomers', 'ProspectCustomers');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/GetCustomersList', 'Customer@CustomersList');
Route::get('/GetClientsList', 'Clients@ClientsList');

Route::get('/EmployeesList', 'Auth\RegisterController@EmployeesList');
Route::post('/UploadUserImage', 'Auth\RegisterController@UploadUserImage');
Route::get('/Employee/{id}', 'Employee@GetEmployeeInfo');
Route::post('/UpdateEmployee/{id}', 'Employee@UpdateEmployee');
Route::get('/CustomerTypes', 'CustomerTypes@index');
Route::post('/SaveCustomerType', 'CustomerTypes@store');
Route::get('/GetCustomerTypes', 'CustomerTypes@customerTypesList');
Route::delete('/DeleteCustomerType/{typeId}', 'CustomerTypes@deleteCustomerType');
Route::get('/GetCustomerTypeInfo/{typeId}', 'CustomerTypes@getCustomerTypeInfo');
Route::post('/UpdateCustomerType/{typeId}', 'CustomerTypes@update');
Route::get('/CustomerProfile/{customerId}', 'Customer@viewProfile');


//Views
Route::get('/client_login', 'ClientLogin@client_login');
Route::get('/clients', 'Clients@clients');
//Route::get('/company_profile', 'OrganizationManagement@manage_company');
Route::get('/pick_up_and_delivery', 'OrganizationManagement@manage_pickUp_delivery');
//Route::get('/employee_managment', 'Auth\RegisterController@manage_employee');
Route::get('/billing/{id}', 'ManageBilling@billing');
Route::get('/select_customer', 'ClientsForBilling@select_customer');
Route::get('/consignment_booking', 'ConsignmentManagement@consignment_booking');
Route::get('/consignment_booking_client', 'ConsignmentManagement@consignment_booking_client');
Route::get('/consignment_booked', 'ConsignmentManagement@consignment_booked');
Route::get('/pending_consignments', 'ConsignmentManagement@pending_consignments');
Route::get('/complaints_suggestions', 'ComplaintsAndSuggestions@complaints_suggestions');
Route::get('/complaints_list', 'ComplaintsAndSuggestions@complaints_list');
Route::get('/complaints_list_client', 'ComplaintsAndSuggestions@complaints_list_client');
Route::get('/suggestions_list_client', 'ComplaintsAndSuggestions@suggestions_list_client');
Route::get('/suggestions_list', 'ComplaintsAndSuggestions@suggestions_list');
Route::get('/access_rights/{id}', 'AccessRights@access_rights');
Route::get('/save_controllers', 'AccessRights@save_controllers');
Route::get('/select_employee', 'AccessRights@select_employee');
Route::get('/edit_profile/{id}', 'Auth\RegisterController@edit_profile');
Route::get('/notifications', 'HomeController@notifications');
Route::get('/notification_prefrences', 'HomeController@notification_prefrences');
Route::get('/ClientProfile/{id}', 'Clients@ClientProfile');
Route::get('/shipment_tracking/{id}', 'ConsignmentManagement@shipment_tracking');
Route::get('/confirmed_consignments', 'ConsignmentManagement@confirmed_consignments');
Route::get('/consignment_statuses', 'ConsignmentManagement@consignment_statuses');
Route::get('/update_consignment_ad/{id}', 'ConsignmentManagement@update_consignment_ad');
Route::get('/update_consignment_cc/{id}', 'ConsignmentManagement@update_consignment_cc');
Route::get('/select_customer_BA', 'ClientsForBilling@select_customer_BA');

Route::get('/invoice/{id}', 'ConsignmentManagement@invoice');

//Save
Route::post('/Client_save', 'Clients@save_client');
Route::post('/Company_save', 'OrganizationManagement@add_company');
Route::post('/PickUp_save', 'OrganizationManagement@add_pickUp');
Route::post('/SaveBilling', 'ManageBilling@save_billing');
Route::post('/client_login_form', 'ClientLogin@client_login_form');
Route::post('/SaveConsignmentClient', 'ConsignmentManagement@SaveConsignmentClient');
Route::post('/saveComplaints', 'ComplaintsAndSuggestions@saveComplaints');
Route::post('/saveSuggestion', 'ComplaintsAndSuggestions@saveSuggestions');
Route::post('/saveRoute', 'AccessRights@saveRoute');
Route::post('/saveAccessRights', 'AccessRights@saveAccessRights');
Route::post('/SaveConsignmentAdmin', 'ConsignmentManagement@SaveConsignmentAdmin');
Route::post('/update_user_profile', 'Auth\RegisterController@update_user_profile');
Route::post('/save_pref_against_emp', 'HomeController@save_pref_against_emp');
Route::post('/save_pref_against_client', 'HomeController@save_pref_against_client');
Route::post('/read_notif_four', 'HomeController@read_notif_four');
Route::post('/UpdateConsignmentClient', 'ConsignmentManagement@UpdateConsignmentClient');

//Get Data to display on page
Route::get('/GetCompaniesList', 'OrganizationManagement@companies_list');
Route::get('/GetPickUpList', 'OrganizationManagement@pickUp_list');
Route::get('/GetCustomersListForBilling', 'ClientsForBilling@GetCustomersListForBilling');
Route::get('/GetCompliantsListClient', 'ComplaintsAndSuggestions@GetCompliantsListClient');
Route::get('/GetSuggestionsListClient', 'ComplaintsAndSuggestions@GetSuggestionsListClient');
Route::get('/GetConsignmentsList', 'ConsignmentManagement@GetConsignmentsList');
Route::get('/GetEmployeeListForRights', 'AccessRights@GetEmployeeListForRights');
Route::get('/check_access_rights', 'AccessRights@check_access_rights');
Route::get('/get_price_if_consignmentTypeFragile', 'ConsignmentManagement@get_price_if_consignmentTypeFragile');
Route::get('/process_this_consignment', 'ConsignmentManagement@process_this_consignment');
Route::get('/delete_pending_consignment', 'ConsignmentManagement@delete_pending_consignment');
Route::get('/activate_client', 'Clients@activate_client');
Route::get('/deactivate_client', 'Clients@deactivate_client');
Route::get('/GetCNNOData', 'ConsignmentManagement@GetCNNOData');
Route::get('/save_consignment_statuses', 'ConsignmentManagement@save_consignment_statuses');
Route::get('/update_status_log', 'ConsignmentManagement@update_status_log');
Route::get('/GetStatusList', 'ConsignmentManagement@GetStatusList');
Route::get('/update_custom_status', 'ConsignmentManagement@update_custom_status');
Route::get('/get_custom_status_data', 'ConsignmentManagement@get_custom_status_data');
Route::get('/GetCCData', 'ConsignmentManagement@GetCCData');
Route::get('/get_client_notif_data', 'HomeController@get_client_notif_data');
Route::get('/mark_consignment_complete', 'ConsignmentManagement@mark_consignment_complete');
Route::get('/GetCustomersListOfAddedBilling', 'ClientsForBilling@GetCustomersListOfAddedBilling');
Route::get('/GetStatusLogForModal', 'ConsignmentManagement@GetStatusLogForModal');


//Get data to show on update page
Route::get('/company_data/{id}', 'OrganizationManagement@get_company_data');
Route::get('/pickUp_data/{id}', 'OrganizationManagement@get_pickUp_data');
Route::get('/client_data/{id}', 'Clients@get_client_data');
Route::get('/notif_pref_against_emp/{id}', 'HomeController@notif_pref_against_emp');
Route::get('/checkBillinAddedOrNot/{id}', 'ManageBilling@checkBillinAddedOrNot');

//Update
Route::post('/company_update', 'OrganizationManagement@update_company');
Route::post('/pickUp_update', 'OrganizationManagement@update_pickUp');
Route::post('/client_update', 'Clients@update_client');
Route::post('/updateClientProfile', 'Clients@updateClientProfile');

//Delete
Route::get('/DeleteCompany', 'OrganizationManagement@delete_company_entry');
Route::get('/DeletepickUp', 'OrganizationManagement@delete_pickUp_entry');
Route::get('/DeleteClient', 'Clients@delete_client_entry');
Route::get('/delete_custom_status', 'ConsignmentManagement@delete_custom_status');
Route::get('/delete_complainOrSuggestion', 'ComplaintsAndSuggestions@delete_complainOrSuggestion');

//Deactive or Active Employee
Route::get('/activate_employee', 'Employee@activate_employee');
Route::get('/deactivate_employee', 'Employee@deactivate_employee');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/cout', 'Clients@cout');



Route::post('/test-upload', 'ManageBilling@test');
Route::get('/testingRoute/{test}', 'ManageBilling@testUnlink');

Route::post('/client_docs', 'Clients@upload_docs');
Route::get('/remove_client_docs/{test}', 'Clients@remove_docs');
