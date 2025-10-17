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

$route['translate_uri_dashes'] = TRUE;

$route['default_controller'] = 'home';
$route['forgot-password'] = "home/forgot_password";


/*
$route['(:any)'] = "home/$1";
$route['livre/(:any)'] = "home/livre/$1";
$route['livreDetails/(:any)'] = "home/livreDetails/$1";
$route['livreCours/(:any)'] = "home/livreCours/$1";
$route['livreResume/(:any)'] = "home/livreResume/$1";
$route['livreQcm/(:any)'] = "home/livreQcm/$1";
$route['livreQroc/(:any)'] = "home/livreQroc/$1";
$route['livreList/(:any)/(:any)'] = "home/livreList/$1/$2";
$route['switchLang/(:any)'] = "home/switchLang/$1";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
*/



$route['^FR/testFigure/(:any)']  = "home/getFigure/$1";
$route['^EN/testFigure/(:any)']  = "home/getFigure/$1";

$route['Videoupload/listVideos']  = "videoupload/listVideos";

$route['^FR/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";	
$route['^EN/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";	
$route['^FR/listTest/(:any)']  = "home/getListTestByChapitres3/$1";	
$route['^EN/listTest/(:any)']  = "home/getListTestByChapitres3/$1";

$route['^FR/switchPlatform/(:any)'] 		= "home/switchPlatform/$1";
$route['^FR/login'] 					    = "home/login";
$route['^login/switchLang/(:any)'] = "home/switchLang/$1";
$route['^FR/category/(:any)'] 		    = "home/pageCategory/$1";
$route['^FR/livreList/(:any)/(:any)'] 	= "home/livreList/$1/$2";
$route['^FR/livre/(:any)'] 				= "home/livre/$1";
$route['^FR/livreDetails/(:any)'] 		= "home/livreDetails/$1";
$route['^FR/livreCours/(:any)/(:any)'] 	= "home/livreCours/$1/$2";
$route['^FR/livreCours/(:any)'] 	    = "home/livreCours/$1";
$route['^FR/livreResume/(:any)/(:any)'] = "home/livreResume/$1/$2";
$route['^FR/livreResume/(:any)']        = "home/livreResume/$1";
$route['^FR/livreQcm/(:any)'] 			= "home/livreQcm/$1";
$route['^FR/livreQroc/(:any)'] 			= "home/livreQroc/$1";
$route['^FR/signUp'] 					= "home/signUp";
$route['^FR/resetUp'] 					= "home/resetUp";
$route['^FR/forgot_password'] 			= "home/forgot_password";
$route['^FR/pagesSetting'] 				= "home/settingPaltform";
$route['^FR/logout'] 					= "home/logout";
$route['^FR/settingUsers'] 				= "home/settingUsers";
$route['^FR/settingUsersEtab'] 			= "home/settingUsersEtab";
$route['^FR/settingCurs'] 				= "home/settingCurs";
$route['^FR/settingPlat'] 				= "home/settingPlat";
$route['^FR/settingActualites'] 		= "home/settingActualites";
$route['^FR/settingTest/(:any)'] 		= "home/settingFigures/$1";
$route['^FR/cursHTML/(:any)/(:any)'] 	= "home/cursHTML/$1/$2";
$route['^FR/cursHTML/(:any)'] 	        = "home/cursHTML/$1";
$route['^FR/figHTML/(:any)'] 			= "home/figHTML/$1";
$route['^FR/livreQcmEdit/(:any)'] 		= "home/livreQcmEdit/$1";
$route['^FR/livreQrocEdit/(:any)'] 		= "home/livreQrocEdit/$1";
$route['^FR/searchIndex'] 				= "home/searchIndex";
$route['^FR/listOffers/(:any)'] 		= "home/listOffers/$1";
$route['^FR/evaluatQCM/(:any)/(:any)/(:any)'] 	= "home/evaluatQCM/$1/$2/$3";
$route['^FR/evaluatQROC/(:any)/(:any)/(:any)'] 	= "home/evaluatQROC/$1/$2/$3";
$route['^FR/evaluatTEST/(:any)'] 	= "home/getListTestByChapitres4/$1";
$route['^FR/evaluatCalque/(:any)'] 	= "home/getListCalqueByChapitres2/$1";
$route['^FR/contactUS'] 				= "home/contactUS";

$route['^EN/switchPlatform/(:any)'] 	= "home/switchPlatform/$1";
$route['^EN/login'] 					= "home/login";
$route['^EN/category/(:any)'] 		    = "home/pageCategory/$1";
$route['^EN/livreList/(:any)/(:any)'] 	= "home/livreList/$1/$2";
$route['^EN/livre/(:any)'] 				= "home/livre/$1";
$route['^EN/livreDetails/(:any)'] 		= "home/livreDetails/$1";
$route['^EN/livreCours/(:any)/(:any)'] 	= "home/livreCours/$1/$2";
$route['^EN/livreCours/(:any)'] 	    = "home/livreCours/$1";
$route['^EN/livreResume/(:any)/(:any)'] = "home/livreResume/$1/$2";
$route['^EN/livreResume/(:any)']        = "home/livreResume/$1";
$route['^EN/livreQcm/(:any)'] 			= "home/livreQcm/$1";
$route['^EN/livreQroc/(:any)'] 			= "home/livreQroc/$1";
$route['^EN/signUp'] 					= "home/signUp";
$route['^EN/resetUp'] 					= "home/resetUp";
$route['^EN/forgot_password'] 			= "home/forgot_password";
$route['^EN/pagesSetting'] 				= "home/settingPaltform";
$route['^EN/logout'] 					= "home/logout";
$route['^EN/settingUsers'] 				= "home/settingUsers";
$route['^EN/settingUsersEtab'] 			= "home/settingUsersEtab";
$route['^EN/settingCurs'] 				= "home/settingCurs";
$route['^EN/settingPlat'] 				= "home/settingPlat";
$route['^EN/settingActualites'] 		= "home/settingActualites";
$route['^EN/settingTest/(:any)'] 		= "home/settingFigures/$1";
$route['^EN/cursHTML/(:any)/(:any)'] 	= "home/cursHTML/$1/$2";
$route['^EN/cursHTML/(:any)'] 	        = "home/cursHTML/$1";
$route['^EN/figHTML/(:any)'] 			= "home/figHTML/$1";
$route['^EN/livreQcmEdit/(:any)'] 	    = "home/livreQcmEdit/$1";
$route['^EN/livreQrocEdit/(:any)'] 		= "home/livreQrocEdit/$1";
$route['^EN/searchIndex'] 				= "home/searchIndex";
$route['^EN/listOffers/(:any)'] 		= "home/listOffers/$1";
$route['^EN/evaluatQCM/(:any)/(:any)/(:any)'] 	= "home/evaluatQCM/$1/$2/$3";
$route['^EN/evaluatQROC/(:any)/(:any)/(:any)'] 	= "home/evaluatQROC/$1/$2/$3";
$route['^EN/evaluatCalque/(:any)'] 	= "home/getListCalqueByChapitres2/$1";
$route['^EN/evaluatTEST/(:any)'] 	= "home/getListTestByChapitres4/$1";

$route['^EN/contactUS'] = "home/contactUS";

$route['^FR/products/buyProduct/(:any)'] 		= "home/products/buyProduct/$1";
$route['^EN/products/buyProduct/(:any)'] 		= "home/products/buyProduct/$1";

$route['getItem'] = "home/getItem";

$route['^ES/switchPlatform/(:any)'] 					= "home/switchPlatform/$1";
$route['^ES/login'] 					    = "home/login";
$route['^ES/category/(:any)'] 		    = "home/pageCategory/$1";
$route['^ES/livreList/(:any)/(:any)'] 	= "home/livreList/$1/$2";
$route['^ES/livre/(:any)'] 				= "home/livre/$1";
$route['^ES/livreDetails/(:any)'] 		= "home/livreDetails/$1";
$route['^ES/livreCours/(:any)/(:any)'] 	= "home/livreCours/$1/$2";
$route['^ES/livreCours/(:any)'] 	    = "home/livreCours/$1";
$route['^ES/livreResume/(:any)/(:any)'] = "home/livreResume/$1/$2";
$route['^ES/livreResume/(:any)']        = "home/livreResume/$1";
$route['^ES/livreQcm/(:any)'] 			= "home/livreQcm/$1";
$route['^ES/livreQroc/(:any)'] 			= "home/livreQroc/$1";
$route['^ES/signUp'] 					= "home/signUp";
$route['^ES/resetUp'] 					= "home/resetUp";
$route['^ES/forgot_password'] 			= "home/forgot_password";
$route['^ES/pagesSetting'] 				= "home/settingPaltform";
$route['^ES/logout'] 					= "home/logout";
$route['^ES/settingUsers'] 				= "home/settingUsers";
$route['^ES/settingUsersEtab'] 			= "home/settingUsersEtab";
$route['^ES/settingCurs'] 				= "home/settingCurs";
$route['^ES/settingPlat'] 				= "home/settingPlat";
$route['^ES/settingActualites'] 		= "home/settingActualites";
$route['^ES/settingTest/(:any)'] 		= "home/settingFigures/$1";
$route['^ES/cursHTML/(:any)/(:any)'] 	= "home/cursHTML/$1/$2";
$route['^ES/cursHTML/(:any)'] 	        = "home/cursHTML/$1";
$route['^ES/figHTML/(:any)'] 			= "home/figHTML/$1";
$route['^ES/livreQcmEdit/(:any)'] 		= "home/livreQcmEdit/$1";
$route['^ES/livreQrocEdit/(:any)'] 		= "home/livreQrocEdit/$1";
$route['^ES/searchIndex'] 				= "home/searchIndex";
$route['^ES/listOffers/(:any)'] 		= "home/listOffers/$1";
$route['^ES/evaluatQCM/(:any)/(:any)/(:any)'] 	= "home/evaluatQCM/$1/$2/$3";
$route['^ES/evaluatQROC/(:any)/(:any)/(:any)'] 	= "home/evaluatQROC/$1/$2/$3";
$route['^ES/evaluatTEST/(:any)'] 	= "home/getListTestByChapitres4/$1";
$route['^ES/evaluatCalque/(:any)'] 	= "home/getListCalqueByChapitres2/$1";
$route['^ES/contactUS'] 				= "home/contactUS";
$route['^ES/v1_livre'] 				    = "home/v1_livre";

$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;



