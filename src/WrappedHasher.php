<?php


namespace ClumsyPixel\Hasher;


use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;


class WrappedHasher implements HasherContract
{
    /**
     * @var HasherContract intermediate Hasher
     */
    protected $hasher;


    /**
     * @var EncrypterContract Symmetric Encrypter
     */
    protected $encrypter;


    /**
     * @var string Algo used to generate first hash iteration
     */
    protected $hashAlgo;


    /**
     * WrappedHasher constructor.
     * @param HasherContract $hasher
     * @param EncrypterContract $encrypter
     * @param array $options
     */
    public function __construct(HasherContract $hasher, EncrypterContract $encrypter, $options = [])
    {
        $this->hasher = $hasher;
        $this->encrypter = $encrypter;

        $this->hashAlgo = isset($options['algo']) ? $options['algo'] : 'sha512';
    }


    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param  array $options
     * @return string
     * @throws \Exception
     */
    public function make($value, array $options = [])
    {
        $hashedValue = $this->hasher->make(
            base64_encode(
                hash($this->hashAlgo, $value)
            ),
            $options
        );

        if ($hashedValue === false) {
            throw new \Exception("Value could not be hashed.");
        }

        return $this->encrypter->encrypt($hashedValue);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string $value
     * @param  string $hashedValue
     * @param  array $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        $hashedValue = $this->encrypter->decrypt($hashedValue);

        return $this->hasher->check(base64_encode(
            hash($this->hashAlgo, $value)
        ), $hashedValue, $options);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string $hashedValue
     * @param  array $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        if (in_array(substr($hashedValue, 0, 3), ['$2y', '$2a'])) return true;

        $hashedValue = $this->encrypter->decrypt($hashedValue);
        return $this->hasher->needsRehash($hashedValue, $options);
    }
}