<?php

	// Carga del motor de plantillas Twig
	require_once 'vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader,[ ]);
	//session_start();

	/*********************************************************/
	echo $twig->render('signup.html', [
		'password_error' => $signup_psswd_error_msg,
		'email_error' => $signup_email_error_msg,
		'anon' => $anonymous_user
	]);
?>
