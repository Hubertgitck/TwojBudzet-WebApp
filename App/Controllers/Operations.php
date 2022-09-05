<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Operation;
use \App\Flash;

/**
 * Account controller
 *
 * PHP version 7.0
 */
class Operations extends Authenticated
{
    /**
     * Add Income
     *
     * @return void
     */
    public function addIncomeAction()
    {
        $operation = new Operation($_POST);

        if(isset($operation->submit)){
            if($operation->addIncome()){
                Flash::addMessage('Dodano przychód pomyślnie!', Flash::SUCCESS);
            }
            else{
                Flash::addMessage('Nie udało się dodać przychodu, spróbuj ponownie później!', Flash::WARNING);
            }
        }
        View::renderTemplate('Operations/AddIncome.html');
    }

    /**
     * Add Expense
     *
     * @return void
     */
    public function addExpenseAction()
    {
        $operation = new Operation($_POST);

        if(isset($operation->submit)){
            if($operation->addExpense()){
                Flash::addMessage('Dodano wydatek pomyślnie!', Flash::SUCCESS);
            }
            else{
                Flash::addMessage('Nie udało się dodać wydatku, spróbuj ponownie później!', Flash::WARNING);
            }
        }
        View::renderTemplate('Operations/AddExpense.html');
    }

      /**
     * Check balance
     *
     * @return void
     */
    public function balanceAction()
    {
        $operation = new Operation($_POST);

        $operation->getDateRange();

        $db_data = $operation->getBalance();

        View::renderTemplate('Operations/balance.html', ['post_at' => $operation->post_at, 'post_at_to_date' => $operation->post_at_to_date, 'db_data' => $db_data]);

    }
}
