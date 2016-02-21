<?php
	require_once("bootstrap.php");

	function get_ticket($ticket_number) {
		$ticket = kyTicket::get($ticket_number);
		$data = array(
				"text" => $ticket->getSubject(),
				"response_type" => "in_channel",
				"attachment" => array(
					"title" => $ticket->getDisplayId(),
					"title_link" => "http://prosoftxp.com/support/staff/index.php?/Tickets/Ticket/View/".$ticket->getDisplayId()
			)
		);
		return $data;
	}

	$klein->respond('GET', '/ticket/[i:id]', function($request, $response) {
		$response->header("content-type","application/json");
		$response->json(get_ticket($request->id));
		$response->send();
	});

	$klein->respond('POST', '/ticket/', function($request, $response) {
		$response->header("content-type","application/json");
		$response->json(get_ticket($request->param("text")));
		$response->send();
	});
	$klein->dispatch();
?>