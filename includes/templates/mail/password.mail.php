<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        password.mail.php                        \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Plantilla de correo para recuperar la contraseña
 *
 *
 */

$subject = 'Recuperar acceso de ' . Core::config('script_name');
//
$content = 'Hola ' . $params['name'] .
    ', enviamos este correo porque hemos recibido una petici&oacute;n para recuperar el acceso a su cuenta en <strong>' .
    Core::config('script_name') . '</strong>. Para ello, haga <a href="' . Core::
    model('extra', 'core')->generateUrl('site', 'recover', null, array('hash' => $params['hash'])) .
    '">clic aqu&iacute;</a>. <br /> <br /> Si no la ha solicitado, ignore este mensaje.';
