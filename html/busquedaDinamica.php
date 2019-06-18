<?php
	require './database.php';
	require './formValidator.php';
	session_start();

	
//Archivo de conexión a la base de datos
$database = new DatabaseHandler();
$num_events = $database->getNumberOfEvents();

			$consultaBusqueda = $_POST['valorBusqueda'];
			
			$consulta = $database->busquedaDinamica($consultaBusqueda);
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
				$fila = sizeof($consulta);
				
					//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
					if ($fila === 0) {
						$mensaje = "<p>No hay ningún usuario con ese nombre y/o apellido</p>";
					} else {
						//Si existe alguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
						echo '<strong>'.$fila.'</strong> Resultados para <strong>'.$consultaBusqueda.'</strong>';

						//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
						for($i=0;$i<$fila;$i++){
						//while($filas){
							$id = $consulta[$i]['id'];
							$nombre = $consulta[$i]['name'];
							$date = $consulta[$i]['date'];
							$time = $consulta[$i]['time'];
							$dateM = $consulta[$i]['dateM'];
							$timeM = $consulta[$i]['timeM'];
							$autor = $consulta[$i]['author'];
							$descripcion = $consulta[$i]['description'];
							$publicado = $consulta[$i]['publicado'];
							$thumbnail = $consulta[$i]['thumbnail'];

							//Output
							$mensaje .= '
							<p>
								<strong>Id:</strong> ' . $id . ' &nbsp &nbsp 
								<strong>Fecha Creacion:</strong> ' . $date . '  &nbsp &nbsp
								<strong>Hora Creacion:</strong> ' . $time . ' &nbsp &nbsp 
								<strong>Fecha Modificacion:</strong> ' . $dateM . ' &nbsp &nbsp
								<strong>Hora Modificacion:</strong> ' . $timeM . '
								<br>
								<br>
								<strong>Nombre:</strong> ' . $nombre . '&nbsp &nbsp
								<strong>Autor:</strong> ' . $autor . '&nbsp &nbsp
								<strong>Publicado:</strong> ' . $publicado . '&nbsp &nbsp
								<strong>Miniatura:</strong> ' . $thumbnail . '&nbsp &nbsp
								<br>
								<br>
								<strong>Descripcion:</strong> ' . $descripcion . '
								<br>
							</p>
							<br>
							<br>
							';

					
						}
					}
			}
			
echo $mensaje;

?>
