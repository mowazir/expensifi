<?php declare(strict_types=1);

require_once 'Db.php';

class Expense extends Db
{
	
	public $conn;

	public function __construct()
	{
		$this->conn = $this->connect();
	}

     public function search($userId, $startDate, $endDate) 
     {
        $sql = "SELECT * FROM transactions
                WHERE user_id = :user_id
                AND date_incurred BETWEEN :start AND :end";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':start' => $startDate,
            ':end' => $endDate
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // returns an array of rows
    }

    //get a count of total no of records
     public function getTotalRecords( $date_incurred = false)
    {
        $condition = $date_incurred ? ' WHERE date_incurred IS NOT NULL'  : '';

        $sql =  "SELECT COUNT(*) FROM transactions$condition" ;

         $stmt = $this->conn->prepare($sql);


        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_COLUMN);

    }


   public function searchnulll($userId, $keyword = '', $startDate = '', $endDate = '') 
   {
    
    $params = [];
    $sql = "SELECT * FROM transactions t 
            WHERE t.user_id = ? 
            AND t.transaction_type = 'expense' ";

    $params[] = $userId; 

    if (!empty(trim($keyword))) {
        $sql .= " AND t.memo LIKE ?";
        $params[] = '%' . trim($keyword) . '%'; 
    }

    if (!empty(trim($startDate))) {
        $sql .= " AND t.date_incurred >= ?";
        $params[] = trim($startDate);
    }

    if (!empty(trim($endDate))) {
        $sql .= " AND t.date_incurred <= ?";
        $params[] = trim($endDate);
    }

    $sql .= " ORDER BY t.date_incurred DESC";

    $stmt = $this->conn->prepare($sql);

       $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

    public function deleteCategory($userid, $tid)
    {
        try {

            $sql = "DELETE FROM transactions WHERE user_id = ? AND transaction_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$userid, $tid]);

            return true;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;   
        }
    }

       public function getTransactions($limit, $offset)
    {
        $sql = "SELECT * FROM transactions
        ORDER BY date_incurred desc
                    LIMIT :limit
                    OFFSET :offset";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $transactions;

    }

    // public function getTransactions2()
    // {
    //     $sql = "SELECT * FROM transactions";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute();

    //     $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     return $transactions;

    // }

//get total expense with user selected date for budget
    public function getTotal(int $userId, string $startDate, string $endDate): float|int|string
    {
        $sql = "
            SELECT COALESCE(SUM(amount), 0)
            FROM transactions
            WHERE user_id = :uid
              AND transaction_type = 'expense'
              AND date_incurred BETWEEN :start_date AND :end_date
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':uid' => $userId,
            ':start_date' => $startDate,
            ':end_date' => $endDate
        ]);

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    //total expenses
    public function totalExpenses(int $user_id)
    {
          $sql =  "SELECT SUM(amount)
             FROM transactions 
             WHERE user_id = ?";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user_id]);

            return $stmt->fetch(PDO::FETCH_COLUMN);
    }

	    // Handles insertion for Income, Expense, and Transfer
    public function addTransaction(array $data) {
        $userId = $data['userId'];
        $type = $data['type'];
        $amount = $data['amount'];
        $account_id = $data['account_id'];
        $destination_account_id = $data['destination_account_id'];
        $category_id = $data['category_id']; 
        $date_incurred = $data['date_incurred'] ;
        $memo = $data['memo'] ;

         if (!in_array($type, ['expense', 'income', 'transfer'])) {
             echo ("Invalid transaction type.");
         }

        try {   
            if ($type === 'transfer') {
                $sql = "INSERT INTO transactions 
                        (user_id, account_id, category_id, transaction_type, amount, date_incurred, memo) 
                        VALUES (:uid, :aid, :cid,:type, :amt, :date, :memo)";
                $stmt = $this->conn->prepare($sql);

                $stmt->execute([
                    ':uid' => $userId, 
                    ':aid' => $account_id,
                    'cid' => $category_id,
                     
                    ':type' => 'transfer', 
                    ':amt' => $amount, 
                    ':date' => $date_incurred, 
                    
                    ':memo' => "Transfer Out to " . ($memo !== null) ? $memo : "Destination"
                ]);

                $stmt->execute([
                    ':uid' => $userId, 
                     ':aid' => $destination_account_id,
                    'cid' => $category_id,
                    
                    ':type' => 'transfer', 
                    ':amt' => $amount, 
                    ':date' => $date_incurred, 
                    
                     ':memo' => "Transfer In from " . ($memo !== null) ? $memo : "Source"
                ]);

            } else {
                $sql = "INSERT INTO transactions 
                        (user_id, account_id, category_id, transaction_type, amount, date_incurred, memo) 
                        VALUES (
                        :uid,:aid, :cid, :type, :amt, :date, :memo
                        )";
                $stmt = $this->conn->prepare($sql);
                
                $stmt->bindValue(':uid', $userId);
                $stmt->bindValue(':aid', $account_id, PDO::PARAM_INT);
                 #$stmt->bindValue(':cid', $category_id, $category_id ? PDO::PARAM_INT : PDO::PARAM_NULL); this stores null
                 $stmt->bindValue(':cid', $category_id, is_null($category_id) ? PDO::PARAM_NULL : PDO::PARAM_INT);
                $stmt->bindValue(':type', $type);
                $stmt->bindValue(':amt', $amount);
                $stmt->bindValue(':date', $date_incurred);
                $stmt->bindValue(':memo', $memo);
                
                $stmt->execute();
            }
            
            return true;

        } catch (PDOException $e) {
           #echo $e->getMessage(); die();
           return false;
        }
    }

}


