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

        $sql = "SELECT name, max_limit
        FROM expenses_category_assigned_to_users
        WHERE user_id = :user_id";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * add income category to currently logged user incomes categories list
     *
     * @return void
     */

    public static function addExpenseCategory($categoryName, $limit = 0)
    {
        $current_user_id = $_SESSION['user_id'];

        $sql = "INSERT INTO expenses_category_assigned_to_users (id,user_id,name,max_limit)
        VALUES (NULL, :user_id, :name, :max_limit)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $categoryName, PDO::PARAM_STR);
        $stmt->bindValue(':max_limit', $limit, PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * Delete selected category
     *
     * @return void
     */
    public static function deleteExpenseCategory($categoryName)
    {
        $current_user_id = $_SESSION['user_id'];

        $sql = "DELETE FROM expenses_category_assigned_to_users
        WHERE user_id=:user_id AND name=:categoryName";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * Edit income category
     *
     * @return void
     */
    public static function editExpenseCategory($oldName, $newName, $newLimit)
    {
        $current_user_id = $_SESSION['user_id'];

        $sql = "UPDATE expenses_category_assigned_to_users
        SET name =:newName, max_limit=:newLimit
        WHERE user_id=:user_id AND name=:oldName";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->bindValue(':newName', $newName, PDO::PARAM_STR);
        $stmt->bindValue(':oldName', $oldName, PDO::PARAM_STR);
        $stmt->bindValue(':newLimit', $newLimit, PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * get current category limit
     *
     * @return array
     */

    public static function checkExpenseLimit($categoryName, $date)
    {
        $current_user_id = $_SESSION['user_id'];
        $from_date = date('Y-m-01', strtotime($date));
        $to_date = date('Y-m-t', strtotime($date));

        $sql = "SELECT SUM(expe.amount) AS 'sum' , (SELECT max_limit FROM expenses_category_assigned_to_users WHERE name = :categoryName and user_id = :user_id ) AS 'limit'
        FROM expenses_category_assigned_to_users cat
        JOIN expenses expe
        ON cat.id = expe.expense_category_assigned_to_user_id
        WHERE cat.user_id = :user_id AND cat.name = :categoryName AND date_of_expense BETWEEN '$from_date' AND '$to_date' ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
}