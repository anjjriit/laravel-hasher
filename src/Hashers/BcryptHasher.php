<?php

namespace ClumsyPixel\Hasher\Hashers;


class BcryptHasher extends \Illuminate\Hashing\BcryptHasher
{
    /**
     * BcryptHasher constructor.
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->rounds = isset($options['rounds']) ? $options['rounds'] : 10;
    }
}
