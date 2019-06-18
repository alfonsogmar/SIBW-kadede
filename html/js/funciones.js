	function ocultar(){
		document.getElementById('cajaComentarios').style.display = 'none';
	}

	function mostrar(){
		document.getElementById('cajaComentarios').style.display = 'block';
	}

	function ocultarBoton(){
		document.getElementById('ocultar').style.display = 'none';
		document.getElementById('mostrar').style.display = 'block';
	}

	function mostrarBoton(){
		document.getElementById('mostrar').style.display = 'none';
		document.getElementById('ocultar').style.display = 'block';
	}

	function validar() {
	  var nombre = document.forms["comment-form"]["nombreComentario"].value;
	  var email = document.forms["comment-form"]["emailComentario"].value;
	  var texto = document.forms["comment-form"]["textoComentario"].value;

	  if (nombre == "" || email == "" || texto == "" ) {
			alert("Todos los campos deben estar rellenos.");
			return false;
	  }else{
			var mailRegex = /[\w-]+@([\w-]+\.)+[\w-]+/;
			found = email.search(mailRegex);
			if(found == -1){
				alert("Por favor, introduzca un email válido.")
				return false;
			}
			else {
				var frm = document.getElementsByName('comment-form')[0];
				frm.reset();
				return true;
			}
	  }
	}

	function validarN(string){
		var modificado = string;
		var prohibidas = ["puta","mierda","cago","cabron","zorra","joder","muertos","cagar","mear","hostia"]
		var posicion;
		for(var i=0; i<prohibidas.length;i++){
			var palabra = prohibidas[i];
			var regex = new RegExp(palabra, "gi");
			posicion=modificado.search(regex);
		var tam= palabra.length;
			while(posicion>=0){
				modificado = modificado.slice(0,posicion)+"*****"+modificado.slice(posicion+tam);
				posicion = modificado.search(regex);
			}
		}
		document.getElementById("nombreComentario").value=modificado;
		return modificado;
	}

	function validarE(string){
		var modificado = string;
		var prohibidas =["puta","mierda","cago","cabron","zorra","joder","muertos","cagar","mear","hostia"]
		var posicion;
		for(var i=0; i<prohibidas.length;i++){
			var palabra = prohibidas[i];
			var regex = new RegExp(palabra, "gi");
			posicion=modificado.search(regex);
			var tam= palabra.length;
			while(posicion>=0){
				modificado = modificado.slice(0,posicion)+"*****"+modificado.slice(posicion+tam);
				posicion = modificado.search(regex);
			}

		}
		document.getElementById("emailComentario").value = modificado;
		return modificado;
	}

	function validarT(string){
		var modificado = string;
		var prohibidas =["puta","mierda","cago","cabron","zorra","joder","muertos","cagar","mear","hostia"]
		var posicion;
		for(var i=0; i<prohibidas.length;i++){
			var palabra = prohibidas[i];
			var regex = new RegExp(palabra, "gi");
			posicion=modificado.search(regex);
			var tam= palabra.length;
			while(posicion>=0){
				modificado = modificado.slice(0,posicion)+"*****"+modificado.slice(posicion+tam);
				posicion = modificado.search(regex);
			}

		}
		document.getElementById("textoComentario").value = modificado;
		return modificado;
	}

	function creaComentarios(){
		var f="";
		for(var i=1;i<=5;i++){
			f+='<div class="comment">'
			f+='<p class="comment-header"> El 21 de marzo de 2019 a las 11:47, {{comentario_creator['+i+']}} escribió: </p>'
			f+='{% for parag in comentario_body['+i+']%}'
			f+='<p>{{parag}}</p>'
			f+='{% endfor %}'
			f+='</div>'
		}
		document.getElementById("comments").innerHTML=f;
	}

	function insertComment(name, email, text) {

		// Array con meses en español
		var monthsInSpansh = new Array ("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");

		var newComment = document.createElement("DIV");
		var newCommentPar = document.createElement("P");

		newComment.className = "comment";

		var date = new Date();

		var newCommentHeader = document.createElement("P");
		newCommentHeader.className = "comment-header";

		var time = date.getHours() + ":" + date.getMinutes();
		var dateString = date.getDate() + " de " + monthsInSpansh[date.getMonth()] + " de " + date.getFullYear() + " a las " + time;
		var txtnode = document.createTextNode("El " + dateString + ", " + name + " escribió:" );
		newCommentHeader.appendChild(txtnode);

		var newText = text
		var censored = ""


		var newCommentbody = document.createElement("P");
		txtnode = document.createTextNode(text);
		newCommentbody.appendChild(txtnode);

		newComment.appendChild(newCommentHeader);
		newComment.appendChild(newCommentbody);
		document.getElementById("comments").appendChild(newComment);

	}

	function postear(site){
		alert(site);
	}

	function mostrarGaleria(lista) {
		if (document.getElementById) {
			document.getElementById('imgContenedor').src = lista.href;
			if (lista.title) {
				document.getElementById('imgDescripcion').childNodes[0].nodeValue = lista.title;
			} else {
				document.getElementById('imgDescripcion').childNodes[0].nodeValue = lista.childNodes[0].nodeValue;
			}
			return false;
		} else {
			return true;
		}
	}

	function mostrarGaleriaVideos(lista) {
		if (document.getElementById) {
			document.getElementById('videosContenedor').src = lista.href;
			if (lista.title) {
				document.getElementById('videosDescripcion').childNodes[0].nodeValue = lista.title;
			} else {
				document.getElementById('videosDescripcion').childNodes[0].nodeValue = lista.childNodes[0].nodeValue;
			}
			return false;
		} else {
			return true;
		}
	}

	//Abrir Ventana con imagen, pop-up
	var ventana
	var cont=0
	var titulopordefecto = "Compartir con el mundo"
	function afoto(cual,titulo,texto,texto2,texto3){
	if(cont==1){
		ventana.close();
		ventana=null
	}
	if(titulo==null){
		titulo=titulopordefecto
	}
	ventana=window.open('','ventana','resizable=no,sc rollbars=no,width=50,height=50')
	ventana.document.write('<html><head><title>' + titulo + '</title></head><body style="overflow:hidden" marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" scroll="no"  onUnload="opener.cont=0"><div align="center"><p>'+texto+'</p><p>'+texto2+' '+texto3+'</p> <a href="javascript:this.close()"><button type="button" onclick="ventana.document.close()">Aceptar</button><img class="thumbnail" src="' + cual + '" onLoad="opener.redimensionar(515, 420)" style="border:none;width:500px;height:300px;"></a></div>')
	ventana.document.close()
	cont++
	}

	function redimensionar(ancho, alto){
		ventana.resizeTo(ancho,alto+30)
		ventana.moveTo((screen.width-ancho)/2,(screen.height-alto)/2) //centra la ventana. Eliminar si no se quiere centrar el popup
	}

	//Funciones de las tablas
	function mostrarTabla(string){
		var t=string;

		document.getElementById('modificarDatos').style.display = 'none';
		document.getElementById('listadoComentarios').style.display = 'none';
		document.getElementById('buscarComentarios').style.display = 'none';
		document.getElementById('listadoEtiquetas').style.display = 'none';
		document.getElementById('listadoEventos').style.display = 'none';
		document.getElementById('buscarEventos').style.display = 'none';
		document.getElementById('listadoImagenes').style.display = 'none';
		document.getElementById('listadoUsuarios').style.display = 'none';

		document.getElementById('eliminaComentarios').style.display = 'none';
		document.getElementById('eliminaEtiquetas').style.display = 'none';
		document.getElementById('eliminaEventos').style.display = 'none';
		document.getElementById('eliminaImagenes').style.display = 'none';

		document.getElementById('modificaDatos').style.display = 'none';
		document.getElementById('modificaComentarios').style.display = 'none';
		document.getElementById('modificaEtiquetas').style.display = 'none';
		document.getElementById('modificaEventos').style.display = 'none';
		document.getElementById('modificaImagenes').style.display = 'none';
		document.getElementById('modificaUsuarios').style.display = 'none';

		document.getElementById('asignaEtiquetas').style.display = 'none';

		document.getElementById(t).style.display = 'block';

		if(string == "buscarComentarios") {
			location.href="../index.php?page=buscar_comentario";
		}
		else if(string == "buscarEventos") {
			location.href="../index.php?page=buscar_evento";
		}

	}

	$(document).ready(function(){
		$('.tabla').Tabledit({
			deleteButton: false,
			editButton: false,
			columns: {
			  identifier: [0, 'Id'],
			  editable: [[4, 'Descripcion']],
			},
			hideIdentifier: true,
			url: 'editarCeldaComentario.php'
		});

	});

	function crearFila(string) {
		//creo una nueva fila especifica para el boton que lo pulsa.
		var l=string;
		var c="tComentarios";
		var e="tEtiquetas";
		var ev="tEventos";
		var im="tImagenes";
		var u="tUsuarios";

		//Hay que ponerle un valor, Estilo "Esto se rellena automaticamente",
		//a los deshabilitados pero no funciona -.-"
		var i=l.localeCompare(c);
		if(i==0){
			var fila='<tr><td><input type="text" name="idC[]" disabled></td>'+
					'<td><input type="text" name="nombreC[]"></td>'+
					'<td><input type="text" name="fechaC[]" disabled></td>'+
					'<td><input type="text" name="horaC[]" disabled></td>'+
					'<td><input type="text" name="emailC[]"></td>'+
					'<td><input type="text" name="descripcionC[]"></td>'+
					'<td><input type="text" name="ipC[]" disabled></td>'+
					'<td><input type="text" name="idEventoC[]"></td></tr>';
					$('.tablaComentarios').append(fila);
					document.getElementById("accC").value = "0";
					document.getElementById("guardarC").className="visible";
					document.getElementById("nuevoC").className="oculto";
					document.getElementById("editarC").className="oculto";
					document.getElementById("borrarC").className="oculto";
		}

		var i=l.localeCompare(e);
		if(i==0){
			var fila='<tr><td><input type="text" name="idE[]" value="Valor Automatico" disabled></td>'+
					'<td><input type="text" name="nombreE[]"></td>'+
					'<td><input type="text" name="eventoE[]"></td></tr>';
					$('.tablaEtiquetas').append(fila);
			document.getElementById("accE").value = "0";
			document.getElementById("guardarE").className="visible";
			document.getElementById("nuevoE").className="oculto";
			document.getElementById("editarE").className="oculto";
			document.getElementById("borrarE").className="oculto";
		}

		var i=l.localeCompare(ev);
		if(i==0){
			var fila='<tr><td><input type="text" name="idEv[]" disabled></td>'+
					'<td><input type="text" name="nombreEv[]"></td>'+
					'<td><input type="text" name="fechaEv[]" value="Valor Automatico" disabled></td>'+
					'<td><input type="text" name="horaEv[]" value="Valor Automatico" disabled></td>'+
					'<td><input type="text" name="fechaMEv[]" value="Valor Automatico" disabled></td>'+
					'<td><input type="text" name="horaMEv[]" value="Valor Automatico" disabled></td>'+
					'<td><input type="text" name="descripcionEv[]"></td>'+
					'<td><input type="text" name="autorEv[]"></td>'+
					'<td><input type="text" name="publicado[]" value="Valor Automatico" disabled></td>'+
					'<td><input type="text" name="miniaturaEv[]"></td></tr>';
					$('.tablaEventos').append(fila);
			document.getElementById("accEv").value = "0";
			document.getElementById("guardarEv").className="visible";
			document.getElementById("nuevoEv").className="oculto";
			document.getElementById("editarEv").className="oculto";
			document.getElementById("borrarEv").className="oculto";
		}

		var i=l.localeCompare(im);
		if(i==0){
			var fila='<tr><td><input type="text" name="idIm[]" value="Valor Automatico" disabled></td>'+
					'<td><input type="text" name="nombreIm[]"></td>'+
					'<td><input type="text" name="rutaIm[]"></td>'+
					'<td><input type="text" name="pieIm[]"></td>'+
					'<td><input type="text" name="creditosIm[]"></td>'+
					'<td><input type="text" name="rutaCreditosIm[]"></td>'+
					'<td><input type="text" name="eventoIm[]"></td></tr>';
					$('.tablaImagenes').append(fila);
			document.getElementById("accI").value = "0";
			document.getElementById("guardarIm").className="visible";
			document.getElementById("nuevoIm").className="oculto";
			document.getElementById("editarIm").className="oculto";
			document.getElementById("borrarIm").className="oculto";
		}

		var i=l.localeCompare(u);
		if(i==0){
			var fila='<tr><td><input type="text" name="emailU[]" value="Valor Automatico" disabled></td>'+
					'<td><input type="text" name="nombreU[]" value="Valor Automatico" disabled></td>'+
					'<td><input type="text" name="rolU[]"></td></tr>';
					$('.tablaUsuarios').append(fila);
			document.getElementById("accU").value = "0";
		}

	};

	function eliminarFila(string) {
		//creo una nueva fila especifica para el boton que lo pulsa.
		var l=string;
		var c="tComentarios";
		var e="tEtiquetas";
		var ev="tEventos";
		var im="tImagenes";
		var u="tUsuarios";

		//Hay que ponerle un valor, Estilo "Esto se rellena automaticamente",
		//a los deshabilitados pero no funciona -.-"
		var i=l.localeCompare(c);
		if(i==0){
			var x = document.getElementsByName("borrarC");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "visible";
			}

		}

		var i=l.localeCompare(e);
		if(i==0){
				var x = document.getElementsByName("borrarE");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "visible";
			}
		}

		var i=l.localeCompare(ev);
		if(i==0){
				var x = document.getElementsByName("borrarEv");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "visible";
			}
		}

		var i=l.localeCompare(im);
		if(i==0){
				var x = document.getElementsByName("borrarI");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "visible";
			}
		}

		var i=l.localeCompare(u);
		if(i==0){
			var x = document.getElementsByName("borrarU");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "visible";
			}
		}

	};

	function borrado(fila,string,eliminar) {
		//creo una nueva fila especifica para el boton que lo pulsa.
		var l=string;
		var c="tComentarios";
		var e="tEtiquetas";
		var ev="tEventos";
		var im="tImagenes";
		var u="tUsuarios";
		var nodoTd = fila.parentNode; //Nodo TD
		var nodoTr = nodoTd.parentNode; //Nodo TR
		//var nodoContenedorForm = document.getElementById('contenedorForm'); //Nodo DIV
		var nodosEnTr = nodoTr.getElementsByTagName('td');

		//Hay que ponerle un valor, Estilo "Esto se rellena automaticamente",
		//a los deshabilitados pero no funciona -.-"
		var i=l.localeCompare(c);
		if(i==0){
			//document.getElementById(l).deleteRow(fila);
			var id = nodosEnTr[0].textContent;
			var nombre = nodosEnTr[1].textContent;
			var fecha = nodosEnTr[2].textContent;
			var hora = nodosEnTr[3].textContent;
			var email = nodosEnTr[4].textContent;
			var descripcion = nodosEnTr[5].textContent;
			var ip = nodosEnTr[6].textContent;
			var idEvento = nodosEnTr[7].textContent;

			document.getElementById('idCD').setAttribute("value", id);
			document.getElementById('idCDH').setAttribute("value", id);
			document.getElementById('nombreCD').setAttribute("value", nombre);
			document.getElementById('fechaCD').setAttribute("value", fecha);
			document.getElementById('horaCD').setAttribute("value", hora);
			document.getElementById('emailCD').setAttribute("value", email);
			document.getElementById('descripcionCD').innerHTML=descripcion;
			document.getElementById('ipCD').setAttribute("value", ip);
			document.getElementById('idEvCD').setAttribute("value", idEvento);

			document.getElementById("accCD").value = "2";
			mostrarTabla(eliminar);

		}

		var i=l.localeCompare(e);
		if(i==0){
			var id = nodosEnTr[0].textContent;
			var nombre = nodosEnTr[1].textContent;
			var eventos = nodosEnTr[2].textContent;

			document.getElementById('idED').setAttribute("value", id);
			document.getElementById('idEDH').setAttribute("value", id);
			document.getElementById('nombreED').setAttribute("value", nombre);
			document.getElementById('evED').setAttribute("value", eventos);

			document.getElementById("accED").value = "2";
			mostrarTabla(eliminar);
		}

		var i=l.localeCompare(ev);
		if(i==0){
			var id = nodosEnTr[0].textContent;
			var nombre = nodosEnTr[1].textContent;
			var fecha = nodosEnTr[2].textContent;
			var hora = nodosEnTr[3].textContent;
			var fechaM = nodosEnTr[4].textContent;
			var horaM = nodosEnTr[5].textContent;
			var descripcion = nodosEnTr[6].textContent;
			var autor = nodosEnTr[7].textContent;
			var miniatura = nodosEnTr[8].textContent;

			document.getElementById('idEvD').setAttribute("value", id);
			document.getElementById('idEvDH').setAttribute("value", id);
			document.getElementById('nombreEvD').setAttribute("value", nombre);
			document.getElementById('fechaEvD').setAttribute("value", fecha);
			document.getElementById('horaEvD').setAttribute("value", hora);
			document.getElementById('fechaEvMD').setAttribute("value", fechaM);
			document.getElementById('horaEvMD').setAttribute("value", horaM);
			document.getElementById('descripcionEvD').innerHTML=descripcion;
			document.getElementById('autorEvD').setAttribute("value", autor);
			document.getElementById('miniEvD').setAttribute("value", miniatura);

			document.getElementById("accEvD").value = "2";
			mostrarTabla(eliminar);
		}

		var i=l.localeCompare(im);
		if(i==0){
			var id = nodosEnTr[0].textContent;
			var nombre = nodosEnTr[1].textContent;
			var ruta = nodosEnTr[2].textContent;
			var pie = nodosEnTr[3].textContent;
			var creditos = nodosEnTr[4].textContent;
			var url = nodosEnTr[5].textContent;
			var evento = nodosEnTr[6].textContent;

			document.getElementById('idImD').setAttribute("value", id);
			document.getElementById('idImDH').setAttribute("value", id);
			document.getElementById('nombreImD').setAttribute("value", nombre);
			document.getElementById('rutaImD').setAttribute("value", ruta);
			document.getElementById('pieImD').setAttribute("value", pie);
			document.getElementById('creditosImD').setAttribute("value", creditos);
			document.getElementById('urlCreImD').setAttribute("value", url);
			document.getElementById('idEvImD').setAttribute("value", evento);

			document.getElementById("accImD").value = "2";
			mostrarTabla(eliminar);
		}

		var i=l.localeCompare(u);
		if(i==0){
			var x = document.getElementsByName("borrarU");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "visible";
			}
		}

	};

	function editarFila(string) {
		//creo una nueva fila especifica para el boton que lo pulsa.
		var l=string;
		var c="tComentarios";
		var e="tEtiquetas";
		var ev="tEventos";
		var im="tImagenes";
		var u="tUsuarios";
		var dp="tDatosPersonales";

		//Hay que ponerle un valor, Estilo "Esto se rellena automaticamente",
		//a los deshabilitados pero no funciona -.-"

		var i=l.localeCompare(c);
		if(i==0){
			var x = document.getElementsByName("editarC");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "visible";
			}
		}

		var i=l.localeCompare(e);
		if(i==0){
				var x = document.getElementsByName("editarE");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "visible";
			}
		}

		var i=l.localeCompare(ev);
		if(i==0){
				var x = document.getElementsByName("editarEv");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "visible";
			}
		}

		var i=l.localeCompare(im);
		if(i==0){
				var x = document.getElementsByName("editarI");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "visible";
			}
		}

		var i=l.localeCompare(u);
		if(i==0){
			var x = document.getElementsByName("editarU");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "visible";
			}
		}

		var i=l.localeCompare(dp);
		if(i==0){
			var x = document.getElementsByName("editarDP");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "visible";
			}
		}


	};

	function editado(fila,string,eliminar) {
		//creo una nueva fila especifica para el boton que lo pulsa.
		var l=string;
		var c="tComentarios";
		var e="tEtiquetas";
		var ev="tEventos";
		var im="tImagenes";
		var u="tUsuarios";
		var dp="tDatosPersonales";
		var nodoTd = fila.parentNode; //Nodo TD
		var nodoTr = nodoTd.parentNode; //Nodo TR
		var nodoContenedorForm = document.getElementById('modificaComentarios'); //Nodo DIV
		var nodosEnTr = nodoTr.getElementsByTagName('td');

		//Hay que ponerle un valor, Estilo "Esto se rellena automaticamente",
		//a los deshabilitados pero no funciona -.-"
		var i=l.localeCompare(c);
		if(i==0){
			//document.getElementById(l).deleteRow(fila);
			var id = nodosEnTr[0].textContent;
			var nombre = nodosEnTr[1].textContent;
			var fecha = nodosEnTr[2].textContent;
			var hora = nodosEnTr[3].textContent;
			var email = nodosEnTr[4].textContent;
			var descripcion = nodosEnTr[5].textContent;
			var ip = nodosEnTr[6].textContent;
			var idEvento = nodosEnTr[7].textContent;
			var nuevoCodigoHtml = '<tr id="'+id+'"><td><input type="text" name="idCE" id="idCN" value="'+id+'" size="5" disabled></td>'+
								'<td><input type="text" name="nombreCE" id="nombreCE" value="'+nombre+'" size="10" disabled></td>'+
								'<td><input type="text" name="fechaCE" id="fechaCE" value="'+fecha+'" size="10" disabled></td>'+
								'<td><input type="text" name="horaCE" id="horaCE" value="'+hora+'" size="5" disabled></td>'+
								'<td><input type="text" name="emailCE" id="emailCE" value="'+email+'" size="20" disabled></td>'+
								'<td><textarea name="descripcionCE" id="descripcionCE" size="50">'+descripcion+'</textarea></td>'+
								'<td><input type="text" name="ipCE" id="ipCE" value="'+ip+'" size="10" disabled></td>'+
								'<td><input type="text" name="idEvCE" id="idEvCE" value="'+idEvento+'" size="5" disabled></td>'+
								'<td>En edición</td></tr>';
			nodoTr.innerHTML = nuevoCodigoHtml;

			document.getElementById("ocultoEdC").setAttribute("value", id);
			document.getElementById("nuevoC").className="oculto";
			document.getElementById("editarC").className="oculto";
			document.getElementById("borrarC").className="oculto";
			document.getElementById("aceptarEdC").className="boton visible";
			document.getElementById("cancelarEdC").className="boton visible";
			document.getElementById("pEdC").className="visible";
			var x = document.getElementsByName("editarC");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "oculto";
			}

			document.getElementById('idCM').setAttribute("value", id);
			document.getElementById('idCMH').setAttribute("value", id);
			document.getElementById('nombreCM').setAttribute("value", nombre);
			document.getElementById('fechaCM').setAttribute("value", fecha);
			document.getElementById('horaCM').setAttribute("value", hora);
			document.getElementById('emailCM').setAttribute("value", email);
			document.getElementById('ipCM').setAttribute("value", ip);
			document.getElementById('idEvCM').setAttribute("value", idEvento);

			//mostrarTabla('modificaComentarios');
		}

		var i=l.localeCompare(e);
		if(i==0){
			var id = nodosEnTr[0].textContent;
			var nombre = nodosEnTr[1].textContent;
			var evento = nodosEnTr[2].textContent;
			var nuevoCodigoHtml = '<tr id="'+id+'"><td><input type="text" name="idEE" id="idEE" value="'+id+'" size="5" disabled></td>'+
								'<td><textarea name="nombreEE" id="nombreEE" size="50">'+nombre+'</textarea></td>'+
								'<td><input type="text" name="idEvEE" id="idEvEE" value="'+evento+'" size="5" disabled></td>'+
								'<td>En edición</td></tr>';
			nodoTr.innerHTML = nuevoCodigoHtml;

			document.getElementById("ocultoEdE").setAttribute("value", id);
			document.getElementById("nuevoE").className="oculto";
			document.getElementById("editarE").className="oculto";
			document.getElementById("borrarE").className="oculto";
			document.getElementById("aceptarEdE").className="boton visible";
			document.getElementById("cancelarEdE").className="boton visible";
			document.getElementById("pEdE").className="visible";
			var x = document.getElementsByName("editarE");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "oculto";
			}

			document.getElementById('idEM').setAttribute("value", id);
			document.getElementById('idEMH').setAttribute("value", id);
			//document.getElementById('nombreEM').setAttribute("value", nombre);
			document.getElementById('eventoEM').setAttribute("value", evento);

			document.getElementById("accEM").value = "2";
			//mostrarTabla(eliminar);
		}

		var i=l.localeCompare(ev);
		if(i==0){
			var id = nodosEnTr[0].textContent;
			var nombre = nodosEnTr[1].textContent;
			var fecha = nodosEnTr[2].textContent;
			var hora = nodosEnTr[3].textContent;
			var fechaM = nodosEnTr[4].textContent;
			var horaM = nodosEnTr[5].textContent;
			var descripcion = nodosEnTr[6].textContent;
			var autor = nodosEnTr[7].textContent;
			var publicado = nodosEnTr[8].textContent;
			var miniatura = nodosEnTr[9].textContent;
			var nuevoCodigoHtml = '<tr id="'+id+'"><td><input type="text" name="idEvE" id="idEvE" value="'+id+'" size="5" disabled></td>'+
								'<td><textarea type="text" name="nombreEvE" id="nombreEvE" size="50">'+nombre+'</textarea></td>'+
								'<td><input type="text" name="fechaEvE" id="fechaEvE" value="'+fecha+'" size="5" disabled></td>'+
								'<td><input type="text" name="horaEvE" id="horaEvE" value="'+hora+'" size="5" disabled></td>'+
								'<td><input type="text" name="fechaMEvE" id="fechaMEvE" value="'+fechaM+'" size="5" disabled></td>'+
								'<td><input type="text" name="horaMEvE" id="horaMEvE" value="'+horaM+'" size="5" disabled></td>'+
								'<td><textarea name="descripcionEvE" id="descripcionEvE" size="50">'+descripcion+'</textarea></td>'+
								'<td><input type="text" name="autorEvE" id="autorEvE" value="'+autor+'" size="5" disabled></td>'+
								'<td><textarea type="text" name="publicadoEvE" id="publicadoEvE" size="50">'+publicado+'</textarea></td>'+
								'<td><textarea type="text" name="miniaturaEvE" id="miniaturaEvE" size="50">'+miniatura+'</textarea></td>'+
								'<td>En edición</td></tr>';
			nodoTr.innerHTML = nuevoCodigoHtml;

			document.getElementById("ocultoEdEv").setAttribute("value", id);
			document.getElementById("nuevoEv").className="oculto";
			document.getElementById("editarEv").className="oculto";
			document.getElementById("borrarEv").className="oculto";
			document.getElementById("aceptarEdEv").className="boton visible";
			document.getElementById("cancelarEdEv").className="boton visible";
			document.getElementById("pEdEv").className="visible";
			var x = document.getElementsByName("editarEv");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "oculto";
			}

			document.getElementById('idEvM').setAttribute("value", id);
			document.getElementById('idEvMH').setAttribute("value", id);
			//document.getElementById('nombreEvM').setAttribute("value", nombre);
			document.getElementById('fechaEvM').setAttribute("value", fecha);
			document.getElementById('horaEvM').setAttribute("value", hora);
			document.getElementById('fechaEvMM').setAttribute("value", fechaM);
			document.getElementById('horaEvMM').setAttribute("value", horaM);
			//document.getElementById('descripcionEvD').innerHTML=descripcion;
			document.getElementById('autorEvM').setAttribute("value", autor);
			//document.getElementById('miniEvM').setAttribute("value", miniatura);

			document.getElementById("accEvM").value = "2";
			//mostrarTabla(eliminar);
		}

		var i=l.localeCompare(im);
		if(i==0){
			var id = nodosEnTr[0].textContent;
			var nombre = nodosEnTr[1].textContent;
			var ruta = nodosEnTr[2].textContent;
			var pie = nodosEnTr[3].textContent;
			var creditos = nodosEnTr[4].textContent;
			var url = nodosEnTr[5].textContent;
			var evento = nodosEnTr[6].textContent;
			var nuevoCodigoHtml = '<tr id="'+id+'"><td><input type="text" name="idImM" id="idImM" value="'+id+'" size="5" disabled></td>'+
								'<td><textarea name="nombreImM" id="nombreImM" size="50">'+nombre+'</textarea></td>'+
								'<td><textarea name="rutaImM" id="rutaImM" size="50">'+ruta+'</textarea></td>'+
								'<td><textarea name="pieImM" id="pieImM" size="50">'+pie+'</textarea></td>'+
								'<td><textarea name="creditosImM" id="creditosImM" size="50">'+creditos+'</textarea></td>'+
								'<td><textarea name="urlImM" id="urlImM" size="50">'+url+'</textarea></td>'+
								'<td><input type="text" name="eventoImM" id="eventoImM" value="'+evento+'" size="5" disabled></td>'+
								'<td>En edición</td></tr>';
			nodoTr.innerHTML = nuevoCodigoHtml;

			document.getElementById("ocultoEdIm").setAttribute("value", id);
			document.getElementById("nuevoIm").className="oculto";
			document.getElementById("editarIm").className="oculto";
			document.getElementById("borrarIm").className="oculto";
			document.getElementById("aceptarEdIm").className="boton visible";
			document.getElementById("cancelarEdIm").className="boton visible";
			document.getElementById("pEdIm").className="visible";
			var x = document.getElementsByName("editarI");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "oculto";
			}

			document.getElementById('idIM').setAttribute("value", id);
			document.getElementById('idImMH').setAttribute("value", id);
			//document.getElementById('nombreImD').setAttribute("value", nombre);
			//document.getElementById('rutaImD').setAttribute("value", ruta);
			//document.getElementById('pieImD').setAttribute("value", pie);
			//document.getElementById('creditosImD').setAttribute("value", creditos);
			//document.getElementById('urlCreImD').setAttribute("value", url);
			document.getElementById('idEvImM').setAttribute("value", evento);

			document.getElementById("accImM").value = "2";
			//mostrarTabla(eliminar);
		}

		var i=l.localeCompare(u);
		if(i==0){
			var email = nodosEnTr[0].textContent;
			var nombre = nodosEnTr[1].textContent;
			var rol = nodosEnTr[2].textContent;
			var nuevoCodigoHtml = '<tr email="'+email+'"><td><input type="text" name="emailUM" id="emailUM" value="'+email+'" size="5" disabled></td>'+
								'<td><input name="nombreUM" id="nombreUM" value="'+nombre+'" disabled></td>'+
								'<td><select name="rolSelectUM" id="rolSelectUM"><option value="registered">Registrado</option><option value="mod">Moderador</option><option value="manager">Gestor</option><option value="super">SuperUsuario</option></select></td>'+
								'<td>En edición</td></tr>';
			nodoTr.innerHTML = nuevoCodigoHtml;

			document.getElementById("ocultoEdU").setAttribute("value", email);
			document.getElementById("editarU").className="oculto";
			document.getElementById("aceptarEdU").className="boton visible";
			document.getElementById("cancelarEdU").className="boton visible";
			document.getElementById("pEdU").className="visible";
			var x = document.getElementsByName("editarU");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "oculto";
			}

			document.getElementById('emailUMV').setAttribute("value", email);
			document.getElementById('emailUMH').setAttribute("value", email);
			document.getElementById('nombreUMV').setAttribute("value", nombre);

			document.getElementById("accUM").value = "2";

		}

		var i=l.localeCompare(dp);
		if(i==0){
			var email = nodosEnTr[0].textContent;
			var nombre = nodosEnTr[1].textContent;
			var fecha = nodosEnTr[2].textContent;
			var rol = nodosEnTr[3].textContent;
			var nuevoCodigoHtml = '<tr email="'+email+'"><td><input type="text" name="emailDPM" id="emailDPM" value="'+email+'" size="5" disabled></td>'+
								'<td><input name="nombreDPM" id="nombreDPM" value="'+nombre+'" ></td>'+
								'<td><input name="fechaDPM" id="fechaDPM" value="'+fecha+'" ></td>'+
								'<td><input name="rolSelectUM" id="rolSelectUM" value"'+rol+'" disabled></td>'+
								'<td>En edición</td></tr>';
			nodoTr.innerHTML = nuevoCodigoHtml;

			document.getElementById("ocultoEdDP").setAttribute("value", email);
			document.getElementById("editarDP").className="oculto";
			document.getElementById("aceptarEdDP").className="boton visible";
			document.getElementById("cancelarEdDP").className="boton visible";
			document.getElementById("pEdDP").className="visible";
			var x = document.getElementsByName("editarDP");

			var i;
			for (i = 0; i < x.length; i++) {
				x[i].className = "oculto";
			}

			document.getElementById('emailDPMV').setAttribute("value", email);
			document.getElementById('emailDPH').setAttribute("value", email);
			document.getElementById('rolDPMV').setAttribute("value", nombre);

			document.getElementById("accDP").value = "2";

		}
	};

	function modificaciones(fila,string,eliminar){
		var l=string;
		var c="tComentarios";
		var e="tEtiquetas";
		var ev="tEventos";
		var im="tImagenes";
		var u="tUsuarios";
		var dp="tDatosPersonales";

		var i=l.localeCompare(c);
		if(i==0){
			fila =document.getElementById('ocultoEdC').getAttribute("value");
		}
		var i=l.localeCompare(e);
		if(i==0){
			fila =document.getElementById('ocultoEdE').getAttribute("value");
		}
		var i=l.localeCompare(ev);
		if(i==0){
			fila =document.getElementById('ocultoEdEv').getAttribute("value");
		}
		var i=l.localeCompare(im);
		if(i==0){
			fila =document.getElementById('ocultoEdIm').getAttribute("value");
		}
		var i=l.localeCompare(u);
		if(i==0){
			fila =document.getElementById('ocultoEdU').getAttribute("value");
		}
		var i=l.localeCompare(dp);
		if(i==0){
			fila =document.getElementById('ocultoEdDP').getAttribute("value");
		}

		fila=document.getElementById(string).rows.namedItem(fila);//.innerHTML;
		var nodoTd = fila.parentNode; //Nodo TD
		var nodoTr = fila.parentNode; //Nodo TR
		//var nodoContenedorForm = document.getElementById('contenedorForm'); //Nodo DIV
		var nodosEnTr = fila.getElementsByTagName('td');

		//Hay que ponerle un valor, Estilo "Esto se rellena automaticamente",
		//a los deshabilitados pero no funciona -.-"
		var i=l.localeCompare(c);
		if(i==0){
			//document.getElementById(l).deleteRow(fila);
			var id = nodosEnTr[0].textContent;
			var nombre = nodosEnTr[1].textContent;
			var fecha = nodosEnTr[2].textContent;
			var hora = nodosEnTr[3].textContent;
			var email = nodosEnTr[4].textContent;
			var descripcion = document.querySelector('#descripcionCE').value + ' "Comentario editado por un Moderador."';
			var ip = nodosEnTr[6].textContent;
			var idEvento = nodosEnTr[7].textContent;

			//document.getElementById('idCM').setAttribute("value", id);
			//document.getElementById('idCMH').setAttribute("value", id);
			//document.getElementById('nombreCM').setAttribute("value", nombre);
			//document.getElementById('fechaCM').setAttribute("value", fecha);
			//document.getElementById('horaCM').setAttribute("value", hora);
			//document.getElementById('emailCM').setAttribute("value", email);
			document.getElementById('descripcionCM').innerHTML=descripcion;
			document.getElementById('descripcionCMH').setAttribute("value", descripcion);
			//document.getElementById('idEvCM').setAttribute("value", idEvento);

			document.getElementById("accCM").value = "2";
			mostrarTabla(eliminar);

		}

		var i=l.localeCompare(e);
		if(i==0){
			var id = nodosEnTr[0].textContent;
			var nombre = document.querySelector('#nombreEE').value;
			var evento = nodosEnTr[2].textContent;

			//document.getElementById('idED').setAttribute("value", id);
			//document.getElementById('idEDH').setAttribute("value", id);
			document.getElementById('nombreEM').setAttribute("value", nombre);
			document.getElementById('nombreEMH').setAttribute("value", nombre);

			document.getElementById("accEM").value = "2";
			mostrarTabla(eliminar);
		}

		var i=l.localeCompare(ev);
		if(i==0){
			var id = nodosEnTr[0].textContent;
			var nombre = document.querySelector('#nombreEvE').value;
			var fecha = nodosEnTr[2].textContent;
			var hora = nodosEnTr[3].textContent;
			var fechaM = nodosEnTr[4].textContent;
			var horaM = nodosEnTr[5].textContent;
			var descripcion = document.querySelector('#descripcionEvE').value;
			var autor = nodosEnTr[7].textContent;
			var publicado = document.querySelector('#publicadoEvE').value;
			var miniatura = document.querySelector('#miniaturaEvE').value;

			//document.getElementById('idEvD').setAttribute("value", id);
			//document.getElementById('idEvDH').setAttribute("value", id);
			//document.getElementById('nombreEvD').setAttribute("value", nombre);
			//document.getElementById('fechaEvD').setAttribute("value", fecha);
			//document.getElementById('horaEvD').setAttribute("value", hora);
			//document.getElementById('fechaEvMD').setAttribute("value", fechaM);
			//document.getElementById('horaEvMD').setAttribute("value", horaM);
			document.getElementById('nombreEvM').setAttribute("value", nombre);
			document.getElementById('nombreEvMH').setAttribute("value", nombre);
			document.getElementById('descripcionEvM').setAttribute("value", descripcion);
			document.getElementById('descripcionEvMH').setAttribute("value", descripcion);
			document.getElementById('publicadoEvM').setAttribute("value", publicado);
			document.getElementById('publicadoEvMH').setAttribute("value", publicado);
			document.getElementById('miniEvM').setAttribute("value", miniatura);
			document.getElementById('miniEvMH').setAttribute("value", miniatura);
			//document.getElementById('autorEvD').setAttribute("value", autor);
			//document.getElementById('miniEvD').setAttribute("value", miniatura);

			document.getElementById("accEvM").value = "2";
			mostrarTabla(eliminar);
		}

		var i=l.localeCompare(im);
		if(i==0){
			//var id = nodosEnTr[0].textContent;
			var nombre = document.querySelector('#nombreImM').value;
			var ruta = document.querySelector('#rutaImM').value;
			var pie = document.querySelector('#pieImM').value;
			var creditos = document.querySelector('#creditosImM').value;
			var url = document.querySelector('#urlImM').value;
			//var evento = nodosEnTr[6].textContent;

			document.getElementById('nombreIM').setAttribute("value", nombre);
			document.getElementById('nombreImMH').setAttribute("value", nombre);
			document.getElementById('rutaIM').setAttribute("value", ruta);
			document.getElementById('rutaImMH').setAttribute("value", ruta);
			document.getElementById('pieIM').setAttribute("value", pie);
			document.getElementById('pieImMH').setAttribute("value", pie);
			document.getElementById('creditosIM').setAttribute("value", creditos);
			document.getElementById('creditosImMH').setAttribute("value", creditos);
			document.getElementById('urlCreIM').setAttribute("value", url);
			document.getElementById('urlCreImMH').setAttribute("value", url);
			//document.getElementById('idEvImD').setAttribute("value", evento);

			document.getElementById("accImM").value = "2";
			mostrarTabla(eliminar);
		}

		var i=l.localeCompare(dp);
		if(i==0){
			var nombre = document.querySelector('#nombreDPM').value;
			var fecha = document.querySelector('#fechaDPM').value;

			document.getElementById('fechaDPMV').setAttribute("value", fecha);
			document.getElementById('fechaDPH').setAttribute("value", fecha);
			document.getElementById('nombreDPMV').setAttribute("value", nombre);
			document.getElementById('nombreDPH').setAttribute("value", nombre);
			mostrarTabla(eliminar);
		}

		var i=l.localeCompare(u);
		if(i==0){
			var selected = document.getElementById('rolSelectUM').value;

			document.getElementById('rolUM').setAttribute("value", selected);
			document.getElementById('rolUMH').setAttribute("value", selected);
			mostrarTabla(eliminar);
		}

	};


		function buildTableFromXML(xml,keyword) {
			var i;
		  var xmlDoc = xml.responseXML;

			//var table = "<h4>Eventos</h4>";
			var table = "";

		  var x = xmlDoc.getElementsByTagName("event");
		  for (i = 0; i <x.length; i++) {
				//alert(x[i].getElementsByTagName("id")[0]);
				//alert(x[i].getElementsByTagName("name")[0].textContent);
		    table += "<li><a href=index.php?page=evento&event=" +
				x[i].getElementsByTagName("id")[0].textContent+ "&searched_substring="+
				keyword+">" +
		    x[i].getElementsByTagName("name")[0].textContent +
		    "</li>";
		  }
		  document.getElementById("search-list").innerHTML = table;
		};


		function searchEvent(keyword) {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					//document.getElementById("search-response").innerHTML = this.responseText;

					// Hacerlo con un XML por ejemplo, para que
					// se genere la lista en cliente y no en servidor
					buildTableFromXML(xmlhttp,keyword);
				}
			}
			xmlhttp.open("GET","eventXML.php?search="+keyword,true);
			xmlhttp.send();
			//alert(keyword);
		};

		function remarkMatches(substring) {
			if(substring == undefined) {
				//alert(substring);
			}
			else if(substring == null) {
				//alert(substring);
			}
			else if(substring == "") {
				//alert(substring);
			}
			else {
				var regex = new RegExp(substring, "gi");
				var title = document.getElementById("event-title").innerHTML;
				//alert(title);
				var description = document.getElementById("event-description").innerHTML;
				//title.replace(regex,"<span class=match>"+substring+"</span>");
				var new_description = description.replace(regex,"<span class=match>$&</span>");
				var new_title = title.replace(regex,"<span class=match-head>$&</span>");
				//document.getElementById("event-title").value = title;
				document.getElementById("event-description").innerHTML = new_description;
				document.getElementById("event-title").innerHTML = new_title;

			}

			return;
		};



	function busquedaDinamica() {
		var textoBusqueda = document.getElementById('search-event-text').value;//$("input#search-event-text").val();

		 if (textoBusqueda != "") {
			$.post("busquedaDinamica.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
				$("#resultadoBusqueda").html(mensaje);
			});
		} else {
			$("#resultadoBusqueda").html('');
		};
	};
