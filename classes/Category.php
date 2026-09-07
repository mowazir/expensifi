<?php

require_once 'Db.php';


class Category extends Db
{
	
	public $conn;

	function __construct()
	{
		$this->conn = $this->connect();
	}

	public function fetchAccounts($userId) {
        $stmt = $this->conn->prepare("SELECT account_id, account_name FROM accounts WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }


	public function getCategories()
	{
		$sql = "SELECT * FROM categories ORDER BY category_name	 ";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();

		$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $records;

	}

	 // Add a new category
    public function addCategory($userId, $name, $type) {
        $stmt = $this->conn->prepare("INSERT INTO categories (user_id, category_name, category_type) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $name, $type]);
    }

	public function fetchCategoryId($user_id)
    {
        #sql
        $sql = "SELECT category_id, user_id, category_name, category_type FROM categories WHERE category_id = ?";
        #prepare
        $stmt = $this->conn->prepare($sql);
        #execute
        $stmt->execute([$user_id]);
        #fetch all data
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categories;

    }

    	// Used by AJAX (fetch_categories.php) to dynamically load options
     public function fetchCategoriesByType($userId, $type) {
       
        $stmt = $this->conn->prepare("
            SELECT category_id, category_name 
            FROM categories 
            WHERE user_id = :uid AND category_type = :type
            ORDER BY category_name
        ");
        $stmt->execute([':uid' => $userId, ':type' => $type]);
        return $stmt->fetchAll();
    }


	public function check_category_status($id)
	{
		
		$sql = "SELECT category_id FROM categories WHERE category_id = ? ";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute([$id]);

		$status = $stmt->fetch(PDO::FETCH_COLUMN);
		return $status ;

	}




}

