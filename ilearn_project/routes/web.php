<?php

use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\MyProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\UserController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::group(['middleware'=>'XSS', function() {
   
// }]);
    
    
// login 
Route::get('/', 'App\Http\Controllers\HomeController@index')->name('Login');
Route::post('Login', 'App\Http\Controllers\LoginController@login');
Route::get('forget_password', 'App\Http\Controllers\LoginController@forgotpassword');
Route::post('forget_password_url', 'App\Http\Controllers\LoginController@forget_password_url');


// home page
Route::get('home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('fetch_table_home', 'App\Http\Controllers\HomeController@fetch_table_home');
Route::post('home_link_category', 'App\Http\Controllers\HomeController@home_link_category');
Route::get('search_category/{title}', 'App\Http\Controllers\MasterListController@search_category');





// categories
Route::get('categories', 'App\Http\Controllers\CategoriesController@index')->name('categories');
Route::post('update_categories', 'App\Http\Controllers\CategoriesController@update_category');
Route::post('delete_category', 'App\Http\Controllers\CategoriesController@delete_category');
Route::post('active_category', 'App\Http\Controllers\CategoriesController@active_category');
Route::post('retrive_category', 'App\Http\Controllers\CategoriesController@retrive_category');
Route::post('edit_category', 'App\Http\Controllers\CategoriesController@edit_category');
Route::post('insert_categories', 'App\Http\Controllers\CategoriesController@insert_category');
Route::get('get_value_table', 'App\Http\Controllers\CategoriesController@fetch_table');
Route::get('getcat_filter_table', 'App\Http\Controllers\CategoriesController@fetch_table_filter');
Route::get('cat_create_fetch', 'App\Http\Controllers\CategoriesController@cat_create_fetch');
Route::get('edit_cat_create_fetch', 'App\Http\Controllers\CategoriesController@edit_cat_create_fetch');
// Route::get('update_cat_access_level', 'App\Http\Controllers\CategoriesController@update_cat_access_level');
Route::post('link_category', 'App\Http\Controllers\CategoriesController@link_category');

// Glossary
Route::get('glossary', 'App\Http\Controllers\GlossaryController@index')->name('glossary');
Route::get('get_glossary_table', 'App\Http\Controllers\GlossaryController@fetch_table_glossary');
Route::get('new_glossary', 'App\Http\Controllers\GlossaryController@create_page');
Route::post('insert_glossary', 'App\Http\Controllers\GlossaryController@insert_glossary');
Route::post('edit_glossary', 'App\Http\Controllers\GlossaryController@edit_glossary');
Route::post('update_glossary', 'App\Http\Controllers\GlossaryController@update_glossary');
Route::post('deactivate_glossary', 'App\Http\Controllers\GlossaryController@deactivate_glossary');
Route::post('active_glossary', 'App\Http\Controllers\GlossaryController@active_glossary');
Route::get('get_filter_table', 'App\Http\Controllers\GlossaryController@fetch_table_glossary');
Route::get('fetch_table_glossary_master', 'App\Http\Controllers\GlossaryController@fetch_table_glossary_master');
Route::post('delete_glossary', 'App\Http\Controllers\GlossaryController@delete_glossary');

// upload forms
Route::get('new_download_form', 'App\Http\Controllers\UploadformsController@fetch_all_forms');
Route::get('new_download_form_filter', 'App\Http\Controllers\UploadformsController@fetch_all_forms');
Route::get('getdownload_form', 'App\Http\Controllers\UploadformsController@download_form_table');
Route::get('getdownload_form_filter', 'App\Http\Controllers\UploadformsController@download_form_table');
Route::get('uploadforms', 'App\Http\Controllers\UploadformsController@index')->name('uploadforms');
Route::get('newuploadforms', 'App\Http\Controllers\UploadformsController@index_newForm');
Route::post('insert_uploadform', 'App\Http\Controllers\UploadformsController@insert_uploadform');
Route::post('edit_uploadforms', 'App\Http\Controllers\UploadformsController@edit_uploadforms');
Route::post('files_url', 'App\Http\Controllers\UploadformsController@imagedown');
Route::post('delete_form', 'App\Http\Controllers\UploadformsController@delete_form');
Route::post('active_form', 'App\Http\Controllers\UploadformsController@active_form');
// Route::post('link_forms', 'App\Http\Controllers\UploadformsController@link_forms');
Route::post('update_forms', 'App\Http\Controllers\UploadformsController@update_forms');
Route::post('delete_forms', 'App\Http\Controllers\UploadformsController@delete_forms');
Route::get('link_forms/{id}', 'App\Http\Controllers\UploadformsController@link_forms');

// policy
Route::get('policy', [PolicyController::class, 'index'])->name('policy');
Route::get('get_policy_table', [PolicyController::class, 'fetch_table_policy']);
Route::post('insert_policy', 'App\Http\Controllers\PolicyController@insert_policy');
Route::post('edit_policy', 'App\Http\Controllers\PolicyController@edit_policy');
Route::post('link_policy', 'App\Http\Controllers\PolicyController@link_policy');
Route::post('update_policy', 'App\Http\Controllers\PolicyController@update_policy');
Route::post('delete_policy', 'App\Http\Controllers\PolicyController@delete_policy');
Route::post('active_policy', 'App\Http\Controllers\PolicyController@active_policy');
Route::post('audit_trail_click', 'App\Http\Controllers\PolicyController@audit_trail_click');
Route::get('GET_CATEGORIES_MASTERFILE', 'App\Http\Controllers\PolicyController@category_func');
Route::get('get_filter_policy_table', [PolicyController::class, 'fetch_table_policy']);
Route::get('department_section', 'App\Http\Controllers\PolicyController@department_section');
Route::post('section', 'App\Http\Controllers\PolicyController@section');
Route::get('edit_department_section', 'App\Http\Controllers\PolicyController@edit_department_section');
// Route::get('title_link', [PolicyController::class, 'title_link']);
Route::get('redirect_to_pdf_view', 'App\Http\Controllers\PolicyController@redirect_to_pdf_view');
Route::get('attachment_link', 'App\Http\Controllers\AttachmentController@attachment_link');

Route::get('title_link/{id}', [PolicyController::class, 'title_link']);

// Announcement
Route::get('annoucement', 'App\Http\Controllers\AnnouncementController@index')->name('annoucement');
Route::get('get_announcement_table', 'App\Http\Controllers\AnnouncementController@fetch_table_announcement');
Route::post('insert_announcement', 'App\Http\Controllers\AnnouncementController@insert_announcement');
Route::post('edit_announcement', 'App\Http\Controllers\AnnouncementController@edit_announcement');
Route::post('update_announcement', 'App\Http\Controllers\AnnouncementController@update_announcement');
Route::post('deactivate_announcement', 'App\Http\Controllers\AnnouncementController@deactivate_announcement');
Route::post('active_announcement', 'App\Http\Controllers\AnnouncementController@active_announcement');
Route::post('delete_announcement', 'App\Http\Controllers\AnnouncementController@delete_announcement');


// User Management
Route::get('user_management', 'App\Http\Controllers\UserController@index')->name('user_management');
Route::get('GET_DEPARTMENT_MASTERFILE', 'App\Http\Controllers\UserController@department_func');
Route::get('GET_SECTION_MASTERFILE', 'App\Http\Controllers\UserController@section_func');
Route::get('get_user_management_table', 'App\Http\Controllers\UserController@get_user_management_table');
Route::post('insert_user', 'App\Http\Controllers\UserController@insert_user');
Route::get('GET_DIVISION_MASTERFILE', 'App\Http\Controllers\UserController@division_func');
Route::get('GET_STATUS_MASTERFILE', 'App\Http\Controllers\UserController@status_func');
Route::get('GET_ROLE_MASTERFILE', 'App\Http\Controllers\UserController@role_func');
Route::post('edit_users', 'App\Http\Controllers\UserController@edit_users');
Route::post('update_users', 'App\Http\Controllers\UserController@update_users');
Route::post('deactivate_users', 'App\Http\Controllers\UserController@deactivate_users');
Route::post('activate_users', 'App\Http\Controllers\UserController@activate_users');
Route::get('dropdown_department', 'App\Http\Controllers\UserController@dropdown_department');
Route::get('department_filter', 'App\Http\Controllers\UserController@get_user_management_table');
Route::get('GET_SECTION_ID', 'App\Http\Controllers\UserController@section_func_id');


// section routes  
Route::get('section', 'App\Http\Controllers\UserController@indexsection');
Route::post('insert_section', 'App\Http\Controllers\UserController@insert_section');
Route::get('display_section', 'App\Http\Controllers\UserController@display_section');
Route::post('fetch_section', 'App\Http\Controllers\UserController@fetch_section');
Route::post('update_section', 'App\Http\Controllers\UserController@update_section');
Route::post('delete_section', 'App\Http\Controllers\UserController@delete_section');
Route::post('deactivate_section', 'App\Http\Controllers\UserController@deactivate_section');
Route::post('activate_section', 'App\Http\Controllers\UserController@activate_section');
Route::get('section_filter', 'App\Http\Controllers\UserController@display_section');
Route::get('section_dropdown', 'App\Http\Controllers\UserController@section_dropdown');


// department routes
Route::get('department', 'App\Http\Controllers\UserController@indexdepartment');
Route::post('insert_department', 'App\Http\Controllers\UserController@insert_department');
Route::get('display_department', 'App\Http\Controllers\UserController@display_department');
Route::post('fetch_department', 'App\Http\Controllers\UserController@fetch_department');
Route::post('update_department', 'App\Http\Controllers\UserController@update_department');
Route::post('deactivate_department', 'App\Http\Controllers\UserController@deactivate_department');
Route::post('activate_department', 'App\Http\Controllers\UserController@activate_department');
Route::post('delete_department', 'App\Http\Controllers\UserController@delete_department');
Route::get('department_form_filter', 'App\Http\Controllers\UserController@display_department');


// logout
Route::get('logout', 'App\Http\Controllers\LogOutController@index');

// changes password
Route::get('change_password', 'App\Http\Controllers\ChangePasswordController@index')->name('change_password');

// master list
Route::get('masterlist', 'App\Http\Controllers\MasterListController@index')->name('masterlist');
Route::get('get_value_table_ajax', 'App\Http\Controllers\MasterListController@get_value_table');
Route::post('masterList', 'App\Http\Controllers\MasterListController@masterList');
Route::get('category_mast', 'App\Http\Controllers\MasterListController@category_mast');
Route::get('master_filter', 'App\Http\Controllers\MasterListController@cat_filter');
Route::get('master_redirect_to_pdf_view', 'App\Http\Controllers\MasterListController@master_redirect_to_pdf_view');
Route::get('masterlist/{search_bar}', 'App\Http\Controllers\MasterListController@index2');
Route::get('masterlist/get_value_table_ajax/', 'App\Http\Controllers\MasterListController@get_value_table');
Route::get('masterlist/category_mast', 'App\Http\Controllers\MasterListController@category_mast');
Route::get('masterlist_category/{category_search}', 'App\Http\Controllers\MasterListController@index3');


// Route::post('create_new_upload', 'App\Http\Controllers\UploadformsController@create_new_upload');
// access level
Route::get('get_access_level_table', 'App\Http\Controllers\CategoriesController@get_access_level_table');
Route::get('update_access_level', 'App\Http\Controllers\CategoriesController@update_access_level');
Route::get('category_session', 'App\Http\Controllers\CategoriesController@category_session');


// audit trail
Route::get('audit_trail', [AuditTrailController::class, 'index']);
Route::post('download_export', [AuditTrailController::class, 'export']);
Route::get('fetch_audit_trail_table', [AuditTrailController::class, 'get_audit_trail']);


// my profile
Route::get('my_profile', 'App\Http\Controllers\MyProfileController@index');
Route::post('profile_det', 'App\Http\Controllers\MyProfileController@profile_det');
Route::post('update_profile', 'App\Http\Controllers\MyProfileController@update_profile');
Route::get('GET_DEPARTMENT', 'App\Http\Controllers\MyProfileController@department_func');




// email

Route::get('send', 'App\Http\Controllers\UserController@subscribe');




