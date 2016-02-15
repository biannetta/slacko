<?php
	require_once("vendor/kayako-sdk/kyIncludes.php");
	require_once("slack/Slack.php");
	require_once("vendor/autoload.php");

	$config = json_decode(file_get_contents("config/config.json"), true);

	$api_settings = $config["kayako"];
	$slack_settings = $config["slack"];

	kyConfig::set(new kyConfig($api_settings["url"],$api_settings["key"],$api_settings["secret"]));
	$slack = new Slack($slack_settings["url"],$slack_settings["name"],$slack_settings["icon"]);
	$klein = new \Klein\Klein();
?>