<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\controller\config.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de la configuración del sitio
 *
 *
 */

$page['name'] = 'Configuraci&oacute;n - Administraci&oacute;n';
$page['code'] = 'adminConfiguration';
//
if( isset($_POST['save']) )
{
    if( ctype_alnum($_POST['cookie_name']) )
    {
        // NOMBRE DEL SITIO
        $data['script_name'] = empty($_POST['script_name']) ? 'SUPERNATURAL' : htmlspecialchars($_POST['script_name']);
        // TAMAÑO MÍNIMO DE AVATAR
        $data['avatar_min_size'] = is_numeric($_POST['avatar_min_size']) ? (float)$_POST['avatar_min_size'] : 1;
        // TAMAÑO MÁXIMO DE AVATAR
        $data['avatar_max_size'] = is_numeric($_POST['avatar_max_size']) ? (float)$_POST['avatar_max_size'] : 5;
        // ANCHO MÍNIMO DE AVATAR
        $data['avatar_min_x'] = ctype_digit($_POST['avatar_min_x']) ? $_POST['avatar_min_x'] : 50;
        // ANCHO MÁXIMO DE AVATAR
        $data['avatar_max_x'] = ctype_digit($_POST['avatar_max_x']) ? $_POST['avatar_max_x'] : 300;
        // ALTO MÍNIMO DE AVATAR
        $data['avatar_min_y'] = ctype_digit($_POST['avatar_min_y']) ? $_POST['avatar_min_y'] : 50;
        // ALTO MÁXIMO DE AVATAR
        $data['avatar_max_y'] = ctype_digit($_POST['avatar_max_y']) ? $_POST['avatar_max_y'] : 300;
        // CODIGO PUBLICIDAD 300X250
        $data['ad_300x250'] = empty($_POST['ad_300x250']) ? '' : $_POST['ad_300x250'];
        // TAMAÑO MÁXIMO DE VÍDEO
        $data['shouts_video_max_size'] = is_numeric($_POST['shouts_video_max_size']) ? (float)$_POST['shouts_video_max_size'] : 10;
        // CARACTERES MÁXIMOS DE SHOUT
        $data['shouts_max_char'] = ctype_digit($_POST['shouts_max_char']) ? $_POST['shouts_max_char'] : 250;
        // PAGO POR CADA 100 DESCARGAS
        $data['shouts_earnings_downloads'] = ctype_digit($_POST['shouts_earnings_downloads']) ? $_POST['shouts_earnings_downloads'] : 100;
        // PRECIO DE LA DESCARGA DE FOTOS
        $data['shouts_price_photo'] = ctype_digit($_POST['shouts_price_photo']) ? $_POST['shouts_price_photo'] : 100;
        // PORCENTAJE DE PUBLICACIÓN DE BOTS
        $data['shouts_percent_day'] = ctype_digit($_POST['shouts_percent_day']) ? $_POST['shouts_percent_day'] : 70;
        // PORCENTAJE DE PUBLICACIÓN DE BOTS POR LA NOCHE
        $data['shouts_percent_night'] = ctype_digit($_POST['shouts_percent_night']) ? $_POST['shouts_percent_night'] : 20;
        // CREDITOS POR CADA CLICK EN LA PÁGINA DE BOTONES
        $data['coins_per_click'] = ctype_digit($_POST['coins_per_click']) ? $_POST['coins_per_click'] : 3;
        // VEROTEL - SIGNATUREKEY (FIRMA)
        $data['verotel_signature'] = empty($_POST['verotel_signature']) ? '' : $_POST['verotel_signature'];
        // VEROTEL - ID DE TIENDA
        $data['verotel_shop_id'] = ctype_digit($_POST['verotel_shop_id']) ? $_POST['verotel_shop_id'] : 0;
        // ESTABLECER NOMBRE DE COOKIE
        $data['cookie_name'] = htmlspecialchars($_POST['cookie_name']);
        // ESTABLECER DURACIÓN DE COOKIE
        $data['cookie_time'] = empty($_POST['cookie_time']) ? 15 : (int)$_POST['cookie_time'];
        // ELEGIR RANGO POR DEFECTO
        $data['reg_group'] = empty($config['reg_group']) ? '3' : $config['reg_group'];
        // ELEGIR ESTADO DE VALIDACIÓN POR CORREO
        $data['reg_validate'] = empty($_POST['reg_validate']) ? '0' : '1';
        // ELEGIR SI COMPROBAR SI ES CLON DURANTE EL REGISTRO
        $data['check_clon'] = empty($_POST['check_clon']) ? '0' : '1';
        // ELEGIR ESTADO DE MANTENIMIENTO
        $data['maintenance'] = empty($_POST['maintenance']) ? '0' : '1';
        // ELEGIR ESTADO DE DEPURACIÓN
        $data['debug_mode'] = empty($_POST['debug_mode']) ? '0' : '1';
        // USUARIO QUE GUARDA
        $data['save_user'] = $session->memberData['member_id'];
        // IP QUE GUARDA
        $data['save_ip'] = Core::model('extra', 'core')->getIp();
        // FECHA DE GUARDADO
        $data['save_time'] = time();
        //
        $data['saved'] = Core::model('configuration', 'admin')->saveConfig($data);
        if( is_int($data['saved']) )
        {
            $message[] = array('Configuraci&oacute;n actualizada. <a href="' . Core::model('extra', 'core')->generateUrl( 'admin', 'configuration', NULL, array('area' => 'delete', 'id' => $data['saved']) ) . '" class="btn-flat toast-action">Deshacer</a>', 'success');
        }
        else {
            $message[] = array('No se pudieron guardar los cambios', 'error');
        }
    } else {
        $message[] = array('El nombre de la cookie debe ser alfanum&eacute;rico', 'error');
    }
    // ESTABLECER MENSAJE EN LA SESION
    $extra->setToast($message);
    //
    Core::model('extra', 'core')->generateUrl('admin', 'configuration', NULL, array('save' => $message[1]), true);
}
else
{
    $save_name = isset( $config['save_user'] ) ? Core::model('db', 'core')->getColumns('members', 'name', array('member_id', $config['save_user'])) : 'el sistema';
    $save_date = isset( $config['save_date'] ) ? date( 'd/m/Y \a \l\a\s H:i', $config['save_date'] ) : 'siglo pasado';
}