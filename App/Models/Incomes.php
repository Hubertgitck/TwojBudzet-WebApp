<?php

namespace App\Models;

use PDO;

/**
 * User model
 *
 * PHP version 7.0
 */
class Incomes extends \Core\Model
{
    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

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
