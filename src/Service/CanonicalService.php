<?php

declare(strict_types=1);

namespace App\Service;

class CanonicalService
{
    public static function filter(string $text): string
    {
        $text = trim($text);
        $search = [' ', '\\', '/', ',', '-',];
        $replace = [''];
        $text = str_replace($search, $replace, $text);

        return strtolower($text);
    }
}