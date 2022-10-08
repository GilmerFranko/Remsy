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
 * @Description Controlador principal de las acciones para las censuras (agregar y eliminar)
 *
 *
 */

// COMPROBAR SI SE HA ESPECIFICADO ACCION Y TIPO
if( isset($_GET['do']) )
{
    // ACCIÓN SOBRE PALABRAS
    if($_GET['do'] == 'new')
    {
        if(isset($_POST['text_from']) && isset($_POST['text_to']) && isset($_POST['reason']) && !empty($_POST['text_from']) && !empty($_POST['text_to']) && !empty($_POST['reason']))
        {
            // AGREGAR CENSURA
            $censor = Core::model('censors', 'admin')->newCensor($_POST['text_from'], $_POST['text_to'], $_POST['reason']);

            if($censor > 0)
            {
                $message[] = array('Censura agregada', 'success');
            }
            else
            {
                $message[] = array('No se ha podido agregar la censura', 'error');
            }
        }
        else
        {
            $message[] = array('Campos vac&iacute;os', 'error');
        }
    }
    elseif($_GET['do'] == 'delete' && isset($_GET['id']) && ctype_digit($_GET['id']))
    {
        // ELIMINAR CENSURA
        $delete = Core::model('db', 'core')->deleteRow('site_censors', $_GET['id']);
        if($delete == true)
        {
            $message[] = array('Censura eliminada', 'success');
        }
        else
        {
            $message[] = array('No se ha podido eliminar #' . $_GET['id'], 'error');
        }
    }
    else
    {
        $message[] = array('Acci&oacute;n desconocida', 'error');
    }
}
else
{
    $message[] = array('Faltan par&aacute;metros', 'error');
}

// ESTABLECE UN MENSAJE EN CASO DE HABERLO
Core::model('extra', 'core')->setToast($message);
// REDIRIGIR
Core::model('extra', 'core')->generateUrl('admin', 'censors', NULL, array('save' => $message[0][1]), true);
