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

        //Check if search inputs are empty, if so, fill in with default date
        if(!empty($operation->search['post_at']) and !isset($operation->last_month)) {
            $post_at = date('Y-m-d');
            $post_at = $operation->search["post_at"];
            list($fiy,$fim,$fid) = explode("-",$post_at);
            $post_at = "$fiy-$fim-$fid";

            if(!empty($operation->search["post_at_to_date"])) {
                $post_at_to_date = date('Y-m-d');
                $post_at_to_date = $operation->search["post_at_to_date"];
                list($tiy,$tim,$tid) = explode("-",$operation->search["post_at_to_date"]);
                $post_at_to_date = "$tiy-$tim-$tid";

            }
        } elseif(isset($operation->last_month)){
            $post_at = date('Y-m-d', strtotime("first day of previous month"));
            $post_at_to_date = date('Y-m-d', strtotime("last day of previous month"));
            unset($operation->search['last_month']);
        }
        else{
            $post_at = date('Y-m-01');
            $post_at_to_date = date('Y-m-t');
        }

    $db_data = $operation->getBalance($post_at, $post_at_to_date);

    View::renderTemplate('Operations/balance.html', ['post_at' => $post_at, 'post_at_to_date' => $post_at_to_date, 'db_data' => $db_data]);
    }
}
