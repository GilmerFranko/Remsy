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
 * @Description Controlador de las pestsañas del perfil
 *
 *
 */
$page['name'] = 'Shouts';
$page['code'] = 'memberTabs';

if( isset($_POST['ajax']) && isset($_POST['member']) && ctype_digit($_POST['member']) )
{
    // DECLARAR Y FILTRAR VARIABLES
    $member = (int) $_POST['member'];
    $tab = isset($_GET['tab']) ? substr($_GET['tab'],2) : 'shouts';

    // SHOUTS
    if($tab == 'shouts' || $tab == 'shoutsVip')
    {
        $page['code'] = 'listShouts';
        $vip = $tab == 'shoutsVip' ? true : false;

        $shouts = Core::model('shout', 'shouts')->getAllShouts(true, 30, $member, true, $vip);
        if($shouts == true)
        {
            // LOS PERFILES NO TIENEN PAGINACION
            $shouts['pages']['paginator'] = '';

            // MOSTRAR SHOUTS
            echo '1:';
            include Core::view('list.area', 'shouts');
            exit;
        }
        else
        {
            $message[] = array('No hay shouts', 2);
        }
    }
    elseif($tab == 'followers')
    {
        $page['code'] = 'memberFollowers';

        $followers = Core::model('profile', 'members')->getFollowsBlocks(0, $member, 0, 'follow', 15);
        if($followers == true)
        {
            // MOSTRAR SEGUIDORES
            echo '1:';
            include Core::view('profile.followers.area', 'members');
            exit;
        }
        else
        {
            $message[] = array('No hay seguidores', 2);
        }
    }
    elseif($tab == 'following')
    {
        $page['code'] = 'memberFollowers';

        $following = Core::model('profile', 'members')->getFollowsBlocks($member, 0, 1, 'follow', 15);
        if($following == true)
        {
            // MOSTRAR SIGUIENDO
            echo '1:';
            include Core::view('profile.following.area', 'members');
            exit;
        }
        else
        {
            $message[] = array('No hay seguidores', 2);
        }
    }
    else
    {
        $message[] = array('P&aacute;gina no encontrada: ' . $tab, 2);
    }
}

// RETORNAR MENSAJE
echo $message[0][1] . ':' . $message[0][0];

// Detener ejecución del script
exit;