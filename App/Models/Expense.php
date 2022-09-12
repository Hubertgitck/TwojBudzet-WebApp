<?php

namespace App\Models;

use PDO;

/**
 * User model
 *
 * PHP version 7.0
 */
class Expense extends \Core\Model
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
     * Get category names for currently logged in user
     *
     * @return array
     */

    public static function getExpensesCategories()
    {
        $current_user_id = $_SESSION['user_id'];

        $sql = "SELECT name
        FROM expenses_category_assigned_to_users
        WHERE user_id = :user_id";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * addIncome function
     *
     * @return array
     */

    public function getCategoryLimit()
    {

    }
}
