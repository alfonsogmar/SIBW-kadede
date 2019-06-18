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
	public function getEventsNamesAndThumbnails() {
		$sql_query = "SELECT Id, Nombre, Miniatura FROM evento;";
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

	function saveComent($evento,$Ip,$nombre,$correo,$hoy,$texto) {
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
	
	// Funciones de Moderador
	public function setComentarioModificado($texto, $id){
		$texto=$texto.' "Mensaje editado por un moderador"';
		$sql_query = "UPDATE comentarios SET Descripcion=? WHERE Id=?;";
		$stmt->bind_param('s',$id);
	
		if($result = $this->connection->query($sql_query)) {
			//echo("OK");
		}
		else {
			echo("Error insertando");
		}

    return $result;
	}
	
	// Funciones de Gestor
	public function setNuevaEtiqueta($nombre){
		$sql_query = "INSERT INTO etiquetas (Nombre) VALUES (?);";
		$stmt->bind_param('s',$nombre);
	
		if($result = $this->connection->query($sql_query)) {
			//echo("OK");
		}
		else {
			echo("Error insertando");
		}

		return $result;
	}
	
	public function deleteEtiqueta($id){
		$sql_query = "DELETE FROM etiquetas WHERE Id=?;";
		$stmt->bind_param('s',$id);
	
		if($result = $this->connection->query($sql_query)) {
			//echo("OK");
		}
		else {
			echo("Error insertando");
		}

		return $result;
	}
	
	public function setEtiquetaEvento($id_evento, $id_etiqueta){
		$sql_query = "INSERT INTO etiquetaado (Id_eventos, Id_etiqueta) VALUES (?,?);";
		$stmt->bind_param('s',$id_evento);
		$stmt->bind_param('s',$id_etiqueta);
		
		if($result = $this->connection->query($sql_query)) {
			//echo("OK");
		}
		else {
			echo("Error insertando");
		}

		return $result;
	}
	
	public function setEvento ($nombre,$hoy,$autor,$descripcion,$miniatura){
		$fecha = $hoy['year']."-".$hoy['mon']."-".$hoy['mday'];
		$hora = $hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];
		
		$sql_query = "INSERT INTO evento (Nombre,Fecha,Hora,FechaModificacion,HoraModificacion,Autor,Descripcion,Miniatura) VALUES (?,?,?,?,?,?,?,?);";
		$stmt->bind_param('s',$nombre);
		$stmt->bind_param('s',$fecha);
		$stmt->bind_param('s',$hora);
		$stmt->bind_param('s',$fecha);
		$stmt->bind_param('s',$hora);
		$stmt->bind_param('s',$autor);
		$stmt->bind_param('s',$descripcion);
		$stmt->bind_param('s',$miniatura);
	
		if($result = $this->connection->query($sql_query)) {
			//echo("OK");
		}
		else {
			echo("Error insertando");
		}

		return $result;
	}
	
	public function updateEvento ($id,$nombre,$hoy,$descripcion,$miniatura){
		$fecha = $hoy['year']."-".$hoy['mon']."-".$hoy['mday'];
		$hora = $hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];
		
		$sql_query = "UPDATE evento SET Nombre=?, FechaModificacion=? ,HoraModificacion=?, Descripcion=?, Miniatura=? WHERE Id=?;";
		$stmt->bind_param('s',$nombre);
		$stmt->bind_param('s',$fecha);
		$stmt->bind_param('s',$hora);
		$stmt->bind_param('s',$descripcion);
		$stmt->bind_param('s',$miniatura);
		$stmt->bind_param('s',$id);
	
		if($result = $this->connection->query($sql_query)) {
			//echo("OK");
		}
		else {
			echo("Error insertando");
		}

		return $result;
	}
	
	public function deleteEvento ($id){
		$sql_query = "DELETE FROM eventos WHERE Id=?;";
		$stmt->bind_param('s',$id);
	
		if($result = $this->connection->query($sql_query)) {
			//echo("OK");
		}
		else {
			echo("Error insertando");
		}

		return $result;
	}

	public function setFotografia ($nombre,$textoPie,$path,$credito,$url,$id_evento){
		
	$sql_query = "INSERT INTO imagen (Nombre,TextoPie,Path,Creditos,UrlCreditos,Id_Eventos) VALUES (?,?,?,?,?,?);";
		$stmt->bind_param('s',$nombre);
		$stmt->bind_param('s',$textoPie);
		$stmt->bind_param('s',$path);
		$stmt->bind_param('s',$credito);
		$stmt->bind_param('s',$url);
		$stmt->bind_param('s',$id_evento);
	
		if($result = $this->connection->query($sql_query)) {
			//echo("OK");
		}
		else {
			echo("Error insertando");
		}

		return $result;
	}

	public function deleteFotografia ($id){	
	$sql_query = "DELETE FROM imagen WHERE Id=?;";
		$stmt->bind_param('s',$id);
	
		if($result = $this->connection->query($sql_query)) {
			//echo("OK");
		}
		else {
			echo("Error insertando");
		}

		return $result;
	}
	
	// Funciones Superusuario (todas las anteriores mas las siguientes)
	public function updateRol ($email,$rol){
		
		$sql_query = "UPDATE usuarios SET Rol=? WHERE Email=?;";
		$stmt->bind_param('s',$rol);
		$stmt->bind_param('s',$email);
	
		if($result = $this->connection->query($sql_query)) {
			//echo("OK");
		}
		else {
			echo("Error insertando");
		}

		return $result;
	}
	
}	
?>
