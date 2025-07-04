<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "goldfish-strategy");
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// 1. Lekérjük a történeti adatokat
$result = $conn->query("SELECT id, recorded_at, total_value, invested FROM portfolio_history ORDER BY recorded_at ASC");
$data = [];
while ($row = $result->fetch_assoc()) {
    $row['total_value'] = (float)$row['total_value'];
    $row['invested'] = isset($row['invested']) ? (float)$row['invested'] : null;
    $data[] = $row;
}

// 2. Lekérjük a portfólió coinokat
$portfolioRes = $conn->query("SELECT coin, amount FROM portfolio");
$coins = [];

while ($row = $portfolioRes->fetch_assoc()) {
    $coin = strtolower($row['coin']);
    $coins[$coin] = (float)$row['amount'];
}

// 3. Lekérjük a manuálisan hozzáadott USDC-t (csak usdc_add típus)
$usdcAddResult = $conn->query("SELECT SUM(amount) AS added_usdc FROM transactions WHERE coin = 'usdc' AND type = 'usdc_add'");
$usdcAmount = (float)($usdcAddResult->fetch_assoc()['added_usdc'] ?? 0);
$totalInvested = round($usdcAmount, 2);

// 4. CoinGecko ID mapping
$coinGeckoIds = [
    'btc' => 'bitcoin',
    'bitcoin' => 'bitcoin',
    'eth' => 'ethereum',
    'ethereum' => 'ethereum',
    'sol' => 'solana',
    'solana' => 'solana',
    'sui' => 'sui',
    'usdc' => 'usd-coin',
    'usd-coin' => 'usd-coin'
];

// 5. Lekérjük az árakat
$response = file_get_contents("http://localhost/goldfish-strategy/api/get-prices.php");
if ($response === FALSE) {
    error_log("❌ Nem sikerült lekérni az árfolyamokat.");
    die(json_encode(['error' => 'Nem sikerült lekérni az árfolyamokat.']));
}
$prices = json_decode($response, true);
file_put_contents("debug_prices.json", json_encode($prices, JSON_PRETTY_PRINT));

// 6. Kiszámoljuk az aktuális értéket
$total = 0;
foreach ($coins as $coin => $amount) {
    $cgId = $coinGeckoIds[$coin] ?? null;
    if (!$cgId || !isset($prices[$cgId]['usd'])) {
        error_log("⚠️ Ár hiányzik vagy ismeretlen coin: $coin ($cgId)");
        continue;
    }
    $price = (float)$prices[$cgId]['usd'];
    $total += $amount * $price;
}
$total = round($total, 2);

// 7. Ha túl alacsony, nem írunk be új értéket
if ($total < 1) {
    error_log("❌ Összérték túl alacsony vagy 0: $total");

    header('Content-Type: application/json');
    echo json_encode([]);
    exit;
}

// 8. Új rekord mentése, ha változott
$lastRecorded = end($data);
if (!$lastRecorded || abs($lastRecorded['total_value'] - $total) > 0.01) {
    $stmt = $conn->prepare("INSERT INTO portfolio_history (recorded_at, total_value, invested) VALUES (?, ?, ?)");
    $now = date('Y-m-d H:i:s');
    $stmt->bind_param("sdd", $now, $total, $totalInvested);
    $stmt->execute();

    $data[] = [
        'recorded_at' => $now,
        'total_value' => $total,
        'invested' => $totalInvested
    ];
}

// 9. Hiányzó `invested` mezők frissítése, ha valahol null lenne
foreach ($data as &$row) {
    if (!isset($row['invested']) || $row['invested'] < 1) {
        $row['invested'] = $totalInvested;
    }
}

// 10. JSON visszaadás
header('Content-Type: application/json');
echo json_encode($data);
