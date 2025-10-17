<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
|------------------------------------------------------------------------
| API RESTful
|------------------------------------------------------------------------
| Vamos mapear /api/todos e /api/todos/{id}. O método HTTP diferencia
| a ação (GET, POST, PUT, DELETE).
*/

$route['default_controller'] = 'welcome';

$route['api/todos']['GET']            = 'api/todos/index';
$route['api/todos']['POST']           = 'api/todos/create';
$route['api/todos/(:num)']['GET']     = 'api/todos/show/$1';
$route['api/todos/(:num)']['PUT']     = 'api/todos/update/$1';
$route['api/todos/(:num)']['DELETE']  = 'api/todos/delete/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
