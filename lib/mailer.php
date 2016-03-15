<?php
	require "vendor/autoload.php";

	function init($config) {
		$mail = new PHPMailer;

		$mail->Host = $config["host"];
		$mail->SMTPAuth = true;
		$mail->Username = $config["username"];
		$mail->Password = $config["password"];
		$mail->SMTPSecure = $config["encryption"];
		$mail->Port = $config["port"];
		$mail->setFrom($config["username"], $config["mailer"]);

		return $mail;
	}

	function send_mail($recipients, $subject, $message) {
		$mail = init(json_decode(file_get_contents("config/config.json"), true)["mail"]);
		$mail->isHTML(ture);

		if(is_array($recipients)) {
			foreach ($recipients as $recipient) {
				$mail->addAddress($recipient);
			}
		} else {
			$mail->addAddress($recipients);
		}

		$mail->Subject = $subject;
		$mail->Body = $message;

		if(!$mail->send()) {
			return array(
				"success" => false,
				"message" => $mail->ErrorInfo
			);
		} else {
			return array(
				"success" => true
			);
		}
	}