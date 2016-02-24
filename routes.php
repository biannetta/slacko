<?php
	require_once("classes/controllers/Tickets.php");

	$klein->respond('GET', '/ticket/[i:id]', function($request, $response) {
		$response->header("content-type","application/json");
		$response->json(Tickets::get_ticket($request->id));
		$response->send();
	});

	$klein->respond('POST', '/ticket/', function($request, $response) {
		$response->header("content-type","application/json");
		$response->json(Tickets::get_ticket($request->param("text")));
		$response->send();
	});
?>