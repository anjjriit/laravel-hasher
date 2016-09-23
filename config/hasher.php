<?php

return array(
    /*
     |--------------------------------------------------------------------------
     | Intermediate Hasher
     |--------------------------------------------------------------------------
     |
     | This option sets the intermediate hasher to be used.
     | You can specify any hasher that implements Laravel's HasherContract (Illuminate\Contracts\Hashing\Hasher).
     |
     | CAUTION: If your encryption key is compromised, this is the hash that will be available upon decryption.
     */

    'intermediate_hasher' => \ClumsyPixel\Hasher\Hashers\BcryptHasher::class,


    /*
     |--------------------------------------------------------------------------
     | Algorithm
     |--------------------------------------------------------------------------
     |
     | This option sets the algorithm to be used to encrypt the plaintext value before
     | the intermediate hasher is applied and supports anything your PHP version supports.
     |
     | Refer to http://php.net/manual/en/function.hash-algos.php to find out what algorithms are supported.
     */

    'algo' => 'sha512',


    /*
     |--------------------------------------------------------------------------
     | Options
     |--------------------------------------------------------------------------
     |
     | This option sets additional options that your intermediate hasher might require to function e.g. bcrypt's adjustable cost factor.
     */

    'options' => [
        'rounds' => 10
    ],
);
