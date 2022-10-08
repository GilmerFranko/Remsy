<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\controller\groups.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de los grupos (rangos)
 *
 *
 */

if( !isset($_POST['ajax']) )
{
    $page['name'] = 'Rangos - Administraci&oacute;n';
    //
    $groups = Core::model('groups', 'admin')->getGroups();
    //
    $group = array('g_id' => '', 'g_title' => 'Nuevo Rango', 'g_colour' => '#000000', 'g_permissions' => '', 'g_max_messages' => 10, 'g_max_shout_images' => 6);

}
else
{
    if( isset($_GET['action']) && $_GET['action'] == 'form')
    {
        if(isset($_POST['id']) && ctype_digit($_POST['id']))
        {
            $group = Core::model('groups', 'admin')->getGroup($_POST['id']);
            //
            if( $group !== false )
            {
                // SE ESTABLECEN LOS PERMISOS
                $array = explode(',', $group['g_permissions']);
                $group['permissions'] = array_flip($array);
                echo '1:';
            }
            else
            {
                die('0:El rango no existe');
            }
        }
        // SE INCLUYE EL FORMULARIO DE EDICIÓN
        require Core::view('groups.form.area');
    }
    elseif( isset($_GET['do']) )
    {
        if( !empty($_POST['title']) )
        {
            // ESTABLECER TÍTULO
            $group['g_title'] = htmlspecialchars($_POST['title']);
            // ESTABLECER COLOR
            $group['g_colour'] = ctype_xdigit( substr($_POST['colour'], 1) ) ? $_POST['colour'] : 'black';
            // ASIGNAR PERMISOS
            $group['g_permissions'] = htmlspecialchars($_POST['permissions']);
            // NÚMERO MÁXIMO DE MENSAJES QUE PUEDE CONSERVAR
            $group['g_max_messages'] = ctype_digit($_POST['max_messages']) ? $_POST['max_messages'] : 50;
            // NÚMERO MÁXIMO DE SHOUTS QUE PUEDE PUBLICAR
            $group['g_max_shout_images'] = ctype_digit($_POST['max_shout_images']) ? $_POST['max_shout_images'] : 6;
            // ESTABLECER CANTIDAD DE PERMISOS
            $group['g_count_permissions'] = strpos($group['g_permissions'], 'admin') !== false ? 'Todos' : (int)(count(explode(',', $group['g_permissions'])));
            // EJECUTAR ACCIÓN
            if( $_GET['do'] == 'edit' && isset($_POST['id']) && ctype_digit($_POST['id']) )
            {
                $do = Core::model('groups', 'admin')->editGroup($group, $_POST['id']);
            }
            else
            {
                $do = Core::model('groups', 'admin')->newGroup($group);
            }
            //
            if( is_array($do) )
            {
                //Core::model('extra', 'core')->setToast( array($do[0], 'success') );
                //
                die($do[1] . ': ' . $do[0]);
            }
            else
            {
                die('0:Ha ocurrido un error');
            }
        }
        else
        {
            die('0:Debe asignar un nombre al rango');
        }
    }
}