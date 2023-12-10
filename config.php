<?php
//File này chứa các hằng số cấu hình

date_default_timezone_set('Asia/Ho_Chi_Minh');

//Thiết lập hằng số cho client
const _MODULE_DEFAULT = 'users'; //Module mặc định
const _ACTION_DEFAULT = 'list'; //Action mặc định

//Hiển thị số trang
const _PAGE = 3;

//Thiết lập hằng số cho admin
const _MODULE_DEFAULT_ADMIN = 'dashboard';

const _INCODE = true; //Ngăn chặn hành vi truy cập trực tiếp vào file

//Thiết lập host
define('_REQUEST_SCHEME',$_SERVER['REQUEST_SCHEME']);

define('_WEB_HOST_ROOT', _REQUEST_SCHEME.'://'.$_SERVER['HTTP_HOST'].'/ShopBanDoTreEm'); //Địa chỉ trang chủ

define('_WEB_HOST_TEMPLATE', _WEB_HOST_ROOT.'/templates/client');

define('_WEB_HOST_ROOT_ADMIN', _WEB_HOST_ROOT.'/admin');

define('_WEB_HOST_ADMIN_TEMPLATE', _WEB_HOST_ROOT.'/templates/admin');

//Thiết lập path
define('_WEB_PATH_ROOT', __DIR__);
define('_WEB_PATH_TEMPLATE', _WEB_PATH_ROOT.'/templates');


// echo '<pre>';
// print_r($_SERVER);
// echo '</pre>';

//Thiết lập kết nối database

const _HOST = 'localhost';

const _USER = 'root';
const _PASS = ''; //Xampp => pass='';
const _DB = 'treemphp';
const _DRIVER = 'mysql';

//Thiết lập debug
const _DEBUG = true;

//Thiết lập số lượng bản ghi hiển thị trên 1 trang
const _PER_PAGE = 1;



//echo '<pre>';
//var_dump($_SERVER);
//echo '</pre>';