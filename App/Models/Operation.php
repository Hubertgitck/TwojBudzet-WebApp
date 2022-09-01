<?php

namespace App\Models;

use PDO;
use \Core\View;

/**
 * User model
 *
 * PHP version 7.0
 */
class Operation extends \Core\Model
{
    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    /**
     * addIncome function
     *
     * @return boolean
     */

    public function addIncome()
    {
         $current_user_id = $_SESSION['user_id'];

         $income_category_sub_sql = "(SELECT id FROM incomes_category_assigned_to_users WHERE name = '$this->income_category' AND user_id = '$current_user_id')";

         $sql = "INSERT INTO incomes (id,user_id,income_category_assigned_to_user_id, amount, date_of_income, income_comment)
         VALUES (NULL, $current_user_id, $income_category_sub_sql, :amount, :date_of_income, :income_comment)";

         $db = static::getDB();
         $stmt = $db->prepare($sql);

         $stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
         $stmt->bindValue(':date_of_income', $this->date, PDO::PARAM_STR);
         $stmt->bindValue(':income_comment', $this->comment, PDO::PARAM_STR);

         return $stmt->execute();
    }

    /**
     * addExpense function
     *
     * @return boolean
     */
    public function addExpense()
    {
        $current_user_id = $_SESSION['user_id'];

        $expense_category_sub_sql = "(SELECT id FROM expenses_category_assigned_to_users WHERE name = '$this->expenses_category' AND user_id = '$current_user_id')";
        $payment_method_sub_sql = "(SELECT id FROM payment_methods_assigned_to_users WHERE name = '$this->payment_method' AND user_id = '$current_user_id')";


        $sql = "INSERT INTO expenses (id,user_id,expense_category_assigned_to_user_id, payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment)
        VALUES (NULL,$current_user_id, $expense_category_sub_sql, $payment_method_sub_sql, :amount, :date_of_expense, :expense_comment)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
        $stmt->bindValue(':date_of_expense', $this->date, PDO::PARAM_STR);
        $stmt->bindValue(':expense_comment', $this->comment, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
    * getBalance function
    *
    * @return boolean
    */
    public function getBalance($from_date, $to_date)
    {
        $current_user_id = $_SESSION['user_id'];
        $incomes_sum = array();
        $incomes_sum['amount'] = 0;
        $db_incomes_summed = array();

        $sql = "SELECT cat.name, inc.amount
        FROM incomes inc
        JOIN incomes_category_assigned_to_users cat
        ON cat.id = inc.income_category_assigned_to_user_id
        WHERE date_of_income BETWEEN '$from_date' AND '$to_date' AND inc.user_id = '$current_user_id'";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $db_incomes = $stmt->fetchALL(PDO::FETCH_ASSOC);

        foreach ($db_incomes as $key=>$value){
            $name = $value['name'];
            if(!isset($db_incomes_summed[$name])){
                $db_incomes_summed[$name]['amount'] = 0;
            }
            $db_incomes_summed[$name]['amount'] += $value['amount'];
            $incomes_sum['amount'] += $value['amount'];
        }

        $db_incomes_summed['incomes_sum'] = $incomes_sum;


        $expenses_sum = array();
        $expenses_sum['amount'] = 0;
        $db_expenses_summed = array();

        $sql = "SELECT exp.amount, cat.name
        FROM expenses exp
        JOIN expenses_category_assigned_to_users cat
        ON cat.id = exp.expense_category_assigned_to_user_id
        WHERE date_of_expense BETWEEN '$from_date' AND '$to_date' AND exp.user_id = '$current_user_id'";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $db_expenses = $stmt->fetchALL(PDO::FETCH_ASSOC);

        foreach ($db_expenses as $key=>$value){
            $name = $value['name'];
            if(!isset($db_expenses_summed[$name])){
                $db_expenses_summed[$name]['amount'] = 0;
            }
            $db_expenses_summed[$name]['amount'] += $value['amount'];
            $expenses_sum['amount'] += $value['amount'];
        }

        $db_expenses_summed['expenses_sum'] = $expenses_sum;

        return array_merge($db_incomes_summed, $db_expenses_summed);

    }
}
