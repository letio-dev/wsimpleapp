<?php

namespace App\Helpers;

class UUIDConverter
{
    /**
     * Convert UUID string to binary(16)
     */
    public static function uuidToBinary(string $uuid): string
    {
        return pack("H*", str_replace('-', '', $uuid));
    }

    /**
     * Convert binary(16) to UUID string
     */
    public static function binaryToUuid(string $binary): string
    {
        $hex = unpack("H*", $binary)[1];
        return vsprintf('%s%s%s%s-%s%s-%s%s-%s%s-%s%s%s%s%s%s', str_split($hex, 2));
    }
}
