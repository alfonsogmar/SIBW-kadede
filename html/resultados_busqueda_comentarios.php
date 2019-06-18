<?php
	// Carga del motor de plantillas Twig
	require_once 'vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader,[ ]);

	/*********************************************************/

	echo $twig->render('resultados_busqueda_comentarios.html', [
		'allComentarios' => $commnts,
		'searched' => $searched_in_comments
	]);

?>
