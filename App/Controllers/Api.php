<?php

namespace App\Controllers;

use \App\Models\Expense;
use \App\Models\Income;

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
        echo json_encode(Expense::getExpensesCategories(), JSON_UNESCAPED_UNICODE);
    }

    public function getIncomesCategoriesAction()
    {
        echo json_encode(Income::getIncomesCategories(), JSON_UNESCAPED_UNICODE);
    }
}
