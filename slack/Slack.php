<?php
/**
 * Class for connecting to Slack
 */
class Slack {
	/**
	 * Slack Endpoint
	 */
	private $endpoint = NULL;

	/**
	 * Slack Bot Name
	 */
	private $bot_name = NULL;

	/**
	 * Slack Bot Icon
	 */
	private $icon = NULL;

	/**
	 * Initialize the slack channel
 	 */
	function __construct($endpoint, $bot_name, $icon) {
		$this->setEndpoint($endpoint);
		$this->setBotName($bot_name);
		$this->setIcon($icon);
	}

	public function sendMessage($message) {
		$data = "payload=" . json_encode(array(
			"username" => $this->getBotName(),
	        "text"     => $message,
	        "icon_url" => $this->getIcon()
	    ));

		$ch = curl_init($this->getEndpoint());
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}

	public function setEndpoint($endpoint) {
		$this->endpoint = $endpoint;
		return $this;
	}

	public function getEndpoint() {
		return $this->endpoint;
	}

	public function setBotName($bot_name) {
		$this->bot_name = $bot_name;
		return $this;
	}

	public function getBotName() {
		return $this->bot_name;
	}

	public function setIcon($icon) {
		$this->icon = $icon;
		return $this;
	}

	public function getIcon() {
		return $this->icon;
	}
}