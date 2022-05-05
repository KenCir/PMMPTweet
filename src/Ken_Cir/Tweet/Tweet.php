<?php

declare(strict_types=1);

namespace Ken_Cir\Tweet;

use Ken_Cir\Tweet\Commands\TweetCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Tweet extends PluginBase
{
    use SingletonTrait;

    const VERSION = "1.0.0";

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        $this->saveResource("config.yml");

        if ($this->getConfig()->get("version") !== self::VERSION) {
            rename("{$this->getDataFolder()}config.yml", "{$this->getDataFolder()}config.yml.{$this->getConfig()->get("version")}");
            $this->saveResource("config.yml", true);
            $this->getLogger()->warning("config.yml バージョンが違うため、上書きしました");
            $this->getLogger()->warning("前バージョンのconfig.ymlは{$this->getDataFolder()}config.yml.{$this->getConfig()->get("version")}にあります");
        }

        $this->getServer()->getCommandMap()->register($this->getName(), new TweetCommand($this->getFile(), $this, "tweet", "ツイートする"));
    }

    protected function onDisable(): void
    {
    }
}