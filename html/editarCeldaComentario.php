<?php
			
	// Carga del motor de plantillas Twig
	require_once 'vendor/autoload.php';
	require './database.php';
	require './formValidator.php';
	session_start();

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader,[ ]);

	$database = new DatabaseHandler();
	
	$input = filter_input_array(INPUT_POST);
		
	if ($input['action'] == 'edit') {
		$update_field='';
		if(isset($input['Descripcion'])) {
			$update_field.= "'".$input['name']."'";
		}
		if($update_field && $input['id']) {
			$edicion = $database->editComment($update_field, $input['id']);
		}
	}
	echo'<script type="text/javascript">
    alert("Tarea Guardada");
    window.location.href="index.php";
    </script>';
?>