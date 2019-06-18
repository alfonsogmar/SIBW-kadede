<?php

	// Carga del motor de plantillas Twig
	require_once 'vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader,[ ]);
	//session_start();

	/*********************************************************/
	echo $twig->render('login.html', [
		'login_error' => $loging_error_msg,
		'anon' => $anonymous_user
	]);
?>
