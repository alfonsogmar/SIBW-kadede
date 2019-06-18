<?php
	session_start();
	require './database.php';
	if(isset($_GET['search'])) {
		// Recupera
		$db = new DatabaseHandler();
		$substring = $_GET['search'];

		if($_SESSION["rol"] == "manager" or $_SESSION["rol"] == "super") {
			$events = $db->searchEvents($substring);
		}
		else {
			$events = $db->searchPublishedEvents($substring);
		}

		// Cambiar cabecera para que navegador sepa
		// que es un documento XML
		header( "content-type: application/xml; UTF-8" );

		/*$xmlstr =
		"<?xml version='1.0' encoding='UTF-8'?>
		<eventos>
		</eventos>";*/
		$xml = new DOMDocument('1.0','UTF-8');
		$xml_events = $xml->createElement( "events" );

		for ($i = 0, $size=count($events); $i < $size; ++$i) {
		    $ev = $xml->createElement("event");
		    $ev_name = $xml->createElement('name', $events[$i]['name']);
		    $ev_id = $xml->createElement('id', $events[$i]['id']);
				$ev->appendChild($ev_name);
				$ev->appendChild($ev_id);
				$xml_events->appendChild($ev);
		}

		$xml->appendChild($xml_events);

		echo $xml->saveXML();
	}
	else {
		echo "ERROR";
	}
?>
