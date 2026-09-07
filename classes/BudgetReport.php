<?php declare(strict_types=1);

require_once 'Db.php';

class BudgetReport extends Db
{
    private $conn;
    public float $budget;
    public float $expenses;
    public float $difference;
    public string $message;

    public function __construct(float $budget, float $expenses)
    {   
        $this->conn = $this->connect();
        $this->budget = $budget;
        $this->expenses = $expenses;
        $this->calculate();
    }

    private function calculate(): void
    {
        $this->difference = $this->budget - $this->expenses;

        if ($this->difference > 0) {
            $this->message = "✅ Underspent by ₦" . number_format($this->difference, 2);
        } elseif ($this->difference < 0) {
            $this->message = "⚠️ Overspent by ₦" . number_format(abs($this->difference), 2);
        } else {
            $this->message = "💰 You spent exactly your budget!";
        }
    }
}
