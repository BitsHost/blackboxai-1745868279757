<?php
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Password: $password\n";
echo "Generated hash: $hash\n";
echo "Verification test: " . (password_verify($password, $hash) ? "Success" : "Failed") . "\n";
echo "Hash format check: " . (preg_match('/^\$2[ayb]\$.{56}$/', $hash) ? "Valid format" : "Invalid format") . "\n";
