<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{

    /**
     * Show the home page
     *
     * @return void
     */
    public function homeAction()
    {
        View::renderTemplate('Home/home.html');
    }
}
