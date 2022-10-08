<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\controller\photos.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal del enviado de fotos
 *
 *
 */

$page['name'] = 'Enviar fotos';
$page['code'] = 'adminPhotos';


// PROCESOS DINÁMICOS
if( !isset($_POST['ajax']) || ( isset($_POST['ajax']) && isset($_GET['page']) ) )
{
    // NOMBRE DE LA PÁGINA
    $page['name'] = 'Enviar fotos - Administraci&oacute;n';
    //  OBTENER LISTA DE 200 BOTS
    $members = Core::model('members', 'admin')->getMembers('', 200, true);
    // OBTENER LISTA DE FOTOS REGALADAS
    $photos = Core::model('admin', 'admin')->getSectionData('photos', 'photos', 10);
    //
    if($photos['rows'] < 1)
    {
        $message[] = array('No hay datos', 'warning');
        Core::model('extra', 'core')->setToast($message);
    }
    //
    if(isset($_POST['ajax']))
    {
        if($members !== false)
        {
            echo '1: ';
            // SE INCLUYE EL AREA DE FOTOS
            require Core::view('photos.area');
            exit;
        }
        else
        {
            die('0: No se pudo cambiar de p&aacute;gina');
        }
    }
}