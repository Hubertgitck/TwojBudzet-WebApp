<?php

namespace App\Models;

use PDO;

/**
 * User model
 *
 * PHP version 7.0
 */
class Income extends \Core\Model
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
     * Get category names for currently logged in user
     *
     * @return array
     */

    public static function getIncomesCategories()
    {
        $current_user_id = $_SESSION['user_id'];

        $sql = "SELECT name
        FROM incomes_category_assigned_to_users
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
