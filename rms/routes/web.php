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

use App\Http\Controllers\HelpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('admin')->group(function (){
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
});
/**
Master Entries
 */
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/missing_monitoring_count', 'HomeController@missing_monitoring')->name('home.missing_monitoring_count');

Route::resource('/vessel', 'VesselController');
Route::resource('/voyage', 'VoyageController');
Route::resource('/port', 'PortController');
Route::resource('/rate', 'RateController');
Route::resource('/yard', 'YardController');
Route::resource('/box_owner', 'BoxOwnerController');
Route::resource('/company', 'CompanyController');
Route::resource('/user', 'UserController');
Route::resource('/temp_container', 'TempContainerController');
Route::resource('/upload', 'UploadController');

//plug_off
Route::resource('/plug_off', 'PlugOffController');

//reefer monitoring
Route::resource('/reefer_monitoring', 'ReeferMonitoringController');
Route::put('/monitoring_row_update/{id}/{monitoring_id?}','ReeferMonitoringController@row_update');//special update function for quick save
Route::put('/monitoring_row_create/{id}','ReeferMonitoringController@row_create');//special update function for quick add
Route::delete('/monitoring_row_delete/{monitoring}','ReeferMonitoringController@row_delete');//special delete function for quick delete
Route::post('/plugging_category/{container}','ReeferMonitoringController@plugging_category');//special delete function for quick delete

//plug on container routes
Route::resource('/container', 'ContainerController');
Route::put('/row_update/{id}','ContainerController@row_update');//special update function for quick save
Route::get('/temp_plug_on/{file}','TempPlugOnController@create');//uploads are temporally evaluated
Route::post('/temp_plug_on/{file}','TempPlugOnController@save');//uploads are saved to the main database

//permission routes
Route::post('/role/permission/{role}', 'RoleController@permission')->name('role.permission');
Route::resource('/role', 'RoleController');
Route::post('/permission/default_permission', 'PermissionController@default_permission')->name('permission.default_permission');
Route::resource('/permission', 'PermissionController');
Route::resource('/access_right', 'AccessRightsController');

//system settings routes
Route::get('system_setting','SystemSettingsController@index')->name('system_settings.index');

//audit
Route::resource('/audit', 'AuditController');

//upload file reader routs
Route::prefix('read')->group(function () {
    Route::get('/plug_on_container_excel/{file}','Readers\PlugOnContainerExcelController@read')->name('read.plug_on_container_excel');
    Route::get('/reefer_monitoring_excel/{file}','Readers\ReeferMonitoringExcellController@read')->name('read.reefer_monitoring_excel');
    Route::get('/plug_off_excel/{file}','Readers\PlugOffExcelController@read')->name('read.plug_off_excel');
    Route::get('/loading_vessel_excel/{file}','Readers\LoadingVesselExcelController@read')->name('read.loading_vessel_excel');
});

//bulk edit routes
Route::post('/bulk_edit','BulkEditController@edit');
Route::post('/bulk_revert','BulkEditController@revert');
Route::post('/bulk_delete','BulkEditController@delete');
Route::get('/bulk_edit_stack','BulkEditController@edit_stack');

//loading vessel routes
Route::get('/loading_vessel_upload', 'LoadingVesselController@index')->name('loading_vessel_upload');
Route::get('/loading_vessel_upload/{file}', 'LoadingVesselController@show')->name('loading_vessel_upload.show');
Route::post('/loading_vessel_upload/{file}', 'LoadingVesselController@save')->name('loading_vessel_upload.save');

/**
 * Reports
 */
//other report
Route::get('/other_report', 'OtherReportController@index')->name('other_report');
Route::post('/other_report_download', 'OtherReportController@download')->name('other_report_download');

//Meersk report
Route::get('/mersk_report', 'MERSKReportController@index')->name('mersk_report');
Route::post('/mersk_report_download', 'MERSKReportController@download')->name('mersk_report_download');

//monitoring report
Route::get('/monitoring_report', 'MonitoringReportController@index')->name('monitoring_report');
Route::get('/monitoring/{container}', 'MonitoringController@index')->name('monitoring');

//Master report
Route::get('/master_report', 'MasterReportController@index')->name('master_report');

//Plug in Containers
Route::get('/plug_in_list', 'PlugInListController@index')->name('plug_in_list');

//Lock Containers
Route::get('/lock', 'LockController@index')->name('lock');
Route::post('/lock/{id}', 'LockController@container_lock')->name('lock');
Route::post('/bulk_lock', 'LockController@bulk_lock')->name('bulk_lock');

//Missed Monitoring Report
Route::get('/missed_monitoring_report', 'MissedMonitoringController@index')->name('missed_monitoring');


//data table ajax paths
Route::prefix('data')->group(function (){
    Route::get('/vessel', 'VesselController@data')->name('data.vessel');
    Route::get('/voyage', 'VoyageController@data')->name('data.voyage');
    Route::get('/port', 'PortController@data')->name('data.port');
    Route::get('/rate', 'RateController@data')->name('data.rate');
    Route::get('/yard', 'YardController@data')->name('data.yard');
    Route::get('/box_owner', 'BoxOwnerController@data')->name('data.box_owner');
    Route::get('/company', 'CompanyController@data')->name('data.company');
    Route::get('/role', 'RoleController@data')->name('data.role');
    Route::get('/permission', 'PermissionController@data')->name('data.permission');
    Route::get('/access_right', 'AccessRightsController@data')->name('data.access_rights');
    Route::get('/user', 'UserController@data')->name('data.user');
    Route::get('/audit', 'AuditController@data')->name('data.audit');
    Route::post('/container', 'ContainerController@data')->name('data.container');
    Route::post('/reefer_monitoring', 'ReeferMonitoringController@data')->name('data.reefer_monitoring');
    Route::post('/containers_search', 'ContainerController@containers_search')->name('data.containers_search');
    Route::post('/loading_vessel_upload', 'LoadingVesselController@data')->name('data.loading_vessel_upload');
    Route::post('/temp_plug_on', 'TempPlugOnController@data')->name('data.temp_plug_on');
    Route::post('/monitoring_report', 'MonitoringReportController@data')->name('data.monitoring_report');
    Route::post('/master_report', 'MasterReportController@data')->name('data.master_report');
    Route::post('/plug_in_list', 'PlugInListController@data')->name('data.plug_in_list');
    Route::post('/lock', 'LockController@data')->name('data.lock');
    Route::post('/missed_monitoring_report', 'MissedMonitoringController@data')->name('data.missed_monitoring');
});

//ajax gets.
Route::get('/monitoring_schedule',function (){
    return view('reefer_monitoring.contents.monitoring');
});

//help routs
Route::prefix('help')->group(function (){
    Route::get('/login','HelpController@login')->name('help.login');
    Route::get('/user_manual','HelpController@user_manual')->name('help.user_manual');
});

//backup routes
Route::prefix('backup')->group(function (){
    Route::get('/index','BackupController@index')->name('backup');//name changed to backup instead od backup.index to be compatible it permissions
    Route::get('/download/{name}','BackupController@download')->name('backup.download');
});
