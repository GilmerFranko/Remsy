<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\site\controller\pages.php        \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador de las páginas estáticas del sitio
 *
 *
 */

if(isset($_GET['name']) && !empty($_GET['name']))
{
	$page = (string)$_GET['name'];
	require Core::view('page.'.$page);
	/*if($_GET['name'] == 'dmca')
	{
		require Core::view('page.dmca');
	}
	elseif($_GET['name'] == 'privacy')
	{
		require Core::view('page.privacy');
	}
	elseif($_GET['name'] == 'protocol')
	{
		require Core::view('page.protocol');
	}
	elseif($_GET['name'] == 'terms')
	{
		require Core::view('page.terms');
	}
	else
	{
		$message[] = array('No se ha encontrado la p&aacute;gina');
	}*/
}
else
{
	$message[] = array('P&aacute;gina no especificada');
}

if(isset($message[0][0]))
{
	// PÁGINA NO ENCONTRADA
	require BG_TEMPLATES . 'error' . DS . '404.php';
}
// FINALIZAR EJECUCIÓN DEL SCRIPT
exit;