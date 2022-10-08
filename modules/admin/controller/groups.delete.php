<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        ...\admin\controller\groups.delete.php   \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de la eliminación de los rangos
 *
 *
 */

if( isset($_GET['id']) )
{
    if( ctype_digit($_GET['id']) )
    {
        if( $_GET['id'] > 3 )
        {
            if( Core::model('groups', 'admin')->deleteGroup($_GET['id']) === true )
            {
                $message = array('Se ha eliminado el rango', 'success');
            }
            else {
                $message = array('No se pudo eliminar el rango', 'error');
            }
        }
        else {
            $message = array('No puede eliminar un rango predeterminado', 'error');
        }
    } else {
        $message = array('Est&aacute; intentando eliminar algo extra&ntilde;o', 'error');
    }
} else {
    $message = array('Debe especificar qu&eacute; rango quiere eliminar', 'error');
}
if( isset($_GET['ajax']) )
{
    die( ($message[1] === 'error' ? '0: ' : '1: ') . $message[0] );
}
else
{
    // ESTABLECE UN MENSAJE EN CASO DE HABERLO
    Core::model('extra', 'core')->setToast($message);
    // REDIRIGIR
    Core::model('extra', 'core')->generateUrl('admin', 'groups', NULL, array('delete' => $message[1]), true);
}