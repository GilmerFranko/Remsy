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

$page['name'] = 'Palabras Bots';
$page['code'] = 'adminBotsWords';

// PROCESOS DINÁMICOS
if( !isset($_POST['ajax']) || ( isset($_POST['ajax']) && isset($_GET['page']) ) )
{
    $page['name'] = 'Palabras Bots - Administraci&oacute;n';
    //
    $bots = Core::model('bots', 'admin')->getWords();
    //
    if($bots['rows'] < 1)
    {
        $message[] = array('No hay resultados', 'warning');
        Core::model('extra', 'core')->setToast($message);
    }
    //
    if(isset($_POST['ajax']))
    {
        if($bots !== false)
        {
            echo '1: ';
            // SE INCLUYE EL AREA DE BOTS
            require Core::view('bots.area');
            exit;
        }
        else
        {
            die('0: No se pudo cambiar de p&aacute;gina');
        }
    }
}

// SE OBTIENEN LOS BOTS QUE RESPONDEN
$bots['answers'] = Core::model('bots', 'admin')->getAnswersBots();