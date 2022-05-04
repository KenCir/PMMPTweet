<?php

declare(strict_types=1);

namespace Ken_Cir\Tweet;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Tweet extends PluginBase
{
    use SingletonTrait;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
    }

    protected function onDisable(): void
    {
    }
}