<?php
	// Cargar Twig
	require_once 'vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader,[ ]);

	echo $twig->render('eventos_etiqueta.html', [
		'tag' => $tag_name,
		'events' => $events_by_tag,
		'anon' => $anonymous_user
	]);
?>
