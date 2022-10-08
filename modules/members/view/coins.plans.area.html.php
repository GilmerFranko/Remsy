<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\view\coins.html.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista del área "Planes" de Créditos
 *
 *
*/
?>
<div id="contentCoinsPlans">
    <div class="row">
      <!-- PAQUETE BASICO -->
      <div class=" col s12 m4">
        <div class="card">
          <div class="card-content center">
            <h5 class=''>Plan b&aacute;sico</h5>
          </div>
          <div class="col s12">
            <button class='btn blue' id="payPlan0">Comprar</button>
          </div>
          <div class="card-content center">
            <h2 class='blue-text '>&dollar;10,<small>00</small></h2>
          </div>
          <div class="center">
            <img src="https://demo.themesberg.com/neumorphism-ui/assets/img/clients/paypal.svg" width="120">
          </div>
          <ul class='collection center'>
            <li class='collection-item'>
              <strong>1.000</strong> Cr&eacute;ditos
            </li>            
          </ul>
        </div>
      </div>
      <!-- PAQUETE ESTANDAR -->
      <div class=" col s12 m4">
        <div class="card">
          <div class="card-content center">
            <h5 class=''>Plan Est&aacute;ndar</h5>
          </div>
          <div class="col s12">
            <button class='btn blue' id="payPlan1">Comprar</button>
          </div>
          <div class="card-content center">
            <h2 class='blue-text '>&dollar;20,<small>00</small></h2>
          </div>
          <div class="center">
            <img src="https://demo.themesberg.com/neumorphism-ui/assets/img/clients/paypal.svg" width="120">
          </div>
          <ul class='collection center'>
            <li class='collection-item'>
              <strong>2.000</strong> Cr&eacute;ditos
            </li>
          </ul>
        </div>
      </div>
      <!-- PAQUETE PREMIUM -->
      <div class=" col s12 m4">
        <div class="card">
          <div class="card-content center">
            <h5 class=''>Plan Premium</h5>
          </div>
          <div class="col s12">
            <button class='btn blue' id="payPlan2">Comprar</button>
          </div>
          <div class="card-content center">
            <h2 class='blue-text '>&dollar;40,<small>00</small></h2>
          </div>
          <div class="center">
            <img src="https://demo.themesberg.com/neumorphism-ui/assets/img/clients/paypal.svg" width="120">
          </div>
          <ul class='collection center'>
            <li class='collection-item'>
              <strong>5.000</strong> Cr&eacute;ditos
            </li>
          </ul>
        </div>
      </div>
      <div class=" col s12 m4">
        <div class="card">
          <div class="card-content center">
            <h5 class=''>Plan Oro</h5>
          </div>
          <div class="col s12">
            <button class='btn blue' id="payPlan3">Comprar</button>
          </div>
          <div class="card-content center">
            <h2 class='blue-text '>&dollar;60,<small>00</small></h2>
          </div>
          <div class="center">
            <img src="https://demo.themesberg.com/neumorphism-ui/assets/img/clients/paypal.svg" width="120">
          </div>
          <ul class='collection center'>
            <li class='collection-item'>
              <strong>10.000</strong> Cr&eacute;ditos
            </li>
          </ul>
        </div>
      </div>
      <div class=" col s12 m4">
        <div class="card">
          <div class="card-content center">
            <h5 class=''>Plan Diamante</h5>
          </div>
          <div class="col s12">
            <button class='btn blue' id="payPlan4">Comprar</button>
          </div>
          <div class="card-content center">
            <h2 class='blue-text '>&dollar;120,<small>00</small></h2>
          </div>
          <div class="center">
            <img src="https://demo.themesberg.com/neumorphism-ui/assets/img/clients/paypal.svg" width="120">
          </div>
          <ul class='collection center'>
            <li class='collection-item'>
              <strong>30.000</strong> Cr&eacute;ditos
            </li>
          </ul>
        </div>
      </div>
    </div>
    
</div>


<?php

$SandBox = false;
$Paypal_Account = "contacto@diaches-game.com";
$DomainUrl = "https://bellasgram.com/chat/";
$UrlSendForm = "https://www.paypal.com/cgi-bin/webscr";


if($SandBox){
  $Paypal_Account = "sb-w2imt372224@business.example.com";
  $UrlSendForm = "https://www.sandbox.paypal.com/cgi-bin/webscr";
}

?>

<!-- Formulario 0 -->
<form id="formPlan0" action="<?php echo $UrlSendForm; ?>" method="post">
  <input name="cmd" type="hidden" value="_cart" />
  <input name="upload" type="hidden" value="1" />
  <input name="business" type="hidden" value="<?php echo $Paypal_Account; ?>" />
  <input name="shopping_url" type="hidden" value="<?php Core::model('extra', 'core')->generateUrl('members', 'coins', null,null); ?>" />
  <input name="currency_code" type="hidden" value="USD" />
  <input name="return" type="hidden" value="<?php echo Core::model('extra', 'core')->generateUrl('members', 'coins', null, array('acredit' => 1014)); ?>" />
    <input type="hidden" name="no_shipping" value="1">
  <input name="rm" type="hidden" value="0" />
  <input name="item_number_1" type="hidden" value="1014" />
  <input name="item_name_1" type="hidden" value="Plan Basico" />
  <input name="amount_1" type="hidden" value="10" />
  <input name="quantity_1" type="hidden" value="1" /> 

</form>
<!--/ Formulario 0 -->
<!-- Formulario 1 -->
<form id="formPlan1" action="<?php echo $UrlSendForm; ?>" method="post">
  <input name="cmd" type="hidden" value="_cart" />
  <input name="upload" type="hidden" value="1" />
  <input name="business" type="hidden" value="<?php echo $Paypal_Account; ?>" />
  <input name="shopping_url" type="hidden" value="<?php Core::model('extra', 'core')->generateUrl('members', 'coins', null,null); ?>" />
  <input name="currency_code" type="hidden" value="USD" />
  <input name="return" type="hidden" value="<?php echo Core::model('extra', 'core')->generateUrl('members', 'coins', null, array('acredit' => 2500)); ?>" />
    <input type="hidden" name="no_shipping" value="1">
  <input name="rm" type="hidden" value="0" />
  <input name="item_number_1" type="hidden" value="2500" />
  <input name="item_name_1" type="hidden" value="Plan Estandar" />
  <input name="amount_1" type="hidden" value="20" />
  <input name="quantity_1" type="hidden" value="1" /> 

</form>
<!--/ Formulario 1 -->
<!-- Formulario 2 -->
<form id="formPlan2" action="<?php echo $UrlSendForm; ?>" method="post">
  <input name="cmd" type="hidden" value="_cart" />
  <input name="upload" type="hidden" value="1" />
  <input name="business" type="hidden" value="<?php echo $Paypal_Account; ?>" />
  <input name="shopping_url" type="hidden" value="<?php Core::model('extra', 'core')->generateUrl('members', 'coins', null,null); ?>" />
  <input name="currency_code" type="hidden" value="USD" />
  <input name="return" type="hidden" value="<?php echo Core::model('extra', 'core')->generateUrl('members', 'coins', null, array('acredit' => 3012)); ?>" />
    <input type="hidden" name="no_shipping" value="1">
  <input name="rm" type="hidden" value="0" />
  <input name="item_number_1" type="hidden" value="3012" />
  <input name="item_name_1" type="hidden" value="Plan Premium" />
  <input name="amount_1" type="hidden" value="40" />
  <input name="quantity_1" type="hidden" value="1" /> 

</form>
<!--/ Formulario 2 -->
<!-- Formulario 3 -->
<form id="formPlan3" action="<?php echo $UrlSendForm; ?>" method="post">
  <input name="cmd" type="hidden" value="_cart" />
  <input name="upload" type="hidden" value="1" />
  <input name="business" type="hidden" value="<?php echo $Paypal_Account; ?>" />
  <input name="shopping_url" type="hidden" value="<?php Core::model('extra', 'core')->generateUrl('members', 'coins', null,null); ?>" />
  <input name="currency_code" type="hidden" value="USD" />
  <input name="return" type="hidden" value="<?php echo Core::model('extra', 'core')->generateUrl('members', 'coins', null, array('acredit' => 4048)); ?>" />
    <input type="hidden" name="no_shipping" value="1">
  <input name="rm" type="hidden" value="0" />
  <input name="item_number_1" type="hidden" value="4048" />
  <input name="item_name_1" type="hidden" value="Plan Oro" />
  <input name="amount_1" type="hidden" value="60" />
  <input name="quantity_1" type="hidden" value="1" /> 

</form>
<!--/ Formulario 3 -->
<!-- Formulario 4 -->
<form id="formPlan4" action="<?php echo $UrlSendForm; ?>" method="post">
  <input name="cmd" type="hidden" value="_cart" />
  <input name="upload" type="hidden" value="1" />
  <input name="business" type="hidden" value="<?php echo $Paypal_Account; ?>" />
  <input name="shopping_url" type="hidden" value="<?php Core::model('extra', 'core')->generateUrl('members', 'coins', null,null); ?>" />
  <input name="currency_code" type="hidden" value="USD" />
  <input name="return" type="hidden" value="<?php echo Core::model('extra', 'core')->generateUrl('members', 'coins', null, array('acredit' => 5485)); ?>" />
    <input type="hidden" name="no_shipping" value="1">
  <input name="rm" type="hidden" value="0" />
  <input name="item_number_1" type="hidden" value="5485" />
  <input name="item_name_1" type="hidden" value="Plan Diamante" />
  <input name="amount_1" type="hidden" value="120" />
  <input name="quantity_1" type="hidden" value="1" /> 

</form>
<!--/ Formulario 4 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">

  $("#payPlan0").click(function(){
    $("#formPlan0").submit();
  });
  $("#payPlan1").click(function(){
    $("#formPlan1").submit();
  });
  $("#payPlan2").click(function(){
    $("#formPlan2").submit();
  });
  $("#payPlan3").click(function(){
    $("#formPlan3").submit();
  });
  $("#payPlan4").click(function(){
    $("#formPlan4").submit();
  });

</script>
