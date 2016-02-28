<?php
	require_once("vendor/kayako-sdk/kyIncludes.php");
	require_once("vendor/autoload.php");

	$config = json_decode(file_get_contents("config/config.json"), true);

	$api_settings = $config["kayako"];
	$slack_settings = $config["slack"];

	$slack_users = array(
		"@biannetta" => "Ben",
		"@tshadd" => "Ty",
		"@eros" => "Eros",
		"@joe.muresan" => "Joe"
	);

	kyConfig::set(new kyConfig($api_settings["url"],$api_settings["key"],$api_settings["secret"]));
	$klein = new \Klein\Klein();
?>
