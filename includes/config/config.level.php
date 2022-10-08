<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        config.level.php                         \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Nivel de acceso para los diferentes módulos
 *
 *
 * NIVEL 0 = CUALQUIERA
 * NIVEL 1 = SOLO VISITANTES
 * NIVEL 2 = SOLO REGISTRADOS
 * NIVEL 3 = MODERADORES Y ADMINISTRADORES
 * NIVEL 4 = SOLO ADMINISTRADORES
 *
*/

// SHOUTS
/*$section['shouts'] = 						array('level' => 2, 'message' => 'Debes iniciar sesi&oacute;n para publicar shouts ', 'url' => '/');
$section['shouts']['download'] = array('level' => 0, 'message' => 'Deber&iacute;as poder entrar aqu&iacute;', 'url' => '/');
*/
// USUARIOS
$section['members']                       = array('level' => 2, 'message' => 'Identif&iacute;cate para continuar', 'url' => '/');
$section['members']['login']              = array('level' => 1, 'message' => 'Debes cerrar sesi&oacute;n antes de volver a identificarte.', 'url' => '/');
$section['members']['logout']             = array('level' => 2, 'message' => 'Para cerrar sesi&oacute;n primero debes identificarte', 'url' => '/');
$section['members']['register']           = array('level' => 1, 'message' => 'Debes cerrar sesi&oacute;n antes de registrarte.', 'url' => '/');
$section['members']['profile']            = array('level' => 2, 'message' => 'Debes identificarse para ver perfiles', 'url' => '/');
$section['members']['account']            = array('level' => 2, 'message' => 'Debes identificarte para editar tu cuenta', 'url' => '/');
$section['members']['account.password']   = array('level' => 2, 'message' => 'Debes identificarte para editar tu contrase&ntilde;a', 'url' => '/');
$section['members']['account.profile']    = array('level' => 2, 'message' => 'Debes identificarte para editar tu perfil', 'url' => '/');
$section['members']['account.avatar']     = array('level' => 2, 'message' => 'Debes identificarte para cambiar tu avatar', 'url' => '/');
$section['members']['follow']             = array('level' => 2, 'message' => 'Debes identificarte para seguir o dejar de seguir usuarios', 'url' => '/');
$section['members']['coins.webhook']      = array('level' => 0, 'message' => 'Identif&iacute;cate si no quieres problemas', 'url' => '/');

// SITIO
$section['site']['button']                = array('level' => 2, 'message' => 'Debes identificarte para recibir cr&eacute;ditos', 'url' => '/');
$section['site']['search']                = array('level' => 2, 'message' => 'Debes identificarte para buscar', 'url' => '/');
$section['site']['recover']               = array('level' => 1, 'message' => 'Debes cerrar sesi&oacute;n antes de pedir un cambio de contrase&ntilde;a', 'url' => Core::model('extra', 'core')->generateUrl('members', 'logout', NULL, array('token' => $session->token)));

// ADMIN
$section['admin']                         = array('level' => 4, 'message' => 'No tienes permisos para acceder', 'url' => '/');
$section['admin']['configuration']        = array('level' => 4, 'message' => 'No tienes permisos para cambiar la configuraci&oacute;n', 'url' => '/');
$section['admin']['configuration.delete'] = array('level' => 4, 'message' => 'No tienes permisos para eliminar configuraciones', 'url' => '/');

// MODERACION
$section['mod']                           = array('level' => 3, 'message' => 'No tienes permisos para acceder', 'url' => '/');
$section['mod']['reports']                = array('level' => 3, 'message' => 'Puedes denunciar, pero no ver las denuncias', 'url' => '/');


/* Se realizan las comprobaciones */
if( isset($section[$sModule][$sSection]) )
{
    $page['level'] = $section[$sModule][$sSection]['level'];
    $page['message'] = $section[$sModule][$sSection]['message'];
}
else
{
    if( isset($section[$sModule]['level']) )
    {
        $page['level'] = $section[$sModule]['level'];
        $page['message'] = $section[$sModule]['message'];
    }
}

if( isset($page['level']) && Core::model('extra', 'core')->setLevel($page['level']) !== true )
{
    require BG_TEMPLATES . 'error' . DS . '401.php';
    exit;
}
