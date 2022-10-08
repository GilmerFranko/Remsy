<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        ...\admin\controller\groups.default.php   \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de la selección de rango predeterminado para el registro
 *
 *
 */

if( isset($_GET['id']) )
{
    if( ctype_digit($_GET['id']) )
    {
        if( is_array( Core::model('groups', 'admin')->getGroup($_GET['id']) ) )
        {
            if( Core::model('groups', 'admin')->defaultGroup($_GET['id']) === true )
            {
                $message[] = array('Se ha configurado el rango predeterminado', 'success');
            }
            else {
                $message[] = array('No se pudo configurar el rango como predeterminado', 'error');
            }
        }
        else {
            $message[] = array('El rango no existe', 'error');
        }
    } else {
        $message[] = array('Est&aacute; intentando eliminar algo extra&ntilde;o', 'error');
    }
} else {
    $message[] = array('Debe especificar qu&eacute; rango quiere eliminar', 'error');
}
// ESTABLECE UN MENSAJE EN CASO DE HABERLO
Core::model('extra', 'core')->setToast($message);
// REDIRIGIR
Core::model('extra', 'core')->generateUrl('admin', 'groups', NULL, array('default' => $message[0][1]), true);