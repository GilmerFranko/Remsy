<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\controller\news.php        \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de las acciones para las noticias (agregar y eliminar)
 *
 *
 */

// COMPROBAR SI SE HA ESPECIFICADO ACCION Y TIPO
if( isset($_GET['do']) )
{
    // ACCIÓN SOBRE PALABRAS
    if($_GET['do'] == 'new')
    {
        if(isset($_POST['content']) && !empty($_POST['content']))
        {
            // AGREGAR CENSURA
            $new = Core::model('news', 'admin')->newNew($_POST['content']);

            if($new > 0)
            {
                $message[] = array('Noticia agregada', 'success');
            }
            else
            {
                $message[] = array('No se ha podido agregar la noticia', 'error');
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
        $delete = Core::model('db', 'core')->deleteRow('site_news', $_GET['id']);
        if($delete == true)
        {
            $message[] = array('Noticia eliminada', 'success');
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
Core::model('extra', 'core')->generateUrl('admin', 'news', NULL, array('save' => $message[0][1]), true);
