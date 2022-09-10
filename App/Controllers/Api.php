<?php

namespace App\Controllers;

use \App\Models\Expenses;
use \App\Models\Incomes;

/**
 * API Controller
 *
 * PHP version 7.0
 */
class Api extends Authenticated
{
    /**
     * Add Income
     *
     * @return category names array
     */

    public function getExpensesCategoriesAction()
    {
        echo json_encode(Expenses::getExpensesCategories(), JSON_UNESCAPED_UNICODE);
    }

    public function getIncomesCategoriesAction()
    {
        echo json_encode(Incomes::getIncomesCategories(), JSON_UNESCAPED_UNICODE);
    }
}
