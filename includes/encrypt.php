<?php
function encrypt_this($data) {
    $key = 's^b)46fbr7@#2t4r2#*%@!*@B$*TcVQ$fr@b5*b5y*^vhur@%@V68(&Y#hcerbu$ew';
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}
function decrypt_this($data) {
    $key = 's^b)46fbr7@#2t4r2#*%@!*@B$*TcVQ$fr@b5*b5y*^vhur@%@V68(&Y#hcerbu$ew';
    $encryption_key = base64_decode($key);
    list($encrypted_data,$iv) = array_pad(explode('::', base64_decode($data),2),2,null);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}
?>