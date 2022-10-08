<?php defined('SUPERNATURAL') || exit;
/**
 *-------------------------------------------------------/
 * @file        bot.php                                  \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Se publican bots del día siguiente
 *
 *
 */

// INCLUYE CONFIGURACIÓN DE LA BASE DE DATOS
require BG_DIR . 'includes' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.db.php';

// CONEXIÓN A LA BASE DE DATOS
$db = new MySQLi($db['hostname'], $db['username'], $db['userpass'], $db['database']);
// SI NO SE PUEDE CONECTAR A LA BASE DE DATOS
if ($db->connect_errno)
{
	die('Error al conectar: ' . $db->connect_error);
}