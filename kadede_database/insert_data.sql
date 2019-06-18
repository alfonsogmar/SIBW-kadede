-- Insertar eventos
USE kadede;

INSERT INTO evento (Nombre , Fecha, Hora, FechaModificacion, HoraModificacion, Autor, Descripcion, Publicado, Miniatura)
VALUES ("Senderismo por la Sierra de Alfaguara" ,"2019-06-14", "09:30:00","2019-08-12","18:32:12","Juan Miguel Moreno",
"El sol, el aire libre, la montaña, la naturaleza, la flora, la fauna... ¿Quién no disfruta de un buen día de senderismo?
Acompáñanos a recorrer una de las mejores rutas de senderismo de toda la provincia, donde pasaremos por el Alboretum, e incluso el hospital abandonado, para los más atrevidos.
Nos vemos en la plaza del ayuntamiento de Alfacar en el día y hora indicados más arriba.
Recomendamos encarecidamente que llevéis bebida en abundancia y algo de comer (bocadillos, tuppers, frutos secos...), pues la travesía va a ser larga y tenemos pensado echar el día allí.
¡Animaos!",1,"alfaguara.jpg");

INSERT INTO evento (Nombre , Fecha, Hora,FechaModificacion, HoraModificacion, Autor, Descripcion, Publicado, Miniatura)
VALUES ("Visita a la Alhambra","2019-05-11","11:00:00","2019-08-12","18:32:12","Andrés Roca Montero",
"Ya seas natural de Granada o un visitante de fuera, la Alhambra es un mágico lugar que hay que visitar al menos una vez en la vida. E incluso si ya la habías visto sigue mereciendo la pena volver, pues seguramente queden rincones que aún no hayas explorado.
Únete a nosotros en esta quedada para recorrer el que quizás sea el monumento más bello y representativo del legado nazarí mientras conoces gente con ganas de pasarlo bien y disfrutas de un fabuloso día de primavera. La idea es formar un grupo de como mínimo 8 personas y de un máximo de 20 (nos encanta que venga cuanta más gente mejor, pero tampoco se trata de colapsar el lugar).
Nos reuniremos en el día y hora indicados arriba. Recomentamos llevar la entrada comprada de antes para evitar engorrosas colas. También sería buena idea que traigáis algo de comer y de beber. Y por favor, confirmad vuestra asistencia SOLO si vais a venir.
¿A qué estás esperando? ¡Únete!
Si deseas saber mas sobre el itinerario, puedes visitar la pagina oficial del monumento a traves del enlace que encontrareis a continuación  Itinerario Alhambra de Granada",1,
"alhambra.jpg"
);

INSERT INTO evento (Nombre , Fecha, Hora,FechaModificacion, HoraModificacion, Autor, Descripcion, Publicado, Miniatura)
VALUES ("Senderismo por la Sierra de Alfaguara 2" ,"2019-06-14", "09:30:00","2019-08-12","18:32:12","Juan Miguel Moreno",
"El sol, el aire libre, la montaña, la naturaleza, la flora, la fauna... ¿Quién no disfruta de un buen día de senderismo?
Acompáñanos a recorrer una de las mejores rutas de senderismo de toda la provincia, donde pasaremos por el Alboretum, e incluso el hospital abandonado, para los más atrevidos.
Nos vemos en la plaza del ayuntamiento de Alfacar en el día y hora indicados más arriba.
Recomendamos encarecidamente que llevéis bebida en abundancia y algo de comer (bocadillos, tuppers, frutos secos...), pues la travesía va a ser larga y tenemos pensado echar el día allí.
¡Animaos!",0,
"alfaguara.jpg"
);

INSERT INTO evento (Nombre , Fecha, Hora,FechaModificacion, HoraModificacion, Autor, Descripcion, Publicado, Miniatura)
VALUES ("Ciclismo por Cenes" ,"2019-7-30", "17:30:00","2019-08-12","18:32:12","Lucía Losada Peña",
"El sol, el aire libre, la montaña, la naturaleza, la flora, la fauna... ¿Quién no disfruta de un buen día de senderismo?
Acompáñanos a recorrer una de las mejores rutas de senderismo de toda la provincia, donde pasaremos por el Alboretum, e incluso el hospital abandonado, para los más atrevidos.
Nos vemos en la plaza del ayuntamiento de Alfacar en el día y hora indicados más arriba.
Recomendamos encarecidamente que llevéis bebida en abundancia y algo de comer (bocadillos, tuppers, frutos secos...), pues la travesía va a ser larga y tenemos pensado echar el día allí.
¡Animaos!",1,
"alfaguara.jpg"
);



INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
VALUES ("Alhambra","Visita a la alhambra","../images/alhambra.jpg","ninguno","ninguna",2);

INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
VALUES ("Alhambra1","Alhambra vista desde una de sus torres","../images/AlhambraCarrusel1.jpg","Imagen cedida por getyourguide","https://www.getyourguide.es/",2);

INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
VALUES ("Alhambra2","Palacio del Generalife","../images/AlhambraCarrusel2.jpg","Imagen cedida por getyourguide","https://www.getyourguide.es/",2);

INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
VALUES ("Alhambra3","Jardines de la Alhambra","../images/AlhambraCarrusel3.jpg","Imagen cedida por getyourguide","https://www.getyourguide.es/",2);

INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
VALUES ("Alhambra4","Jardines de la Alhambra","../images/AlhambraCarrusel4.jpg","Imagen cedida por getyourguide","https://www.getyourguide.es/",2);

INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
VALUES ("Alhambra5","Jardines de la Alhambra","../images/AlhambraCarrusel5.jpg","Imagen cedida por getyourguide","https://www.getyourguide.es/",2);

INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
VALUES ("Alhambra6","Jardines de la Alhambra","../images/AlhambraCarrusel6.jpg","Imagen cedida por getyourguide","https://www.getyourguide.es/",2);

INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
VALUES ("Alhambra7","Jardines de la Alhambra","../images/AlhambraCarrusel7.jpg","Imagen cedida por getyourguide","https://www.getyourguide.es/",2);

INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
VALUES ("Alfaguara","Paisaje de la alfaguara","../images/alfaguara.jpg","ninguno","ninguna",1);

INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
VALUES ("Alfaguara","Paisaje de la alfaguara","../images/alfaguara.jpg","ninguno","ninguna",3);

INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
VALUES ("Ciclismo","Ciclismo por Cenes de la Vega","../images/alfaguara.jpg","ninguno","ninguna",4);

-- INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
-- VALUES ("Facebook","Compartir en Facebook","../images/Facebook.png","ninguno","ninguna");

-- INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
-- VALUES ("Impresora","Imprimir el evento","../images/impresora.png","ninguno","ninguna");

-- INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
-- VALUES ("Instagram","Compartir en Instagram","../images/instagram.png","ninguno","ninguna");

-- INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
-- VALUES ("LogoBlack","logo de kadede","../images/logo_black.png","ninguno","ninguna");

-- INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
-- VALUES ("LogoWhite","logo de kadede","../images/logo_white.png","ninguno","ninguna");

-- INSERT INTO imagen (Nombre, Textopie, Path, Creditos, UrlCreditos, Id_Eventos)
-- VALUES ("Twitter","Compartir en Twitter","../images/Twitter.png","ninguno","ninguna");



INSERT INTO videos (Nombre, Fecha, Hora, Path, Id_Eventos)
VALUES ("Un paseo por la alhambra","2019-05-11","11:47:00","https://www.youtube.com/embed/P9MnwfHCuDI",2);



INSERT INTO comentarios (Nombre, Fecha, Hora, Email, Descripcion, IP, Id_Eventos)
VALUES ("Juanillo","2019-03-21","11:47","JuanitoCalavera@humoramarillo.com","Ya tengo excusa para no ir a la comunión de mi sobrino!! Jajaj salu2","143.12.238.93",2);

INSERT INTO comentarios (Nombre, Fecha, Hora, Email, Descripcion, IP, Id_Eventos)
VALUES ("Antonio","2019-03-25","17:12","AntonioColgao@estatomorao.com","Aunque no lo creáis, yo soy de Granada y nunca he estado en la Alhambra.
¿De verdad hay que ir alguna vez en la vida? ¿O es puro marketing?","458.11.86.321",2);


INSERT INTO etiquetas(Nombre) VALUES ("Paseo");
INSERT INTO etiquetas(Nombre) VALUES ("Alhambra");
INSERT INTO etiquetas(Nombre) VALUES ("Monumento");
INSERT INTO etiquetas(Nombre) VALUES ("Senderismo");
INSERT INTO etiquetas(Nombre) VALUES ("AireLibre");
INSERT INTO etiquetas(Nombre) VALUES ("Granada");
INSERT INTO etiquetas(Nombre) VALUES ("Ciclismo");



INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (1,1);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (2,1);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (3,1);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (2,2);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (2,3);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (1,4);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (3,4);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (1,5);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (2,5);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (3,5);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (4,5);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (1,6);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (2,6);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (3,6);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (4,6);

INSERT INTO etiquetado (Id_Eventos,Id_Etiqueta)
VALUES (4,7);


INSERT INTO prohibidas(Nombre) VALUES ("puta");

INSERT INTO prohibidas(Nombre) VALUES ("mierda");

INSERT INTO prohibidas(Nombre) VALUES ("cago");

INSERT INTO prohibidas(Nombre) VALUES ("cabron");

INSERT INTO prohibidas(Nombre) VALUES ("zorra");

INSERT INTO prohibidas(Nombre) VALUES ("joder");

INSERT INTO prohibidas(Nombre) VALUES ("muertos");

INSERT INTO prohibidas(Nombre) VALUES ("cagar");

INSERT INTO prohibidas(Nombre) VALUES ("mear");

INSERT INTO prohibidas(Nombre) VALUES ("hostia");


INSERT INTO general(Titulo, Cuerpo) VALUES ("Sobre esta web",
"Nuestra página web surgió como un proyecto de prácticas de la asignatura Sistemas de Información Basados en Web, impartida en el tercer curso del Grado en Ingeniería Informática por la Universidad de Granada, durante el curso 2018/2019.
El desarrollo de la página fue llevado a cabo por los estudiantes Javier Marcos Segura (javirizos) y Alfonso García Martínez (alfonsogmar).
Actualmente, kadede.es no tiene ninguna finalidad comercial, sino que es un proyecto con fines puramente didácticos desde sus orígenes. No obstante, no descartamos comenzar algún día un proyecto serio a partir de este...
Por desgracia, actualmente no disponemos de correo de contacto operativo. En cuanto lo tengamos, no duden en escribirnos a la siguiente dirección:
info@kadede.es
");
