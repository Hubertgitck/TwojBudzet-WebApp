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
class Operations extends \Core\Controller
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
            $operation->addExpense();
            Flash::addMessage('Dodano wydatek pomyślnie!', Flash::SUCCESS);
        }

        else{
            Flash::addMessage('Nie udało się dodać wydatku, spróbuj ponownie później!', Flash::WARNING);
        }

        View::renderTemplate('Operations/AddExpense.html');

    }

    public function balanceAction()
    {
        View::renderTemplate('Operations/balance.html');



    }
}
