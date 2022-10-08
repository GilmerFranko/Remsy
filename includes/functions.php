<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        function.php                          \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Archivo que contiene varias funciones intuitivas, rápidas e imprescindibles
 *
 *
*/

/**
 * Carga una clase de un modulo
 * @param  String $route Ruta
 * @return Class
 */
function loadClass(String $route)
{
	if($route = explode('/',$route))
	{
		return Core::model($route[1], $route[0]);
	}
	return false;
}

/**
 * Carga la clase relacionada a una tabla
 * @param  String $tabla Nombre de la tabla
 * @return Class
 */
function db(String $table)
{
	return LoadTable::model($table);
}
