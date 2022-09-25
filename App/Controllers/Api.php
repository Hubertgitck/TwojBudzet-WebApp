<?php

namespace App\Controllers;

use \App\Models\Expense;
use \App\Models\Income;
use \App\Models\User;

/**
 * API Controller
 *
 * PHP version 7.0
 */
class Api extends Authenticated
{

    /**
     * Add income category to database
     *
     * @return
     */

    public function addIncomeCategoryAction()
    {
        $name = $this->route_params['name'];

        Income::addIncomeCategory($name);
    }

    /**
     * Delete income category from database
     *
     * @return
     */

    public function deleteIncomeCategoryAction()
    {
        $name = $this->route_params['name'];

        Income::deleteIncomeCategory($name);
    }

    /**
     * edit income category in db
     *
     * @return category names array
     */
    public function editIncomeCategoryAction()
    {
        $oldName = $this->route_params['oldname'];
        $newName = $this->route_params['newname'];

        Income::editIncomeCategory($oldName, $newName);
    }

    /**
     * Add income category to database
     *
     * @return
     */
    public function addExpenseCategoryAction()
    {
        $name = $this->route_params['name'];
        $limit = $this->route_params['limit'] ?? null;

        Expense::addExpenseCategory($name,$limit);
    }

    /**
     * Delete income category from database
     *
     * @return
     */

    public function deleteExpenseCategoryAction()
    {
        $name = $this->route_params['name'];

        Expense::deleteExpenseCategory($name);
    }

    /**
     * edit expense category in db
     *
     * @return category names array
     */
    public function editExpenseCategoryAction()
    {
        $oldName = $this->route_params['oldname'];
        $newName = $this->route_params['newname'];
        $newLimit = $this->route_params['limit'] ?? null;

        Expense::editExpenseCategory($oldName, $newName,$newLimit);
    }

    /**
     * edit expense category in db
     *
     * @return category names array
     */
    public function checkExpenseLimitAction()
    {
        $categoryName = $this->route_params['name'];
        $selectedDate = $this->route_params['date'];

        echo json_encode(Expense::checkExpenseLimit($categoryName, $selectedDate), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Add payment method to database
     *
     * @return
     */
    public function addPaymentMethodAction()
    {
        echo $name = $this->route_params['name'];

        Income::addPaymentMethod($name);
    }

    /**
     * Delete payment method from database
     *
     * @return
     */

    public function deletePaymentMethodAction()
    {
        $name = $this->route_params['name'];

        Income::deletePaymentMethod($name);
    }

    /**
     * edit payment method
     *
     * @return category names array
     */
    public function editPaymentMethodAction()
    {
        $oldName = $this->route_params['oldname'];
        $newName = $this->route_params['newname'];

        Income::editPaymentMethod($oldName, $newName);
    }

     /**
     * get income categories from database
     *
     * @return category names array
     */

    public function getIncomesCategoriesAction()
    {
        echo json_encode(Income::getIncomesCategories(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * get payment methods from database
     *
     * @return category names array
     */

    public function getPaymentMethodsAction()
    {
        echo json_encode(Income::getPaymentMethods(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * get expense categories from database
     *
     * @return category names array
     */

    public function getExpensesCategoriesAction()
    {
        echo json_encode(Expense::getExpensesCategories(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update user data
     *
     * @return category names array
     */

    public function updateUserProfileAction()
    {
        $userData['username'] = $this->route_params['newname'];
        $userData['email'] = $this->route_params['newemail'];

        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $userData['password'] = $data->password ?? null;

        $user = new User($userData);

        $user->updateUserProfile();
    }
}
