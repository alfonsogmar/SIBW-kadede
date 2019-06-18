<?php
	require './database.php';
	require './formValidator.php';
	session_start();

	// Valores por defecto de las variables (inválidos)
	$event = -1;
	$num_events = -1;
	// Por defecto, generamos la portada
	$page = 'portada';
	$signup_error_msg = "";
	$signup_email_error_msg = "";
	$loging_error_msg = "";

	// Objeto manejador de la base de datos:
	// se encarga de gestionar todas las conexiones
	// y consultas a la base de datos
	$database = new DatabaseHandler();

	// Número de eventos guardados en la base de datos
	$num_events = $database->getNumberOfEvents();

	if (!isset($_SESSION["usuario"])){
		$_SESSION["usuario"] = "invitado";
		$_SESSION["rol"] = "anonymous";
		$anonymous_user = True;
	}
	else {
		if($_SESSION["usuario"] == "invitado") {
			$_SESSION["rol"] = "anonymous";
			$anonymous_user = True;
		}
		else {
			$anonymous_user = False;
		}
	}

	// Obtener variables del GET
	if (!empty($_GET)){
		// Obtenemos la variable 'page'
		if(isset($_GET['page']) and file_exists($_GET['page'].'.php') ) {
			$page = $_GET['page'];
		}
		// Obtenemos la variable 'event'
		if(isset($_GET['event']) and $_GET['event']>0 and $_GET['event']<=$num_events ) {
			$event = $_GET['event'];
		}

		if(isset($_GET['close'])) {
			$_SESSION = Array();
			$_SESSION["usuario"] = "invitado";
			$anonymous_user = True;
		}

		// Para resaltar coincidencias de búsqueda
		if(isset($_GET['searched_substring'])) {
			$searched_substring = $_GET['searched_substring'];
		}


	}
	if (!empty($_POST)){
		// Obtenemos la variable 'page'
		if(isset($_POST['page']) and file_exists($_POST['page'].'.php') ) {
			$page = $_POST['page'];
		}
		// Obtenemos la variable 'event'
		if(isset($_POST['event']) and $_POST['event']>0 and $_POST['event']<=$num_events ) {
			$event = $_POST['event'];
		}

		// Registro de un usuario
		if(isset($_POST['signup-email']) and isset($_POST['signup-name']) and
		isset($_POST['signup-date']) and isset($_POST['signup-passwd']) and
		isset($_POST['signup-passwd2'])) {
			$valid_signup = True;

			$signup_name = $_POST['signup-name'];
			$signup_date = $_POST['signup-date']; // ¿Validar fecha?



			$signup_mail = $_POST['signup-email'];
			// Comprobar que sea email válido
			if(validateEmail($signup_mail) == 0) {
				$signup_email_error_msg = "X  Por favor, introduzca una dirección de correo electrónico válida.";
				$valid_signup = False;
			}
			else {
				// Comprobar que el email no está ya guardado en la base de datos
				if($database->findEmail($signup_mail)) {
					$signup_email_error_msg = "X  Ya hay un usuario registrado con esa dirección de correo electrónico. Por favor, introduzca un correo distinto.";
					$valid_signup = False;
				}
			}

			// Comprobar que las dos contraseñas son iguales
			if(strcmp($_POST['signup-passwd'], $_POST['signup-passwd2']) != 0) {
				$valid_signup = False;
				$signup_psswd_error_msg = "X  Las contraseñas no coinciden. Por favor, introduzca la misma contraseña dos veces.";
				$signup_password = "";
			}
			else {
				$signup_password = $_POST['signup-passwd'];
			}

			if($valid_signup) {
				$page = "portada";
				$database->signInUser($signup_mail,$signup_name,$signup_date,$signup_password);
				$_SESSION["usuario"] = $signup_name;
				$_SESSION["rol"] = $database->getUserRol($signup_mail);
				$_SESSION["email"] = $signup_mail;
				$anonymous_user = False;
			}
			else {
				$page = "signup";
			}
		}

		// Inicio de sesión de usuario registrado
		if(isset($_POST['login-email']) and isset($_POST['login-passwd'])) {
			if($database->checkEmailAndPassword($_POST['login-email'],$_POST['login-passwd'])) {
				$page = "portada";
				$_SESSION["usuario"] = $database->getUserName($_POST['login-email']);
				$_SESSION["rol"] = $database->getUserRol($_POST['login-email']);
				$_SESSION["email"] = $_POST['login-email'];
				$anonymous_user = False;
			}
			else {
				$loging_error_msg = "X  No existe ningún usuario con esa contraseña.";
				$page = "login";
			}
		}

		// DEBUG
		// Comprobar comentarios buscados
		if(isset($_POST['search-comment-text'])) {
			$searched_in_comments = $_POST['search-comment-text'];
			$commnts = $database->searchComment($searched_in_comments);
			$page = "resultados_busqueda_comentarios";
			/*foreach ($commnts as $comm) {
				echo($comm['name']);
				echo('---');
				echo($comm['description']);
				echo('------------------------------------------------');
			}*/
		}

		// DEBUG
		// Comprobar eventos buscados
		if(isset($_POST['search-event-text'])) {
			$searched_in_events = $_POST['search-event-text'];
			$evnts = $database->searchEvents($searched_in_events);
			$page = "resultados_busqueda_eventos";

		}

		if(isset($_POST['valorBusqueda'])){
			$consultaBusqueda = $_POST['valorBusqueda'];

			//Filtro anti-XSS
			$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
			$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");
			$consultaBusqueda = str_replace($caracteres_malos, $caracteres_buenos, $consultaBusqueda);

			//Variable vacía (para evitar los E_NOTICE)
			$mensaje = "";

			//Comprueba si $consultaBusqueda está seteado
			if (isset($consultaBusqueda)) {

			//Selecciona todo de la tabla evento
			//donde el nombre sea igual a $consultaBusqueda,
			//o el autor sea igual a $consultaBusqueda,
			//o la descripcion sea igual a $consultaBusqueda.
			$consulta = $database->busquedaDinamica($consultaBusqueda);

			//Obtiene la cantidad de filas que hay en la consulta
			$filas = mysqli_num_rows($consulta);

				//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
				if ($filas === 0) {
					$mensaje = "<p>No hay ningún usuario con ese nombre y/o apellido</p>";
				} else {
					//Si existe alguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
					echo 'Resultados para <strong>'.$consultaBusqueda.'</strong>';

					//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
					while($resultados = $consulta->fetch_assoc())
						$nombre = $resultados['name'];
						$autor = $resultados['author'];
						$descripcion = $resultados['description'];
						/*"id" => $row["Id"],
					"name" => $row["Nombre"],
					"date" => $row["Fecha"],
					"time" => $row["Hora"],
					"dateM" => $row["FechaModificacion"],
					"timeM" => $row["HoraModificacion"],
					"author" => $row["Autor"],
					"description" => $row["Descripcion"],
					"publicado" => $publico,
					"thumbnail"*/

						//Output
						$mensaje .= '
						<p>
						<strong>Nombre:</strong> ' . $nombre . '<br>
						<strong>Apellido:</strong> ' . $autor . '<br>
						<strong>Edad:</strong> ' . $descripcion . '<br>
						</p>';


					}
				}
			}

	}


	if($page == "portada") {
		// Si estamos en la portada, recuperamos los nombres y miniaturas
		// de los eventos guardados en la base de datos
		$only_published = !($_SESSION["rol"] == "manager" or $_SESSION["rol"] == "super");
		$db_names_and_thumbs = $database->getEventsNamesAndThumbnails($only_published);
		$tags_array = $database->getAllTags();
	}
	else if($page == "evento"){

		// Guardar nuevo comentario recibido en variables POST
		if(!empty($_POST)){
			if(isset($_POST['textarea']) and isset($_SESSION['rol'])) {
				// Comprobar si el usuario actual es registrado o superusuario
				if($_SESSION['rol'] == 'registered' or $_SESSION['rol'] == 'super'){
					$nombre = $_SESSION["usuario"];
					$email = $_SESSION['email'];
					$textArea = $_POST['textarea'];
					$Ip = get_ip_address();
					$hoy = getdate();
					$save = $database->saveComent($event,$Ip,$nombre,$email,$hoy,$textArea);
				}
			}

			if(isset($_POST["edit-comment-text"]) and isset($_POST["edit-comment-id"])) {
				// Editar comentario recibido en POST e identificado por 'edit-comment-id'
			}
		}

		// Borrar comentario (acción de moderador)
		if(isset($_GET["delete_comment"])) {
			$database->deleteComment($_GET["delete_comment"]);
		}

		// Si estamos en evento, recuperamos los comentarios para ese evento
		$event_data = $database->getEventById($event);
		$db_comentarios = $database->getComentarioById($event);

		// Imágenes y vídeos del evento
		// HAY QUE CAMBIARLO
		if($event==2){
			$imagen1= $database->getImagenById($event,2);
			$imagen2= $database->getImagenById($event,3);
		}else if($event==1){
			$imagen1= $database->getImagenById($event,9);
			$imagen2= $database->getImagenById($event,9);
		}else if($event==3){
			$imagen1= $database->getImagenById($event,10);
			$imagen2= $database->getImagenById($event,10);
		}else if($event==4){
			$imagen1= $database->getImagenById($event,11);
			$imagen2= $database->getImagenById($event,11);
		}
		$gallery= $database->getEventPhotos($event);
		$galleryVideos = $database->getEventVideos($event);

		// Etiquetas asociadas al evento actual
		$event_tags = $database->getEventTags($event);



	}
	else if($page == "evento_imprimir"){
		$event_data = $database->getEventById($event);
		$imagen1= $database->getImagenById($event,2);
		$galleryVideos = $database->getEventVideos($event);
	}
	else if($page == "eventos_etiqueta") {
		$num_tags = $database->countTags();
		if (!empty($_GET)){
			// Obtenemos la variable 'tag'
			if(isset($_GET['tag']) and $_GET['tag']>0 and $_GET['tag']<=$num_tags) {
				$tag = $_GET['tag'];
			}
		}
		$events_by_tag = $database->getEventsByTag($tag);
		$tag_name = $database->getTagName($tag);
	}
	else if($page == "general"){
		$general_info = $database->getGeneralInfoPage();
	}
	else if($page == "panel") {
		if (!empty($_POST)){

		// Obtenemos la variable 'page'
		if(isset($_POST['page']) and file_exists($_POST['page'].'.php') ) {
			$page = $_POST['page'];
		}

		// Editar Datos
		if(isset($_POST['nombreDP']) and isset($_POST['emailDP']) and
		isset($_POST['fechaDP']) and isset($_POST['accionDP'])) {
			$nombre = $_POST['nombreDP'];
			$email = $_POST['emailDP'];
			$fecha = $_POST['fechaDP'];

			$save = $database->updateDatos($nombre, $fecha ,$email);
		}

		// Nuevo comentario
		if(isset($_POST['nombreC']) and isset($_POST['descripcionC']) and
		isset($_POST['idEventoC']) and isset($_POST['accionC'])) {
			$nombreC=$_POST['nombreC'];
			$emailC=$_POST['emailC'];
			$descripcionC = $_POST['descripcionC'];
			$eventC = $_POST['idEventoC'];
			$accionC = $_POST['accionC'];
			$Ip = get_ip_address();
			$hoy = getdate();

			for ($i = 0; $i < count($nombreC); $i++) {
				$save = $database->saveComent($eventC[$i],$Ip,$nombreC[$i],$emailC[$i],$hoy,$descripcionC[$i]);
			}
		}

		// Editar comentario
		if(isset($_POST['idCM']) and isset($_POST['descripcionCM'])
		and isset($_POST['accionCM'])) {
			$idM=$_POST['idCM'];
			$desM=$_POST['descripcionCM'];

			$save = $database->editComment($desM, $idM);
		}

		// Eliminar comentario
		if(isset($_POST['idCD']) and isset($_POST['accionCD'])) {
			if($_POST['accionCD']==2){
				$id=$_POST['idCD'];
				$saves = $database->borrarComentario($id);
			}
		}

		// Buscar comentario NO HECHO
		if(isset($_POST['signup-email']) and isset($_POST['signup-name']) and
		isset($_POST['signup-date']) and isset($_POST['signup-passwd']) and
		isset($_POST['signup-passwd2'])) {

		}

		// Nueva etiqueta
		if(isset($_POST['nombreE']) and isset($_POST['eventoE'])
		and isset($_POST['accionE'])) {
			$nombreE = $_POST['nombreE'];
			$eventE = $_POST['eventoE'];
			$accionE = $_POST['accionE'];

			for ($i = 0; $i < count($nombreE); $i++) {
				$save = $database->setNuevaEtiqueta($nombreE[$i]);
				$id =  $database->selectEtiqueta($nombreE[$i]);
				$save = $database->setEtiquetaEvento($eventE[$i], $id);
			}

		}

		// Editar etiqueta
		if(isset($_POST['idEM']) and isset($_POST['nombreEM'])
		and isset($_POST['accionEM'])) {

			$idM=$_POST['idEM'];
			$desM=$_POST['nombreEM'];

			$save = $database->updateEtiqueta($desM, $idM);
		}

		// Eliminar etiqueta
		if(isset($_POST['idED']) and isset($_POST['accionED'])) {
			$a=$_POST['accionED'];
			if($_POST['accionED']==2){
					$id=$_POST['idED'];
					$saves = $database->deleteEtiquetado($id);
					if($saves==1){
						$saves = $database->deleteEtiqueta($id);
					}
				}
		}

		// Nuevo Evento
		if(isset($_POST['nombreEv']) and isset($_POST['descripcionEv']) and
		isset($_POST['autorEv']) and isset($_POST['miniaturaEv'])
		and isset($_POST['accionEv'])) {
			$nombreEv=$_POST['nombreEv'];
			$descripcionEv = $_POST['descripcionEv'];
			$autorEv = $_POST['autorEv'];
			$miniaturaEv = $_POST['miniaturaEv'];
			$hoy = getdate();

			for ($i = 0; $i < count($nombreEv); $i++) {
				$save = $database->setEvento ($nombreEv[$i],$hoy,$autorEv[$i],$descripcionEv[$i],$miniaturaEv[$i]);
			}
		}

		// Editar Evento
		if(isset($_POST['idEvM']) and isset($_POST['descripcionEvM'])
		and isset($_POST['nombreEvM']) and isset($_POST['miniEvM'])
		and isset($_POST['accionEvM'])) {
			$hoy = getdate();
			$id=$_POST['idEvM'];
			$nombre=$_POST['nombreEvM'];
			$descripcion=$_POST['descripcionEvM'];
			$mini=$_POST['miniEvM'];
			$publicado=$_POST['publicadoEvM'];
			if(strcmp($publicado,'si')==0){
				$publicado=1;
			}else{
				$publicado=0;
			}
			$save = $database->updateEvento ($id,$nombre,$hoy,$descripcion,$publicado,$mini);

		}

		// Eliminar Evento
		if(isset($_POST['idEvD']) and isset($_POST['accionEvD'])) {
			if($_POST['accionEvD']==2){
				$id=$_POST['idEvD'];
				$saves = $database->borrarComentariosEvento($id);
				if($saves==1){
					$saves = $database->deleteEtiquetadoEvento($id);
					if($saves==1){
						$saves = $database->deleteImagenEvento($id);
						if($saves==1){
							$saves = $database->deleteVideosEvento($id);
							if($saves==1){
								$saves = $database->deleteEvento($id);
							}
						}
					}
				}
			}
		}

		// Buscar Evento NO HECHO
		if(isset($_POST['signup-email']) and isset($_POST['signup-name']) and
		isset($_POST['signup-date']) and isset($_POST['signup-passwd']) and
		isset($_POST['signup-passwd2'])) {

		}

		// Nueva Imagen
		if(isset($_POST['nombreIm']) and isset($_POST['rutaIm']) and
		isset($_POST['pieIm']) and isset($_POST['creditosIm']) and
		isset($_POST['rutaCreditosIm']) and isset($_POST['eventoIm'])
		and isset($_POST['accionI'])) {

			$nombreIm=$_POST['nombreIm'];
			$rutaIm=$_POST['rutaIm'];
			$pieIm = $_POST['pieIm'];
			$creditosIm = $_POST['creditosIm'];
			$rutaCreditosIm=$_POST['rutaCreditosIm'];
			$eventoIm = $_POST['eventoIm'];

			for ($i = 0; $i < count($nombreIm); $i++) {
			$save = $database->setFotografia($nombreIm[$i],$pieIm[$i],$rutaIm[$i],$creditosIm[$i],$rutaCreditosIm[$i],$eventoIm[$i]);

			}
		}

		// Eliminar Imagen
		if(isset($_POST['idImD']) and isset($_POST['accionImD'])) {
			$id=$_POST['idImD'];
			$saves = $database->deleteImagen($id);
		}

		// Editar Imagen
		if(isset($_POST['idImM']) and isset($_POST['nombreImM'])
		and isset($_POST['rutaImM']) and isset($_POST['pieImM'])
		and isset($_POST['creditosImM']) and isset($_POST['urlCreImM'])
		and isset($_POST['accionImM'])) {
			$id =$_POST['idImM'];
			$nombre =$_POST['nombreImM'];
			$ruta = $_POST['rutaImM'];
			$pie = $_POST['pieImM'];
			$creditos =$_POST['creditosImM'];
			$url =$_POST['urlCreImM'];

			$save = $database->updateImagen ($id,$nombre,$pie,$ruta,$creditos,$url);

		}

		// Editar Rol
		if(isset($_POST['emailUM']) and isset($_POST['rolUM'])
		and isset($_POST['accionUM'])) {
			$email =$_POST['emailUM'];
			$rol =$_POST['rolUM'];

			$save = $database->updateRol ($email,$rol);
		}
	}

		if(isset($_SESSION['email'])) {
			$nombreUsuario = $database->SelectUsuario($_SESSION['email']);
			$birthdate = $database->getUserBirthdate($_SESSION['email']);
			$allComentarios = $database->todosComentarios();
			$allEtiquetas = $database->todasEtiquetas();
			$allEventos = $database->todosEventos();
			$allImagenes = $database->todasImagenes();
			$allUsuarios = $database->todosUsuarios();
		}
	}
	else if($page == "editar_comentario") {
		if (!empty($_GET)){
			if(isset($_GET{"edit_comment"})) {
				$comment_to_be_edited_id = $_GET{"edit_comment"};
				$comment_to_be_edited_text = $database->getCommentDescription($comment_to_be_edited_id);
			}
			else {
				$page = 'portada';
			}
		}
		else {
			$page = 'portada';
		}
	}

	/*
		HACER PÁGINA/S DE "NO DISPONIBLE" PARA VARIABLES CON VALORES INVÁLIDOS
	*/

	require($page.".php");

?>
