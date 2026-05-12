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
$route['debugEsCategory'] = "home/debugEsCategory";


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
$route['^ES/testFigure/(:any)']  = "home/getFigure/$1";
$route['^RU/testFigure/(:any)']  = "home/getFigure/$1";
$route['^TR/testFigure/(:any)']  = "home/getFigure/$1";
$route['^PT/testFigure/(:any)']  = "home/getFigure/$1";
$route['^IT/testFigure/(:any)']  = "home/getFigure/$1";
$route['^DE/testFigure/(:any)']  = "home/getFigure/$1";
$route['^PL/testFigure/(:any)']  = "home/getFigure/$1";
$route['^JA/testFigure/(:any)']  = "home/getFigure/$1";
$route['^KO/testFigure/(:any)']  = "home/getFigure/$1";

$route['Videoupload/listVideos']  = "videoupload/listVideos";

$route['^FR/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";
$route['^EN/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";
$route['^ES/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";
$route['^RU/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";
$route['^TR/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";
$route['^PT/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";
$route['^IT/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";
$route['^DE/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";
$route['^PL/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";
$route['^JA/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";
$route['^KO/listCalque/(:any)']  = "home/getListCalqueByChapitres/$1";
$route['^FR/listTest/(:any)']  = "home/getListTestByChapitres3/$1";
$route['^EN/listTest/(:any)']  = "home/getListTestByChapitres3/$1";
$route['^ES/listTest/(:any)']  = "home/getListTestByChapitres3/$1";
$route['^RU/listTest/(:any)']  = "home/getListTestByChapitres3/$1";
$route['^TR/listTest/(:any)']  = "home/getListTestByChapitres3/$1";
$route['^PT/listTest/(:any)']  = "home/getListTestByChapitres3/$1";
$route['^IT/listTest/(:any)']  = "home/getListTestByChapitres3/$1";
$route['^DE/listTest/(:any)']  = "home/getListTestByChapitres3/$1";
$route['^PL/listTest/(:any)']  = "home/getListTestByChapitres3/$1";
$route['^JA/listTest/(:any)']  = "home/getListTestByChapitres3/$1";
$route['^KO/listTest/(:any)']  = "home/getListTestByChapitres3/$1";

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
$route['^FR/livreFigures/(:any)']       = "home/livreFigures/$1";
$route['^FR/figuresOnly/(:any)']        = "home/figuresOnly/$1";

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
$route['^EN/livreFigures/(:any)']       = "home/livreFigures/$1";
$route['^EN/figuresOnly/(:any)']        = "home/figuresOnly/$1";

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
$route['^ES/livreFigures/(:any)']       = "home/livreFigures/$1";
$route['^ES/figuresOnly/(:any)']        = "home/figuresOnly/$1";

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

$route['^RU/switchPlatform/(:any)'] 				= "home/switchPlatform/$1";
$route['^RU/login'] 				    = "home/login";
$route['^RU/category/(:any)'] 		    = "home/pageCategory/$1";
$route['^RU/livreList/(:any)/(:any)'] 	= "home/livreList/$1/$2";
$route['^RU/livre/(:any)'] 				= "home/livre/$1";
$route['^RU/livreDetails/(:any)'] 		= "home/livreDetails/$1";
$route['^RU/livreCours/(:any)/(:any)'] 	= "home/livreCours/$1/$2";
$route['^RU/livreCours/(:any)'] 	    = "home/livreCours/$1";
$route['^RU/livreResume/(:any)/(:any)'] = "home/livreResume/$1/$2";
$route['^RU/livreResume/(:any)']        = "home/livreResume/$1";
$route['^RU/livreFigures/(:any)']       = "home/livreFigures/$1";
$route['^RU/figuresOnly/(:any)']        = "home/figuresOnly/$1";

$route['^RU/livreQcm/(:any)'] 			= "home/livreQcm/$1";
$route['^RU/livreQroc/(:any)'] 			= "home/livreQroc/$1";
$route['^RU/signUp'] 					= "home/signUp";
$route['^RU/resetUp'] 					= "home/resetUp";
$route['^RU/forgot_password'] 			= "home/forgot_password";
$route['^RU/pagesSetting'] 				= "home/settingPaltform";
$route['^RU/logout'] 					= "home/logout";
$route['^RU/settingUsers'] 				= "home/settingUsers";
$route['^RU/settingUsersEtab'] 			= "home/settingUsersEtab";
$route['^RU/settingCurs'] 				= "home/settingCurs";
$route['^RU/settingPlat'] 				= "home/settingPlat";
$route['^RU/settingActualites'] 		= "home/settingActualites";
$route['^RU/settingTest/(:any)'] 		= "home/settingFigures/$1";
$route['^RU/cursHTML/(:any)/(:any)'] 	= "home/cursHTML/$1/$2";
$route['^RU/cursHTML/(:any)'] 	        = "home/cursHTML/$1";
$route['^RU/figHTML/(:any)'] 			= "home/figHTML/$1";
$route['^RU/livreQcmEdit/(:any)'] 		= "home/livreQcmEdit/$1";
$route['^RU/livreQrocEdit/(:any)'] 		= "home/livreQrocEdit/$1";
$route['^RU/searchIndex'] 				= "home/searchIndex";
$route['^RU/listOffers/(:any)'] 		= "home/listOffers/$1";
$route['^RU/evaluatQCM/(:any)/(:any)/(:any)'] 	= "home/evaluatQCM/$1/$2/$3";
$route['^RU/evaluatQROC/(:any)/(:any)/(:any)'] 	= "home/evaluatQROC/$1/$2/$3";
$route['^RU/evaluatTEST/(:any)'] 	= "home/getListTestByChapitres4/$1";
$route['^RU/evaluatCalque/(:any)'] 	= "home/getListCalqueByChapitres2/$1";
$route['^RU/contactUS'] 				= "home/contactUS";
$route['^RU/v1_livre'] 				    = "home/v1_livre";

$route['^TR/switchPlatform/(:any)'] 				= "home/switchPlatform/$1";
$route['^TR/login'] 				    = "home/login";
$route['^TR/category/(:any)'] 		    = "home/pageCategory/$1";
$route['^TR/livreList/(:any)/(:any)'] 	= "home/livreList/$1/$2";
$route['^TR/livre/(:any)'] 				= "home/livre/$1";
$route['^TR/livreDetails/(:any)'] 		= "home/livreDetails/$1";
$route['^TR/livreCours/(:any)/(:any)'] 	= "home/livreCours/$1/$2";
$route['^TR/livreCours/(:any)'] 	    = "home/livreCours/$1";
$route['^TR/livreResume/(:any)/(:any)'] = "home/livreResume/$1/$2";
$route['^TR/livreResume/(:any)']        = "home/livreResume/$1";
$route['^TR/livreFigures/(:any)']       = "home/livreFigures/$1";
$route['^TR/figuresOnly/(:any)']        = "home/figuresOnly/$1";

$route['^TR/livreQcm/(:any)'] 			= "home/livreQcm/$1";
$route['^TR/livreQroc/(:any)'] 			= "home/livreQroc/$1";
$route['^TR/signUp'] 					= "home/signUp";
$route['^TR/resetUp'] 					= "home/resetUp";
$route['^TR/forgot_password'] 			= "home/forgot_password";
$route['^TR/pagesSetting'] 				= "home/settingPaltform";
$route['^TR/logout'] 					= "home/logout";
$route['^TR/settingUsers'] 				= "home/settingUsers";
$route['^TR/settingUsersEtab'] 			= "home/settingUsersEtab";
$route['^TR/settingCurs'] 				= "home/settingCurs";
$route['^TR/settingPlat'] 				= "home/settingPlat";
$route['^TR/settingActualites'] 		= "home/settingActualites";
$route['^TR/settingTest/(:any)'] 		= "home/settingFigures/$1";
$route['^TR/cursHTML/(:any)/(:any)'] 	= "home/cursHTML/$1/$2";
$route['^TR/cursHTML/(:any)'] 	        = "home/cursHTML/$1";
$route['^TR/figHTML/(:any)'] 			= "home/figHTML/$1";
$route['^TR/livreQcmEdit/(:any)'] 		= "home/livreQcmEdit/$1";
$route['^TR/livreQrocEdit/(:any)'] 		= "home/livreQrocEdit/$1";
$route['^TR/searchIndex'] 				= "home/searchIndex";
$route['^TR/listOffers/(:any)'] 		= "home/listOffers/$1";
$route['^TR/evaluatQCM/(:any)/(:any)/(:any)'] 	= "home/evaluatQCM/$1/$2/$3";
$route['^TR/evaluatQROC/(:any)/(:any)/(:any)'] 	= "home/evaluatQROC/$1/$2/$3";
$route['^TR/evaluatTEST/(:any)'] 	= "home/getListTestByChapitres4/$1";
$route['^TR/evaluatCalque/(:any)'] 	= "home/getListCalqueByChapitres2/$1";
$route['^TR/contactUS'] 				= "home/contactUS";
$route['^TR/v1_livre'] 				    = "home/v1_livre";

$route['^PT/switchPlatform/(:any)'] 				= "home/switchPlatform/$1";
$route['^PT/login'] 				    = "home/login";
$route['^PT/category/(:any)'] 		    = "home/pageCategory/$1";
$route['^PT/livreList/(:any)/(:any)'] 	= "home/livreList/$1/$2";
$route['^PT/livre/(:any)'] 				= "home/livre/$1";
$route['^PT/livreDetails/(:any)'] 		= "home/livreDetails/$1";
$route['^PT/livreCours/(:any)/(:any)'] 	= "home/livreCours/$1/$2";
$route['^PT/livreCours/(:any)'] 	    = "home/livreCours/$1";
$route['^PT/livreResume/(:any)/(:any)'] = "home/livreResume/$1/$2";
$route['^PT/livreResume/(:any)']        = "home/livreResume/$1";
$route['^PT/livreFigures/(:any)']       = "home/livreFigures/$1";
$route['^PT/figuresOnly/(:any)']        = "home/figuresOnly/$1";

$route['^PT/livreQcm/(:any)'] 			= "home/livreQcm/$1";
$route['^PT/livreQroc/(:any)'] 			= "home/livreQroc/$1";
$route['^PT/signUp'] 					= "home/signUp";
$route['^PT/resetUp'] 					= "home/resetUp";
$route['^PT/forgot_password'] 			= "home/forgot_password";
$route['^PT/pagesSetting'] 				= "home/settingPaltform";
$route['^PT/logout'] 					= "home/logout";
$route['^PT/settingUsers'] 				= "home/settingUsers";
$route['^PT/settingUsersEtab'] 			= "home/settingUsersEtab";
$route['^PT/settingCurs'] 				= "home/settingCurs";
$route['^PT/settingPlat'] 				= "home/settingPlat";
$route['^PT/settingActualites'] 		= "home/settingActualites";
$route['^PT/settingTest/(:any)'] 		= "home/settingFigures/$1";
$route['^PT/cursHTML/(:any)/(:any)'] 	= "home/cursHTML/$1/$2";
$route['^PT/cursHTML/(:any)'] 	        = "home/cursHTML/$1";
$route['^PT/figHTML/(:any)'] 			= "home/figHTML/$1";
$route['^PT/livreQcmEdit/(:any)'] 		= "home/livreQcmEdit/$1";
$route['^PT/livreQrocEdit/(:any)'] 		= "home/livreQrocEdit/$1";
$route['^PT/searchIndex'] 				= "home/searchIndex";
$route['^PT/listOffers/(:any)'] 		= "home/listOffers/$1";
$route['^PT/evaluatQCM/(:any)/(:any)/(:any)'] 	= "home/evaluatQCM/$1/$2/$3";
$route['^PT/evaluatQROC/(:any)/(:any)/(:any)'] 	= "home/evaluatQROC/$1/$2/$3";
$route['^PT/evaluatTEST/(:any)'] 	= "home/getListTestByChapitres4/$1";
$route['^PT/evaluatCalque/(:any)'] 	= "home/getListCalqueByChapitres2/$1";
$route['^PT/contactUS'] 				= "home/contactUS";
$route['^PT/v1_livre'] 				    = "home/v1_livre";

$route['^IT/switchPlatform/(:any)'] 				= "home/switchPlatform/$1";
$route['^IT/login'] 				    = "home/login";
$route['^IT/category/(:any)'] 		    = "home/pageCategory/$1";
$route['^IT/livreList/(:any)/(:any)'] 	= "home/livreList/$1/$2";
$route['^IT/livre/(:any)'] 				= "home/livre/$1";
$route['^IT/livreDetails/(:any)'] 		= "home/livreDetails/$1";
$route['^IT/livreCours/(:any)/(:any)'] 	= "home/livreCours/$1/$2";
$route['^IT/livreCours/(:any)'] 	    = "home/livreCours/$1";
$route['^IT/livreResume/(:any)/(:any)'] = "home/livreResume/$1/$2";
$route['^IT/livreResume/(:any)']        = "home/livreResume/$1";
$route['^IT/livreFigures/(:any)']       = "home/livreFigures/$1";
$route['^IT/figuresOnly/(:any)']        = "home/figuresOnly/$1";

$route['^IT/livreQcm/(:any)'] 			= "home/livreQcm/$1";
$route['^IT/livreQroc/(:any)'] 			= "home/livreQroc/$1";
$route['^IT/signUp'] 					= "home/signUp";
$route['^IT/resetUp'] 					= "home/resetUp";
$route['^IT/forgot_password'] 			= "home/forgot_password";
$route['^IT/pagesSetting'] 				= "home/settingPaltform";
$route['^IT/logout'] 					= "home/logout";
$route['^IT/settingUsers'] 				= "home/settingUsers";
$route['^IT/settingUsersEtab'] 			= "home/settingUsersEtab";
$route['^IT/settingCurs'] 				= "home/settingCurs";
$route['^IT/settingPlat'] 				= "home/settingPlat";
$route['^IT/settingActualites'] 		= "home/settingActualites";
$route['^IT/settingTest/(:any)'] 		= "home/settingFigures/$1";
$route['^IT/cursHTML/(:any)/(:any)'] 	= "home/cursHTML/$1/$2";
$route['^IT/cursHTML/(:any)'] 	        = "home/cursHTML/$1";
$route['^IT/figHTML/(:any)'] 			= "home/figHTML/$1";
$route['^IT/livreQcmEdit/(:any)'] 		= "home/livreQcmEdit/$1";
$route['^IT/livreQrocEdit/(:any)'] 		= "home/livreQrocEdit/$1";
$route['^IT/searchIndex'] 				= "home/searchIndex";
$route['^IT/listOffers/(:any)'] 		= "home/listOffers/$1";
$route['^IT/evaluatQCM/(:any)/(:any)/(:any)'] 	= "home/evaluatQCM/$1/$2/$3";
$route['^IT/evaluatQROC/(:any)/(:any)/(:any)'] 	= "home/evaluatQROC/$1/$2/$3";
$route['^IT/evaluatTEST/(:any)'] 	= "home/getListTestByChapitres4/$1";
$route['^IT/evaluatCalque/(:any)'] 	= "home/getListCalqueByChapitres2/$1";
$route['^IT/contactUS'] 				= "home/contactUS";
$route['^IT/v1_livre'] 				    = "home/v1_livre";

$route['^DE/switchPlatform/(:any)'] 				= "home/switchPlatform/$1";
$route['^DE/login'] 				    = "home/login";
$route['^DE/category/(:any)'] 		    = "home/pageCategory/$1";
$route['^DE/livreList/(:any)/(:any)'] 	= "home/livreList/$1/$2";
$route['^DE/livre/(:any)'] 				= "home/livre/$1";
$route['^DE/livreDetails/(:any)'] 		= "home/livreDetails/$1";
$route['^DE/livreCours/(:any)/(:any)'] 	= "home/livreCours/$1/$2";
$route['^DE/livreCours/(:any)'] 	    = "home/livreCours/$1";
$route['^DE/livreResume/(:any)/(:any)'] = "home/livreResume/$1/$2";
$route['^DE/livreResume/(:any)']        = "home/livreResume/$1";
$route['^DE/livreFigures/(:any)']       = "home/livreFigures/$1";
$route['^DE/figuresOnly/(:any)']        = "home/figuresOnly/$1";

$route['^DE/livreQcm/(:any)'] 			= "home/livreQcm/$1";
$route['^DE/livreQroc/(:any)'] 			= "home/livreQroc/$1";
$route['^DE/signUp'] 					= "home/signUp";
$route['^DE/resetUp'] 					= "home/resetUp";
$route['^DE/forgot_password'] 			= "home/forgot_password";
$route['^DE/pagesSetting'] 				= "home/settingPaltform";
$route['^DE/logout'] 					= "home/logout";
$route['^DE/settingUsers'] 				= "home/settingUsers";
$route['^DE/settingUsersEtab'] 			= "home/settingUsersEtab";
$route['^DE/settingCurs'] 				= "home/settingCurs";
$route['^DE/settingPlat'] 				= "home/settingPlat";
$route['^DE/settingActualites'] 		= "home/settingActualites";
$route['^DE/settingTest/(:any)'] 		= "home/settingFigures/$1";
$route['^DE/cursHTML/(:any)/(:any)'] 	= "home/cursHTML/$1/$2";
$route['^DE/cursHTML/(:any)'] 	        = "home/cursHTML/$1";
$route['^DE/figHTML/(:any)'] 			= "home/figHTML/$1";
$route['^DE/livreQcmEdit/(:any)'] 		= "home/livreQcmEdit/$1";
$route['^DE/livreQrocEdit/(:any)'] 		= "home/livreQrocEdit/$1";
$route['^DE/searchIndex'] 				= "home/searchIndex";
$route['^DE/listOffers/(:any)'] 		= "home/listOffers/$1";
$route['^DE/evaluatQCM/(:any)/(:any)/(:any)'] 	= "home/evaluatQCM/$1/$2/$3";
$route['^DE/evaluatQROC/(:any)/(:any)/(:any)'] 	= "home/evaluatQROC/$1/$2/$3";
$route['^DE/evaluatTEST/(:any)'] 	= "home/getListTestByChapitres4/$1";
$route['^DE/evaluatCalque/(:any)'] 	= "home/getListCalqueByChapitres2/$1";
$route['^DE/contactUS'] 				= "home/contactUS";
$route['^DE/v1_livre'] 				    = "home/v1_livre";

$route['^PL/switchPlatform/(:any)'] 				= "home/switchPlatform/$1";
$route['^PL/login'] 				    = "home/login";
$route['^PL/category/(:any)'] 		    = "home/pageCategory/$1";
$route['^PL/livreList/(:any)/(:any)'] 	= "home/livreList/$1/$2";
$route['^PL/livre/(:any)'] 				= "home/livre/$1";
$route['^PL/livreDetails/(:any)'] 		= "home/livreDetails/$1";
$route['^PL/livreCours/(:any)/(:any)'] 	= "home/livreCours/$1/$2";
$route['^PL/livreCours/(:any)'] 	    = "home/livreCours/$1";
$route['^PL/livreResume/(:any)/(:any)'] = "home/livreResume/$1/$2";
$route['^PL/livreResume/(:any)']        = "home/livreResume/$1";
$route['^PL/livreFigures/(:any)']       = "home/livreFigures/$1";
$route['^PL/figuresOnly/(:any)']        = "home/figuresOnly/$1";

$route['^PL/livreQcm/(:any)'] 			= "home/livreQcm/$1";
$route['^PL/livreQroc/(:any)'] 			= "home/livreQroc/$1";
$route['^PL/signUp'] 					= "home/signUp";
$route['^PL/resetUp'] 					= "home/resetUp";
$route['^PL/forgot_password'] 			= "home/forgot_password";
$route['^PL/pagesSetting'] 				= "home/settingPaltform";
$route['^PL/logout'] 					= "home/logout";
$route['^PL/settingUsers'] 				= "home/settingUsers";
$route['^PL/settingUsersEtab'] 			= "home/settingUsersEtab";
$route['^PL/settingCurs'] 				= "home/settingCurs";
$route['^PL/settingPlat'] 				= "home/settingPlat";
$route['^PL/settingActualites'] 		= "home/settingActualites";
$route['^PL/settingTest/(:any)'] 		= "home/settingFigures/$1";
$route['^PL/cursHTML/(:any)/(:any)'] 	= "home/cursHTML/$1/$2";
$route['^PL/cursHTML/(:any)'] 	        = "home/cursHTML/$1";
$route['^PL/figHTML/(:any)'] 			= "home/figHTML/$1";
$route['^PL/livreQcmEdit/(:any)'] 		= "home/livreQcmEdit/$1";
$route['^PL/livreQrocEdit/(:any)'] 		= "home/livreQrocEdit/$1";
$route['^PL/searchIndex'] 				= "home/searchIndex";
$route['^PL/listOffers/(:any)'] 		= "home/listOffers/$1";
$route['^PL/evaluatQCM/(:any)/(:any)/(:any)'] 	= "home/evaluatQCM/$1/$2/$3";
$route['^PL/evaluatQROC/(:any)/(:any)/(:any)'] 	= "home/evaluatQROC/$1/$2/$3";
$route['^PL/evaluatTEST/(:any)'] 	= "home/getListTestByChapitres4/$1";
$route['^PL/evaluatCalque/(:any)'] 	= "home/getListCalqueByChapitres2/$1";
$route['^PL/contactUS'] 				= "home/contactUS";
$route['^PL/v1_livre'] 				    = "home/v1_livre";

$route['^JA/switchPlatform/(:any)'] 				= "home/switchPlatform/$1";
$route['^JA/login'] 				    = "home/login";
$route['^JA/category/(:any)'] 		    = "home/pageCategory/$1";
$route['^JA/livreList/(:any)/(:any)'] 	= "home/livreList/$1/$2";
$route['^JA/livre/(:any)'] 				= "home/livre/$1";
$route['^JA/livreDetails/(:any)'] 		= "home/livreDetails/$1";
$route['^JA/livreCours/(:any)/(:any)'] 	= "home/livreCours/$1/$2";
$route['^JA/livreCours/(:any)'] 	    = "home/livreCours/$1";
$route['^JA/livreResume/(:any)/(:any)'] = "home/livreResume/$1/$2";
$route['^JA/livreResume/(:any)']        = "home/livreResume/$1";
$route['^JA/livreFigures/(:any)']       = "home/livreFigures/$1";
$route['^JA/figuresOnly/(:any)']        = "home/figuresOnly/$1";

$route['^JA/livreQcm/(:any)'] 			= "home/livreQcm/$1";
$route['^JA/livreQroc/(:any)'] 			= "home/livreQroc/$1";
$route['^JA/signUp'] 					= "home/signUp";
$route['^JA/resetUp'] 					= "home/resetUp";
$route['^JA/forgot_password'] 			= "home/forgot_password";
$route['^JA/pagesSetting'] 				= "home/settingPaltform";
$route['^JA/logout'] 					= "home/logout";
$route['^JA/settingUsers'] 				= "home/settingUsers";
$route['^JA/settingUsersEtab'] 			= "home/settingUsersEtab";
$route['^JA/settingCurs'] 				= "home/settingCurs";
$route['^JA/settingPlat'] 				= "home/settingPlat";
$route['^JA/settingActualites'] 		= "home/settingActualites";
$route['^JA/settingTest/(:any)'] 		= "home/settingFigures/$1";
$route['^JA/cursHTML/(:any)/(:any)'] 	= "home/cursHTML/$1/$2";
$route['^JA/cursHTML/(:any)'] 	        = "home/cursHTML/$1";
$route['^JA/figHTML/(:any)'] 			= "home/figHTML/$1";
$route['^JA/livreQcmEdit/(:any)'] 		= "home/livreQcmEdit/$1";
$route['^JA/livreQrocEdit/(:any)'] 		= "home/livreQrocEdit/$1";
$route['^JA/searchIndex'] 				= "home/searchIndex";
$route['^JA/listOffers/(:any)'] 		= "home/listOffers/$1";
$route['^JA/evaluatQCM/(:any)/(:any)/(:any)'] 	= "home/evaluatQCM/$1/$2/$3";
$route['^JA/evaluatQROC/(:any)/(:any)/(:any)'] 	= "home/evaluatQROC/$1/$2/$3";
$route['^JA/evaluatTEST/(:any)'] 	= "home/getListTestByChapitres4/$1";
$route['^JA/evaluatCalque/(:any)'] 	= "home/getListCalqueByChapitres2/$1";
$route['^JA/contactUS'] 				= "home/contactUS";
$route['^JA/v1_livre'] 				    = "home/v1_livre";

$route['^KO/switchPlatform/(:any)'] 				= "home/switchPlatform/$1";
$route['^KO/login'] 				    = "home/login";
$route['^KO/category/(:any)'] 		    = "home/pageCategory/$1";
$route['^KO/livreList/(:any)/(:any)'] 	= "home/livreList/$1/$2";
$route['^KO/livre/(:any)'] 				= "home/livre/$1";
$route['^KO/livreDetails/(:any)'] 		= "home/livreDetails/$1";
$route['^KO/livreCours/(:any)/(:any)'] 	= "home/livreCours/$1/$2";
$route['^KO/livreCours/(:any)'] 	    = "home/livreCours/$1";
$route['^KO/livreResume/(:any)/(:any)'] = "home/livreResume/$1/$2";
$route['^KO/livreResume/(:any)']        = "home/livreResume/$1";
$route['^KO/livreFigures/(:any)']       = "home/livreFigures/$1";
$route['^KO/figuresOnly/(:any)']        = "home/figuresOnly/$1";

$route['^KO/livreQcm/(:any)'] 			= "home/livreQcm/$1";
$route['^KO/livreQroc/(:any)'] 			= "home/livreQroc/$1";
$route['^KO/signUp'] 					= "home/signUp";
$route['^KO/resetUp'] 					= "home/resetUp";
$route['^KO/forgot_password'] 			= "home/forgot_password";
$route['^KO/pagesSetting'] 				= "home/settingPaltform";
$route['^KO/logout'] 					= "home/logout";
$route['^KO/settingUsers'] 				= "home/settingUsers";
$route['^KO/settingUsersEtab'] 			= "home/settingUsersEtab";
$route['^KO/settingCurs'] 				= "home/settingCurs";
$route['^KO/settingPlat'] 				= "home/settingPlat";
$route['^KO/settingActualites'] 		= "home/settingActualites";
$route['^KO/settingTest/(:any)'] 		= "home/settingFigures/$1";
$route['^KO/cursHTML/(:any)/(:any)'] 	= "home/cursHTML/$1/$2";
$route['^KO/cursHTML/(:any)'] 	        = "home/cursHTML/$1";
$route['^KO/figHTML/(:any)'] 			= "home/figHTML/$1";
$route['^KO/livreQcmEdit/(:any)'] 		= "home/livreQcmEdit/$1";
$route['^KO/livreQrocEdit/(:any)'] 		= "home/livreQrocEdit/$1";
$route['^KO/searchIndex'] 				= "home/searchIndex";
$route['^KO/listOffers/(:any)'] 		= "home/listOffers/$1";
$route['^KO/evaluatQCM/(:any)/(:any)/(:any)'] 	= "home/evaluatQCM/$1/$2/$3";
$route['^KO/evaluatQROC/(:any)/(:any)/(:any)'] 	= "home/evaluatQROC/$1/$2/$3";
$route['^KO/evaluatTEST/(:any)'] 	= "home/getListTestByChapitres4/$1";
$route['^KO/evaluatCalque/(:any)'] 	= "home/getListCalqueByChapitres2/$1";
$route['^KO/contactUS'] 				= "home/contactUS";
$route['^KO/v1_livre'] 				    = "home/v1_livre";

$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;

$route['^FR/PlatFormeConvert/(:any)'] = 'home/PlatFormeConvert/$1';
$route['^EN/PlatFormeConvert/(:any)'] = 'home/PlatFormeConvert/$1';
$route['^ES/PlatFormeConvert/(:any)'] = 'home/PlatFormeConvert/$1';
$route['^RU/PlatFormeConvert/(:any)'] = 'home/PlatFormeConvert/$1';
$route['^TR/PlatFormeConvert/(:any)'] = 'home/PlatFormeConvert/$1';
$route['^PT/PlatFormeConvert/(:any)'] = 'home/PlatFormeConvert/$1';
$route['^IT/PlatFormeConvert/(:any)'] = 'home/PlatFormeConvert/$1';
$route['^DE/PlatFormeConvert/(:any)'] = 'home/PlatFormeConvert/$1';
$route['^PL/PlatFormeConvert/(:any)'] = 'home/PlatFormeConvert/$1';
$route['^JA/PlatFormeConvert/(:any)'] = 'home/PlatFormeConvert/$1';
$route['^KO/PlatFormeConvert/(:any)'] = 'home/PlatFormeConvert/$1';

$route['^ES/products/buyProduct/(:any)'] 		= "home/products/buyProduct/$1";
$route['^RU/products/buyProduct/(:any)'] 		= "home/products/buyProduct/$1";
$route['^TR/products/buyProduct/(:any)'] 		= "home/products/buyProduct/$1";
$route['^PT/products/buyProduct/(:any)'] 		= "home/products/buyProduct/$1";
$route['^IT/products/buyProduct/(:any)'] 		= "home/products/buyProduct/$1";
$route['^DE/products/buyProduct/(:any)'] 		= "home/products/buyProduct/$1";
$route['^PL/products/buyProduct/(:any)'] 		= "home/products/buyProduct/$1";
$route['^JA/products/buyProduct/(:any)'] 		= "home/products/buyProduct/$1";
$route['^KO/products/buyProduct/(:any)'] 		= "home/products/buyProduct/$1";


