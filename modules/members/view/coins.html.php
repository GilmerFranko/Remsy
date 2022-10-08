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
 * @Description Vista del área "Creditos" de la Cuenta
 *
 *
 * Signature Key: b2z8eS6uAaB3y3a6FRhHKKB2wxdcgx
 * Shop ID: 114913
*/

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<section id="memberCoin">
  <div class="col s12">
    <ul class="tabs tabs-fixed-width tab-demo z-depth-1">
      <li class="tab col s3"><a href="#tabPlans">Planes</a></li>
      <li class="tab col s3"><a href="#tabHistory">Historial</a></li>
    </ul>
  </div>
  <div class="container">
    <div class="row">
      <!-- CANTIDAD DE CRÉDITOS ACTUALES -->
      <div class="col s12">
        <div class="card-panel blue lighten-4 blue-text text-darken-4 flow-text center-align">Tienes <span id="coinsCurrent"><?php echo $session->memberData['coins']; ?></span> cr&eacute;ditos
        
        <br/>
     <p style="color:#fa0000";> <b>  Los cr&eacute;ditos los consigues gratis desde nuestra <a href="https://bellasgram.com/index.php?app=site&section=pages&name=entrarapp">aplicacion</a>, puedes conseguir hasta 300 cr&eacute;ditos gratis por dia.</b> ganas cr&eacute;ditos por comentar fotos, por darle me gusta a fotos, por cada vez que te den me gusta a tus comentarios, viendo videos, etc... ademas puedes canjear tus cr&eacute;ditos por dinero!.</b></p>
        
        
        Si no te llegan al instante <a href="https://bellasgram.com/index.php?app=site&section=contact">ESCRÍBENOS</a> mencionando que hiciste la compra, revisaremos y los acreditaremos a tu cuenta. </b><b> Tambien puedes ganar cr&eacute;ditos gratis comentando las fotos y recibiendo me gustas en tus comentarios. </b></p>
        <?php
if($session->platform == 'app') {
	echo'<span><p style="color:#000000";><b>Gana cr&eacute;ditos gratis,  toca <a href="https://bellasgram.com/index.php?app=site&section=pages&name=dinero">AQUI</a> y mira como</b></p></span>';
}
?></div>
      </div>
      <!-- MENSAJE DE ERROR -->
      <div id="error-message"></div>
    </div>
    <!-- INTRUCCIONES -->
    <div class="row">
      <div class="col s12 center">
        <strong>Instrucci&oacute;nes</strong>
      </div>
    </div>
    <!-- PLANES E HISTORIAL -->
    <div class="row">
      <div id="tabPlans" class="col s12">
        <?php include Core::view('coins.plans.area'); ?>
      </div>
      <!-- FIN PLANES -->
      <!-- HISTORIAL -->
      <div id="tabHistory" class="col s12">
        <?php include Core::view('coins.history.area'); ?>
      </div>
    </div>
    <!-- FIN HISTORIAL -->
    <!-- JAVASCRIPT NECESARIO PARA STRIPE -->
    <script>
      var plan = '';

      function setPlan(plan = 1)
      {
        $('#checkout-button-' + plan).addClass('disabled');
        if(plan == 0)
        {
          plan = '<?php echo $plan0['url']; ?>';
        }
        else if(plan == 1)
        {
          plan = '<?php echo $plan1['url']; ?>';
        }
        else if(plan == 2)
        {
          plan = '<?php echo $plan2['url']; ?>';
        }
        else if(plan == 3)
        {
          plan = '<?php echo $plan3['url']; ?>';
        }
        else if(plan == 4)
        {
          plan = '<?php echo $plan4['url']; ?>';
        }

        buyPlan(plan);

      }
      
        function buyPlan(plan){

          window.location.href=plan;
      }
          
    </script>
  </div>
</section>
<!-- / Body -->

<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->
