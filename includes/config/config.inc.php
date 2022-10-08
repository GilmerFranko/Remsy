<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        config.inc.php                           \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Configuración extra
 *
 *
*/

/* Se obtiene la configuración */
$config = Core::model('config', 'core')->getConfig();
require BG_CONF . 'config.site.php';

/* Mensaje din&aacute;mico a mostrar en plantilla */
$message = array();

/* Número de página actual */
$page['number'] = isset($_GET['page']) && ctype_digit($_GET['page']) ? $_GET['page'] : 1;

/* Se inicializa la sesión */
session_start();

// Nombre de sesion
// session_id();

// Regenerar sesion
// session_regenerate_id();


/* Zona horaria por defecto */
date_default_timezone_set('UTC');

/* Nivel de error */
error_reporting(($config['debug_mode'] == 1) ? -1 : 0);