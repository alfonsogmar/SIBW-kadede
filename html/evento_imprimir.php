<?php
	//require 'templates/evento_imprimir.html'

	// Carga del motor de plantillas Twig
	require_once 'vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader,[ ]);

	/*********************************************************/


	$monthInSpanish = ["zero","enero","febrero","marzo","abril","mayo","junio","julio",
	"agosto","septiembre","octubre","noviembre","diciembre"];




	// Título, autor y demás datos del evento
	$eventTitle = $event_data['name'];
	$eventCreator = $event_data['author'];
	$eventDate = $event_data['date'];
	$eventTime = $event_data['time'];
	$eventDateM = $event_data['dateM'];
	$eventTimeM = $event_data['timeM'];
	$eventBody = explode("\n", $event_data["description"]);
	$eventMini = $event_data['thumbnail'];

	// Videos
	$eventVideos = $galleryVideos;

	// Dividimos el cuerpo del evento en dos,
	// para mostrarlo en dos columnas en la versión imprimible

	$eventBodyLeft = [];
	for ($i=0, $size = sizeof($eventBody)/2 - 1; $i <$size; ++$i){
		array_push($eventBodyLeft,$eventBody[$i]);
	}

	$eventBodyRight = [];
	for ($i=sizeof($eventBody)/2, $size = sizeof($eventBody); $i <$size; ++$i){
		array_push($eventBodyRight,$eventBody[$i]);
	}

	// Fecha y hora de creación
	$eventDateArray = explode('-',$eventDate);
	$eventDateString = intval($eventDateArray[2])." de ".$monthInSpanish[intval($eventDateArray[1])];

	$eventTimeArray = explode(':',$eventTime);
	$eventTimeString = $eventTimeArray[0].":".$eventTimeArray[1];

	// Fecha y hora de modificación
	$eventLastModDateArray = explode('-',$eventDateM);
	$eventLastModDateString = intval($eventLastModDateArray[2])." de ".$monthInSpanish[intval($eventLastModDateArray[1])];

	$eventLastModTimeArray = explode(':',$eventTimeM);
	$eventLastModTimeString = $eventLastModTimeArray[0].":".$eventLastModTimeArray[1];


	echo $twig->render('evento_imprimir.html',
		['event_title' => $eventTitle,
		 'event_creator' => $eventCreator,
	 	 'event_date' => $eventDateString,
		 'event_time' => $eventTimeString,
	 	 'event_dateM' => $eventLastModDateString,
		 'event_timeM' => $eventLastModTimeString,
		 'event_body_left' => $eventBodyLeft,
		 'event_body_right' => $eventBodyRight,
		 'event_thumbnail' => $eventMini,
		 'event_videos' => $eventVideos
	 ]);
?>
