<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\controller\censors.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de las palabras censuradas
 *
 *
 */

$page['name'] = 'Filtro de texto';
$page['code'] = 'adminCensors';


// PROCESOS DINÁMICOS
if( !isset($_POST['ajax']) || ( isset($_POST['ajax']) && isset($_GET['page']) ) )
{
    $page['name'] = 'Palabras censuradas - Administraci&oacute;n';
    //
    $censors = Core::model('admin', 'admin')->getSectionData('site_censors', 'censors', 10);
    //
    if($censors['rows'] < 1)
    {
        $message[] = array('No hay resultados', 'warning');
        Core::model('extra', 'core')->setToast($message);
    }
    //
    if(isset($_POST['ajax']))
    {
        if($censors !== false)
        {
            echo '1: ';
            // SE INCLUYE EL AREA DE BOTS
            require Core::view('censors.area');
            exit;
        }
        else
        {
            die('0: No se pudo cambiar de p&aacute;gina');
        }
    }
}