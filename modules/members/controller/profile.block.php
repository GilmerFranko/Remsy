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
 * @Description Controlador de los bloqueos de usuarios
 *
 *
 */

if( isset($_GET['user']) && isset($_GET['action']) && isset($_GET['token']) )
{

    // ANTIFLOOD
    $antiFlood = Core::model('extra', 'core')->antiFlood('block', '', false);
    
    if($antiFlood === true)
    {
        // COMPRUEBA TOKEN (CSRF)
        if($session->checkToken($_GET['token']) == true)
        {
            //
            if(ctype_digit($_GET['user']))
            {
                // SE COMPRUEBA QUE EL USUARIO EXISTE
                $userid = Core::model('member', 'members')->isMember($_GET['user'], '', true);
                if( $userid > 0 ){

                    // BLOQUEA O DESBLOQUEA
                    if($_GET['action'] == 'block')
                    {
                        // SE COMPRUEBA QUE NO LO TENGA BLOQUEADO
                        if(Core::model('profile', 'members')->getFollowsBlocks($session->memberData['member_id'], $userid, 0, 'block', 1) == false)
                        {
                            // BLOQUEA
                            if( Core::model('profile', 'members')->setFollowBlock($session->memberData['member_id'], $userid, 'block') == true)
                            {
                                // ELIMINA SI LO SIGO
                                Core::model('profile', 'members')->setUnfollowBlock($session->memberData['member_id'], $userid, 'follow');
                                // ELIMINA SI ME SIGUE
                                Core::model('profile', 'members')->setUnfollowBlock($userid, $session->memberData['member_id'], 'follow');

                                // SUMAR BLOQUEOS A LAS CUENTAS
                                Core::model('db', 'core')->updateCount('members', 'blocks', $userid, '+1', 'member_id');
                                Core::model('db', 'core')->updateCount('members', 'blocks', $session->memberData['member_id'], '+1', 'member_id');

                                // MENSAJE DE CONFIRMACION
                                $message[] = array('Usuario bloqueado', 'success');
                            }
                            else
                            {
                                $message[] = array('Error al bloquear', 'error');
                            }
                        }
                        else
                        {
                            $message[] = array('Ya existe un bloqueo', 'error');
                        }
                    }
                    elseif($_GET['action'] == 'unblock')
                    {
                        // DESBLOQUEAR
                        if( Core::model('profile', 'members')->setUnfollowBlock($session->memberData['member_id'], $userid, 'block') == true )
                        {
                            // RESTAR BLOQUEOS A LAS CUENTAS
                            Core::model('db', 'core')->updateCount('members', 'blocks', $userid, '-1', 'member_id');
                                Core::model('db', 'core')->updateCount('members', 'blocks', $session->memberData['member_id'], '-1', 'member_id');

                            // MENSAJE DE CONFIRMACION
                            $message[] = array('Has desbloqueado al usuario', 'success');
                        }
                        else
                        {
                            $message[] = array('Error al desbloquear', 'error');
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
            $message[] = array('Token incorrecto', 'error');
        }
    }
    else
    {
        $message[] = array('Espera ' . $antiFlood . ' segundos', 'error');
    }

    //
    if( !empty($message[0][0]) )
    {
        Core::model('extra', 'core')->setToast($message);
        Core::model('extra', 'core')->generateUrl('shouts', 'list', NULL, NULL, true);
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