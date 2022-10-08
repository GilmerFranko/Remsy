<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\controller\account.php   \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador de sección "Perfil" en la cuenta
 *
 *
 */

// ELEGIR NOMBRE COMPLETO
$profile['full_name'] = empty($_POST['full_name']) ? '' : htmlspecialchars($_POST['full_name']);
// SELECCIONAR ZONA HORARIA
$profile['timezone'] = empty($_POST['timezone']) ? 'America/Los_Angeles' : $_POST['timezone'];
//
if (Core::model('account', 'members')->saveProfile($profile, $session->memberData['member_id']) === true)
{
    if (empty($message))
    {
        $message[] = array(
            'Informaci&oacute;n actualizada',
            'success'
        );
    }
}
else
{
    $message[] = array(
        'No se pudieron guardar algunos cambios',
        'error'
    );
}