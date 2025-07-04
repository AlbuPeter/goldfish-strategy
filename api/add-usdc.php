<?php
require_once "db.php";

$amount = floatval($_POST['amount']);
if ($amount > 0) {
    $conn->query("UPDATE portfolio SET amount = amount + $amount WHERE coin = 'USDC'");
    $conn->query("INSERT INTO transactions (coin, amount, price, type) VALUES ('usdc', $amount, 1.0, 'usdc_add')");
}
echo "success";
