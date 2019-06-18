<?php

	// Carga del motor de plantillas Twig
	require_once 'vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader,[ ]);

	/*********************************************************/

	$general_body = explode("\n",$general_info['body']);

	echo $twig->render('general.html', [
			'general_title' => $general_info['title'],
			'general_body' => $general_body,
			'anon' => $anonymous_user
	]);


?>
