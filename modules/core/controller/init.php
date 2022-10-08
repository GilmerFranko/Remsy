<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\core\controller\index.php        \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Se incluyen los archivos necesarios para mostrar la página
 *
 *
*/

/* Se carga el modelo del internauta y se comprueba la sesión */
$session = Core::model('session', 'core');
$extra = Core::model('extra', 'core');
$db = Core::model('db', 'core');
// ESTABLECE ZONA HORARIA EN LA QUE SE BASAN LAS PUBLICACIONES
//date_default_timezone_set($session->memberData['pp_timezone']);
$extra->db->set_charset('utf8');
$extra->db->query('SET NAMES  "utf8"');
$extra->db->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");


/* Se comprueba si se puede acceder al sitio */
Core::model('extra', 'core')->checkLoad();

/* Se define el módulo y la sección a cargar
* Si es visitante, muestra home-guest, si no, muestra home-member
*/
$sModule = isset($_GET['app']) ? strtolower($_GET['app']) : 'works';
$sSection = isset($_GET['section']) ? strtolower($_GET['section']) : 'groups' ;

$sSection = isset($_GET['area']) ? $sSection .'.'. $_GET['area'] : $sSection;

/* Se comprueba si existe el archivo a cargar */
$sModuleFile = BG_MODS . $sModule . DS . 'controller' . DS . $sSection . '.php';

if(file_exists($sModuleFile))
{
	/* Se comprueba el nivel de acceso */
	require BG_CONF . 'config.level.php';

	/* Se establece el módulo */
	Core::setModule($sModule, $sSection, $config);

	/* Se incluye el controlador del módulo */
	require Core::controller($sSection);

	/* Se incluye la vista del módulo si no es una petición ajax. Si lo es se muestra un error en caso de haberlo - EN REVISIÓN */
	if( !isset($_POST['ajax']) )
	{
		/*Incluir header*/
		require Core::view('head', 'core');
		/*Incluir navbar*/
		require Core::view('menu', 'core');
		/*Mostrar la vista*/
		require Core::view($sSection, '', 'index');
		/*Se incluye archivo controlador javascript de existir*/
		$sModuleFile = BG_MODS . $sModule . DS . 'controller' . DS . $sSection . '.javascript.php';
		if(file_exists($sModuleFile))
		{
			require $sModuleFile;
		}
		/*Incluir footer*/
		require Core::view('footer', 'core');

		/*Mostrar mensaje de sesion*/
		if(isset($_SESSION['message']))
		{
			echo Core::model('extra', 'core')->getToast();
		}
	}
	else
	{
		echo Core::model('extra', 'core')->getToast($message);
	}
}
else
{
	require BG_TEMPLATES . 'error' . DS . '404.php';
}
