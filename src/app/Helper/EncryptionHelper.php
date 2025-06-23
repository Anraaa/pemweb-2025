<?php

namespace App\Helper;

use Illuminate\Support\Facades\Crypt;
use PhpParser\Stmt\TryCatch;

class EncryptionHelper
{
    public static function encrypt($data)
    {
        $key = env('KEY_ENCRYPT', 'defaultkey');
        return Crypt::encryptString($data, false);
    }

    public static function decrypt($encyptedData)
    {
        try{
            return Crypt::decryptString($encyptedData);
        } catch (\Exception $e) {
            // Handle decryption failure, e.g., log the error or return null
            return 'Decryption failed: ', $e->getMessage();
        }
    }
}