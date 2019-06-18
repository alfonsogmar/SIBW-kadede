<?php

	// Carga del motor de plantillas Twig
	require_once 'vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader,[ ]);

	/*********************************************************/

	echo $twig->render('editar_comentario.html',[
		'comment_id' => $comment_to_be_edited_id,
		'comment_text' => $comment_to_be_edited_text
	]);
