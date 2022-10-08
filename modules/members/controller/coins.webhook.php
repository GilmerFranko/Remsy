<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\controller\coins.webhook.php\
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal del receptor de compras
 *
 *
 * Signature Key: b2z8eS6uAaB3y3a6FRhHKKB2wxdcgx
 * Shop ID: 114913
*/

$page['name'] = 'WebHook';
$page['code'] = 'memberCoinWebhook';

// COMPROBAR SI SE OBTIENEN DATOS
if (isset($_GET) && !empty($_GET))
{
	// ID DE VENTA
	$buy['payment_intent'] = isset($_GET['saleID']) ? (int)$_GET['saleID'] : 0;
	// COMPROBAR SI NO SE HA REGISTRADO YA
	$already = Core::model('db', 'core')->getColumns('members_coins', 'payment_intent', array(
			'payment_intent',
			$buy['payment_intent']
		));
	if($already > 0) { exit; }
	// PRECIO OBTENIDO
	$buy['priceAmount'] = isset($_GET['priceAmount']) ? str_replace('.', '', $_GET['priceAmount']) : 0;
	// MONEDA
	$buy['currency'] = isset($_GET['priceCurrency']) ? $_GET['priceCurrency'] : 0;
	// TIPO
	$buy['type'] = isset($_GET['type']) ? $_GET['type'] : '';
	// FIRMA
	$buy['signature'] = isset($_GET['signature']) ? $_GET['signature'] : '';
	// EMAIL
	$buy['email'] = isset($_GET['email']) ? $_GET['email'] : '';
	// EMAIL
	$buy['referenceID'] = isset($_GET['referenceID']) ? $_GET['referenceID'] : '';
	// COMPRADOR (custom1)
	$buy['member'] = isset($_GET['custom1']) ? $_GET['custom1'] : 0;
	// PLAN (custom2)
	$buy['product'] = isset($_GET['custom2']) ? $_GET['custom2'] : 0;
	// RESULTADO
	$buy['saleResult'] = isset($_GET['saleResult']) ? $_GET['saleResult'] : '';
	// SOURCE
	$buy['source'] = var_export($_REQUEST, true);

	/**
	 * COMPROBAR EN LA PÁGINA DE VEROTEL SI SE HA COMPRADO REALMENTE
	**/ 
	// GENERAR FIRMA
	$signature = sha1($config['verotel_signature'].':saleID='.$buy['payment_intent'].':shopID='.$config['verotel_shop_id'].':version=3');
	// GENERAR ENLACE
	$statusUrl = 'https://secure.verotel.com/status/order?saleID='.$buy['payment_intent'].'&shopID='.$config['verotel_shop_id'].'&version=3&signature='.$signature;
	// COMPROBAR ESTADO
	$buy['source_status'] = file_get_contents($statusUrl);

	preg_match_all('/(.[a-zA-Z0-9_-]+): (.{2,})/', $buy['source_status'], $matches);

	$i = 0;
	foreach($matches[0] as $key)
	{
		$buy[$matches[1][$i]] = $matches[2][$i];
		++$i;
	}

	// METODOS DE COMPROBACION DE PAGO ACEPTADO
	$buy['status'] = $buy['saleResult'] == 'APPROVED' ? 'paid' : strpos($buy['source_status'], 'saleResult: APPROVED') !== false ? 'paid' : 'unknown';

	//$buy['priceAmount'] = str_replace('.', '', $buy['priceAmount']);
	//$export = var_export($buy, true);
	//file_put_contents('verotel.txt', $export);
	//var_dump($buy);

	// SI EL PAGO FUE APROBADO
	if($buy['status'] == 'paid')
	{
		// COMPROBAR SI EL USUARIO EXISTE POR ID
		$member = Core::model('db', 'core')->getColumns('members', 'member_id', array(
			'member_id',
			$buy['member']
		));

		if ($member > 0)
		{
			// DEFINIR CREDITOS A SUMAR
			if ($buy['product'] == 1)
			{
				$buy['coins'] = 3000;
			}
			elseif ($buy['product'] == 2)
			{
				$buy['coins'] = 8000;
			}
			elseif ($buy['product'] == 3)
			{
				$buy['coins'] = 18000;
			}

			// REGISTRAR COMPRA
			$newBuy = Core::model('coins', 'members')->newBuy($buy);

			if($newBuy > 0)
			{	
				// SUMAR CRÉDITOS AL USUARIO
				Core::model('db', 'core')->updateCount('members', 'coins', $buy['member'], ('+' . $buy['coins']) , 'member_id');
				// NOTIFICAR AL USUARIO
				Core::model('notifications', 'members')->newNotification($buy['member'], $buy['member'], 'newBuy', $buy['coins'], null, null, true);
				die('OK');
				$message[] = array(
					'Compra realizada',
					'success'
				);
			}
			else
			{
				$message[] = array(
					'Problema al registrar la compra. Contacte con el administrador.',
					'error'
				);
			}
		}
		else
		{
			$message[] = array(
				'Usuario no identificado: ' . $buy['member'],
				'error'
			);
		}
		// RETORNAR RESPUESTA CORRECTA
		http_response_code(200); // PHP 5.4 o superior
	}
	else
	{
		$message[] = array(
			'Pago rechazado',
			'error'
		);
	}
}
else
{
	$message[] = array(
		'No hay datos',
		'error'
	);
}
// FINALIZAR EJECUCIÓN DEL SCRIPT
exit;