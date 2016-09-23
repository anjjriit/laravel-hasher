<?php


use ClumsyPixel\Hasher\WrappedHasher;
use GrahamCampbell\TestBench\AbstractPackageTestCase;


class HasherTest extends AbstractPackageTestCase
{
    public function testServiceProviderIsInjectable()
    {
        $this->assertIsInjectable(WrappedHasher::class);
    }

    public function testBasic() {
        /**
         * @var \Illuminate\Contracts\Hashing\Hasher
         */
        $hasher = $this->app->make(WrappedHasher::class);

        $hash = $hasher->make('123456');

        $this->assertTrue($hasher->check('123456', $hash));

        $this->assertFalse($hasher->check('12345', $hash));
        $this->assertFalse($hasher->check('test', $hash));
        $this->assertFalse($hasher->check(str_random(64), $hash));
    }


    public function testBcryptRehash() {
        /**
         * @var \Illuminate\Contracts\Hashing\Hasher
         */
        $hasher = $this->app->make(WrappedHasher::class);

        $this->assertTrue($hasher->needsRehash(password_hash('test', PASSWORD_BCRYPT)));
    }


    public function testRehash() {
        /**
         * @var \Illuminate\Contracts\Hashing\Hasher
         */
        $hasher = $this->app->make(WrappedHasher::class);

        $this->assertFalse($hasher->needsRehash($hasher->make('test')));
        $this->assertTrue($hasher->needsRehash($hasher->make('test', ['rounds' => 5])));
    }


    public function testRandom() {
        /**
         * @var \Illuminate\Contracts\Hashing\Hasher
         */
        $hasher = $this->app->make(WrappedHasher::class);

        for ($i=0; $i<32; $i++) {
            $plain = str_random(random_int(4, 256));
            $this->assertTrue($hasher->check($plain, $hasher->make($plain)));
        }
    }
}