<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['layanan'] = 'main/layanan';
$route['contact'] = 'main/contact';

/* 
|
|   ROUTE URL UNTUK PDF 
|
*/
$route['export/datamaster/toko'] = 'function/client_export_master/data_toko_export_pdf';
$route['export/datamaster/jabatan'] = 'function/client_export_master/data_jabatan_export_pdf';
$route['export/datamaster/karyawan'] = 'function/client_export_master/data_karyawan_export_pdf';
$route['export/datamaster/staff'] = 'function/client_export_master/data_staff_export_pdf';
$route['export/datamaster/itemcategory'] = 'function/client_export_master/data_item_category_export_pdf';
$route['export/datamaster/item'] = 'function/client_export_master/data_item_master_export_pdf';
$route['export/datamaster/vendor'] = 'function/client_export_master/data_vendor_export_pdf';
$route['export/datamaster/customer'] = 'function/client_export_master/data_customer_export_pdf';

$route['export/karyawan/(:any)'] = 'function/client_export_master/data_karyawan_export_person_pdf/$1';


$route['export/datasales/quotation/(:any)'] = 'function/client_export_sales/quotation/$1';
$route['export/datasales/sales/(:any)'] = 'function/client_export_sales/sales/$1';
$route['export/datasales/payment/(:any)'] = 'function/client_export_sales/payment/$1';
$route['export/datasales/payment/(:any)/(:any)'] = 'function/client_export_sales/payment/$1/$2';
$route['export/datasales/delivery/(:any)'] = 'function/client_export_sales/delivery/$1';
$route['export/datasales/po/a5/(:any)'] = 'function/client_export_sales/po_a5/$1';
$route['export/datasales/po/a6/(:any)'] = 'function/client_export_sales/po_a6/$1';
$route['export/datasales/to/(:any)'] = 'function/client_export_sales/to/$1';
$route['export/datasales/ti/(:any)'] = 'function/client_export_sales/ti/$1';
$route['export/datasales/performa/(:any)'] = 'function/client_export_sales/performa/$1';
$route['export/pembelian/grpo/a5/(:any)'] = 'function/client_export_pembelian/grpo_a5/$1';
$route['export/pembelian/grpo/a6/(:any)'] = 'function/client_export_pembelian/grpo_a6/$1';
$route['export/inventory/(:any)/(:any)'] = 'function/client_export_inventory/$1/$2';
