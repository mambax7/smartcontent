<?php
//Traducción por debianus. Sugerencias y reporte de errores en http://es.impresscms.org
/**
* $Id: admin.php 158 2007-12-17 16:40:26Z malanciault $
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

define('_AM_SCONTENT_AVAILABLE', "<span style='font-weight: bold; color: green;'>Disponible</span>");
define('_AM_SCONTENT_CATCREATED', 'La nueva categoría fue creada y guardada');
define('_AM_SCONTENT_CATEGORIES', 'Categorías');
define('_AM_SCONTENT_CATEGORIES_DSC', 'Lista de todas las categorías creadas.');
define('_AM_SCONTENT_CATEGORY_CREATE', 'Crear una categoría');
define('_AM_SCONTENT_CATEGORY_CREATE_INFO', 'Complete el siguiente formulario para crear una nueva categoría. La misma aparecerá inmediatemente en el contenido que pueden ver los usuarios.');
define('_AM_SCONTENT_CATEGORY_MODIFIED', 'La categoría fue modificada con éxito');
define('_AM_SCONTENT_CATEGORY_PAGES', 'Páginas de esta categoría');
define('_AM_SCONTENT_CATEGORY_PAGES_DSC', 'Lista con todas las páginas incluídas en esta categoría.');
define('_AM_SCONTENT_CREATETHEDIR', 'Crear la carpeta');
define('_AM_SCONTENT_CREATINGNEW', 'Creating new');
define('_AM_SCONTENT_DB_CHECKTABLES', 'Comprobar las tablas');
define('_AM_SCONTENT_DB_CURRENTVER', "Versión actual: <span class='currentVer'>%s</span>");
define('_AM_SCONTENT_DB_DBVER', 'Versión de la base de datos %s');
define('_AM_SCONTENT_DB_MSG_ADD_DATA', 'Datos añadidos en la tabla %s');
define('_AM_SCONTENT_DB_MSG_ADD_DATA_ERR', 'Error al añadir los datos en la tabla %s');
define('_AM_SCONTENT_DB_MSG_CHGFIELD', 'Cambiando el campo %s en la tabla %s');
define('_AM_SCONTENT_DB_MSG_CHGFIELD_ERR', 'Error al cambiar el campo %s en la tabla %s');
define('_AM_SCONTENT_DB_MSG_CREATE_TABLE', 'Tabla %s creada');
define('_AM_SCONTENT_DB_MSG_CREATE_TABLE_ERR', 'Error al crear la tabla %s');
define('_AM_SCONTENT_DB_MSG_DROPFIELD', 'DEFINE_ME @ _AM_SCONTENT_DB_MSG_DROPFIELD');
define('_AM_SCONTENT_DB_MSG_DROPFIELD_ERR', 'DEFINE_ME @ _AM_SCONTENT_DB_MSG_DROPFIELD_ERR');
define('_AM_SCONTENT_DB_MSG_DROP_TABLE', 'DEFINE_ME @ _AM_SCONTENT_DB_MSG_DROP_TABLE');
define('_AM_SCONTENT_DB_MSG_DROP_TABLE_ERR', 'DEFINE_ME @ _AM_SCONTENT_DB_MSG_DROP_TABLE_ERR');
define('_AM_SCONTENT_DB_MSG_NEWFIELD', 'El campo %s fue añadido con éxito');
define('_AM_SCONTENT_DB_MSG_NEWFIELD_ERR', 'Error al añadir el campo %s');
define('_AM_SCONTENT_DB_MSG_RENAME_TABLE', 'DEFINE_ME @ _AM_SCONTENT_DB_MSG_RENAME_TABLE');
define('_AM_SCONTENT_DB_MSG_RENAME_TABLE_ERR', 'DEFINE_ME @ _AM_SCONTENT_DB_MSG_RENAME_TABLE_ERR');
define('_AM_SCONTENT_DB_MSG_UPDATE_TABLE', 'DEFINE_ME @ _AM_SCONTENT_DB_MSG_UPDATE_TABLE');
define('_AM_SCONTENT_DB_MSG_UPDATE_TABLE_ERR', 'DEFINE_ME @ _AM_SCONTENT_DB_MSG_UPDATE_TABLE_ERR');
define('_AM_SCONTENT_DB_NEEDINSTALL', 'DEFINE_ME @ _AM_SCONTENT_DB_NEEDINSTALL');
define('_AM_SCONTENT_DB_NEEDUPDATE', 'Su base de datos no está actualizada. Por favor, actualice las tablas de la misma<br><b>Nota: SmartFactory recomienda encarecidamente que haga una copia de seguridad de todas las tablas del módulo SmarCtontent antes de ejecutar este script de actualización.</b><br>');
define('_AM_SCONTENT_DB_NOUPDATE', 'Su base de datos está actualizada: no es necesaria ninguna actualización.');
define('_AM_SCONTENT_DB_UPDATE_DB', 'Actualizando la base de datos');
define('_AM_SCONTENT_DB_UPDATE_ERR', 'Ocurrieron errores al actualizar a la versión %s');
define('_AM_SCONTENT_DB_UPDATE_NOW', 'Actualizar');
define('_AM_SCONTENT_DB_UPDATE_OK', 'Actualización con éxito a la versión %s');
define('_AM_SCONTENT_DB_UPDATE_TO', 'Actualizando a la versión %s');
define('_AM_SCONTENT_DB_VERSION_ERR', 'DEFINE_ME @ _AM_SCONTENT_DB_VERSION_ERR');
define('_AM_SCONTENT_EDITING', 'Modificar');
define('_AM_SCONTENT_ICO_DELETE', 'Eliminar');
define('_AM_SCONTENT_ICO_EDIT', 'Modificar');
define('_AM_SCONTENT_NOTAVAILABLE', "<span style='font-weight: bold; color: red;'>No disponible</span>");
define('_AM_SCONTENT_NOTWRITABLE', 'DEFINE_ME @ _AM_SCONTENT_NOTWRITABLE');
define('_AM_SCONTENT_PAGES', 'Páginas');
define('_AM_SCONTENT_PAGES_DSC', 'Lista de todas las páginas de este módulo.');
define('_AM_SCONTENT_PAGE_CREATE', 'Crear una página');
define('_AM_SCONTENT_PAGE_CREATED', 'La página fue creada con éxito.');
define('_AM_SCONTENT_PAGE_CREATE_INFO', 'Complete este formulario para crear una nueva página.');
define('_AM_SCONTENT_PAGE_EDIT', 'Información de la página');
define('_AM_SCONTENT_PAGE_EDIT_INFO', 'Complete este formulario para modificar esta página.');
define('_AM_SCONTENT_PAGE_MODIFIED', 'La página fue modificada con éxito');
define('_AM_SCONTENT_STATUS', 'Estado');
define('_AM_SCONTENT_PAGE_EXTERNAL_LINK_CREATE', 'Crear un enlace a una página');
define('_AM_SCONTENT_CATEGRY_PAGES_DSC', 'Lista de todas las páginas incluidas en esta categoría.');

define('_AM_SCONTENT_PAGE_SET_EXT_LINK', 'Enlace externo...');
?>