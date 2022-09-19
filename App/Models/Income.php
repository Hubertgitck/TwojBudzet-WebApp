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

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * add income category to currently logged user incomes categories list
     *
     * @return void
     */

    public static function addIncomeCategory($categoryName)
    {
        $current_user_id = $_SESSION['user_id'];

        $sql = "INSERT INTO incomes_category_assigned_to_users (id,user_id,name)
        VALUES (NULL, :user_id, :name)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $categoryName, PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * Delete selected category
     *
     * @return void
     */
    public static function deleteIncomeCategory($categoryName)
    {
        $current_user_id = $_SESSION['user_id'];

        $sql = "DELETE FROM incomes_category_assigned_to_users
        WHERE user_id=:user_id AND name=:categoryName";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Edit income category
     *
     * @return void
     */
    public static function editIncomeCategory($oldName, $newName)
    {
        $current_user_id = $_SESSION['user_id'];

        $sql = "UPDATE incomes_category_assigned_to_users
        SET name =:newName
        WHERE user_id=:user_id AND name=:oldName";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->bindValue(':newName', $newName, PDO::PARAM_STR);
        $stmt->bindValue(':oldName', $oldName, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Get payment methods names for currently logged in user
     *
     * @return array
     */

    public static function getPaymentMethods()
    {
        $current_user_id = $_SESSION['user_id'];

        $sql = "SELECT name
        FROM payment_methods_assigned_to_users
        WHERE user_id = :user_id";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * add income category to currently logged user incomes categories list
     *
     * @return void
     */

    public static function addPaymentMethod($paymentMethodName)
    {
        $current_user_id = $_SESSION['user_id'];

        $sql = "INSERT INTO payment_methods_assigned_to_users (id,user_id,name)
        VALUES (NULL, :user_id, :name)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $paymentMethodName, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Delete selected payment method
     *
     * @return void
     */
    public static function deletePaymentMethod($paymentMethodName)
    {
        $current_user_id = $_SESSION['user_id'];

        $sql = "DELETE FROM payment_methods_assigned_to_users
        WHERE user_id=:user_id AND name=:paymentMethodName";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->bindValue(':paymentMethodName', $paymentMethodName, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Edit payment category
     *
     * @return void
     */
    public static function editPaymentMethod($oldName, $newName)
    {
        $current_user_id = $_SESSION['user_id'];

        $sql = "UPDATE payment_methods_assigned_to_users
        SET name =:newName
        WHERE user_id=:user_id AND name=:oldName";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $current_user_id, PDO::PARAM_INT);
        $stmt->bindValue(':newName', $newName, PDO::PARAM_STR);
        $stmt->bindValue(':oldName', $oldName, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * get Category limit
     *
     * @return
     */

    public function getCategoryLimit()
    {

    }
}
