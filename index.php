<?php
	require_once("bootstrap.php");

	function get_ticket($ticket_number) {
		$ticket = kyTicket::get($ticket_number);
		$message = $ticket->getDisplayId()." ".$ticket->getSubject()." ".$ticket->getFullName();
		return $message;
	}

	$klein->respond('GET', '/ticket/[i:id]', function($request) {
		print get_ticket($request->id);
	});
	$klein->dispatch();
?>