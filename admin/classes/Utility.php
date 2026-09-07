<?php

class Utility
{

	public static function generateReference()
	{
		return uniqid('cc') ; //payment ref should not have chars like slash etc

	}

	public static function is_email($email)
	{
		$rsp = filter_var($email, FILTER_VALIDATE_EMAIL);

		if ($rsp === false) {
			return false;
		} else{
			return true;
		}

	}

	public static function sanitize( $evil_string)
	{

		$safe_string = strip_tags($evil_string);
		$safe_string = htmlentities($safe_string);
		return $safe_string;
	}


}

/**
 * Promo system for admins and users.
 *
 * Database tables expected:
 * CREATE TABLE promos (
 *   id INT PRIMARY KEY AUTO_INCREMENT,
 *   name VARCHAR(100) NOT NULL,
 *   description TEXT,
 *   discount_value DECIMAL(10,2) NOT NULL,
 *   discount_type ENUM('percentage','fixed') DEFAULT 'percentage',
 *   start_date DATETIME NOT NULL,
 *   end_date DATETIME NOT NULL,
 *   max_claims INT NOT NULL DEFAULT 0,
 *   created_at DATETIME DEFAULT CURRENT_TIMESTAMP
 * );
 *
 * CREATE TABLE promo_claims (
 *   id INT PRIMARY KEY AUTO_INCREMENT,
 *   promo_id INT NOT NULL,
 *   user_id INT NOT NULL,
 *   claimed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 *   UNIQUE KEY unique_user_promo (promo_id, user_id)
 * );
 */
class PromoManager
{
	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	public function createPromo($name, $description, $discountValue, $discountType, $startDate, $endDate, $maxClaims)
	{
		$name = trim((string) $name);
		$description = trim((string) $description);
		$discountValue = (float) $discountValue;
		$discountType = strtolower((string) $discountType);
		$startDate = $this->normalizeDate($startDate);
		$endDate = $this->normalizeDate($endDate);
		$maxClaims = (int) $maxClaims;

		if ($name === '') {
			throw new InvalidArgumentException('Promo name is required.');
		}
		if (!in_array($discountType, ['percentage', 'fixed'], true)) {
			throw new InvalidArgumentException('Discount type must be percentage or fixed.');
		}
		if ($discountValue <= 0) {
			throw new InvalidArgumentException('Discount value must be greater than zero.');
		}
		if ($endDate <= $startDate) {
			throw new InvalidArgumentException('End date must be greater than start date.');
		}
		if ($maxClaims <= 0) {
			throw new InvalidArgumentException('Maximum claims must be greater than zero.');
		}

		$stmt = $this->pdo->prepare(
			'INSERT INTO promos (name, description, discount_value, discount_type, start_date, end_date, max_claims) VALUES (:name, :description, :discount_value, :discount_type, :start_date, :end_date, :max_claims)'
		);

		$stmt->execute([
			':name' => $name,
			':description' => $description,
			':discount_value' => $discountValue,
			':discount_type' => $discountType,
			':start_date' => $startDate,
			':end_date' => $endDate,
			':max_claims' => $maxClaims,
		]);

		return (int) $this->pdo->lastInsertId();
	}

	public function getPromo($promoId)
	{
		$stmt = $this->pdo->prepare('SELECT * FROM promos WHERE id = :id LIMIT 1');
		$stmt->execute([':id' => (int) $promoId]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function getPromoForUser($promoId, $userId, $userCreatedAt = null)
	{
		$promo = $this->getPromo($promoId);
		if (!$promo) {
			return ['eligible' => false, 'message' => 'Promo not found.'];
		}

		if (!$this->isPromoActive($promo)) {
			return ['eligible' => false, 'message' => 'Promo is not currently active.'];
		}

		if (!$this->hasUserBeenActiveForSevenDays($userId, $userCreatedAt)) {
			return ['eligible' => false, 'message' => 'User must be active for at least 7 days to claim this promo.'];
		}

		if ($this->hasUserClaimedPromo($promoId, $userId)) {
			return ['eligible' => false, 'message' => 'This promo can only be claimed once per user.'];
		}

		if ($this->getPromoClaimCount($promoId) >= (int) $promo['max_claims']) {
			return ['eligible' => false, 'message' => 'This promo has reached its maximum number of claims.'];
		}

		return [
			'eligible' => true,
			'promo' => $promo,
			'message' => 'User is eligible to claim the promo.'
		];
	}

	public function claimPromo($promoId, $userId, $userCreatedAt = null)
	{
		$promo = $this->getPromo($promoId);
		if (!$promo) {
			return ['success' => false, 'message' => 'Promo not found.'];
		}

		$eligibility = $this->getPromoForUser($promoId, $userId, $userCreatedAt);
		if (!$eligibility['eligible']) {
			return ['success' => false, 'message' => $eligibility['message']];
		}

		$this->pdo->beginTransaction();
		try {
			$stmt = $this->pdo->prepare(
				'INSERT INTO promo_claims (promo_id, user_id, claimed_at) VALUES (:promo_id, :user_id, NOW())'
			);
			$stmt->execute([
				':promo_id' => (int) $promoId,
				':user_id' => (int) $userId,
			]);

			$this->pdo->commit();
			return [
				'success' => true,
				'message' => 'Promo claimed successfully.',
				'claimed_at' => date('Y-m-d H:i:s')
			];
		} catch (Exception $e) {
			$this->pdo->rollBack();
			return ['success' => false, 'message' => 'Failed to claim promo: ' . $e->getMessage()];
		}
	}

	public function hasUserClaimedPromo($promoId, $userId)
	{
		$stmt = $this->pdo->prepare('SELECT 1 FROM promo_claims WHERE promo_id = :promo_id AND user_id = :user_id LIMIT 1');
		$stmt->execute([
			':promo_id' => (int) $promoId,
			':user_id' => (int) $userId,
		]);
		return (bool) $stmt->fetchColumn();
	}

	public function getPromoClaimCount($promoId)
	{
		$stmt = $this->pdo->prepare('SELECT COUNT(*) FROM promo_claims WHERE promo_id = :promo_id');
		$stmt->execute([':promo_id' => (int) $promoId]);
		return (int) $stmt->fetchColumn();
	}

	public function listPromoClaims($promoId)
	{
		$stmt = $this->pdo->prepare(
			'SELECT pc.id, pc.promo_id, pc.user_id, pc.claimed_at, u.name AS user_name, u.email AS user_email FROM promo_claims pc LEFT JOIN users u ON u.id = pc.user_id WHERE pc.promo_id = :promo_id ORDER BY pc.claimed_at DESC'
		);
		$stmt->execute([':promo_id' => (int) $promoId]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function hasUserBeenActiveForSevenDays($userId, $userCreatedAt = null)
	{
		if ($userCreatedAt === null) {
			return false;
		}

		$date = new DateTime($userCreatedAt);
		$now = new DateTime();
		$diff = $now->diff($date);
		$daysActive = (int) (($diff->format('%r') === '-' ? -1 : 1) * (($diff->days * 24 * 60 * 60) + ($diff->h * 60 * 60) + ($diff->i * 60) + $diff->s));

		return $daysActive >= 7 * 24 * 60 * 60;
	}

	public function isPromoActive($promo)
	{
		if (!$promo) {
			return false;
		}

		$now = new DateTime();
		$start = new DateTime($promo['start_date']);
		$end = new DateTime($promo['end_date']);

		return $now >= $start && $now <= $end;
	}

	private function normalizeDate($date)
	{
		$dateTime = new DateTime($date);
		return $dateTime->format('Y-m-d H:i:s');
	}
}

class PromoManagerDemo
{
	public static function renderPage($promoManager)
	{
		$promoId = 1;
		$userId = 42;
		$userCreatedAt = date('Y-m-d H:i:s', strtotime('-10 days'));
		$promo = $promoManager->getPromo($promoId);
		$eligibility = $promo ? $promoManager->getPromoForUser($promoId, $userId, $userCreatedAt) : ['eligible' => false, 'message' => 'Promo not found.'];
		$claimResult = $promo && $eligibility['eligible'] ? $promoManager->claimPromo($promoId, $userId, $userCreatedAt) : ['success' => false, 'message' => $eligibility['message']];

		echo '<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Promo Demo</title>
			<style>
				body { font-family: Arial, sans-serif; background: #f5f7fb; margin: 0; padding: 40px; color: #1f2937; }
				.container { max-width: 900px; margin: 0 auto; }
				.card { background: #fff; border-radius: 14px; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08); padding: 28px; }
				.header { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 24px; }
				.badge { display: inline-block; background: #e0f2fe; color: #075985; border-radius: 999px; padding: 8px 12px; font-size: 12px; font-weight: bold; }
				h1 { margin: 0; font-size: 2rem; }
				.grid { display: grid; grid-template-columns: 1.3fr 0.7fr; gap: 24px; }
				.info-box, .stat-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; }
				.info-box h3, .stat-box h3 { margin-top: 0; }
				.meta { margin: 12px 0; color: #475569; line-height: 1.6; }
				ul { padding-left: 18px; margin: 10px 0 0; }
				button { border: none; border-radius: 10px; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; padding: 12px 20px; font-weight: 600; cursor: pointer; }
				button:hover { opacity: 0.95; }
				.status { padding: 12px 14px; border-radius: 10px; margin-top: 16px; font-weight: 600; }
				.status.success { background: #dcfce7; color: #166534; }
				.status.error { background: #fee2e2; color: #991b1b; }
				.status.info { background: #e0f2fe; color: #0c4a6e; }
				.muted { color: #64748b; }
				@media (max-width: 700px) { .grid { grid-template-columns: 1fr; } .header { display: block; } }
			</style>
		</head>
		<body>
			<div class="container">
				<div class="card">
					<div class="header">
						<div>
							<span class="badge">Promo Manager</span>
							<h1>Welcome Bonus</h1>
						</div>
						<button type="button">Claim Promo</button>
					</div>

					<div class="grid">
						<div class="info-box">
							<h3>Offer details</h3>
							<div class="meta">
								<strong>Discount:</strong> 10% off<br>
								<strong>Period:</strong> ' . htmlspecialchars($promo['start_date'] ?? '2026-01-01 00:00:00') . ' to ' . htmlspecialchars($promo['end_date'] ?? '2026-12-31 23:59:59') . '<br>
								<strong>Required account age:</strong> 7 days minimum
							</div>
							<ul>
								<li>One claim per user</li>
								<li>Limited to a total of ' . (int) ($promo['max_claims'] ?? 500) . ' claims</li>
								<li>Eligible only while the promo is active</li>
							</ul>
						</div>

						<div class="stat-box">
							<h3>Eligibility</h3>
							<p class="muted">User #'. (int) $userId .'</p>
							<p><strong>Status:</strong> ' . ($eligibility['eligible'] ? 'Eligible' : 'Not eligible') . '</p>
							<p><strong>Claims used:</strong> ' . $promoManager->getPromoClaimCount($promoId) . '</p>
							<p><strong>Account age:</strong> ' . htmlspecialchars($userCreatedAt) . '</p>
						</div>
					</div>

					<div class="status ' . ($claimResult['success'] ? 'success' : ($eligibility['eligible'] ? 'info' : 'error')) . '">
						' . htmlspecialchars($claimResult['message'] ?? $eligibility['message']) . '
					</div>
				</div>
			</div>
		</body>
		</html>';
	}
}

// Example usage:
// $pdo = new PDO('mysql:host=localhost;dbname=expensify', 'root', '');
// $promoManager = new PromoManager($pdo);
// $promoId = $promoManager->createPromo('Welcome Bonus', 'Get a discount after 7 days', 10, 'percentage', '2026-01-01', '2026-12-31', 500);
// $result = $promoManager->claimPromo($promoId, 42, '2026-01-01 12:00:00');
// $claims = $promoManager->listPromoClaims($promoId);
// PromoManagerDemo::renderPage($promoManager);
