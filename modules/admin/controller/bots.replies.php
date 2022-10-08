<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\controller\botsanswers.php \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de las respuestas de bots
 *
 *
 */

$page['name'] = 'Respuestas Bots';
$page['code'] = 'adminBotsAnswers';

// PROCESOS DINÁMICOS
if( isset($_GET['search']) && ctype_digit($_GET['search']) )
{
    $page['name'] = 'Respuestas Bots - Administraci&oacute;n';
    //
    $replies = Core::model('bots', 'admin')->getReplies($_GET['search']);
    //
    if($replies['rows'] < 1)
    {
        $message[] = array('No hay respuestas en esta palabra', 'warning');
        Core::model('extra', 'core')->setToast($message);
    }
    //
    if(isset($_POST['ajax']))
    {
        if($replies !== false)
        {
            echo '1: ';
            // SE INCLUYE EL AREA DE BOTS
            require Core::view('bots.replies.area');
            exit;
        }
        else
        {
            die('0: No se pudo cambiar de p&aacute;gina');
        }
    }
}
else
{
    $message[] = array('ID de palabra incorrecta', 'error');
}

if(isset($message[0][0]))
{
    // ESTABLECE UN MENSAJE EN CASO DE HABERLO
    Core::model('extra', 'core')->setToast($message);
    // REDIRIGIR
    Core::model('extra', 'core')->generateUrl('admin', 'bots', null, array('save' => $message[0][1]), true);
}