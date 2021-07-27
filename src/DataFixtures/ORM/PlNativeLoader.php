<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM;

use App\DataFixtures\Provider\EnumForFuncProvider;
use Faker\Factory as FakerGeneratorFactory;
use Faker\Generator as FakerGenerator;
use Nelmio\Alice\Faker\Provider\AliceProvider;
use Nelmio\Alice\Loader\NativeLoader;

class PlNativeLoader extends NativeLoader
{
    public const LOCALE = 'pl_PL';

    protected function createFakerGenerator(): FakerGenerator
    {
        $generator = FakerGeneratorFactory::create(self::LOCALE);
        $generator->addProvider(new AliceProvider());
        $generator->addProvider(new EnumForFuncProvider());
        $generator->seed($this->getSeed());

        return $generator;
    }
}