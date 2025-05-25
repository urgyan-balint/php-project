<?php
function decode_password($filename) {
    $key = [5, -14, 31, -9, 3];
    $lines = file($filename, FILE_IGNORE_NEW_LINES);
    $users = [];
    
    foreach ($lines as $line) {
        $decoded = '';
        $keyIndex = 0;
        
        for ($i = 0; $i < strlen($line); $i++) {
            $charCode = ord($line[$i]);
            $offset = $key[$keyIndex % count($key)];
            $decodedChar = $charCode - $offset;
            
            // Overflow/underflow kezelése
            $decodedChar += ($decodedChar < 0) ? 256 : 0;
            $decodedChar %= 256;
            
            $decoded .= chr($decodedChar);
            $keyIndex++;
        }
        
        list($username, $password) = explode('*', $decoded);
        $users[$username] = $password;
    }
    return $users;
}

// Dekódolt jelszavak kiírása
echo "<pre>";
print_r(decode_password('password.txt'));
echo "</pre>";
?>