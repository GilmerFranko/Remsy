<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        welcome.mail.php                         \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Plantilla de correo para la bienvenida al usuario
 *
 *
 */

$subject = 'Bienvenido a ' . Core::config('script_name');
//
$content = 'Hola ' . $params['name'] .
    ', enviamos este correo porque hemos recibido una petici&oacute;n para validar su cuenta en <strong>' .
    Core::config('script_name') . '</strong>. Para ello, haga <a href="' . Core::
    model('extra', 'core')->generateUrl('site', 'recover', null, array('hash' => $params['hash'])) .
    '">clic aqu&iacute;</a>. <br /> <br /> Si no ha solicitado la activaci&oacute;n, ignore este mensaje.';
