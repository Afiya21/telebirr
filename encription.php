<?php
$publicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgIwN9mVEWG9kagbxt2ippr8RNzK/fhBXcZa1ViQRnClz3VTjk9cnomIds3AFhsiNihNTPVSirbeCOKxr99mvJuuGdarzfkNEIbOkSLFfO7P6HdQHQjaTg9LueWUy1tz1gh0dsNpg4zPVr+T9lTCTWOnDgU2hNixo0r9wo72dxwXTc55vX4X7sWSz29WzrlKyyBQ2+CcA55EYp6cWwpkaTSfV+Boymr/ZnLI7qlp/7FGZk2574fvE/9uCZdnAHYCTzKOFUjEwZ9o8sw/f+TVglbKvRDSMpqsZXN6DY7FvXMp52ACM7OAp63y8Hir2YKAWj6OJ8KVoS8TAUeDmHyaWwwIDAQAB';

$ussd = encryptRSA($ussdjson, $publicKey);


function encryptRSA($data, $public)
{
    $pubPem = chunk_split($public, 64, "\n");
    $pubPem = "-----BEGIN PUBLIC KEY-----\n" . $pubPem . "-----END PUBLIC KEY-----\n";
    $public_key = openssl_pkey_get_public($pubPem);
    if (!$public_key) {
        die('invalid public key');
    }
    $crypto = '';
    foreach (str_split($data, 117) as $chunk) {
        $return = openssl_public_encrypt($chunk, $cryptoItem, $public_key);
        if (!$return) {
            return ('fail');
        }
        $crypto .= $cryptoItem;
    }
    $ussd = base64_encode($crypto);
    return $ussd;
}
