<?php

namespace App\Helpers;

use Illuminate\Encryption\Encrypter;

/**
 * This class override Illuminate\Encryption\Encrypter to match with EPARK
 * encryption method
 *
 * @package namespace App\Helpers
 */
class EparkEncrypter extends Encrypter
{
    protected function validMac(array $payload)
    {
        return true;
    }
}
