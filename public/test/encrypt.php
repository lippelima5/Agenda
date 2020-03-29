<?php

$string_to_encrypt = "Test";
$password = "123";
$encrypted_string = openssl_encrypt($string_to_encrypt, "AES-128-ECB", $password);
$decrypted_string = openssl_decrypt($encrypted_string, "AES-128-ECB", $password);

echo ($password);
echo ($encrypted_string);
echo ($decrypted_string);
