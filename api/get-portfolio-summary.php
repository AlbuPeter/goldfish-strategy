<?php
$conn = new mysqli("localhost", "root", "", "goldfish-strategy");
if ($conn->connect_error) {
    die(json_encode(["error" => "Adatbázis hiba"]));
}

$cacheFile = __DIR__ . '/price_cache.json';
if (!file_exists($cacheFile)) {
    echo json_encode(["error" => "Nem található ár cache"]);
    exit;
}
$prices = json_decode(file_get_contents($cacheFile), true);

// Coin mapping
$coinMap = [
    'btc' => 'bitcoin',
    'eth' => 'ethereum',
    'sol' => 'solana',
    'sui' => 'sui',
    'usdc' => 'usd-coin'
];

$currentValue = 0;

// 1. Coin aktuális érték számítása
$res = $conn->query("SELECT coin, amount FROM portfolio WHERE amount > 0");
while ($row = $res->fetch_assoc()) {
    $short = strtolower($row['coin']);
    if (!isset($coinMap[$short])) continue;

    $price = $prices[$coinMap[$short]]['usd'] ?? null;
    if (!$price) continue;

    $value = $row['amount'] * $price;
    $currentValue += $value;
}

// 2. Manuálisan hozzáadott USDC lekérdezése
$usdcQuery = $conn->query("SELECT SUM(amount) AS added FROM transactions WHERE coin = 'USDC' AND type = 'usdc_add'");
$usdcAdded = (float)($usdcQuery->fetch_assoc()['added'] ?? 0);


// 3. Profit és százalék
$profit = $currentValue - $usdcAdded;
$profitPercent = $usdcAdded > 0 ? round(($profit / $usdcAdded) * 100, 2) : 0;

echo json_encode([
    "current_value" => round($currentValue, 2),
    "invested" => round($usdcAdded, 2),
    "profit" => round($profit, 2),
    "profit_percent" => $profitPercent
]);
