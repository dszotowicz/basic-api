<?php

declare(strict_types=1);

namespace App\Glossary;

use App\Tools\ConstantKeeper;

class PositionType extends ConstantKeeper
{
    const HELP_DESK = 1;
    const MANAGER = 2;
    const CUSTOMER_SUPPORT = 3;
    const DIRECTOR = 4;
}