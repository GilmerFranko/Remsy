<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\controller\profile.php   \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador de los seguidores de usuarios
 *
 *
 */

if( isset($_GET['user'], $_GET['action'], $_GET['token']) )
{
    // ANTIFLOOD
    $antiFlood = Core::model('extra', 'core')->antiFlood('follow', '', false);
    
    if($antiFlood === true)
    {
        // COMPRUEBA TOKEN (CSRF)
        if($session->checkToken($_GET['token']) == true)
        {
            // COMPROBAR QUE TENGO PERMISO PARA SEGUIR O DEJAR DE SEGUIR
            if( $session->isAllowed('follow_members') )
            {
                //if( ctype_alnum($username) )
                if( ctype_digit($_GET['user']) )
                {
                    // SE COMPRUEBA QUE EL USUARIO EXISTE
                    $user = Core::model('db', 'core')->getColumns('members', array('member_id', 'name', 'bot'), array('member_id', $_GET['user']));
                    if( $user != false && $user['member_id'] > 0 )
                    {
                        // SIGUE O DEJA DE SEGUIR
                        if($_GET['action'] == 'follow')
                        {
                            // SE COMPRUEBA QUE NO ME TENGA BLOQUEO
                            $block_from = Core::model('profile', 'members')->getFollowsBlocks($user['member_id'], $session->memberData['member_id'], 0, 'block', 1);
                            // SE COMPRUEBA QUE NO LO TENGO BLOQUEADO
                            $block_to = Core::model('profile', 'members')->getFollowsBlocks($session->memberData['member_id'], $user['member_id'], 0, 'block', 1);

                            if($block_from == false && $block_to == false)
                            {
                                // SE COMPRUEBA QUE NO LO SIGA YA
                                if(Core::model('profile', 'members')->getFollowsBlocks($session->memberData['member_id'], $user['member_id'], 0, 'follow', 1) == false)
                                {
                                    // EMPIEZA A SEGUIRLO
                                    if( Core::model('profile', 'members')->setFollowBlock($session->memberData['member_id'], $user['member_id'], 'follow') == true)
                                    {
                                        // SUMAR SEGUIDOR AL USUARIO
                                        Core::model('db', 'core')->updateCount('members', 'follows', $user['member_id'], '+1', 'member_id');
                                        // NOTIFICACION DE SEGUIMIENTO (SI NO ES BOT)
                                        if($user['bot'] == '0')
                                        {
                                            Core::model('notifications', 'members')->newNotification($user['member_id'], $session->memberData['member_id'], 'follow');
                                        }

                                        // MENSAJE DE CONFIRMACION
                                        $message[] = array('Ahora sigues a ' . $user['name'], 'success');
                                    }
                                    else
                                    {
                                        $message[] = array('Error al seguir a ' . $user['name'], 'error');
                                    }
                                }
                                else
                                {
                                    $message[] = array('Ya sigues a ' . $user['name'], 'error');
                                }
                            }
                            else
                            {
                                $message[] = array('Hay un problema con ' . $user['name'], 'error');
                            }
                        }
                        elseif($_GET['action'] == 'unfollow')
                        {
                            // DEJAR DE SEGUIRLO
                            if( Core::model('profile', 'members')->setUnfollowBlock($session->memberData['member_id'], $user['member_id'], 'follow') == true )
                            {
                                // SUMAR SEGUIDOR AL USUARIO
                                Core::model('db', 'core')->updateCount('members', 'follows', $user['member_id'], '-1', 'member_id');

                                // MENSAJE DE CONFIRMACION
                                $message[] = array('Ya no sigues a ' . $user['name'], 'success');
                            }
                            else
                            {
                                $message[] = array('Error al dejar de seguir', 'error');
                            }
                        }
                        else
                        {

                            $message[] = array('Acci&oacute;n no definida', 'error');
                        }
                    }
                    else
                    {
                        $message[] = array('El usuario no existe', 'error');
                    }
                }
                else
                {
                    $message[] = array('El usuario no puede existir', 'error');
                }
            }
            else
            {
                $message[] = array('No tienes permiso para eso', 'error');
            }
        }
        else
        {
            $message[] = array('Token incorrecto', 'error');
        }
    }
    else
    {
        $message[] = array('Espera ' . $antiFlood . ' segundos', 'error');
    }

    Core::model('extra', 'core')->setToast($message);

    //
    if( !empty($message[0][0]) )
    {
        Core::model('extra', 'core')->setToast($message);
        Core::model('extra', 'core')->generateUrl('members', 'profile', NULL, array('user' => $_GET['user']), true);
    }
}
else
{
    // Si estoy registrado, me redirige a mi perfil, pero si no, me redirige a la pagina principal
    if($session->is_member == true) {
        Core::model('extra', 'core')->generateUrl('members', 'profile', NULL, array('user' => $session->memberData['member_id']), true);
    } else {
        Core::model('extra', 'core')->redirectTo( Core::config('base_url') );
    }
}

// DETIENE LA EJECUCION
exit;