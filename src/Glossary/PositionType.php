<?php

declare(strict_types=1);

namespace App\Glossary;

use App\Tools\ConstantKeeper;

class PositionType extends ConstantKeeper
{
    const HELP_DESK = 'help_desk';
    const MANAGER = 'manager';
    const CUSTOMER_SUPPORT = 'customer_support';
    const DIRECTOR = 'director';
}