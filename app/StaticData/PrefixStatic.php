<?php

namespace App\StaticData;

use Illuminate\Support\Str;

class PrefixStatic
{
    public const BAR = 'BAR';
    public const BAZ = 'BAZ';
    public const FOO = 'FOO';

    public function getPrefixList(): array
    {
        return [
            'BAR' => self::BAR,
            'BAZ' => self::BAZ,
            'FOO' => self::FOO
        ];
    }
}
