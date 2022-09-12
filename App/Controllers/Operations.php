<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;
use \App\Models\Expense;
use \App\Models\Balance;
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
        $income = new Income($_POST);

        if(isset($income->submit)){
            if($income->addIncome()){
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
        $expense = new Expense($_POST);

        if(isset($expense->submit)){
            if($expense->addExpense()){
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
        $balance = new Balance($_POST);

        $balance->getDateRange();

        $db_data = $balance->getBalance();

        View::renderTemplate('Operations/balance.html', ['post_at' => $balance->post_at, 'post_at_to_date' => $balance->post_at_to_date, 'db_data' => $db_data]);

    }
}
