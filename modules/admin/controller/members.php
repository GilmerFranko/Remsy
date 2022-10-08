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
 * @Description Controlador principal de los usuarios
 *
 *
 */

$page['name'] = 'Usuarios';
$page['code'] = 'adminMembers';

// OBTENER LOS BOTS
$bots = isset($_GET['bots']) ? true : false;
// PREFERENCIAS DE BÚSQUEDAS
$search = '';
if(isset($_REQUEST['search']))
{
    // DEFINIR
    $search = htmlspecialchars($_REQUEST['search']);
    $_SESSION['members']['search'] = $search;
}
else
{
    if(isset($_SESSION['search']))
    {
        $search = $_SESSION['members']['search'];
    }
}

// REDIRIGIR
if( (isset($_POST['search']) && !empty($_POST['search'])) || (isset($_SESSION['members']['search']) && !isset($_GET['search']) ) )
{
    if( !isset($_POST['ajax']) && !empty($search) )
    {
        Core::model('extra', 'core')->generateUrl('admin', 'members', null, array('search' => $search), true);
    }
}

// PROCESOS DINÁMICOS
if( !isset($_POST['ajax']) || ( isset($_POST['ajax']) && isset($_GET['page']) ) )
{
    $page['name'] = 'Usuarios - Administraci&oacute;n';
    //
    $members = Core::model('members', 'admin')->getMembers($search, 10, $bots);
    //
    if($members['rows'] < 1)
    {
        $message[] = array('No hay resultados de ' . $search, 'warning');
        Core::model('extra', 'core')->setToast($message);
    }
    //
    if(isset($_POST['ajax']))
    {
        if($members !== false)
        {
            echo '1: ';
            // SE INCLUYE EL FORMULARIO DE USUARIOS
            require Core::view('members.area');
            exit;
        }
        else
        {
            die('0: No se pudo cambiar de p&aacute;gina');
        }
    }
}

// SE OBTIENEN LOS USUARIOS CONECTADOS
$online = Core::model('members', 'admin')->getOnlines(5);

// SE OBTIENEN TODOS LOS RANGOS
$groups = Core::model('groups', 'admin')->getGroups();
$member = $session->memberData;


if(isset($_POST['ajax']))
{
    if( isset($_GET['action']) && $_GET['action'] == 'form')
    {
        if(isset($_POST['id']) && ctype_digit($_POST['id']))
        {
            $member['name'] = Core::model('db', 'core')->getColumns('members', 'name', array('member_id', $_POST['id']));
            // SE ASOCIA LA INFORMACIÓN DEL PERFIL
            $member = Core::model('profile', 'members')->getMemberProfile($member['name']);
            //
            if( $member !== false ) {
                echo '1: ';
            } else {
                die('0:El usuario no existe');
            }
        }
        // SE INCLUYE EL FORMULARIO DE EDICIÓN
        require Core::view('members.form.area');
    }
    elseif( isset($_GET['do']) )
    {
        if( !empty($_POST['name']) && ($_GET['do'] == 'edit' || !empty($_POST['password'])) && !empty($_POST['email']) )
        {
            if( preg_match("/^([a-zA-Z0-9 ]{4,30}+)$/isu", $_POST['name']) && ($_GET['do'] == 'edit' || strlen($_POST['password']) > 5) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) )
            {
                if(isset($member)) unset($member);
                /* Se definen y limpian las variables */
                $memberData = array_map('htmlspecialchars', $_POST);
                $member['name'] = $memberData['name'];
                $member['email'] = strtolower($memberData['email']);
                $member['pp_gender'] = empty($memberData['pp_gender']) ? '0' : '1';
                $member['group_id'] = ctype_digit($memberData['group_id']) ? $memberData['group_id'] : $config['reg_group'];
                $member['banned'] = empty($memberData['banned']) ? 0 : time();
                $member['newbies_content'] = is_numeric($memberData['newbies_content']) ? (int)$memberData['newbies_content'] : '0';
                $member['bot'] = is_numeric($memberData['bot']) ? (int)$memberData['bot'] : '0';
                $member['bot_response'] = empty($memberData['bot_response']) ? '0' : '1';
                $member['coins'] = is_numeric($memberData['coins']) ? (float)$memberData['coins'] : '0';
                $member['shouts_downloads'] = is_numeric($memberData['shouts_downloads']) ? (int)$memberData['shouts_downloads'] : '0';

                if( !empty($memberData['password']) ) { $member['password'] = password_hash($memberData['password'], PASSWORD_DEFAULT); }
                // SE COMPRUEBA SI EL USUARIO EXISTE
                if( Core::model('member', 'members')->checkUserExists($member['name'], $member['email'], $memberData['id']) === false ) 
                {
                    // COMPROBAR ACCIÓN
                    if( $_GET['do'] == 'edit' )
                    {
                        if( isset($_POST['id']) && ctype_digit($_POST['id']) )
                        {
                            // SE OBTIENE EL RANGO ACTUAL DEL USUARIO
                            $group_id = Core::model('db', 'core')->getColumns('members', 'group_id', array('member_id', $_POST['id']));
                            // GUARDAR CAMBIOS
                            if( Core::model('members', 'admin')->editMember($member, $memberData['id']) === true )
                            {
                                if($group_id != $member['group_id'])
                                {
                                    // SUMAR USUARIO AL RANGO
                                    if(Core::model('groups', 'admin')->alterCountGroup($member['group_id'], true) === true)
                                    {
                                        // RESTAR USUARIO AL RANGO
                                        if(Core::model('groups', 'admin')->alterCountGroup($group_id, false) === false)
                                        {
                                            die('0:La cuenta de ' . $member['name'] . ' ha sido editada. Se ha sumado la cantidad de usuarios al nuevo rango, pero no se ha restado al antiguo rango.');
                                        }
                                    }
                                    else
                                    {
                                        die('0:La cuenta de ' . $member['name'] . ' ha sido editada, pero no se ha sumado la cantidad de usuarios al nuevo rango.');
                                    }
                                }
                                // MUESTRA MENSAJE SATISFACTORIO
                                die('1:La cuenta de ' . $member['name'] . ' ha sido editada correctamente. <a href="#" class="btn-flat toast-action" onclick="window.location.reload(); return false;">Actualizar</a>.');
                            }
                            else {
                                die('0:Hubo un error');
                            }
                        } else {
                            die('0:ID de usuario inv&aacute;lido');
                        }
                    }
                } else {
                    die('0:El usuario ya existe');
                }
            } else {
                die('0:Uno o varios campos son inv&aacute;lidos');
            }
        } else {
            die('0:Los campos no pueden estar vac&iacute;os');
        }
    }
}