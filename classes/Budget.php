<?php declare(strict_types=1);

require_once 'Db.php';


class Budget extends Db
{
    
    public $conn;

    function __construct()
    {
        $this->conn = $this->connect();
    }

      public function getBudget()
    {
        $sql = "SELECT * FROM budgets order by budget_id desc";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $budgets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $budgets;

    }

    //a method that recieve id of a budget that toggles its status
    public function toggle_budget($id)
    {
        
        
        $cur_status = $this->check_budget_status($id);
        $sql = "UPDATE budgets SET is_active = ? WHERE budget_id = ?";
        $stmt = $this->conn->prepare($sql);
        $last_status = $cur_status == 'yes' ? 'no' : 'yes';
        $result = $stmt->execute([$last_status, $id]);
        return $result;
        

    }

    //a method that recieve the id of a budget and return its status
    public function check_budget_status($id)
    {
        
        $sql = "SELECT is_active FROM budgets WHERE budget_id = ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        $status = $stmt->fetch(PDO::FETCH_COLUMN);
        return $status ;

    }

     public function deleteBudget($userid, $bid)
    {
        try {

            $sql = "DELETE FROM budgets WHERE user_id = ? AND budget_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$userid, $bid]);

            return true;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;   
        }
    }


//get total budget
    public function getTotal(int $userId, string $startDate, string $endDate)
    {
        $sql = "
            SELECT COALESCE(SUM(amount_limit), 0)
            FROM budgets
            WHERE user_id = :uid
              AND is_active = 1
              AND start_date <= :end_date
              AND end_date >= :start_date
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':uid' => $userId,
            ':start_date' => $startDate,
            ':end_date' => $endDate
        ]);

        return $stmt->fetch(PDO::FETCH_COLUMN);

        #return (float) $stmt->fetchColumn();
    }

//perform calculations and determine its status
    public function calculateBudget(float|int $budget, float|int $expenses): array
    {
        $difference = $budget - $expenses;

        if ($difference > 0) {
            $status = "Underspent by {$difference}";
        } elseif ($difference < 0) {
            $status = "Overspent by " . abs($difference);
        } else {
            $status = "You spent exactly your budget.";
        }

        return [
            'budget' => $budget,
            'expenses' => $expenses,
            'difference' => $difference,
            'status' => $status
        ];
    }


//create budget

    public function createBudget($userId, $categoryId, $budget_name, $amountLimit, $type, $startDate, $endDate) {
        
        $sql = "INSERT INTO budgets (user_id, category_id, budget_name,  amount_limit, period_type, start_date, end_date) 
                VALUES (?,?,?,?,?,?,?)"; 
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $userId,
            $categoryId,
            $budget_name,
            $amountLimit,
            $type,
            $startDate,
            $endDate
        ]);
      
        return true; 
    }


    
}
