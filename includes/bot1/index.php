<?php
/**
 *-------------------------------------------------------/
 * @file        bot.php                                  \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Se publican bots del día siguiente
 *
 *
 */

// DEFINE LA CABECERA
define('SUPERNATURAL', TRUE);

// DEFINE DIRECTORIO PRINCIPAL
define('BG_DIR', str_replace("includes", '', dirname(__DIR__)) );

// DEFINE DIRECTORIO DE IMAGENES
define('BG_IMAGES', BG_DIR . 'filestore' . DIRECTORY_SEPARATOR);

// ESTABLECE ZONA HORARIA EN LA QUE SE BASAN LAS PUBLICACIONES
date_default_timezone_set('America/Costa_Rica');

// INCLUYE LA BASE DE DATOS
require 'database.php';

// INCLUYE FUNCIONES
require 'functions.php';

// ELIMINAR IMAGENES NO UTILIZADAS (Función eliminada por unknowthrow en BellasGram - sin copia)
//cleanImages();

// ELIMINAR NOTIFACIONES LEIDAS DE LOS ULTIMOS 7 DIAS
$notifications = deleteNotifications(7);

// ELIMINAR RECOVERS DE MÁS DE 1 DIA
$recovers = deleteRecovers(1);

// ELIMINAR SHOUTS DE MÁS DE 90 DIAS
$deleted = deleteShouts(90);

// ELIMINAR SUSPENDIDOS DE MÁS DE 30 DIAS
$banned = deleteBanned(30);

// ELIMINAR FOTOS REGALADAS EXPIRADAS
$photos = deletePhotosGifts();

// ENVIAR CORREOS
$bulkemails = sendBulkemails(1, 5);

// REGISTRAR PROXIMAS PUBLICACIONES
require 'post-shouts.php';

// SI HAY BOTS SIN IMAGENES
if (!empty($bi) && is_array($bi))
{
	$bots = implode(', ', $bi);
	$botsCant = count($bi);
	// AVISAR AL ADMINISTRADOR (1) DE QUE NO TIENE FOTOS
	$db->query('INSERT INTO `members_notifications` (`to_member`, `from_member`, `not_key`, `content`, `sent_time`) VALUES (\'1\', \'0\', \'botWithoutPhoto\', \'<strong>' . $botsCant . ' sin fotos:</strong> ' . $bots . '.\', UNIX_TIMESTAMP()) ');
	$html .= '<strong>Bots sin fotos:</strong> ' . $botsCant . ': ' . $bots . '<br/>';
}
$result = '<strong>Notificaciones eliminadas:</strong> ' . $notifications . '<br/>
<strong>Recovers eliminados:</strong> ' . $recovers . '<br/>
<strong>Shouts eliminados:</strong> ' . $deleted . '<br/>
<strong>Usuarios suspendidos eliminados:</strong> ' . $banned . '<br/>
<strong>Fotos regaladas expiradas eliminadas:</strong> ' . $photos . '<br/>
<strong>Bots:</strong> ' . $totalBots . '<br/>
<strong>Bots que publican:</strong> ' . $botsCount . '<br/>
<strong>Shouts publicados:</strong>' . $s . ' (' . $sd . ' de d&iacute;a y ' . $sn . ' de noche)<br/>
<strong>Notificaciones enviadas:</strong> ' . $n . '<br/>
<strong>Correos enviados:</strong> 1 (' . $bulkemails . ')<br/>
<strong>Errores SQL:</strong> ' . $e;

// LISTA DE ADMINISTRADORES
$admins = array(1, 23699);

// ELIMINAR NOTIFICACIONES ANTERIORES
$db->query('DELETE FROM `members_notifications` WHERE `not_key` = \'botExecuted\' || `not_key` = \'botSchedules\' LIMIT 6');

// INSERTAR NOTIFICACION A ADMINS
foreach ($admins as $val)
{
    // AVISAR AL ADMINISTRADOR DE LA EJECUCIÓN DEL BOT
	$db->query('INSERT INTO `members_notifications` (`to_member`, `from_member`, `not_key`, `content`, `sent_time`) VALUES (\''.$val.'\', \'0\', \'botExecuted\', \'' . $result . '\', UNIX_TIMESTAMP()) ');
	$schedules = $night['schedules'] . $day['schedules'];

	// AVISAR AL ADMINISTRADOR DE LOS HORARIOS DE BOTS
	$db->query('INSERT INTO `members_notifications` (`to_member`, `from_member`, `not_key`, `content`, `sent_time`) VALUES (\''.$val.'\', \'0\', \'botSchedules\', \'' . $schedules . '\', UNIX_TIMESTAMP()) ');
}

// MOSTRAR RESULTADO
echo $html . $result . '<br/><br/>' . $schedules;