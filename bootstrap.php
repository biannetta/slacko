<?php
	require_once("vendor/kayako-sdk/kyIncludes.php");

	$config = json_decode(file_get_contents("config/config.json"), true);
	$api_settings = $config["api"];

	kyConfig::set(new kyConfig($api_settings["url"],$api_settings["key"],$api_settings["secret"]));
?>