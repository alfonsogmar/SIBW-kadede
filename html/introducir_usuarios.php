<?php

	require './database.php';
	$database = new DatabaseHandler();
	$database->saveMod();
	$database->saveManager();
	$database->saveSuper();
	echo("Usuarios especiales guardados en BD");
?>
