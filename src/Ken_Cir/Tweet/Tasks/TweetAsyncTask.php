<?php

declare(strict_types=1);

namespace Ken_Cir\Tweet\Tasks;

use Ken_Cir\Tweet\Tweet;
use pocketmine\scheduler\AsyncTask;
use Abraham\TwitterOAuth\TwitterOAuth;

class TweetAsyncTask extends AsyncTask
{
    private string $vendorPath;

    private string $twitterKey;

    private string $twitterSecret;

    private string $accessTokenKey;

    private string $accessTokenSecret;

    private string $tweetText;

    public function __construct(string $vendorPath, string $twitterKey, string $twitterSecret, string $accessTokenKey, string $accessTokenSecret, string $tweetText)
    {
        $this->vendorPath = $vendorPath;
        $this->twitterKey = $twitterKey;
        $this->twitterSecret = $twitterSecret;
        $this->accessTokenKey = $accessTokenKey;
        $this->accessTokenSecret = $accessTokenSecret;
        $this->tweetText = $tweetText;
    }

    public function onRun(): void
    {
        include "{$this->vendorPath}vendor/autoload.php";

        $twitter = new TwitterOAuth($this->twitterKey, $this->twitterSecret, $this->accessTokenKey, $this->accessTokenSecret);
        $twitter->post("statuses/update", array("status" => $this->tweetText));
    }

    public function onCompletion(): void
    {
        // 念のため
        unset($this->twitterKey, $this->twitterSecret, $this->accessToken, $this->accessTokenSecret);

        Tweet::getInstance()->getLogger()->info("ツイートしました、ツイート内容: $this->tweetText");
    }
}