<?php

# Interfaz de conexión a base de datos orientada a objetos
class DatabaseHandler {
	private $connection;
	private $host = "localhost";
	private $username = "kadede_user";
	private $password = "kadede_User123_user";
	private $database = "kadede";

	// Constructor
	public function __construct() {
		$this->connection = new mysqli($this->host, $this->username,
			$this->password, $this->database);

			if ($this->connection->connect_errno) {
			    echo "Fallo al conectar a MySQL: ".$this->connection->connect_error;
			}

			$this->connection->set_charset("utf8");
	}

	public function __destruct() {
		$this->connection->close();
	}

	public function getNumberOfEvents() {
		$sql_query = "SELECT COUNT(*) FROM evento";
		if($this->connection->ping()) {
			$result = $this->connection->query($sql_query);
			if($row = $result->fetch_assoc()) {
				/* Depuración
				$row_keys = array_keys($row);
				for($i = 0, $size = count($row_keys); $i < $size; ++$i) {
    			echo($row_keys[$i]);
				}
				*/
				$count = $row['COUNT(*)'];
			}
			else {
				$count = -1;
			}
		}
		else {
			echo "Sin conexión con BD";
			$count = -1;
		}
		return $count;
	}

	// Devuelve diccionario con los datos de UN SOLO EVENTO dado su Id
	public function getEventById($event_id) {
		$sql_query = "SELECT * FROM evento WHERE Id=".$this->connection->real_escape_string($event_id).";";
		$result = $this->connection->query($sql_query);
		if($row = $result->fetch_assoc()){
			$event_info = [
				"id" => $row["Id"],
				"name" => $row["Nombre"],
				"date" => $row["Fecha"],
				"time" => $row["Hora"],
				"dateM" => $row["FechaModificacion"],
				"timeM" => $row["HoraModificacion"],
				"author" => $row["Autor"],
				"description" => $row["Descripcion"],
				"thumbnail" => $row["Miniatura"]
			];
		}
		return $event_info;
	}

	public function getNumComentarios($event_id){
		$sql_query = "SELECT max(id) AS ID  FROM comentarios;";// WHERE Id_Eventos=".$event_id.";";
		$result = $this->connection->query($sql_query);
		if($row = $result->fetch_assoc()){
			$num_comentarios=[
				"id" => $row["ID"]
			];
		}
		return $num_comentarios;
	}

	// Devuelve la fecha configurada
	public function reg_date($dt) {
		$day = array("Domingo,", "Lunes,", "Martes,", "Miércoles,", "Jueves,", "Viernes," ,"Sábado,");
		$month = array("","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		date_default_timezone_set("Europe/Madrid");
		$fecha_reg = $day[date('w', $dt)].date(" d", $dt)." de ".$month[date('n', $dt)]." de ".date("Y", $dt)." a las ".date("G:i", $dt)." hrs.";
		return $fecha_reg;
	}

	// Para portada
	public function getEventsNamesAndThumbnails($published_only) {
		if($published_only) {
		$sql_query = "SELECT Id, Nombre, Miniatura FROM evento WHERE Publicado = 1;";
		}
		else {
			$sql_query = "SELECT Id, Nombre, Miniatura FROM evento;";
		}
		$result = $this->connection->query($sql_query);

		$events_info = [];

		while($row = $result->fetch_assoc()){
			$event_row = [
				"id" => $row["Id"],
				"name" => $row["Nombre"],
				"thumbnail" => $row["Miniatura"]
			];
			array_push($events_info, $event_row);
		}
		return $events_info;
	}

	public function getComentarioById($event_id){
		$comments_inf = [];

		$sql_query = "SELECT * FROM comentarios WHERE Id_Eventos=".$event_id.";";
		if($result = $this->connection->query($sql_query))
		{
			while($row = $result->fetch_assoc()){
				$comment_row = [
					"id" => $row["Id"],
					"name" => $row["Nombre"],
					"date" => $row["Fecha"],
					"time" => $row["Hora"],
					"description" => $row["Descripcion"]
				];
				array_push($comments_inf,$comment_row);
			}
		}
		else {
			echo("Error al consultar comentarios en BD");
		}
		return $comments_inf;
	}

	public function getImagenById($event_id,$id){
		$sql_query = "SELECT * FROM imagen WHERE id=".$id." and Id_Eventos=".$event_id.";";
		$result = $this->connection->query($sql_query);
		if($row = $result->fetch_assoc()){
			$image_info = [
				"name" => $row["Nombre"],
				"txtpie" => $row["TextoPie"],
				"path" => $row["Path"],
				"credit" => $row["Creditos"],
				"pathcredit" => $row["UrlCreditos"]
			];
		}
		return $image_info;
	}

	public function getEventPhotos($event_id) {
		$sql_query = "SELECT * FROM imagen WHERE Id_Eventos=".$event_id.";";
		$result = $this->connection->query($sql_query);

		$event_photos = [];

		while($row = $result->fetch_assoc()){
			$photo_info=[
				"id" => $row["Id"],
				"name" => $row["Nombre"],
				"txtpie" => $row["TextoPie"],
				"path" => $row["Path"],
				"credit" => $row["Creditos"],
				"pathcredit" => $row["UrlCreditos"]
			];
			array_push($event_photos, $photo_info);
		}
		return $event_photos;
	}

	public function getEventVideos($event_id) {
		$sql_query = "SELECT * FROM videos WHERE Id_Eventos=".$event_id.";";
		$result = $this->connection->query($sql_query);

		$event_videos = [];

		while($row = $result->fetch_assoc()){
			$video_info=[
				"id" => $row["Id"],
				"name" => $row["Nombre"],
				"path" => $row["Path"]
			];
			array_push($event_videos, $video_info);
		}
		return $event_videos;
	}

	public function saveComent($evento,$Ip,$nombre,$correo,$hoy,$texto) {
		$fecha = $hoy['year']."-".$hoy['mon']."-".$hoy['mday'];
		$hora = $hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];
		$sql_query = "INSERT INTO comentarios (Nombre, Fecha, Hora, Email, Descripcion, IP, Id_Eventos) VALUES ('".$nombre."','".$fecha."','".$hora."','".$correo."','".$texto."','".$Ip."','".$evento."');";

		if($result = $this->connection->query($sql_query)) {
			//echo("OK");
		}
		else {
			echo("Error insertando");
		}

    return $result;
	}

	/*public function deleteComment($comment_id) {
		$sql_query = "DELETE FROM comentarios WHERE Id=?;";
		$stmt = $this->connection->prepare($sql_query);
		if($stmt === False) {
			echo("Error al preparar sentencia SQL");
		}
		else{
			$stmt->bind_param('s',$param_comment);
			$param_comment = intval($comment_id);
			$success = $stmt->execute();
			if(!$success) {
				echo("Error al intentar borrar comentario de BD");
			}
		}


	}*/

	public function getTagName($tag_id) {
		$sql_query = "SELECT Id, Nombre FROM etiquetas WHERE Id=".$tag_id.";";
		$name = "";
		if ($result = $this->connection->query($sql_query)) {
			if($row = $result->fetch_assoc()) {
				$name = $row["Nombre"];
			}
		}
		return $name;
	}

	public function countTags() {
		$sql_query = "SELECT COUNT(*) FROM etiquetas";
		$count = -1;
		if ($result = $this->connection->query($sql_query)) {
			if($row = $result->fetch_assoc()) {
				$count = $row['COUNT(*)'];
			}
		}
		return $count;
	}

	public function getAllTags() {
		$sql_query = "SELECT Id, Nombre FROM etiquetas;";
		$tags = [];
		if ($result = $this->connection->query($sql_query)) {
			while($row = $result->fetch_assoc()) {
				$tag_array = [
					"id" => $row["Id"],
					"name" => $row["Nombre"]
				];
				array_push($tags,$tag_array);
			}
		}
		return $tags;
	}

	public function getEventTags($event_id) {
		$sql_query = "SELECT  etiquetas.Id, etiquetas.Nombre
		FROM etiquetas INNER JOIN etiquetado
		on etiquetas.Id = etiquetado.Id_etiqueta
		WHERE etiquetado.Id_Eventos=".$event_id.";";
		$tags = [];
		if ($result = $this->connection->query($sql_query)) {
			while($row = $result->fetch_assoc()) {
				$tag_array = [
					"id" => $row["Id"],
					"name" => $row["Nombre"]
				];
				array_push($tags,$tag_array);
			}
		}
		return $tags;
	}

	public function getEventsByTag($tag_id) {
		$sql_query = "SELECT evento.Id, evento.Nombre, evento.Miniatura, etiquetado.Id_eventos
		FROM evento INNER JOIN etiquetado ON evento.Id = etiquetado.Id_eventos
		WHERE etiquetado.Id_etiqueta = ".$tag_id.";";
		$events = [];
		if($result = $this->connection->query($sql_query)) {
			while($row = $result->fetch_assoc()) {
				$event_info = [
					'id' => $row['Id'],
					'name' => $row['Nombre'],
					'thumbnail' => $row['Miniatura']
				];
				array_push($events, $event_info);
			}
		}
		return $events;
	}

	public function getGeneralInfoPage() {
		$general_info_array = [];
		$sql_query = "SELECT * FROM general;";
		if($result = $this->connection->query($sql_query)) {
			if($row = $result->fetch_assoc()) {
				$general_info_array = [
					'title' => $row["Titulo"],
					'body' => $row["Cuerpo"]
				];
			}
		}
		return $general_info_array;
	}

	public function signInUser($user_email,$user_name, $user_date, $user_psswd) {
		$sql_query = "INSERT INTO usuarios(Email, Nombre, Fecha_Nacimiento, Passwd ,Rol)
		VALUES(?, ?, ?, ?, ?);";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('sssss',$param_email, $param_name, $param_date, $hashed_psswd, $param_rol);
		$param_name = $user_name;
		$param_email = $user_email;
		$param_date = $user_date;
		$param_rol = 'registered';
		$hashed_psswd = password_hash($user_psswd, PASSWORD_DEFAULT);
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
	}

	public function findEmail($user_email) {
		$valid = False;
		$sql_query = "SELECT Email from usuarios WHERE Email=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('s',$param_email);
		$param_email = $user_email;
		$success = $stmt->execute();
		if($success) {
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()) {
				$valid = False;
			}
		}
		else {
			echo("Error al consultar base de datos");
			$valid = False;
		}
		return $valid;
	}

	public function checkEmailAndPassword($user_email, $user_psswd) {
		$sql_query = "SELECT Email, Passwd from usuarios WHERE Email=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('s',$param_email);
		$param_email = $user_email;
		$success = $stmt->execute();
		if($success) {
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()) {
				$stored_psswd = $row['Passwd'];
				$match = password_verify($user_psswd,$stored_psswd);
			}
			else {
				$match = False;
			}
		}
		else {
			echo("Error al consultar base de datos");
			$match = False;
		}
		return $match;
	}

	public function getUserName($user_email) {
		$user_name = "";
		$sql_query = "SELECT Nombre from usuarios WHERE Email=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('s',$param_email);
		$param_email = $user_email;
		$success = $stmt->execute();
		if($success) {
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()) {
				$user_name = $row['Nombre'];
			}
		}
		return $user_name;
	}

	public function getUserRol($user_email) {
		$user_rol = "";
		$sql_query = "SELECT Rol from usuarios WHERE Email=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('s',$param_email);
		$param_email = $user_email;
		$success = $stmt->execute();
		if($success) {
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()) {
				$user_rol = $row['Rol'];
			}
		}
		return $user_rol;
	}

	public function getUserBirthdate($user_email) {
		$user_birthdate = "";
		$sql_query = "SELECT Fecha_Nacimiento from usuarios WHERE Email=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('s',$param_email);
		$param_email = $user_email;
		$success = $stmt->execute();
		if($success) {
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()) {
				$user_birthdate = $row['Fecha_Nacimiento'];
			}
		}
		return $user_birthdate;
	}

	// FUNCIONES PARA INTRODUCIR USUARIOS ESPECIALES EN LA BASE DE DATOS
	public function saveMod() {
		$sql_query = "INSERT INTO usuarios(Email, Nombre, Fecha_Nacimiento, Passwd ,Rol)
		VALUES(?, ?, ?, ?, ?);";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('sssss',$param_email, $param_name, $param_date, $hashed_psswd, $param_rol);
		$param_name = "moderador1";
		$param_email = "moderador@kadede.es";
		$param_date = "1970-01-01";
		$param_rol = "mod";
		$hashed_psswd = password_hash("123", PASSWORD_DEFAULT);
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
	}

	public function saveManager() {
		$sql_query = "INSERT INTO usuarios(Email, Nombre, Fecha_Nacimiento, Passwd ,Rol)
		VALUES(?, ?, ?, ?, ?);";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('sssss',$param_email, $param_name, $param_date, $hashed_psswd, $param_rol);
		$param_name = "gestor1";
		$param_email = "gestor@kadede.es";
		$param_date = "1970-01-01";
		$param_rol = "manager";
		$hashed_psswd = password_hash("123", PASSWORD_DEFAULT);
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
	}

	public function saveSuper() {
		$sql_query = "INSERT INTO usuarios(Email, Nombre, Fecha_Nacimiento, Passwd ,Rol)
		VALUES(?, ?, ?, ?, ?);";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('sssss',$param_email, $param_name, $param_date, $hashed_psswd, $param_rol);
		$param_name = "root";
		$param_email = "root@kadede.es";
		$param_date = "1970-01-01";
		$param_rol = "super";
		$hashed_psswd = password_hash("123", PASSWORD_DEFAULT);
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
	}
	//Funciones Todos
	public function updateDatos($nombre, $fecha ,$email){
		$sql_query = "UPDATE usuarios SET Nombre=?, Fecha_Nacimiento=? WHERE Email=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('sss',$param_nom,$param_fecha,$param_ema);

		$param_nom = $nombre;
		$param_fecha = $fecha;
		$param_ema = $email;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar actualizar comentario en BD");
		}

    return $success;
	}

	public function SelectUsuario($email){
		$comments_inf = [];

		$sql_query = 'SELECT Nombre FROM usuarios WHERE email=?;';
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('s',$param_text);
		$param_text = $email;
		$success = $stmt->execute();
		if($success) {
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()) {
				$user_name = $row['Nombre'];
			}
		}

		return $user_name;
	}

	// Funciones de Moderador
	public function editComment($text, $id){
		$sql_query = "UPDATE comentarios SET Descripcion=? WHERE Id=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('si',$param_text,$param_id);
		$param_id = $id;
		$param_text= $text;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar actualizar comentario en BD");
		}

    return $success;
	}

	public function borrarComentario($id){
		$sql_query = "DELETE FROM comentarios WHERE Id=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('i',$param_id);
		$param_id = $id;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
		return $success;
	}

	// Funciones de Gestor
	public function setNuevaEtiqueta($nombre){
		$sql_query = "INSERT INTO etiquetas (Nombre) VALUES (?);";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('s',$nombre);
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
		return $success;
	}

	public function selectEtiqueta($nombre){
		$sql_query = "SELECT id FROM etiquetas WHERE nombre=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('s',$nombre);
		$success = $stmt->execute();
		if($success) {
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()) {
				$id = $row['id'];
			}
		}
		return $id;
	}

	public function updateEtiqueta($text, $id){
		$sql_query = "UPDATE etiquetas SET Nombre=? WHERE Id=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('si',$param_text,$param_id);
		$param_id = $id;
		$param_text = $text;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar actualizar comentario en BD");
		}

    return $success;
	}

	public function deleteEtiquetado($id){
		$sql_query = "DELETE FROM etiquetado WHERE Id_Etiqueta=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('i',$param_id);
		$param_id = $id;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
		return $success;
	}

	public function deleteEtiqueta($id){
		$sql_query = "DELETE FROM etiquetas WHERE Id=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('i',$param_id);
		$param_id = $id;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
		return $success;
	}

	public function setEtiquetaEvento($id_evento, $id_etiqueta){
		$sql_query = "INSERT INTO etiquetado (Id_eventos, Id_etiqueta) VALUES (?,?);";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('ss',$id_evento, $id_etiqueta);
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
		return $success;
	}

	public function setEvento ($nombre,$hoy,$autor,$descripcion,$miniatura){
		$fecha = $hoy['year']."-".$hoy['mon']."-".$hoy['mday'];
		$hora = $hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];
		$publicado = 0;

		$sql_query = "INSERT INTO evento (Nombre,Fecha,Hora,FechaModificacion,HoraModificacion,Autor,Descripcion,Publicado,Miniatura) VALUES (?,?,?,?,?,?,?,?,?);";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('sssssssis',$nombre,$fecha,$hora,$fecha,$hora,$autor,$descripcion,$publicado,$miniatura);
		$success = $stmt->execute();

		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
		return $success;
	}

	public function updateEvento ($id,$nombre,$hoy,$descripcion,$publicado,$miniatura){
		$fecha = $hoy['year']."-".$hoy['mon']."-".$hoy['mday'];
		$hora = $hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];

		$sql_query = "UPDATE evento SET Nombre=?, FechaModificacion=? ,HoraModificacion=?, Descripcion=?, Publicado=?, Miniatura=? WHERE Id=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('ssssisi',$param_nom,$param_fm,$param_hm,$param_des,$param_pub, $param_min,$param_id);
		$param_id = $id;
		$param_nom = $nombre;
		$param_fm = $fecha;
		$param_hm = $hora;
		$param_des = $descripcion;
		$param_pub = $publicado;
		$param_min  = $miniatura;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar actualizar comentario en BD");
		}

		return $success;
	}

	public function borrarComentariosEvento($id){
		$sql_query = "DELETE FROM comentarios WHERE Id_Eventos=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('i',$param_id);
		$param_id = $id;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
		return $success;
	}

	public function deleteEtiquetadoEvento($id){
		$sql_query = "DELETE FROM etiquetado WHERE Id_Eventos=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('i',$param_id);
		$param_id = $id;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
		return $success;
	}

	public function deleteImagenEvento($id){
		$sql_query = "DELETE FROM imagen WHERE Id_Eventos=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('i',$param_id);
		$param_id = $id;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
		return $success;
	}

	public function deleteVideosEvento($id){
		$sql_query = "DELETE FROM videos WHERE Id_Eventos=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('i',$param_id);
		$param_id = $id;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
		return $success;
	}

	public function deleteEvento ($id){
		$sql_query = "DELETE FROM evento WHERE Id=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('i',$param_id);
		$param_id = $id;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
		return $success;
	}

	public function setFotografia ($nombre,$textoPie,$path,$credito,$url,$id_evento){

		$sql_query = "INSERT INTO imagen (Nombre,TextoPie,Path,Creditos,UrlCreditos,Id_Eventos) VALUES (?,?,?,?,?,?);";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('ssssss',$nombre,$textoPie,$path,$credito,$url,$id_evento);
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
		return $success;
	}

	public function deleteImagen($id){
		$sql_query = "DELETE FROM imagen WHERE Id=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('i',$param_id);
		$param_id = $id;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar insertar en BD");
		}
		return $success;
	}

	public function updateImagen ($id,$nombre,$txt,$path,$creditos,$url){
		$sql_query = "UPDATE imagen SET Nombre=?, TextoPie=? ,Path=?, Creditos=?, UrlCreditos=? WHERE Id=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('sssssi',$param_nom,$param_txt,$param_p,$param_c,$param_u,$param_id);
		$param_id = $id;
		$param_nom = $nombre;
		$param_txt = $txt;
		$param_p = $path;
		$param_c = $creditos;
		$param_u  = $url;
		$success = $stmt->execute();
		if(!$success) {
			echo("Error al intentar actualizar comentario en BD");
		}

    return $success;
	}

	// Funciones Superusuario (todas las anteriores mas las siguientes)
	public function updateRol ($email,$rol){
		$sql_query = 'SELECT count(*) FROM usuarios WHERE rol="super";';
		$stmt = $this->connection->prepare($sql_query);
		$success = $stmt->execute();
		if($success) {
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()) {
				$alone = $row['count(*)'];
			}
		}
		$sql_query = 'SELECT rol FROM usuarios WHERE email=?;';
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('s',$param_ema);
		$param_ema = $email;
		$success = $stmt->execute();
		if($success) {
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()) {
				$ex = $row['rol'];
			}
		}
		if($rol!="super"){
			if($ex=="super" and $alone>1){
				$sql_query = "UPDATE usuarios SET Rol=? WHERE Email=?;";
				$stmt = $this->connection->prepare($sql_query);
				$stmt->bind_param('ss',$param_rol,$param_ema);
				$param_ema = $email;
				$param_rol  = $rol;
				$success = $stmt->execute();
				if(!$success) {
					echo("Error al intentar actualizar comentario en BD");
				}
				return $success;
			}else if($ex!="super"){
				$sql_query = "UPDATE usuarios SET Rol=? WHERE Email=?;";
				$stmt = $this->connection->prepare($sql_query);
				$stmt->bind_param('ss',$param_rol,$param_ema);
				$param_ema = $email;
				$param_rol  = $rol;
				$success = $stmt->execute();
				if(!$success) {
					echo("Error al intentar actualizar comentario en BD");
				}
				return $success;
			}else{
				echo'<script type="text/javascript">
					alert("No se puede realizar la accion. Siempre debe existir al menos un Super Usuario.");
					</script>';
			}
		}else{
			$sql_query = "UPDATE usuarios SET Rol=? WHERE Email=?;";
			$stmt = $this->connection->prepare($sql_query);
			$stmt->bind_param('ss',$param_rol,$param_ema);
			$param_ema = $email;
			$param_rol  = $rol;
			$success = $stmt->execute();
			if(!$success) {
				echo("Error al intentar actualizar comentario en BD");
			}
			return $success;
		}
	}

	public function SelectSuper(){
		$comments_inf = [];

		$sql_query = 'SELECT count(*) FROM usuarios WHERE rol="super";';
		$stmt = $this->connection->prepare($sql_query);
		$success = $stmt->execute();
		if($success) {
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()) {
				$super = $row['count(*)'];
			}
		}

		return $super;
	}

	//Funciones para las tablas
	public function todosComentarios(){
		$comments_inf = [];
		$num=1;
		$sql_query = "SELECT * FROM comentarios;";
		if($result = $this->connection->query($sql_query))
		{
			while($row = $result->fetch_assoc()){
				$comment_row = [
					"num"=>$num,
					"id" => $row["Id"],
					"name" => $row["Nombre"],
					"date" => $row["Fecha"],
					"time" => $row["Hora"],
					"email" => $row["Email"],
					"description" => $row["Descripcion"],
					"ip" => $row["IP"],
					"idEvento" => $row["Id_Eventos"]
				];
				array_push($comments_inf,$comment_row);
				$num++;
			}
		}
		else {
			echo("Error al consultar comentarios en BD");
		}
		return $comments_inf;
	}

	public function todasEtiquetas(){
		$comments_inf = [];

		$sql_query = 'SELECT etiquetas.Id,etiquetas.Nombre, count(distinct etiquetado.Id_Eventos) "Eventos a los que afecta" FROM etiquetas, etiquetado WHERE etiquetas.Id = etiquetado.Id_Etiqueta GROUP BY etiquetas.Id,etiquetas.Nombre;';
		if($result = $this->connection->query($sql_query))
		{
			while($row = $result->fetch_assoc()){
				$comment_row = [
					"id" => $row["Id"],
					"name" => $row["Nombre"],
					"eventos"=> $row["Eventos a los que afecta"]
				];
				array_push($comments_inf,$comment_row);
			}
		}
		else {
			echo("Error al consultar comentarios en BD");
		}
		return $comments_inf;
	}

	public function todosEventos(){
		$comments_inf = [];

		$sql_query = 'SELECT * FROM evento;';
		if($result = $this->connection->query($sql_query))
		{
			while($row = $result->fetch_assoc()){
				$publico=$row["Publicado"];
				if($publico==1){
					$publico='si';
				}else{
					$publico='no';
				}
				$comment_row = [
					"id" => $row["Id"],
					"name" => $row["Nombre"],
					"date" => $row["Fecha"],
					"time" => $row["Hora"],
					"dateM" => $row["FechaModificacion"],
					"timeM" => $row["HoraModificacion"],
					"author" => $row["Autor"],
					"description" => $row["Descripcion"],

					"publicado" => $publico,
					"thumbnail" => $row["Miniatura"]
				];
				array_push($comments_inf,$comment_row);
			}
		}
		else {
			echo("Error al consultar comentarios en BD");
		}
		return $comments_inf;
	}

	public function todasImagenes(){
		$comments_inf = [];

		$sql_query = 'SELECT * FROM imagen;';
		if($result = $this->connection->query($sql_query))
		{
			while($row = $result->fetch_assoc()){
				$comment_row = [
					"id" => $row["Id"],
					"name" => $row["Nombre"],
					"txtpie" => $row["TextoPie"],
					"path" => $row["Path"],
					"credit" => $row["Creditos"],
					"pathcredit" => $row["UrlCreditos"],
					"idEvento" => $row["Id_Eventos"]
				];
				array_push($comments_inf,$comment_row);
			}
		}
		else {
			echo("Error al consultar comentarios en BD");
		}
		return $comments_inf;
	}

	public function todosUsuarios(){
		$comments_inf = [];

		$sql_query = 'SELECT * FROM usuarios;';
		if($result = $this->connection->query($sql_query))
		{
			while($row = $result->fetch_assoc()){
				$comment_row = [
					"email" => $row["Email"],
					"name" => $row["Nombre"],
					"nacimiento" => $row["Fecha_Nacimiento"],
					"rol" => $row["Rol"]
				];
				array_push($comments_inf,$comment_row);
			}
		}
		else {
			echo("Error al consultar comentarios en BD");
		}
		return $comments_inf;
	}

	public function getCommentDescription($comment_id) {
		$comment_text = "";
		$sql_query = "SELECT Descripcion FROM comentarios WHERE Id=?;";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('i',$param_id);
		$param_id = intval($comment_id);
		$success = $stmt->execute();
		if($success) {
			$result = $stmt->get_result();
			if($row = $result->fetch_assoc()) {
				$comment_text = $row['Descripcion'];
			}
		}
		else {
			echo("Error al consultar base de datos");
		}

		return $comment_text;
	}
	/**** Búsqueda de eventos y comentarios ****/

	public function searchComment($substring) {
	$found_comments = [];
	$sql_query = "SELECT * FROM comentarios;";
	$result = $this->connection->query($sql_query);
	while($row = $result->fetch_assoc()) {
		$comment_description = $row["Descripcion"];
		$comment_title = $row["Nombre"];
		$comment_email = $row["Email"];
		$comment_info = [
			"id" => $row["Id"],
			"name" => $row["Nombre"],
			"date" => $row["Fecha"],
			"time" => $row["Hora"],
			"email" => $row["Email"],
			"description" => $row["Descripcion"],
			"ip" => $row["IP"],
			"event_id" => $row["Id_Eventos"]
		];

		// Buscamos primero la subcadena en el nombre del autor
		$found_in_title = stripos($comment_title,$substring);
		if ($found_in_title !== false) {

			array_push($found_comments,$comment_info);
		}
		else {
			// Si no está en el nombre, buscamos en la descripción/cuerpo
			$found_in_description = stripos($comment_description,$substring);
			if ($found_in_description !== false) {
				array_push($found_comments,$comment_info);
			}
			else {
				// Si no tampoco está en la descripción, buscamos en la dirección
				// de correo
				$found_in_email = stripos($comment_email,$substring);
				if ($found_in_email !== false) {
					array_push($found_comments,$comment_info);
				}
			}
		}
	}
	//echo(count($found_comments));
	return $found_comments;
}

	public function searchEvents($substring) {
		$found_events = [];
		$sql_query = "SELECT * FROM evento;";
		$result = $this->connection->query($sql_query);
		while($row = $result->fetch_assoc()) {
			$event_description = $row["Descripcion"];
			$event_title = $row["Nombre"];
			$event_info = [
				"id" => $row["Id"],
				"name" => $row["Nombre"],
				"date" => $row["Fecha"],
				"time" => $row["Hora"],
				"dateM" => $row["FechaModificacion"],
				"timeM" => $row["HoraModificacion"],
				"author" => $row["Autor"],
				"description" => $row["Descripcion"],
				"thumbnail" => $row["Miniatura"]
			];

			// Buscamos primero la subcadena en el título
			$found_in_title = stripos($event_title,$substring);
			if ($found_in_title !== false) {
				array_push($found_events,$event_info);
			}
			else {
				// Si no está en el título, buscamos en la descripción/cuerpo
				// Buscamos primero la subcadena en el título
				$found_in_description = stripos($event_description,$substring);
				if ($found_in_description !== false) {
					array_push($found_events,$event_info);
				}
			}
		}
		return $found_events;
	}

	public function searchPublishedEvents($substring) {
		$found_events = [];
		$sql_query = "SELECT * FROM evento WHERE Publicado = 1;";
		$result = $this->connection->query($sql_query);
		while($row = $result->fetch_assoc()) {
			$event_description = $row["Descripcion"];
			$event_title = $row["Nombre"];
			$event_info = [
				"id" => $row["Id"],
				"name" => $row["Nombre"],
				"date" => $row["Fecha"],
				"time" => $row["Hora"],
				"dateM" => $row["FechaModificacion"],
				"timeM" => $row["HoraModificacion"],
				"author" => $row["Autor"],
				"description" => $row["Descripcion"],
				"thumbnail" => $row["Miniatura"]
			];

			// Buscamos primero la subcadena en el título
			$found_in_title = stripos($event_title,$substring);
			if ($found_in_title !== false) {
				array_push($found_events,$event_info);
			}
			else {
				// Si no está en el título, buscamos en la descripción/cuerpo
				// Buscamos primero la subcadena en el título
				$found_in_description = stripos($event_description,$substring);
				if ($found_in_description !== false) {
					array_push($found_events,$event_info);
				}
			}
		}
		return $found_events;
	}

	public function busquedaDinamica($consulta){
		$comments_inf = [];
		$sql_query = "SELECT * FROM evento WHERE Nombre LIKE ? OR Autor LIKE ? OR Descripcion LIKE ?; ";
		$stmt = $this->connection->prepare($sql_query);
		$stmt->bind_param('sss',$param_consulta,$param_consulta,$param_consulta);
		$param_consulta='%'.$consulta.'%';
		$success = $stmt->execute();
		if($success) {
			$result = $stmt->get_result();
			while($row = $result->fetch_assoc()) {
				$publico=$row["Publicado"];
				if($publico==1){
					$publico='si';
				}else{
					$publico='no';
				}
				$comment_row = [
					"id" => $row["Id"],
					"name" => $row["Nombre"],
					"date" => $row["Fecha"],
					"time" => $row["Hora"],
					"dateM" => $row["FechaModificacion"],
					"timeM" => $row["HoraModificacion"],
					"author" => $row["Autor"],
					"description" => $row["Descripcion"],
					"publicado" => $publico,
					"thumbnail" => $row["Miniatura"]
				];
				array_push($comments_inf,$comment_row);
			}
		}
		return $comments_inf;
	}

}

?>
