<?php

	// Carga del motor de plantillas Twig
	require_once 'vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader,[ ]);
	session_start();

	/*********************************************************/

	$monthInSpanish = ["zero","enero","febrero","marzo","abril","mayo","junio","julio",
	"agosto","septiembre","octubre","noviembre","diciembre"];


	/*
		Buscamos en la base de datos el evento cuya Id coincida
		con el valor de la variable $event, y rellenamos la
		plantilla con el contenido de su entrada en la tabla de eventos
	*/

	$page = 'evento';

	$eventTitle = $event_data['name'];
	$eventCreator = $event_data['author'];
	$eventDate = $event_data['date'];
	$eventTime = $event_data['time'];
	$eventDateM = $event_data['dateM'];
	$eventTimeM = $event_data['timeM'];
	$eventBody = explode("\n", $event_data["description"]);

	$eventEnlace = $event_data['thumbnail'];

	//$numeroComent = $numeroComentarios['id'];
	$imageName1 = $imagen1['name'];
	$imageName2 = $imagen2['name'];
	$imageTxt1 = $imagen1['txtpie'];
	$imageTxt2 = $imagen2['txtpie'];
	$imagePath1 = $imagen1['path'];
	$imagePath2 = $imagen2['path'];
	$imageCredit1 = $imagen1['credit'];
	$imageCredit2 = $imagen2['credit'];
	$imagePathCredit1 = $imagen1['pathcredit'];
	$imagePathCredit2 = $imagen2['pathcredit'];

	$event_comments = $db_comentarios;
	for ($i=0, $size = sizeof($event_comments); $i <$size; ++$i){
		$event_comments[$i]['description'] = explode("\n",$db_comentarios[$i]['description']);

		// Cambiar formato fecha
		$commentDateArray = explode('-',$event_comments[$i]['date']);
		// Usamos intval para quitar ceros a la izquierda
		$commentDateString =  intval($commentDateArray[2])." de ".$monthInSpanish[intval($commentDateArray[1])];
		$event_comments[$i]['date'] = $commentDateString;

		// Cambiar formato hora
		$commentTimeArray = explode(':',$event_comments[$i]['time']);
		$commentTimeString =  $commentTimeArray[0].":".$commentTimeArray[1];
		$event_comments[$i]['time'] = $commentTimeString;
	}


	$galeria = $gallery;
	//$size = sizeof($galeria);
	//echo '<script type="text/javascript">alert("'.$size.'");</script>';
	$galeriaVideos = $galleryVideos;

	$eventDateArray = explode('-',$eventDate);
	$eventDateString = intval($eventDateArray[2])." de ".$monthInSpanish[intval($eventDateArray[1])];

	$eventTimeArray = explode(':',$eventTime);
	$eventTimeString = $eventTimeArray[0].":".$eventTimeArray[1];

	$eventLastModDateArray = explode('-',$eventDateM);
	$eventLastModDateString = intval($eventLastModDateArray[2])." de ".$monthInSpanish[intval($eventLastModDateArray[1])];

	$eventLastModTimeArray = explode(':',$eventTimeM);
	$eventLastModTimeString = $eventLastModTimeArray[0].":".$eventLastModTimeArray[1];

	// Comprobar si el usuario actual está registrado o es superusuario
	$registered_user = False;
	$mod_user = False;

	if (!isset($_SESSION["usuario"]) or !isset($_SESSION["rol"]) or $anonymous_user){
		$registered_user = False;
		$mod_user = False;
	}
	else {
		if($_SESSION["rol"] == 'registered'){
			$registered_user = True;
			$mod_user = False;
		}
		else if($_SESSION["rol"] == 'mod') {
			$registered_user = False;
			$mod_user = True;
		}
		else if($_SESSION["rol"] == 'super') {
			$registered_user = True;
			$mod_user = True;
		}
	}


	echo $twig->render('evento.html',
		['event_title' => $eventTitle,
		 'event_creator' => $eventCreator,
	 	 'event_date' => $eventDateString,
		 'event_time' => $eventTimeString,
	 	 'event_dateM' => $eventLastModDateString,
		 'event_timeM' => $eventLastModTimeString,
		 'event_body' => $eventBody,
		 'event_enlace' => $eventEnlace,
		 'comentarios' => $event_comments,
		 'galeria' => $galeria,
		 'image_name1' => $imageName1,
		 'image_name2' => $imageName2,
		 'image_txt1'  => $imageTxt1,
		 'image_txt2' => $imageTxt2,
		 'image_path1' => $imagePath1,
		 'image_path2' => $imagePath2,
		 'image_credit1' => $imageCredit1,
		 'image_credit2' => $imageCredit2,
		 'image_pathcredit1' => $imagePathCredit1,
		 'image_pathcredit2' => $imagePathCredit2,
		 'videos' => $galeriaVideos,
		 'nombre' => $nombre,
		 'email' => $email,
		 'texta' => $textArea,
		 'page' => $page,
		 'event_id' => $event,
		 'tags' => $event_tags,
		 'user' => $_SESSION["usuario"],
		 'anon' => $anonymous_user,
		 'is_registered' => $registered_user,
		 'is_mod' => $mod_user,
		 'searched' => $searched_substring
		]
	);
?>
