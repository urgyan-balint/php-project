<?php
// 1. POST-adatok
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// 2. Dekódoló függvény
function decodeLine($encodedLine) {
    $key = [5, -14, 31, -9, 3];
    $decoded = '';
    $keyIndex = 0;
    // sor végén lehet \r vagy \n, ezért trimeljük
    $line = rtrim($encodedLine, "\r\n");
    for ($i = 0, $len = strlen($line); $i < $len; $i++) {
        $decoded .= chr(ord($line[$i]) - $key[$keyIndex]);
        $keyIndex = ($keyIndex + 1) % count($key);
    }
    return $decoded;
}

// 3. Fájl beolvasása és dekódolása
$lines = file(__DIR__ . '/password.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$creds = [];
foreach ($lines as $encodedLine) {
    // Először dekódoljuk a teljes sort:
    $decodedLine = decodeLine($encodedLine);
    // Most szétvágjuk a felhasználónévre és jelszóra:
    if (strpos($decodedLine, '*') !== false) {
        list($u, $p) = explode('*', $decodedLine, 2);
        $creds[$u] = $p;
    }
}

// 4. Felhasználó ellenőrzése
if (!isset($creds[$username])) {
    exit('Nincs ilyen felhasználó.');
}

// 5. Jelszó ellenőrzése
if ($creds[$username] !== $password) {
    echo 'Hibás jelszó. Átirányítás...';
    header('Refresh:3; url=https://www.police.hu');
    exit;
}

// 6. Adatbázis lekérdezés
$mysqli = new mysqli('localhost', 'root', '', 'adatok');
if ($mysqli->connect_error) {
    die('Adatbázis hiba: ' . $mysqli->connect_error);
}
$stmt = $mysqli->prepare('SELECT Titkos FROM tabla WHERE Username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($color);
if (!$stmt->fetch()) {
    die('Adatbázisban nem található a felhasználó.');
}
$stmt->close();
$mysqli->close();

// 7. Megjelenítés
?>
<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <title>Üdvözlet</title>
  <style>
    body { background-color: <?= htmlspecialchars($color) ?>; color: #fff; text-align:center; padding-top:3em; }
  </style>
</head>
<body>
  <h1>Sikeres belépés, <?= htmlspecialchars($username) ?>!</h1>
  <p>A kedvenc színed: <strong><?= htmlspecialchars($color) ?></strong></p>
</body>
</html>
