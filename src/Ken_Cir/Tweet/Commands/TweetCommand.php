<?php

declare(strict_types=1);

namespace Ken_Cir\Tweet\Commands;

use Ken_Cir\Tweet\Tasks\TweetAsyncTask;
use Ken_Cir\Tweet\Tweet;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\utils\TextFormat;

class TweetCommand extends Command implements PluginOwned
{
    private Plugin $plugin;

    private string $vendorPath;

    public function __construct(string $vendorPath, Tweet $plugin, string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);

        $this->plugin = $plugin;
        $this->vendorPath = $vendorPath;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->plugin->getConfig()->get("twitterKey")
            or !$this->plugin->getConfig()->get("twitterSecret")
            or !$this->plugin->getConfig()->get("accessTokenKey")
            or !$this->plugin->getConfig()->get("accessTokenSecret")) {
            $sender->sendMessage(TextFormat::RED . "config.yml 設定されていません");
            return;
        }

        $this->plugin->getServer()->getAsyncPool()->submitTask(new TweetAsyncTask($this->vendorPath,
            $this->plugin->getConfig()->get("twitterKey"),
            $this->plugin->getConfig()->get("twitterSecret"),
            $this->plugin->getConfig()->get("accessTokenKey"),
            $this->plugin->getConfig()->get("accessTokenSecret"),
            join(" ", $args)));

        $sender->sendMessage(TextFormat::GREEN . "ツイートしています、ツイート内容: " .  join(" ", $args));
    }

    public function getOwningPlugin(): Plugin
    {
        return $this->plugin;
    }
}