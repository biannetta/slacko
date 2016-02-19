<?php
	require_once("bootstrap.php");

	function get_ticket($ticket_number) {
		$ticket = kyTicket::get($ticket_number);
		$data = array(
				"text" => $ticket->getSubject(),
				"attachment" => array(
					"title" => $ticket->getDisplayId(),
					"title_link" => "http://prosoftxp.com/support/staff/index.php?/Tickets/Ticket/View/".$ticket->getDisplayId()
			)
		);
		return $data;
	}

	$klein->respond('GET', '/ticket/[i:id]', function($request) {
		return json_encode(get_ticket($request->id));
	});

	$klein->respond('POST', '/ticket/', function($request) {
		return json_encode(get_ticket($request->param("text")));
	});
	$klein->dispatch();
?>