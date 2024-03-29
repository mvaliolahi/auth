<?php

namespace Mvaliolahi\Auth\Helpers\UniqueId;

class UniqueId
{
    /**
     * @param int $length
     * @return string
     */
    public static function makeString($length = 2)
    {
        return strtoupper(
            uniqid(
                bin2hex(openssl_random_pseudo_bytes($length))
            )
        );
    }

    /**
     * @param int $length
     * @return int
     */
    public static function makeDigit($length)
    {
        if (!app()->environment('production')) {
            return "12345";
        }

        $intMin = (10 ** $length) / 10;
        $intMax = (10 ** $length) - 1;

        return mt_rand($intMin, $intMax);
    }
}
