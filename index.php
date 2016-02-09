<?php
	require_once("bootstrap.php");

	$tickets = kyTicket::getAll(
			kyTicketStatus::getAll()->filterByTitle(array("=","Open")), array()
		);

	print($tickets[0]);
?>