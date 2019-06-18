<?php
	// Cargar Twig
	require_once 'vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader,[ ]);

	// Creamos la sesion de la web
	//session_start();
	/*if (!isset($_SESSION["usuario"])){
		$_SESSION["usuario"] = "invitado";
	}*/

	echo $twig->render('portada.html', [
		'events' => $db_names_and_thumbs,
		'tags' => $tags_array,
		'user' => $_SESSION["usuario"],
		'anon' => $anonymous_user
	]);
?>
