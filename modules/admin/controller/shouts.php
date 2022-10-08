<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\controller\members.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de los shouts
 *
 *
 */

$page['name'] = 'Shouts';
$page['code'] = 'adminShouts';

$shouts = Core::model('shouts', 'admin')->getShouts(15);
//
if ($shouts['rows'] < 1)
{
    $message[] = array(
        'No hay shouts',
        'warning'
    );
    Core::model('extra', 'core')->setToast($message);
}
//
if (isset($_POST['ajax']))
{
    if ($shouts !== false)
    {
        echo '1: ';
        // SE INCLUYE LA TABLA DE SHOUTS
        require Core::view('shouts.area');

        exit;
    }
    else
    {
        die('0: No se pudo cambiar de p&aacute;gina');
    }
}
