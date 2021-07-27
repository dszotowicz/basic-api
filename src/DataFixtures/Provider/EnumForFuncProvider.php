<?php

declare(strict_types=1);

namespace App\DataFixtures\Provider;

class EnumForFuncProvider
{
    public function enumForFunc(string $path)
    {
        $list = call_user_func($path);
        $selected = array_rand($list);

        return $list[$selected];
    }
}