<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Sessions
 */
session_start();


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Login', 'action' => 'new']);
$router->add('home', ['controller' => 'Home', 'action' => 'home']);
$router->add('balance', ['controller' => 'operations', 'action' => 'balance']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);

$router->add('password/reset/<token:[\da-f]+>', ['controller' => 'Password', 'action' => 'reset']);
$router->add('signup/activate/<token:[\da-f]+>', ['controller' => 'Signup', 'action' => 'activate']);

//Api section
$router->add('api/addIncomeCategory/<name:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>', ['controller' => 'Api', 'action' => 'addIncomeCategory']);
$router->add('api/deleteIncomeCategory/<name:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>', ['controller' => 'Api', 'action' => 'deleteIncomeCategory']);
$router->add('api/editIncomeCategory/<oldname:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>/<newname:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>', ['controller' => 'Api', 'action' => 'editIncomeCategory']);

$router->add('api/addPaymentMethod/<name:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>', ['controller' => 'Api', 'action' => 'addPaymentMethod']);
$router->add('api/deletePaymentMethod/<name:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>', ['controller' => 'Api', 'action' => 'deletePaymentMethod']);
$router->add('api/editPaymentMethod/<oldname:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>/<newname:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>', ['controller' => 'Api', 'action' => 'editPaymentMethod']);

$router->add('api/addExpenseCategory/<name:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>/<limit:[[0-9]+(\.[0-9]*)?|\.[0-9]+]>', ['controller' => 'Api', 'action' => 'addExpenseCategory']);
$router->add('api/addExpenseCategory/<name:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>/', ['controller' => 'Api', 'action' => 'addExpenseCategory']);
$router->add('api/deleteExpenseCategory/<name:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>', ['controller' => 'Api', 'action' => 'deleteExpenseCategory']);
$router->add('api/editExpenseCategory/<oldname:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>/<newname:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>/', ['controller' => 'Api', 'action' => 'editExpenseCategory']);
$router->add('api/editExpenseCategory/<oldname:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>/<newname:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>/<limit:([[0-9]+(\.[0-9]*)?|\.[0-9]+])>', ['controller' => 'Api', 'action' => 'editExpenseCategory']);
$router->add('api/checkExpenseLimit/<name:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ ]+>/<date:[0-9]{4}-[0-9]{2}-[0-9]{2}>', ['controller' => 'Api', 'action' => 'checkExpenseLimit']);


$router->add('api/updateUserProfile/<newname:[A-Za-zżźćńółęąśŻŹĆĄŚĘŁÓŃ \d]+>/<newemail:[^\s@]+@[^\s@]+\.[^\s@]+>', ['controller' => 'Api', 'action' => 'updateUserProfile']);


$router->add('{controller}/{action}');
$router->dispatch($_SERVER['QUERY_STRING']);
