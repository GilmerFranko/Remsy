<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\controller\notifications.php
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de las notificaciones
 *
 *
 */

$page['name'] = 'Notificaciones';
$page['code'] = 'viewNotifications';

/*if(isset($_SESSION['message']))
{
    echo Core::model('extra', 'core')->getToast();
}*/

// OBTENER NOTIFICACIONES
$notifications = Core::model('notifications', 'members')->getNotifications(50);

// OBTENER FOTOS QUE ME HAN REGALADO
$photos = Core::model('notifications', 'members')->getPhotos(20);

// ELIMINAR ANTIGUAS - DE 7 DÍAS (ESTA TAREA SE LE HA PUESTO AL BOT)
//Core::model('notifications', 'members')->removeOldNotifications($session->memberData['member_id'], 7);

// MARCAR COMO LEÍDAS
Core::model('notifications', 'members')->setReadNotifications();

// MOSTRAR NOTIFICACIONES
if(isset($_POST['ajax']))
{
    include Core::view('notifications.ajax');
    exit;
}