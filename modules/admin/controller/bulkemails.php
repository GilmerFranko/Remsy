<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\controller\bulkemail.php  \
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

$page['name'] = 'Enviar correos masivos';
$page['code'] = 'adminbulkemail';

// PROCESOS DINÁMICOS
if( !isset($_POST['ajax']) || ( isset($_POST['ajax']) && isset($_GET['page']) ) )
{
    // NOMBRE DE LA PÁGINA
    $page['name'] = 'Enviar correos - Administraci&oacute;n';
    // OBTENER LISTA DE CORREOS ENVIADOS
    $bulkemails = Core::model('admin', 'admin')->getSectionData('site_bulk_emails', 'bulkemails', 10);

    // COMPROBAR Y OBTENER DESTINATARIOS DE UN ARCHIVO
    if( !isset($_GET['save']) && isset($_GET['id']) && ctype_digit($_GET['id']) )
    {
        // OBTENER DESTINATARIOS
        $addressees = Core::model('bulkemails', 'admin')->listAddressees($_GET['id']);
        $addressees_time = (count($addressees)*1)/1000;
    }


    //
    if($bulkemails['rows'] < 1)
    {
        $message[] = array('No hay datos', 'warning');
        Core::model('extra', 'core')->setToast($message);
    }
    //
    if(isset($_POST['ajax']))
    {
        if($bulkemails !== false)
        {
            echo '1: ';
            // SE INCLUYE EL AREA DE EMAILS
            require Core::view('bulkemails.area');
            exit;
        }
        else
        {
            die('0: No se pudo cambiar de p&aacute;gina');
        }
    }
}