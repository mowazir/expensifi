<?php

require_once 'Db.php';


class Category extends Db
{
	
	public $conn;

	function __construct()
	{
		$this->conn = $this->connect();
	}

	public function fetchAccounts() {
        $stmt = $this->conn->prepare("SELECT account_name FROM accounts");
        $stmt->execute();
        return $stmt->fetchAll();
    }


	public function getCategories()
	{
		$sql = "SELECT * FROM categories ORDER BY category_name";
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
//
     public function getCategoryById( $categoryId) {
        $sql = "SELECT category_id, category_name, category_type FROM categories WHERE category_id = :cid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':cid' => $categoryId]);
        $category = $stmt->fetch();
        return $category ;
    }


     public function updateCategory(int $categoryId, string $name, string $type): bool {
        $sql = "UPDATE categories SET category_name = :name, category_type = :type WHERE category_id = :cid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':type' => $type,
            ':cid' => $categoryId
        ]);
        
        return true; 
    }

    public function deleteCategory(int $categoryId): bool {

        $sql = "DELETE FROM categories WHERE category_id = :cid";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':cid' => $categoryId]);
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



