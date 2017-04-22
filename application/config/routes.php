<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin'] = "Home/HomeAdminController/dashboard";
$route['admin/install/([a-z_-]+)'] = 'InstallController/install/$1';
$route['admin/install'] = 'InstallController/start';
$route['admin/([a-z_-]+)/([a-zA-Z_-]+)(.*)?'] = '$1/$1AdminController/$2';

$route['default_controller'] = 'Home/HomeController/index';

$route['ara'] = 'Search/SearchController/search';
$route['galeriler/([a-zA-Z0-9_-]+)'] = 'Gallery/GalleryController/view/$1';
$route['galeriler'] = 'Gallery/GalleryController/index';
$route['hesap/giris'] = 'User/UserController/login';
$route['hesap/cikis'] = 'User/UserController/logout';
$route['hesap/olustur'] = 'User/UserController/create';
$route['hesap/profil'] = 'User/UserController/profile';
$route['hesap/parola'] = 'User/UserController/password';
$route['hesap/avatar'] = 'User/UserController/avatar';
$route['hesap/bildirim'] = 'User/UserController/notification';
$route['hesap/dogrula/(.+)'] = 'User/UserController/verify/$1';
$route['hesap/parolami-unuttum'] = 'User/UserController/forgotPassword';
$route['hesap/parolami-sifirla/(.+)'] = 'User/UserController/resetPassword/$1';
$route['hesap'] = 'User/UserController/index';
$route['([a-zA-Z0-9_-]+)/([a-zA-Z0-9_-]+)'] = 'News/NewsController/view/$1/$2';
$route['([a-zA-Z0-9_-]+)'] = 'Category/CategoryController/view/$1';
