<?php
function encrypt($plaintext, $decrypt_password){
    $salt = openssl_random_pseudo_bytes(16);
    $iv = openssl_random_pseudo_bytes(12);
    $key = hash_pbkdf2("sha256", $decrypt_password, $salt, 100000, 32, true);
    $tag = "";
    $ciphertext = openssl_encrypt($plaintext, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $tag);
    return base64_encode($salt . $iv . $tag . $ciphertext);
}

function decrypt($data, $decrypt_password){
    if(!is_string($data) || $data == ""){
        return false;
    }
    $raw = base64_decode($data, true);
    if($raw === false || strlen($raw) < 44){
        return false;
    }
    $salt = substr($raw, 0, 16);
    $iv = substr($raw, 16, 12);
    $tag = substr($raw, 28, 16);
    $ciphertext = substr($raw, 44);
    $key = hash_pbkdf2("sha256", $decrypt_password, $salt, 100000, 32, true);
    return openssl_decrypt($ciphertext, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $tag);
}

function make_link($getties, $decrypt_password){
    return "index.php?" . urlencode(encrypt($getties, $decrypt_password));
}

function make_uuid(){
    $bytes = random_bytes(16);
    $bytes[6] = chr((ord($bytes[6]) & 0x0f) | 0x40);
    $bytes[8] = chr((ord($bytes[8]) & 0x3f) | 0x80);
    $hex = bin2hex($bytes);
    return substr($hex, 0, 8) . "-" . substr($hex, 8, 4) . "-" . substr($hex, 12, 4) . "-" . substr($hex, 16, 4) . "-" . substr($hex, 20, 12);
}
?>
