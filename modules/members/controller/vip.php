<?php defined('SUPERNATURAL') || exit;
/**
 *-------------------------------------------------------/
 * @file        modules\members\controller\vip.php       \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de las membresias
 *
 *
 */
$page['name'] = 'Membres&iacute;a VIP';
$page['code'] = 'memberVip';

// GENERAR MEMBRESIAS
$memberships = array(
	array(
		'coins' => 2000,
		'title' => '1 d&iacute;a',
		'days' => 1,
	) ,
	array(
		'coins' => 5000,
		'title' => '1 semana',
		'days' => 7,
	),
	array(
		'coins' => 15000,
		'title' => '1 mes',
		'days' => 30,
	),
	array(
		'coins' => 50000,
		'title' => '1 a&ntilde;o',
		'days' => 365,
	)
);

// En cuanto se dividen las columnas
$cols = 12/count($memberships);

// SI SE ADQUIEREN
if(isset($_POST['plan']))
{	// COMPROBAR SI EL PLAN EXISTE
	if(isset($memberships[$_POST['plan']]))
	{
		$plan = $memberships[$_POST['plan']];
		$days = $plan['days']*86400;
		$time = $session->memberData['vip'] < time() ? time()+$days : $session->memberData['vip']+$days;
		// COMPROBAR SI TENGO CREDITOS SUFICIENTES
		if($session->memberData['coins'] >= $plan['coins'])
		{
			// RESTAR CREDITOS AL USUARIO
			if( Core::model('db', 'core')->updateCount('members', 'coins', $session->memberData['member_id'], ('-'.$plan['coins']), 'member_id') == true)
			{
				// SUMAR DIAS VIP
				if( Core::model('account', 'members')->setMemberInput($time, 'vip', $session->memberData['member_id']) == true)
				{

					$message[] = array('Gracias por adquirir la membres&iacute;a', 'success');
				}
				else
				{
					$message[] = array('Error al sumar los d&iacute;as VIP', 'error');
				}
			}
			else
			{
				$message[] = array('Error al restar los cr&eacute;ditos', 'error');
			}
		}
		else
		{
			$message[] = array('No tienes suficientes cr&eacute;ditos', 'error');
		}
	}
	else
	{
		$message[] = array('La membres&iacute;a no existe', 'error');
	}

	// ESTABLECER MENSAJE EN LA SESION
	Core::model('extra', 'core')->setToast($message);
	// RECARGAR PAGINA
	if($message[0][1] == 'success')
	{
		header('Refresh:0');
	}
}