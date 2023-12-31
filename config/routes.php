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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'listings';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['homes'] = 'listings/type/res';
$route['condos'] = 'listings/type/con';
$route['rural'] = 'listings/rur';
$route['open\-houses'] = 'listings/open_houses';
$route['sold'] = 'listings/sold';

$route['homes\/(\d+)'] = 'listings/property/res/$1';
$route['condos\/(\d+)'] = 'listings/property/con/$1';
$route['rural\/(\d+)'] = 'listings/property/rur/$1';
$route['map'] = 'listings/map';
$route['homes\/(\d+)\/([\w\-]+)'] = 'listings/property/res/$1/$2';
$route['condos\/(\d+)\/([\w\-]+)'] = 'listings/property/con/$1/$2';
$route['rural\/(\d+)\/([\w\-]+)'] = 'listings/property/rur/$1/$2';

$route['search'] = 'listings/search';

$route['office'] = 'listings/office';

$route['development\/([\w\-]+)'] = 'snippetListings/development/$1';
$route['street\/([\w\-]+)'] = 'snippetListings/street/$1';
$route['latest\/(\d+)'] = 'snippetListings/latest/$1';
$route['facebook/open-houses'] = 'snippetListings/facebook_open_houses';
$route['facebook/latest'] = 'snippetListings/facebook_latest';

$route['sitemap\.xml'] = 'listings/xml_sitemap';