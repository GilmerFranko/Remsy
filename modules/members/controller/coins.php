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
$page['name'] = 'Mis cr&eacute;ditos';
$page['code'] = 'memberCoin';
$Items = [
	1014 => [
		'Creditos' => 1000,
		'price' => 10
	],
	2500 => [
		'Creditos' => 2000,
		'price' => 20
	],
	3012 => [
		'Creditos' => 5000,
		'price' => 40
	],
	4048 => [
		'Creditos' => 10000,
		'price' => 60
	],
	5485 => [
		'Creditos' => 30000,
		'price' => 120
	]
	];
// CARGAR COMPRAS
$purchases = Core::model('coins', 'members')->getPurchases($session->memberData['member_id']);

// ESTABLECER 3 PLANES
$plan0['url'] = Core::model('extra', 'core')->generateUrl('members', 'coins', null, array('payment_id' => 1014));

// PLAN 2
$plan1['url'] = Core::model('extra', 'core')->generateUrl('members', 'coins', null, array('payment_id' => 2500));

// PLAN 3
$plan2['url'] = Core::model('extra', 'core')->generateUrl('members', 'coins', null, array('payment_id' => 3012));

$plan3['url'] = Core::model('extra', 'core')->generateUrl('members', 'coins', null, array('payment_id' => 4048));

$plan4['url'] = Core::model('extra', 'core')->generateUrl('members', 'coins', null, array('payment_id' => 5485));

if (isset($_GET['payment_id'])) {
    $item = (object) $Items[ $_GET['payment_id'] ];
    $SandBox = true;
	$Paypal_Account = "contacto@diaches-game.com";
	$DomainUrl = "https://bellasgram.com/";
	$UrlSendForm = "https://www.paypal.com/cgi-bin/webscr";


	if($SandBox){
		$Paypal_Account = "sb-ce3o06105974@business.example.com";
		$UrlSendForm = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	} 
?> 
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<div class="loading">One moment, please... Un momento, por favor...</div>

<form id="realizarPago" action="<?php echo $UrlSendForm; ?>" method="post">
	<input name="cmd" type="hidden" value="_cart" />
	<input name="upload" type="hidden" value="1" />
	<input name="business" type="hidden" value="<?php echo $Paypal_Account; ?>" />
	<input name="shopping_url" type="hidden" value="<?php echo $DomainUrl; ?>" />
	<input name="currency_code" type="hidden" value="USD" />
	<input name="return" type="hidden" value="<?php echo Core::model('extra', 'core')->generateUrl('members', 'coins', null, array('acredit' => $_GET['payment_id'])); ?>" />
    <input type="hidden" name="no_shipping" value="1">
	<input name="rm" type="hidden" value="2" />
	<input name="item_number_1" type="hidden" value="<?php echo $_GET['payment_id']; ?>" />
	<input name="item_name_1" type="hidden" value="<?php echo $item->Creditos; ?> Creditos" />
	<input name="amount_1" type="hidden" value="<?php echo $item->price; ?>" />
	<input name="quantity_1" type="hidden" value="1" /> 

</form>
<script>
$(document).ready(function () {
	$("#realizarPago").submit();
});
</script>
<?php
	exit();
}

// RECIBE JSON DE PAYPAL PARA CONFIRMAR PAGO
if (isset($_GET['acredit'])) {

	// BORRAR VARIABLE DE LA URL
	header("location: ".Core::model('extra', 'core')->generateUrl('members', 'coins', null,null));
	// PRECIO OBTENIDO
	$buy['priceAmount'] = $Items[$_GET['acredit']]['price'];
	// MONEDA
	$buy['priceCurrency'] = "USD";
	// TIPO
	$buy['type'] = 	"";
	// FIRMA
	$buy['signature'] = isset($_GET['signature']) ? $_GET['signature'] : '';
	// EMAIL
	$buy['email'] = "";
	// EMAIL
	$buy['referenceID'] = "";
	// COMPRADOR (custom1)
	$buy['member'] = $session->memberData['member_id'];;
	// PLAN (custom2)
	$buy['product'] = $_GET['acredit'];
	// CREDITOS DADOS
	$buy['coins'] = $Items[$_GET['acredit']]['Creditos'];
	// RESULTADO
	$buy['saleResult'] = isset($_GET['saleResult']) ? $_GET['saleResult'] : '';
	// SOURCE
	$buy['source'] = var_export($_REQUEST, true);
	// ESTADO DEL PAGO
	$buy['status'] = "paid";
	//COMPROBAR SI EL PAGO FUE EFECTUADO
	if ($buy['status']=='paid') {

		// REGISTRAR COMPRA
		$newBuy = Core::model('coins', 'members')->newBuy($buy);

		if ($newBuy) {
			// SUMAR CRÉDITOS AL USUARIO
			Core::model('db', 'core')->updateCount('members', 'coins', $buy['member'], ('+' . $buy['coins']) , 'member_id');
			// NOTIFICAR AL USUARIO
			Core::model('notifications', 'members')->newNotification($buy['member'], $buy['member'], 'newBuy', $buy['coins'], null, null, true);
			//die('OK');
			$message[] = array(
				'Compra realizada',
				'success'
			);
		}
	}
}