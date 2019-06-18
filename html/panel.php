<?php

	// Carga del motor de plantillas Twig
	require_once 'vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader,[ ]);

	$rol_info = "";
	$modificarDatos="Modificar Datos Personales";
	$modificarDatosImagen="./images/ModificarDatos.png";
	$modificarDatosJs="modificarDatos";
	
	//$setComentario="Añadir Comentario";
	//$setComentarioImagen="./images/setComentario.png";
	//$delComentario="Eliminar Comentario";
	//$delComentarioImagen="./images/deleteComentario.png";
	//$updateComentario="Modificar Comentario";
	//$updateComentarioImagen="./images/updateComentario.png";
	$listadoComentario="Listado de Comentarios";
	$listadoComentarioImagen="./images/listadoComentarios.png";
	$listadoComentarioJs="listadoComentarios";
	$buscarComentario="Buscar un Comentario";
	$buscarComentarioImagen="./images/buscarComentario.png";
	$buscarComentarioJs="buscarComentarios";
	
	//$setEtiquetas="Añadir Etiqueta";
	//$setEtiquetasImagen="./images/setEtiqueta.png";
	//$delEtiquetas="Eliminar Etiqueta";
	//$delEtiquetasImagen="./images/deleteEtiqueta.png";
	$listadoEtiquetas="Listado de etiquetas";
	$listadoEtiquetasImagen="./images/setEtiqueta.png";
	$listadoEtiquetasJs="listadoEtiquetas";
	
	//$setEvento="Añadir Evento";
	//$setEventoImagen="./images/setEvento.png";
	//$delEvento="Eliminar Evento";
	//$delEventoImagen="./images/deleteEvento.png";
	//$updateEvento="Modificar Evento";
	//$updateEventoImagen="./images/updateEvento.png";
	$listadoEvento="Listado de Eventos";
	$listadoEventoImagen="./images/listadoEvento.png";
	$listadoEventoJs="listadoEventos";
	$buscarEvento="Buscar Evento";
	$buscarEventoImagen="./images/buscarEvento.png";
	$buscarEventoJs="buscarEventos";
	
	//$setImagen="Añadir Imagen";
	//$setImagenImagen="./images/setImagen.png";
	//$delImagen="Eliminar Imagen";
	//$delImagenImagen="./images/deleteImagen.png";
	$listadoImagenes="Listado de imagenes";
	$listadoImagenesImagen="./images/setImagen.png";
	$listadoImagenesJs="listadoImagenes";
	
	//$setRol="Añadir Rol";
	//$setRolImagen="./images/setRol.png";
	//$delRol="Eliminar Rol";
	//$delRolImagen="./images/deleteRol.png";
	$listadoUsuarios="Listado de Usuarios";
	$listadoUsuariosImagen="./images/deleteRol.png";
	$listadoUsuariosJs="listadoUsuarios";
	
	$panel_inf = [];
	$panel="panelMinus";
	
	if($_SESSION["rol"] == "registered") {
		$rol_info = "Usuario registrado";
	
		$panel_row = [
			"name" => $modificarDatos,
			"image" => $modificarDatosImagen,
			"tabla" => $modificarDatosJs
		];
		array_push($panel_inf,$panel_row);
		
	}
	else if($_SESSION["rol"] == "mod") {
		$rol_info = "Moderador";
		$panel_row = [
			"name" => $modificarDatos,
			"image" => $modificarDatosImagen,
			"tabla" => $modificarDatosJs
		];
		array_push($panel_inf,$panel_row);
		
		$panel_row = [
			"name" => $listadoComentario,
			"image" => $listadoComentarioImagen,
			"tabla" => $listadoComentarioJs
		];
		array_push($panel_inf,$panel_row);
		
		$panel_row = [
			"name" => $buscarComentario,
			"image" => $buscarComentarioImagen,
			"tabla" => $buscarComentarioJs
		];
		array_push($panel_inf,$panel_row);
	}
	else if($_SESSION["rol"] == "manager") {
		$rol_info = "Gestor";
		$panel="panelSuper";
		
		$panel_row = [
			"name" => $modificarDatos,
			"image" => $modificarDatosImagen,
			"tabla" => $modificarDatosJs
		];
		array_push($panel_inf,$panel_row);
		
		$panel_row = [
			"name" => $listadoEtiquetas,
			"image" => $listadoEtiquetasImagen,
			"tabla" => $listadoEtiquetasJs
		];
		array_push($panel_inf,$panel_row);
		
		$panel_row = [
			"name" => $listadoEvento,
			"image" => $listadoEventoImagen,
			"tabla" => $listadoEventoJs
		];
		array_push($panel_inf,$panel_row);
		
		$panel_row = [
			"name" => $buscarEvento,
			"image" => $buscarEventoImagen,
			"tabla" => $buscarEventoJs
		];
		array_push($panel_inf,$panel_row);
		
		$panel_row = [
			"name" => $listadoImagenes,
			"image" => $listadoImagenesImagen,
			"tabla" => $listadoImagenesJs
		];
		array_push($panel_inf,$panel_row);
	}
	else if($_SESSION["rol"] == "super") {
		$rol_info = "Super";
		$panel="panelSuper";
		
		$panel_row = [
			"name" => $modificarDatos,
			"image" => $modificarDatosImagen,
			"tabla" => $modificarDatosJs
		];
		array_push($panel_inf,$panel_row);
		
		$panel_row = [
			"name" => $listadoComentario,
			"image" => $listadoComentarioImagen,
			"tabla" => $listadoComentarioJs
		];
		array_push($panel_inf,$panel_row);
		
		$panel_row = [
			"name" => $buscarComentario,
			"image" => $buscarComentarioImagen,
			"tabla" => $buscarComentarioJs
		];
		array_push($panel_inf,$panel_row);
		$panel_row = [
			"name" => $listadoEtiquetas,
			"image" => $listadoEtiquetasImagen,
			"tabla" => $listadoEtiquetasJs
		];
		array_push($panel_inf,$panel_row);
		$panel_row = [
			"name" => $listadoEvento,
			"image" => $listadoEventoImagen,
			"tabla" => $listadoEventoJs
		];
		array_push($panel_inf,$panel_row);
		$panel_row = [
			"name" => $buscarEvento,
			"image" => $buscarEventoImagen,
			"tabla" => $buscarEventoJs
		];
		array_push($panel_inf,$panel_row);
		$panel_row = [
			"name" => $listadoImagenes,
			"image" => $listadoImagenesImagen,
			"tabla" => $listadoImagenesJs
		];
		array_push($panel_inf,$panel_row);
		$panel_row = [
			"name" => $listadoUsuarios,
			"image" => $listadoUsuariosImagen,
			"tabla" => $listadoUsuariosJs
		];
		array_push($panel_inf,$panel_row);
		
	}

	$all_comments = $allComentarios;
	for ($i=0, $size = sizeof($all_comments); $i <$size; ++$i){
		//$all_comments[$i]['description'] = explode("\n",$allComentarios[$i]['description']);
	}
	$super = "Super";
	$oculto = "oculto";
	
	if($rol_info==$super){
		$oculto = "visible";
	}
	
	/*********************************************************/

	echo $twig->render('panel.html',[
		'user_name' => $nombreUsuario,
		'user_mail' => $_SESSION["email"],
		'user_rol' => $rol_info,
		'user_birthdate' => $birthdate,
		'oculto_visible' => $oculto,
		'panelInf' => $panel_inf,
		'panelClase' => $panel,
		'allComentarios' => $all_comments,
		'allEtiquetas' => $allEtiquetas,
		'allEventos' => $allEventos,
		'allImagenes' => $allImagenes,
		'allUsuarios' => $allUsuarios
	]);
