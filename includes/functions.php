<?php
// includes/functions.php
// AES encryption helper using OpenSSL
// Output format: base64_encode( IV || ciphertext )

function deriveKey($key, $method) {
    // derive binary key of needed length from arbitrary password
    // method e.g. 'AES-128-CBC' -> 16 bytes, 'AES-256-CBC' -> 32 bytes
    $needed = 16;
    if (stripos($method, '256') !== false) $needed = 32;
    // use SHA-256 then take needed bytes
    $hash = hash('sha256', $key, true);
    return substr($hash, 0, $needed);
}

function encryptAES($plaintext, $key, $method = 'AES-128-CBC') {
    $ivlen = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $rawKey = deriveKey($key, $method);
    $ciphertext_raw = openssl_encrypt($plaintext, $method, $rawKey, OPENSSL_RAW_DATA, $iv);
    if ($ciphertext_raw === false) return '';
    // prepend IV so decrypt can extract it; then base64 encode for safe transport
    return base64_encode($iv . $ciphertext_raw);
}

function decryptAES($b64data, $key, $method = 'AES-128-CBC') {
    $data = base64_decode($b64data, true);
    if ($data === false) return '';
    $ivlen = openssl_cipher_iv_length($method);
    if (strlen($data) < $ivlen) return '';
    $iv = substr($data, 0, $ivlen);
    $ciphertext = substr($data, $ivlen);
    $rawKey = deriveKey($key, $method);
    $plaintext = openssl_decrypt($ciphertext, $method, $rawKey, OPENSSL_RAW_DATA, $iv);
    if ($plaintext === false) return '';
    return $plaintext;
}
?>