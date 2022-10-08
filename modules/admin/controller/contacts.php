<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\controller\contacts.php    \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de los formularios de contacto
 *
 *
 */

$page['name'] = 'Contactos';
$page['code'] = 'adminContacts';

// COMPROBAR SI SE HA ESPECIFICADO ELIMINAR
if( isset($_GET['do']) && $_GET['do'] == 'delete' && isset($_GET['id']) && ctype_digit($_GET['id']))
{
    // ELIMINAR CONTACTO
    $delete = Core::model('site', 'site')->deleteContact($_GET['id']);
}

// PREFERENCIAS DE BÚSQUEDAS
$search = '';
if(isset($_REQUEST['search']))
{
    // DEFINIR
    $search = htmlspecialchars($_REQUEST['search']);
    $_SESSION['contacts']['search'] = $search;
}
else
{
    if(isset($_SESSION['search']))
    {
        $search = $_SESSION['contacts']['search'];
    }
}

// REDIRIGIR
if( (isset($_POST['search']) && !empty($_POST['search'])) || (isset($_SESSION['contacts']['search']) && !isset($_GET['search']) ) )
{
    if( !isset($_POST['ajax']) && !empty($search) )
    {
        Core::model('extra', 'core')->generateUrl('admin', 'contacts', null, array('search' => $search), true);
    }
}

// PROCESOS DINÁMICOS
if( !isset($_POST['ajax']) || ( isset($_POST['ajax']) && isset($_GET['page']) ) )
{
    $page['name'] = 'Contactos - Administraci&oacute;n';
    //
    $contacts = Core::model('site', 'site')->getContacts($search, 20);
    //
    if($contacts['rows'] < 1)
    {
        $message[] = array('No hay resultados de ' . $search, 'warning');
        Core::model('extra', 'core')->setToast($message);
    }
    //
    if(isset($_POST['ajax']))
    {
        if($contacts !== false)
        {
            echo '1: ';
            // SE INCLUYE EL FORMULARIO DE USUARIOS
            require Core::view('contacts.area');
            exit;
        }
        else
        {
            die('0: No se pudo cambiar de p&aacute;gina');
        }
    }
}