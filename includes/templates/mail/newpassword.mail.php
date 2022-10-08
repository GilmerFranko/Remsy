<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        newpassword.mail.php                     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Plantilla de correo para enviar contraseña por email
 *
 *
 */

$subject = 'Recuperar acceso de ' . Core::config('script_name');
//
$content = 'Hola ' . $params['name'] .
    ', tu nueva contrase&ntilde;a es <strong>' . $params['password']. '</strong> <br /> <br /> Si no la ha solicitado, cambie su contrase&ntilde;a cuanto antes.';
