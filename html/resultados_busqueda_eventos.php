<?php
	// Carga del motor de plantillas Twig
	require_once 'vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader,[ ]);

	/*********************************************************/

	echo $twig->render('resultados_busqueda_eventos.html', [
		'allEventos' => $evnts,
		'searched' => $searched_in_events
	]);

?>
