<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\controller\photos.load.php \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador que obtiene las rutas de la bot seleccionada
 *
 *
 */

// PROCESOS DINÁMICOS
if (isset($_POST['ajax']) && isset($_POST['name']))
{
    // LIMPIAR NOMBRE DE AUTORA
    $author = Core::model('extra', 'core')->cleanVar($_POST['name']);
    // INICIALIZAR ARRAY
    $files  = array();
    // ESTABLECER DIRECTORIO DE BÚSQUEDA
    $botDir = 'filestore/bots/' . $author . '/';
    // OBTENER LISTA DE LAS RUTAS
    foreach (glob($botDir . '*.{jpg,jpeg,png}', GLOB_BRACE) as $archivo)
    {
        $files[str_replace( array( $botDir, '\\', '/' ) , '', $archivo ) ] = $archivo;

    }
    // SI HAY FOTOS
    if (!empty($files))
    {
        die('1: ' . json_encode($files));
    }
    // SI NO HAY FOTOS
    else
    {
        die('0: No hay fotos de ' . $author);
    }
}
elseif(isset($_POST['ajax']) && isset($_POST['search']))
{
    // INICIALIZAR ARRAY
    $users  = array();
    //  OBTENER COINCIDENCIAS
    $members = Core::model('members', 'admin')->getMembers($_POST['search'], 100);
    // OBTENER LISTA DE LOS USUARIOS
    while( $member = $members['data']->fetch_assoc() ) {
        $users[$member['name']] = $member['pp_thumb_photo'];
    }
    // SI HAY FOTOS
    if (!empty($users))
    {
        die('1: ' . json_encode($users));
    }
    // SI NO HAY FOTOS
    else
    {
        die('0: No hay coincidencias');
    }
}
else
{
    die('0: No puedes estar aqu&iacute;');
}