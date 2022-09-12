<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */

    //const DB_HOST = 'budget.hubert-koziel.profesjonalnyprogramista.pl.mysql.dhosting.pl';
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */

    //const DB_NAME = 'chei7n_budgethu';
    const DB_NAME = 'mvcapp';

    /**
     * Database user
     * @var string
     */

    //const DB_USER = 'iez9wo_budgethu';
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */

    //const DB_PASSWORD = 'ahNgei3theoK';
    const DB_PASSWORD = '';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * Secret key for hashing
     * @var boolean
     */
    const SECRET_KEY = 'your-secret-key';
}