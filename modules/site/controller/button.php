<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\controller\coins.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de los creditos
 *
 *
 */
$page['name'] = 'Cr&eacute;ditos gratis';
$page['code'] = 'siteButton';

// CARGAR DATOS DE USO DEL BOTÓN
$button = unserialize($session->memberData['coins_free']);

// SI HAN PASADO MÁS DE 8 HORAS, REINICIAMOS DATOS
if($button['next_date'] < time())
{
	$button = array(
		'first_date' => time(),
		'next_date' => time()+21600,
		'clicks' => 0,
		'coins' => (int)$button['coins'],
	);
}
else
{
	// GENERAR DATOS
	$button = array(
		'first_date' => $button['first_date'],
		'next_date' => $button['next_date'],
		'clicks' => $button['clicks'],
		'coins' => ($button['coins']+$config['coins_per_click']),
	);
}


if(isset($_POST['ajax']))
{
	// COMPROBAR QUE NO HA SUPERADO LA CUOTA DIARIA
	if($button['clicks'] < 3)
	{
		// SUMAR CLICK
		++$button['clicks'];
		// SERIALIZAR DATOS
		$coinsFree = serialize($button);
		// ACTUALIZAR DATOS DEL USUARIO
		$updated = Core::model('account', 'members')->setMemberInput($coinsFree, 'coins_free', $session->memberData['member_id']);
		# Si se ha actualizado...
		if($updated == true)
		{
			// SUMAR CRÉDITOS AL USUARIO
			Core::model('db', 'core')->updateCount('members', 'coins', $session->memberData['member_id'], ('+' . $config['coins_per_click']) , 'member_id');
			$message[] = array('Cr&eacute;ditos regalados', 'success');
		}
		# Si hay algún error
		else
		{
			$message[] = array('No se ha podido actualizar la informac&iacute;on del usuario', 'error');
		}
	}
	else
	{
		$message[] = array('Has superado la cuota diaria', 'error');
	}

	// COMPROBAR MENSAJES
	if(isset($message[0][0]))
	{
		die( ($message[0][1] === 'error' ? '0: ' : '1: ') . $message[0][0] );
	}
}