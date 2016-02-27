<?php
	require_once("bootstrap.php");

	function get_ticket($ticket_number) {
		$ticket = kyTicket::get($ticket_number);
		$data = array(
				"response_type" => "in_channel",
				"attachments" => array(
					array(
						"title" => $ticket->getDisplayId()." - ".$ticket->getSubject(),
						"title_link" => "http://prosoftxp.com/support/staff/index.php?/Tickets/Ticket/View/".$ticket->getDisplayId(),
						"fields" => array(
							array(
								"title" => "Creator",
								"value" => $ticket->getFullName(),
								"short" => "true"
							),
							array(
								"title" => "Assigned To",
								"value" => $ticket->getOwnerStaffName(),
								"short" => "true"
							)
						)
					)
				)
		);
		return $data;
	}

	function get_staff_member_by_user($username) {
		$staff = kyStaff::getAll()->filterByUserName($slack_users[$username]);
		return $staff;
	}

	$klein->respond('GET', '/ticket/[i:id]', function($request, $response) {
		$response->header("content-type","application/json");
		$response->json(get_ticket($request->id));
		$response->send();
	});

	$klein->respond('POST', '/ticket/', function($request, $response) {
		$raw_text = $request->param("text");
		$params = explode(" ", $raw_text);

		if (count($params) == 2) {
			$staff = get_staff_member_by_user($params[1]);
			file_put_contents('php://stderr', print_r($staff));
		}

		$response->header("content-type","application/json");
		$response->json(get_ticket($params[0]));
		$response->send();
	});
	$klein->dispatch();
?>
