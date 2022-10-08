<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        common.php                               \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Se definen los directorios y se incluyen las configuraciones, funciones y clases a utilizar.
 *
 *
*/

/* Tiempo de ejecución y memoria utilizada inicialmente */
define('START_MEMORY', memory_get_usage());
define('START_TIME', array_sum(explode(' ', microtime())));

/* Espacio */
define('SPACE', ' ');

/* Separador */
define('DS', DIRECTORY_SEPARATOR);

/* Directorio de includes */
define('BG_INC', __DIR__ . DS);

/* Directorio principal */
define('BG_DIR', dirname(__DIR__) . DS);

/* Directorio de librerías */
define('BG_LIB', BG_INC . 'library' . DS);

/* Directorio de modelos de tablas */
define('BG_MODT', BG_INC . 'tables_model' . DS);

/* Directorio de configuración */
define('BG_CONF', BG_INC . 'config' . DS);

/* Directorios de módulos */
define('BG_MODS', BG_DIR . 'modules' . DS);

/* Directorios de las plantillas predefinidas */
define('BG_TEMPLATES', BG_INC . 'templates' . DS);

/* Directorios de subidas */
define('BG_UPLOADS', BG_DIR . 'filestore' . DS . 'uploads');

/* Núcleo */
require BG_LIB . 'core.class.php';
    

/* Modelo padre */
require BG_LIB . 'model.class.php';

/* Modulo Padre */

//----------Esto supone debe ir en otro archivo por separado, luego pienso como hacer que sea automatizado ------//
/* Archivos que se encargarán de administrar los modulos */
require BG_LIB  . 'module.class.php';
require BG_LIB  . 'work.module.class.php';
require BG_LIB  . 'core.module.class.php';
require BG_LIB  . 'model_db.class.php';
require BG_MODT . 'autoload_tables_model.php';
/*------------------------------*/
/* Funciones especiales */
require BG_INC . 'functions.php';



/* Configuración predeterminada */
require BG_CONF . 'config.inc.php';

/* Archivo que cargará SH-MVC */
require Core::controller('init');
