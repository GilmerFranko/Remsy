<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        model.class.php                          \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de administrar el modulo Core
 *
 *
*/
/** Como esta actualmente se requeriran/incluiran todos los archivos encargador de administrar los modulos y por lo tanto puede crear lentitud al cargar tantos archivos, se podria cargar solo el archivo necesario como en laravel con la instrucción "use";*/
class mCore extends Module
{
	public function __construct()
	{
		parent::__construct();
		$this->set_module("core");
	}

}
