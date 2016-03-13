<?php
	include "bootstrap.php";

	function get_ticket($ticket_number)	{
		$ticket = kyTicket::get($ticket_number);
		return $ticket;
	}

	function get_ticket_response($ticket_number) {
		$ticket = get_ticket($ticket_number);
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
								"value" => $ticket->getOwnerStaffName() == "" ? "Unassigned" : $ticket->getOwnerStaffName(),
								"short" => "true"
							)
						)
					)
				)
		);
		return $data;
	}

	function get_staff_member_by_user($username) {
		$config = json_decode(file_get_contents("config/config.json"), true);
		$staff = kyStaff::getAll()->filterByEmail($config["slack"][$username]);
		return $staff;
	}

	function assign_ticket($ticket, $staff) {
		$ticket->setOwnerStaff($staff);
		$ticket->update();
	}

	$klein->respond('GET', '/ticket/[i:id]', function($request, $response) {
		echo kyTicket::get($request->id);
	});

	$klein->respond('GET', '/staff/[i:id]', function($request, $response) {
		echo kyStaff::get($request->id);
	});

	$klein->respond('GET', '/staff/[:username]', function($request, $response) {
		echo get_staff_member_by_user($request->username);
	});

	$klein->respond('POST', '/ticket/', function($request, $response) {
		$raw_text = $request->param("text");
		$params = explode(" ", $raw_text);

		$response->header("content-type","application/json");

		if (count($params) == 2) {
			$ticket = get_ticket($params[0]);
			$staff = get_staff_member_by_user($params[1]);

			assign_ticket($ticket, $staff);
			$response->json($data = array(
				"response_type" => "in_channel",
				"attachments" => array(
					array(
						"title" => $ticket->getDisplayId()." - ".$ticket->getSubject(),
						"title_link" => "http://prosoftxp.com/support/staff/index.php?/Tickets/Ticket/View/".$ticket->getDisplayId(),
						"text" => "This ticket has been assigned to ".$params[1]
					)
				)
			));
			$response->send();
		} else {
			if (strtoupper($params[0]) == "HELP") {
				$response->json(array(
						"text" => "• `/ticket 123456` Display Information and Link about Case 123456 \n • `/ticket 123456 @username` Assign Ticket 123456 to Username \n • `/ticket help` List help about Kayako Slack command",
						"mrkdwn_in" => ["text","pretext"]
					)
				);
				$response->send();
			} else {
				$response->json(get_ticket_response($params[0]));
				$response->send();
			}
		}
	});
	$klein->dispatch();
?>
