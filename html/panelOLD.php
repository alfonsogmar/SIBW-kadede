<?php

	// Carga del motor de plantillas Twig
	require_once 'vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader,[ ]);

	$rol_info = "";
	if($_SESSION["rol"] == "registered") {
		$rol_info = "Usuario registrado";
	}
	else if($_SESSION["rol"] == "mod") {
		$rol_info = "Moderador";
	}
	else if($_SESSION["rol"] == "manager") {
		$rol_info = "Gestor";
	}
	else if($_SESSION["rol"] == "super") {
		$rol_info = "Superusuario";
	}

	/*********************************************************/

	echo $twig->render('panel.html',[
		'user_name' => $_SESSION["usuario"],
		'user_mail' => $_SESSION["email"],
		'user_rol' => $rol_info,
		'user_birthdate' => $birthdate
	]);
