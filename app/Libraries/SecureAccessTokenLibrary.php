<?php

namespace App\Libraries;

class  SecureAccessTokenLibrary {
    public static function encryptToken($token, $encryptionKey) {
        $encryptionKey = base64_decode($encryptionKey);
        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = openssl_random_pseudo_bytes($ivLength); // Generate random IV
        $encryptedToken = openssl_encrypt($token, 'aes-256-cbc', $encryptionKey, 0, $iv);
    
        if ($encryptedToken === false) {
            throw new \Exception('Encryption failed: ' . openssl_error_string());
        }
    
        // Return encrypted data along with IV, separated by "::"
        return base64_encode($encryptedToken . '::' . $iv);
    }
    
    // Function to decrypt the token
    public static function decryptToken($encryptedToken, $encryptionKey) {
        $encryptionKey = base64_decode($encryptionKey);
    
        // Decode the base64-encoded encrypted token
        $tokenParts = explode('::', base64_decode($encryptedToken), 2);
    
        // Check if we have both the encrypted data and the IV
        if (count($tokenParts) !== 2) {
            throw new \Exception('Invalid encrypted token format.');
        }
    
        list($encryptedData, $iv) = $tokenParts;
    
        // Decrypt the data
        $decryptedToken = openssl_decrypt($encryptedData, 'aes-256-cbc', $encryptionKey, 0, $iv);
    
        if ($decryptedToken === false) {
            throw new \Exception('Decryption failed: ' . openssl_error_string());
        }
    
        return $decryptedToken;
    }
}
