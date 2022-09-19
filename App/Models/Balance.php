<?php

namespace App\Models;

use PDO;
use \Core\View;

/**
 * User model
 *
 * PHP version 7.0
 */
class Balance extends \Core\Model
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
    * getBalance function
    *
    * @return array of expenses and incomes
    */
    public function getBalance()
    {
        $from_date = $this->post_at;
        $to_date = $this->post_at_to_date;

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

     /**
    * getDateRange function
    *
    * @return void
    */

    public function getDateRange(){
        if(!empty($this->search['post_at']) and !isset($this->last_month)) {
            $post_at = date('Y-m-d');
            $post_at = $this->search["post_at"];
            list($fiy,$fim,$fid) = explode("-",$post_at);
            $this->post_at = "$fiy-$fim-$fid";

            if(!empty($this->search["post_at_to_date"])) {
                $post_at_to_date = date('Y-m-d');
                $post_at_to_date = $this->search["post_at_to_date"];
                list($tiy,$tim,$tid) = explode("-",$post_at_to_date);
                $this->post_at_to_date = "$tiy-$tim-$tid";

            }
        } elseif(isset($this->last_month)){
            $this->post_at = date('Y-m-d', strtotime("first day of previous month"));
            $this->post_at_to_date = date('Y-m-d', strtotime("last day of previous month"));
            unset($this->search['last_month']);
        }
        else{
            $this->post_at = date('Y-m-01');
            $this->post_at_to_date = date('Y-m-t');
        }

    }
}
