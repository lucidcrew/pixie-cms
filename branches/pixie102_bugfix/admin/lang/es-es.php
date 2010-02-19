<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                          //
// Title: Language File (Spanish ES).                              //
// Author: Victor Alvarez                                          //
// Basado en la traducci�n de Carlos El�as (Spanish CL)            //
//*****************************************************************//

$lang = array(
    // system
    'skip_to' => 'Ir al contenido',
    'view_site' => 'Ver web',
    'logout' => 'Salir',
    'license' => 'Liberado bajo la',
    'tag_line' => 'El Peque�o y Sencillo Creador de P�ginas Web',
    'latest_referrals' => '�ltimas Referencias',
    'latest_activity' => '�ltimas Actividades',
    'feed_subscribe' => 'Suscribirse',
    'rss_feed' => 'RSS Feed',
    'when' => '�Cu�ndo?',
    'who' => '�Qui�n?',
    'what' => '�Qu�?',
    'from' => '�Desde?',
    'switch_to' => 'Cambiar a',
    'a_few_seconds' => 'Algunos segundos',
    'a_minute' => '1 minuto',
    'minutes' => 'minutos',
    'a_hour' => '1 hora',
    'hours' => 'horas',
    'a_day' => '1 d�a',
    'days' => 'd�as',
    'ago' => '',
    'user' => 'Usuario',
    'to' => 'a',
    'database_backup' => 'Copia de seguridad de la base de datos.',
    'database_info' => 'As�gurese de realizar una copia de seguridad de su base de datos frecuentemente, use el bot�n de la derecha para realizarla de forma manual. Las copias de seguridad se guardan en /files/sqlbackups/ y se pueden descargar desde la lista de abajo. Los �ltimas copias est�n resaltadas.',
    'database_backups' => 'Copias de seguridad',
    'download' => 'Descargar',
    'delete' => 'Borrar',
    'delete_file' => '�Borrar archivo?',
    'theme_info' => 'Los temas que est�n instalados se listan a continuaci�n. Puede instalar m�s temas subiendo las carpetas de los mismos a admin/themes. Se pueden descargar m�s desde <a href="http://www.getpixie.co.uk">www.getpixie.co.uk</a> o puede crear los suyos de forma sencilla usando solo CSS. El tema actual se encuentra resaltado.',
    'theme_pick' => 'Seleccione un tema para su web',
    'theme_apply' => 'Aplicar este tema',
    'sure_delete_page' => 'Est� seguro que desea eliminar',
    'sure_empty_page' => 'Est� seguro que desea limpiar',
    'settings_page' => '',  //this is intencional left empty 'cos in spanish grammar u can't say "Limpiar Inicio p�gina" correct syntax will be "Limpiar p�gina inicio"
    'settings_plugin' => 'plugin',
    'plugins' => 'Plugins',
    'plugins_info' => 'Los plugins a�aden nuevas funcionalidades al sitio',
    'empty' => 'Limpiar',
    'oops' => 'Ooops!',
    'feature_disabled' => 'Esta caracter�stica esta deshabilitada, la pr�xima version de Pixie la tendr�.',
    'pages_in_navigation' => 'P�ginas en el men�',
    'pages_in_navigation_info' => 'Estas p�ginas aparecen en el menu de su web, para cambiar el orden arr�strelas con el rat�n a la posicion deseada. La p�gina que est� primera en la lista es la que aparece primero en el menu.',
    'pages_outside_navigation' => 'P�ginas fuera del men�',
    'pages_outside_navigation_info' => 'Estas p�ginas son visibles por el p�blico pero no aparecen en el men� de su web', 
    'pages_disabled' => 'P�ginas deshabilitadas',
    'pages_disabled_info' => 'Estas p�ginas no son visibles',
    'edit_user' => 'Editar Usuario',
    'create_user' => 'Crear nuevo usuario',
    'create_user_info' => 'Se enviar� un correo al nuevo usuario con las instrucciones de acceso, adem�s se le crear� una contrase�a aleatoria',
    'user_info' => 'Abajo hay una lista de los usuarios que tienen accesso a Pixie. Puede crear m�s usuarios para ayudarle con su web usando el formulario de la derecha, la cuenta de superusuario esta resaltada.',
    'user_delete_confirm' => 'Est� seguro de que desea eliminar el usuario:',
    'tags' => 'Etiquetas',
    'upload' => 'Subido',
    'file_manager_info' => 'El tama�o m�ximo de los archivos est� configurado en 100Mb. Por favor, sea paciente cuando sube archivos grandes',
    'file_manager_latest' => '�ltimos subidos',
    'file_manager_tagged' => 'Todos los archivos etiquetados:',
    'filename' => 'Nombre de archivo',
    'filedate' => 'Modificar fecha',
    'results_from' => 'Resultado formulario',
    'sure_delete_entry' => 'Eliminar entrada',
    'from_the' => 'desde el',
    'page_settings' => 'Configuraci�n de la p�gina',
    'advanced' => 'Avanzado',
    'your_site_has' => 'Su web tiene',
    'visitors_online' => 'visita(s) online.',    
    'in_the_last' => 'en los �ltimos',
    'site_visitors' => 'Visitas a la web.',
    'page_views' => 'P�ginas vistas.',
    'spam_attacks' => 'Ataques Spam',
    'last_login_on' => '�ltimo login:',
    'quick' => '',  //same as the adove in spanish it should be "Links r�pidos" no "R�pidos links"
    'links' => 'Links',
    'new_entry' => 'A�adir entrada en: ',
    'entry' => '', //another grammar error this goes first in spanish e.g. "Entrada Nombre"
    'edit' => 'Editar ',
    'page' => 'p�gina.',
    'blog' => 'Blog.',
    'search' => 'Buscar',
    'forums' => 'Foros.',
    'downloads' => 'Descargas.',
    'create_backup' => 'Crear copia de seguridad',
    'button_backup' => 'Copia de seguridad de la Base de datos',
    'page_type' => 'Tipo de p�gina',
    'settings_page_new' => 'Crear nueva',
    'total_records' => 'Todos los guardados',
    'showing_from_record' => 'Mostrar guardados',
    'page(s)' => 'p�gina(s)',
    'help' => 'Ayuda',
    'statistics' => 'Estad�sticas',
    'help_settings_page_type' => 'Cuando cree una p�gina nueva puede escoger estos tres tipos:',
    'help_settings_page_dynamic' => 'Ejemplos de p�ginas din�micas son los blogs y noticias, estas p�ginas tiene soporte RSS y comentarios',
    'help_settings_page_static' => 'Una p�gina est�tica es simplemente un bloque HTML (o PHP si prefiere), Estas p�ginas son las simples que raramente debe actualizar',
    'help_settings_page_module' => 'Una p�gina m�dulo a�ade contenido espec�fico a su web, Los m�dulos pueden ser descargados desde <a href="http://www.getpixie.co.uk">www.getpixie.co.uk</a>, un ejemplo es el m�dulo de eventos. Los m�dulos a veces est�n incrustados con los plugins.',
    'help_settings_user_type' => 'Cuando a�ade un usuario puede escoger entre tres tipos:',
    'help_settings_user_admin' => '<b>Administrador</b> - Los Administradores tienen accesso a todos los par�metros de Pixie, pueden editar las configuraci�nes, crear contenido y hacer lo que ellos deseen.',
    'help_settings_user_client' => '<b>Cliente</b> - Un cliente s�lo puede a�adir contenido a Pixie, no puede cambiar ninguna configuraci�n de la web',
    'help_settings_user_user' => '<b>Usuario</b> - Un usuario de Pixie s�lo tiene accesso al Tablero, tiene un perfil Pixie y puede ver las estadisticas de la web',
    'install_module' => 'Instalar un nuevo plugin o m�dulo',
    'select_module' => 'Seleccione el m�dulo o plugin que desea activar',
    'all_installed' => 'Todos los plugins o m�dulos disponibles se encuentran instalados y activados.',

    // system messages
    'error_save_settings' => 'Error al guardar la configuraci�n.',
    'ok_save_settings' => 'Su nueva configuraci�n se guard� y se activ�.',
    'comment_spam' => 'Comentario spam bloqueado.',
    'failed_login' => 'Error de acceso a la web.',
    'login_exceeded' => 'Usted ha excedido la cantidad m�xima de intentos (3) para acceder a Pixie, por favor int�ntelo en 24 horas.',
    'logins_exceeded' => 'Se detectaron 3 intentos fallidos al acceder, Pixie ha bloqueado su IP durante 24 horas.',
    'ok_login' => 'Usuario '.$username.' accedi� al sistema.',
    'failed_protected_page' => 'No se puede eliminar la p�gina 404, puede ser un posible intento de hack.',
    'ok_delete_page' => 'Se elimin� correctamente la',
    'ok_delete_entry' => 'Se elimin� correctamente la entrada (#'.$delete.') de el',
    'failed_delete' => 'No se puede eliminar (#'.$delete.').',
    'login_missing' => 'Por favor provea la informaci�n de acceso requerida.',
    'login_incorrect' => 'Los datos de su acceso son incorrectos.',
    'forgotten_missing' => 'El usuario o correo no es v�lido.',
    'forgotten_ok' => 'Se envi� una nueva contrase�a a su correo.',
    'forgotten_log_error' => 'Error al intentar reiniciar la contrase�a.',
    'forgotten_log_ok' => 'Se envi� una nueva contrase�a a ',
    'rss_access_attempt' => 'Acesso denegado al intentar acceder a un RSS privado, deber� subscribirse nuevamente desde Pixie.',
    'unknown_error' => 'Algo sali� mal. Es posible (pero poco probable) que la base de datos se haya ca�do o que usted se haya levantado con el pie izquierdo hoy',
    'unknown_edit_url' => 'La direcci�n entregada para editar no es v�lida.',
    'unknown_referrer' => 'Referencia desconocida.',
    'profile_name_error' => 'Por favor introduzca su nombre completo.', 
    'profile_correo_error' => 'Por favor introduzca un correo v�lido.', 
    'profile_web_error' => 'por favor introduzca un sitio web v�lido.', 
    'profile_ok' => 'Su perfil se actualiz�.',
    'profile_contrase�a_error' => 'A Pixie le fue imposible guardar su nueva contrase�a, int�ntelo nuevamente',
    'profile_contrase�a_ok' => 'Su contrase�a de Pixie fue actualizada, la necesitara la pr�xima vez que acceda a la web.',
    'profile_contrase�a_inv�lid' => 'No introdujo una contrase�a actual v�lida.',
    'profile_contrase�a_inv�lid_length' => 'Las contrase�as deben tener por lo menos 6 caracteres.',
    'profile_contrase�a_match_error' => 'Las contrase�as que introdujo no coinciden.',
    'profile_contrase�a_missing' => 'por favor introduzca toda la informaci�n requerida',
    'site_name_error' => 'Su web necesita un nombre.',
    'site_url_error' =>  'por favor introduzca una URL v�lida.',
    'backup_ok' => 'Se cre� con �xito la copia de seguridad de la base de datos.',
    'backup_delete_ok' => 'Se elimin� correctamente la copia de seguridad:',
    'backup_delete_no' => 'No puede eliminar la copia de seguridad m�s reciente.',
    'backup_delete_error' => 'Pixie no puede eliminar esta copia de seguridad.',
    'theme_ok' => 'Se le aplic� el tema a su web.',
    'theme_error' => 'Pixie no puede cambiar el tema.',
    'all_content_deleted' => 'Todo el contenido fue eliminado de',
    'user_delete_ok' => 'Fue eliminado de Pixie.',
    'user_delete_error' => 'No se puede eliminar usuario',
    'user_name_missing' => 'por favor introduzca un usuario.',
    'user_realname_missing' => 'por favor introduzca un nombre.',
    'user_contrase�a_missing' => 'por favor introduzca una contrase�a.',
    'user_correo_error' => 'por favor introduzca un correo v�lido.',
    'user_update_ok' => 'Guardada la nueva configuraci�n',
    'user_duplicate' => 'Ya existe un usuario con ese nombre, pruebe otro.',
    'user_new_ok' => 'Creado nuevo usuario:',
    'saved_new_settings_for' => 'Guardada la nueva configuraci�n para',
    'file_upload_error' => 'Pixie tiene un problema al grabar la informaci�n en la base de datos, el archivo se ha debido subir de todos modos.',
    'file_upload_tag_error' => 'por favor aseg�rese de etiquetar sus archivos subidos.',
    'file_delete_ok' => 'Se elimin� correctamente:',
    'file_delete_fail' => 'Pixie no pudo eliminar:',
    'form_build_fail' => 'No se pudo construir un formulario editable... �introdujo los datos correctos en el m�dulo?',
    'date_error' => 'Introdujo una fecha inv�lida.',
    'correo_error' => 'Asegurese de introducir un correo v�lido.',
    'url_error' => 'Asegurese de introducir una URL v�lida.',
    'is_required' => 'requerido.',
    'saved_new' => 'Guardada nueva entrada',
    'in_the' => 'en la',
    'on_the' => 'en la',
    'saved_new_page' => 'Creada nueva p�gina',
    'save_update_entry' => 'Guardados los cambios de su entrada',
    'bad_cookie' => 'Su cookie a desaparecido :( necesitar� acceder otra vez.',
    'no_module_selected' => 'No seleccion� ningun m�dulo o plugin para instalar, int�ntelo de nuevo.',
    'install_module_ok' => 'se instal� correctamente.',

    // helper
    'helper_plugin' => 'Usted no puede editar la configuraci�n de los plugins, usando los botones que est�n arriba puede vaciar el contenido o eliminar un plugin. Si elimina un plugin, por ejemplo el de comentarios, sus visitas no podr�n dejar comentarios en las p�ginas din�micas ',
    'helper_nocontent' => 'Esta p�gina no tiene ning�n contenido. use el bot�n verde de arriba para a�adir la primera entrada (el bot�n verde no est� en el plugin de comentarios).',
    'helper_nopages' => 'Una vez un hombre sabio dijo, -una web sin p�ginas es como un ave sin alas... no va a ning�n lugar-. Utilice el formulario de la derecha para a�adir una nueva p�gina a su web. Una vez hecho esto este mensaje desaparecer�.',
    'helper_nopages404' => 'Su web s�lo tiene una p�gina, esta es la p�gina de error 404, la cual puede ser editada m�s abajo.',
    'helper_nopagesadmin' => 'Usted puede <a href="?s=settings"> a�adir m�s paginas en la seccion \'Setup Stuff\' </a> de Pixie.',
    'helper_nopagesuser' => 'Contacte con el administrador de la web para preguntar c�mo puede a�adir nuevas p�ginas.',
    'helper_search' => 'Su b�squeda no obtuvo ning�n resultado, intente buscar otra vez.',
    
    // navigation
    'nav1_settings' => 'Configuraci�n',
    'nav1_publish' => 'Publicar',
    'nav1_home' => 'Tablero',
    'nav2_home' => 'Inicio',
    'nav2_profile' => 'Perfil',
    'nav2_security' => 'Contrase�a',
    'nav2_logs' => 'Registros',
    'nav2_delete' => 'Eliminar Cuenta',
    'nav2_pages' => 'Paginas',
    'nav2_files' => 'Administrador de Archivos',
    'nav2_backup' => 'Copia de seguridad',
    'nav2_users' => 'Usuarios',
    'nav2_blocks' => 'Bloques',
    'nav2_theme' => 'Tema',
    'nav2_site' => 'Web',
    'nav2_settings' => 'Configuraci�n',

    // forms
    'form_login' => 'Acceder',
    'form_username' => 'Nombre de usuario',
    'form_contrase�a' => 'Contrase�a',
    'form_rememberme' => '�Desea que recuerde la sesi�n en este ordenador?',
    'form_forgotten' => '�Olvid� su contrase�a?',
    'form_returnto' => 'Volver a ',
    'form_help_forgotten' => 'por favor introduzca su correo o nombre de usuario para su cuenta Pixie. Su contrase�a se enviar� a su correo.',
    'form_resetcontrase�a' => 'Generar nuevamente la contrase�a',
    'form_name' => 'Nombre completo',
    'form_usernameorcorreo' => 'Nombre de usuario o correo',
    'form_telephone' => 'Tel�fono',
    'form_correo' => 'Correo',
    'form_website' => 'P�gina web',
    'form_occupation' => 'Trabajo',
    'form_address_street' => 'Direcci�n',
    'form_address_town' => 'Ciudad',
    'form_address_county' => 'Regi�n',
    'form_address_pcode' => 'C�digo Postal',
    'form_address_country' => 'Pais',
    'form_address_biography' => 'Biograf�a',
    'form_fl1' => 'Sus enlaces favoritos',
    'form_button_save' => 'Guardar',
    'form_button_update' => 'Actualizar',
    'form_button_cancel' => 'Cancelar',
    'form_button_install' => 'Instalar',
    'form_button_create_page' => 'Crear P�gina',
    'form_current_contrase�a' => 'Contrase�a actual',
    'form_new_contrase�a' => 'Nueva contrase�a',
    'form_confirm_contrase�a' => 'Confirmar contrase�a',
    'form_tags' => 'Etiquetas',
    'form_content' => 'Contenido',
    'form_comments' => 'Comentarios',
    'form_public' => 'P�blico',
    'form_optional'=> '(opcional)',
    'form_required'=> '*',
    'form_title'=> 'Titulo',
    'form_posted'=> 'Fecha &amp; Hora',
    'form_date' => 'Fecha &amp; Hora',
    'form_help_comments' => '�Desea que la gente comente en esta entrada?',
    'form_help_public' => '�Desea que esta entrada/p�gina sea visible en la web (si selecciona NO, esta se guardar� como borrador).',
    'form_help_tags' => 'Las etiquetas funcionan como categor�as y hacen que todo sea mas f�cil de encontrar. Introduzca palabras clave separadas por espacios.',
    'form_help_current_tags' => 'Sugerencias:',
    'form_help_current_blocks' => 'Bloques disponibles:',
    'form_php_warning' => '(Esta p�gina contiene PHP. El editor ha sido deshabilitado para permitir la edici�n de c�digo avanzada)',
    'form_legend_site_settings' => 'Ajuste la configuraci�n de la web',
    'form_site_name' => 'Nombre de la web',
    'form_help_site_name' => '�Como le gustar�a que se llamara su web?',
    'form_page_name' => 'Nombre de la URL',
    'form_help_page_name' => 'Esto se usar� para crear un enlace (por ejemplo http://www.susitio.com/<b>elnombre</b>/)..',
    'form_page_display_name' => 'Nombre de la p�gina',
    'form_help_page_display_name' => '�Como le gustaria que se llamara su p�gina?',
    'form_page_description' => 'Descripci�n de la p�gina',
    'form_help_page_description' => 'Escriba una descripci�n para su p�gina.',
    'form_page_blocks' => 'Bloques de la p�gina',
    'form_help_page_blocks' => 'Los bloques son areas extra de contenido. Los nombres de los bloques deberan estar separados por espacios. (El manejo de bloques sera mejorado en futuras versiones de Pixie).',
    'form_searchable' => 'Indexable',
    'form_help_searchable' => '�Desea que esta p�gina se encuentre en b�squedas p�blicas?',
    'form_posts_per_page' => 'Entradas en esta p�gina',
    'form_help_posts_per_page' => '�Cu�ntas entradas desea que se muestren en esta p�gina?',
    'form_rss' => 'RSS',
    'form_help_rss' => '�Desea que esta p�gina genere un archivo RSS?',
    'form_in_navigation' => 'En el men�',
    'form_help_in_navigation' => '�Desea que esta p�gina se muestre en el men� de su web?',
    'form_site_url' => 'Direcci�n de la web',
    'form_help_site_url' => 'Cual es la direcci�n de su sitio (ej: http://www.susitio.com/directorio/).',
    'form_site_homepage' => 'P�gina de inicio',
    'form_help_homepage' => '�Cual de sus p�ginas desea que vean primero sus visitas?',
    'form_site_keywords' => 'Palabras clave del sitio',
    'form_help_site_keywords' => 'Escriba palabras clave separadas por coma. (ej: este, sitio, la, lleva).',
    'form_site_author' => 'Autor de la web',
    
    
    
    'form_site_copywright' => 'Copyright del sitio', //this is the first time do I found the word Copywright with a w, is this correct?  
    'form_site_curl' => '�URLs amigables?',
    'form_help_site_curl' => '�Le gustaria que su web utilize URLs amigables? Una URL amigable se ve as� www.yoursite.com/amigable/ cuando normalmente deberia verse www.yoursite.com/?s=clara. Esta funci�n s�lo sirve para servidores sobre Linux',
    'form_legend_pixie_settings' => 'Configure la forma en la que Pixie se comporta',
    'form_pixie_language' => 'Idioma',
    'form_help_pixie_language' => 'Seleccione el idioma que desea utilizar.',
    'form_pixie_timezone' => 'Zona horaria',
    'form_help_pixie_timezone' => 'Seleccione su zona horaria para que se muestre la hora correctamente.',
    'form_pixie_dst' => 'Horario de ahorro de energia',
    'form_help_pixie_dst' => '�Le gustaria que Pixie autom�ticamente ajustar� la hora seg�n el horario de ahorro de energia?',
    'form_pixie_date' => 'Fecha &amp; Hora',
    'form_help_pixie_date' => 'Seleccione su formato preferido para fecha y hora.',
    'form_pixie_rte' => 'Editor de texto',
    'form_help_pixie_rte' => '�Le gustaria usar el editor de texto TinyMCE? (este hace que editar sus p�ginas sea muy f�cil, pero no est� soportado por todos los navegadores)',
    'form_pixie_logs' => 'Tiempo en el que expiran los registros (Logs)',
    'form_help_pixie_logs' => '�Despu�s de cu�ntos d�as prefiere que expiren los registros? (Logs)',
    'form_pixie_sysmess' => 'Mensaje del Sistema',
    'form_help_pixie_sysmess' => 'Este mensaje se mostrar� cada usuario de Pixie al acceder al sistema',
    'form_help_settings_page_type' => '�Qu� tipo de p�gina le gustar�a crear?',
    'form_legend_user_settings' => 'Configuraci�n de usuario',
    'form_user_username' => 'Nombre de usuario',
    'form_help_user_username' => 'Los nombres de usuario no pueden llevar espacios',
    'form_user_realname' => 'Nombre completo',
    'form_help_user_realname' => 'Introduzca el nombre completo del usuario',
    'form_user_permissions' => 'Permisos',
    'form_help_user_permissions' => '�Qu� permisos le gustar�a que tenga el usuario?',
    'form_help_user_permissions_block' => '�Qu� tipo de usuario ser� este?',
    'form_button_create_user' => 'Crear usuario',
    'form_upload_file' => 'Archivo',
    'form_help_upload_file' => 'Seleccione un archivo para subir desde su ordenador.',
    'form_help_upload_tags' => 'Palabras clave separadas por espacios',
    'form_upload_replace_files' => '�Reemplazar el archivo?', 
    'form_help_upload_replace_files' => '�Est� intentando reemplazar el archivo?',
    'form_search_words' => 'Palabras clave',
    'form_privs' => 'Permisos de la p�gina',
    'form_help_privs' => '�A qui�n se le permitir� modificar esta p�gina?', 
    
    //correo
    'correo_newcontrase�a_subject' => 'Nueva contrase�a para ('.str_replace("http://", "", $site_url).') ',
    'correo_changecontrase�a_subject' => 'contrase�a cambiada ('.str_replace("http://", "", $site_url).') ',
    'correo_newcontrase�a_message' => 'Su contrase�a fue enviada a: ',
    'correo_account_close_message' => 'Su cuenta de Pixie fue cerrada en '.$site_url.'. Contacte con el administrador de la web para m�s informaci�n.',
    'correo_account_close_subject' => 'Cuenta cerrada ('.str_replace("http://", "", $site_url).') ',
    'correo_account_edit_subject' => 'Informaci�n importante sobre su cuenta ('.str_replace("http://", "", $site_url).') ',
    'correo_account_new_subject' => 'Nueva cuenta ('.str_replace("http://", "", $site_url).') ',
    
    //front end
    'continue_reading' => 'Leer m�s',
    'permalink' => 'Enlace permanente',
    'theme' => 'Tema',
    'navigation' => 'Men�',
    'skip_to_content' => 'Ir al contenido &raquo;',
    'skip_to_nav' => 'Ir al men� &raquo;',
    'by' => 'Por',
    'on' => 'el',
    'view' => 'Ver',
    'profile' => 'perfil',
    'all_posts_tagged' => 'todas las entradas con etiquetas',
    'permalink_to' => 'Enlace permanente a',
    'comments' => 'Comentarios',
    'comment' => 'Comentario',
    'no_comments' => 'Sin comentarios...',
    'comment_closed' => 'Comentarios cerrados.',
    'comment_thanks' => 'Gracias por su comentario.',
    'comment_leave' => 'Dejar un comentario',
    'comment_form_info' => 'El formulario de comentarios posee <a href="http://gravatar.com" title="Consigue un Gravatar">Gravatar</a> y <a href="http://www.cocomment.com" title="Sigue y comparte tus comentarios">coComment</a>.',
    'comment_name' => 'Nombre',
    'comment_correo' => 'Correo',
    'comment_web' => 'Web',
    'comment_button_leave' => 'Enviar comentario',
    'comment_name_error' => 'por favor introduzca su nombre.',
    'comment_correo_error' => 'Por favor, introduzca un correo v�lido.',
    'comment_web_error' => 'Por favor, introduzca una p�gina web v�lida.',
    'comment_comment_error' => 'Introduzca un comentario.',    
    'comment_save_log' => 'Comentado en: ',
    'tagged' => 'Etiquetas',
    'tag' => 'Etiqueta',
    'popular' => 'M�s popular',
    'archives' => 'Archivos',
    'posts' => 'Entradas',
    'last_updated' => '�ltima actualizaci�n',
    'edit_post' => 'Editar esta entrada',
    'edit_page' => 'Editar esta p�gina',
    'popular_posts' => 'Entradas populares',
    'next_post' => 'Siguiente entrada',
    'next_page' => 'Siguiente p�gina',
    'previous_post' => 'Entrada anterior',
    'previous_page' => 'P�gina anterior',
    'dynamic_page' => 'P�gina'
);
?>