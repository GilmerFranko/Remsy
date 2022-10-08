<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\controller\bots.actions.php\
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de las acciones para los bots (agregar o eliminar palabra)
 *
 *
 */

// COMPROBAR SI SE HA ESPECIFICADO ACCION Y TIPO
if( isset($_GET['do']) && isset($_GET['type']))
{
    // ACCIÓN SOBRE PALABRAS
    if($_GET['type'] == 'word')
    {
        // AGREGAR PALABRA
        if($_GET['do'] == 'new')
        {
            // VALIDAR CAMPOS
            if(isset($_POST['word']) && isset($_POST['bot']) && !empty($_POST['word']) && ctype_digit($_POST['bot']))
            {
                // REGISTRAR PALABRA (sin htmlspecialchars, permite HTML)
                $addWord = Core::model('bots', 'admin')->newWord($_POST['bot'], $_POST['word']);
                if( $addWord > 0 )
                {
                    $message[] = array('Palabra agregada: #' . $addWord, 'success');
                }
                else
                {
                    $message[] = array('No se pudo agregar la palabra', 'error');
                }
            }
            else
            {
                $message[] = array('No se ha especificado una palabra', 'error');
            }
        }
        // ELIMINAR PALABRA
        elseif($_GET['do'] == 'delete' && ctype_digit($_GET['id']))
        {
            $deleteWord = Core::model('bots', 'admin')->deleteWord($_GET['id']);
            if($deleteWord == 1)
            {
                $message[] = array('Palabra eliminada', 'success');
            } 
            elseif($deleteWord == 2)
            {
                $message[] = array('Se ha eliminado la palabra, pero no sus respuestas', 'warning');
            }
            else
            {
                $message[] = array('No se ha podido borrar la palabra', 'error');
            }
        }
    }
    elseif($_GET['type'] == 'reply')
    {
        // AGREGAR RESPUESTA
        if($_GET['do'] == 'new' && isset($_POST['reply']) && isset($_POST['word']) && ctype_digit($_POST['word']))
        {
            // BORRAR RESPUESTAS VACÍAS
            $replies = array_filter($_POST['reply']);
            $i = 0;
            foreach ($replies as $reply)
            {
                // REGISTRAR PALABRA (sin htmlspecialchars, permite HTML)
                $addReply = Core::model('bots', 'admin')->newReply(trim($_POST['word']), $reply);
                if( $addReply > 0 )
                {
                    $message[] = array('Respuesta agregada: #' . $addReply, 'success');
                }
                else
                {
                    $message[] = array('No se pudo agregar la respuesta', 'error');
                }

                // SUMAR A RESPUESTAS
                ++$i;
            }
        }
        // ELIMINAR RESPUESTA
        elseif($_GET['do'] == 'delete' && isset($_GET['word']) && ctype_digit($_GET['word']) && isset($_GET['id']) && ctype_digit($_GET['id']))
        {
            if(Core::model('bots', 'admin')->deleteReply($_GET['word'], $_GET['id']) == true)
            {
                $message[] = array('Respuesta eliminada', 'success');
            } 
            else
            {
                $message[] = array('No se ha podido borrar la respuesta', 'error');
            }
        }
    }
    else
    {
        $message[] = array('Tipo desconocido', 'error');
    }
}
else
{
    $message[] = array('Faltan par&aacute;metros', 'error');
}

// ESTABLECE UN MENSAJE EN CASO DE HABERLO
Core::model('extra', 'core')->setToast($message);
// REDIRIGIR
Core::model('extra', 'core')->generateUrl('admin', 'bots', NULL, array('save' => $message[0][1]), true);
