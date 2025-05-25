<?php
// index.php
?>
<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <title>Bejelentkezés</title>
  <style>
    form { max-width: 400px; margin: 2em auto; padding:1em; border:1px solid #ccc; border-radius:8px; }
    input { width: 100%; padding:0.5em; margin:0.5em 0; }
    button { padding:0.5em 1em; }
  </style>
</head>
<body>
  <h2>Bejelentkezés</h2>
  <form action="ellenorzes.php" method="post">
    <label for="username">Felhasználónév (e-mail):</label><br>
    <input type="email" name="username" id="username" required><br>

    <label for="password">Jelszó:</label><br>
    <input type="password" name="password" id="password" required><br>

    <button type="submit">Bejelentkezés</button>
  </form>

  <p>Név: <strong>[Ide írd a neved]</strong></p>
  <p>Neptun kód: <strong>[NEPTUN]</strong></p>
</body>
</html>