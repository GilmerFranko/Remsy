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
 * @Description Controlador de sección "Avatar" en la cuenta
 *
 *
 */

$page['name'] = 'Cambiar avatar';
$page['code'] = 'changeAvatar';
//
if (isset($_FILES['avatar_pc']) && !empty($_FILES['avatar_pc']['size']))
{
    $message[] = Core::model('account', 'members')->uploadAvatar($_FILES['avatar_pc'], $session->memberData['member_id']);
}
elseif (!empty($_POST['avatar_gravatar']))
{
    $avatar = Core::model('account', 'members')->generateAvatar($session->memberData['email'], 2, true);
    //
    if (Core::model('account', 'members')->setAvatar($avatar, 2, $session->memberData['member_id']) === true)
    {
        $message[] = array(
            'Avatar actualizado con Gravatar',
            'success'
        );
    }
    else
    {
        $message[] = array(
            'No se ha podido guardar gravatar',
            'error'
        );
    }
}
elseif (!empty($_POST['avatar_url']))
{
    $avatar = Core::model('account', 'members')->generateAvatar($_POST['avatar_url'], 1, true);
    //
    if ($avatar === $_POST['avatar_url'])
    {
        if (Core::model('account', 'members')->setAvatar($avatar . '?_r=' . time() , 1, $session->memberData['member_id']) === true)
        {
            $message[] = array(
                'Avatar actualizado',
                'success'
            );
        }
        else
        {
            $message[] = array(
                'No se ha podido guardar el enlace como avatar',
                'error'
            );
        }
    }
    else
    {
        $message[] = array(
            $avatar,
            'error'
        );
    }
}