<?php
class Tickets {

	public function get_ticket($ticket_number) {
		$ticket = kyTicket::get($ticket_number);
		$message = $ticket->getDisplayId()." ".$ticket->getSubject()." ".$ticket->getFullName();

		return $message;
	}

}