<?php
function encrypt($plaintext, $decrypt_password){
    $salt = openssl_random_pseudo_bytes(16);
    $iv = openssl_random_pseudo_bytes(12);
    $key = hash_pbkdf2("sha256", $password, $salt, 100000, 32, true);
    $tag = "";
    $ciphertext = openssl_encrypt($plaintext, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $tag);
    return base64_encode($salt . $iv . $tag . $ciphertext);
}

function decrypt($data, $decrypt_password){
    $raw = base64_decode($data);
    $salt = substr($raw, 0, 16);
    $iv = substr($raw, 16, 12);
    $tag = substr($raw, 28, 16);
    $ciphertext = substr($raw, 44);
    $key = hash_pbkdf2("sha256", $password, $salt, 100000, 32, true);
    return openssl_decrypt($ciphertext, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $tag);
}
?>