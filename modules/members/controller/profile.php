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
 * @Description Controlador principal del perfil
 *
 *
 */
if( isset($_GET['user']) && ctype_digit($_GET['user']) )
{
    // SE ASOCIA LA INFORMACIÓN DEL PERFIL
    $memberData = Core::model('profile', 'members')->getMemberProfile($_GET['user']);
    //
    if( is_array($memberData) )
    {
            // COMPROBAR SI ME TIENE BLOQUEADO
            if(Core::model('profile', 'members')->checkBlock($session->memberData['member_id'], $memberData['member_id']) === false)
            {

                // ESTABLECE EL TÍTULO DE LA PÁGINA
                $page['name'] = 'Perfil de ' . $memberData['name'];
                $page['code'] = 'memberProfile';
            }
            else
            {
                $message[] = array('El usuario no aparece', 'error');
            }
        }
        else
        {
            $message[] = array('El usuario no existe', 'error');
        }
    //
    if( !empty($message[0][0]) )
    {
        require BG_TEMPLATES . 'error' . DS . '404.php';
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