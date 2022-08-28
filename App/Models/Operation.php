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

    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */
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
 
         //Get currently logged user id from session in order to use it in subquerries (binding values doesn't work for subqueries)
 
         $current_user_id = $_SESSION['user_id'];
 
         $income_category_sub_sql = "(SELECT id FROM incomes_category_assigned_to_users WHERE name = '$this->income_category' AND user_id = $current_user_id)";
 
         $sql = "INSERT INTO incomes (id,user_id,income_category_assigned_to_user_id, amount, date_of_income, income_comment)
         VALUES (NULL,$current_user_id, $income_category_sub_sql, :amount, :date_of_income, :income_comment)";
 
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

        //Get currently logged user id from session in order to use it in subquerries (binding values doesn't work for subqueries)

        $current_user_id = $_SESSION['user_id'];

        $expense_category_sub_sql = "(SELECT id FROM expenses_category_assigned_to_users WHERE name = '$this->expenses_category' AND user_id = $current_user_id)";
        $payment_method_sub_sql = "(SELECT id FROM payment_methods_assigned_to_users WHERE name = '$this->payment_method' AND user_id = $current_user_id)";


        $sql = "INSERT INTO expenses (id,user_id,expense_category_assigned_to_user_id, payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment)
        VALUES (NULL,$current_user_id, $expense_category_sub_sql, $payment_method_sub_sql, :amount, :date_of_expense, :expense_comment)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
        $stmt->bindValue(':date_of_expense', $this->date, PDO::PARAM_STR);
        $stmt->bindValue(':expense_comment', $this->comment, PDO::PARAM_STR);

        return $stmt->execute();

    }

}
