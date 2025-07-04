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
$coinInvested = 0; // csak coin vásárlás
$usdcAdded = 0;

// 1. Coin vásárlások (kivéve USDC)
$res = $conn->query("SELECT coin, amount, avg_price FROM portfolio WHERE amount > 0");
while ($row = $res->fetch_assoc()) {
    $short = strtolower($row['coin']);
    if (!isset($coinMap[$short])) continue;

    $price = $prices[$coinMap[$short]]['usd'] ?? null;
    if (!$price) continue;

    $value = $row['amount'] * $price;
    $currentValue += $value;

    // Coin vásárlás befektetési érték számítása (USDC kivételével)
    if ($short !== 'usdc') {
        $coinInvested += $row['amount'] * $row['avg_price'];
    }
}

// 2. Manuálisan hozzáadott USDC lekérdezése
$usdcQuery = $conn->query("SELECT SUM(amount) AS added FROM transactions WHERE coin = 'USDC' AND type = 'usdc_add'");
$usdcAdded = (float)($usdcQuery->fetch_assoc()['added'] ?? 0);

// 3. Összes befektetett összeg
$totalInvested = $coinInvested + $usdcAdded;

$profit = $currentValue - $totalInvested;
$profitPercent = $totalInvested > 0 ? round(($profit / $totalInvested) * 100, 2) : 0;

echo json_encode([
    "current_value" => round($currentValue, 2),
    "invested" => round($totalInvested, 2),
    "profit" => round($profit, 2),
    "profit_percent" => $profitPercent
]);
