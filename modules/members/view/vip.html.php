<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\view\vip.html.php        \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista del área "VIP" de la Cuenta
 *
 *
*/

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<section id="memberVIP">
  <div class="container">
    <div class="row">
     <!-- CANTIDAD DE CRÉDITOS ACTUALES -->
      <div class="col s12">
        <div class="card-panel blue lighten-4 blue-text text-darken-4 flow-text center-align"><?php echo $session->memberData['vip'] > time()  ? ('Suscripci&oacute;n v&aacute;lida hasta ' . Core::model('date', 'core')->getTimeAgo($session->memberData['vip']) . ' &raquo; <small>'.date('d\/m \a \l\a\s H:i', $session->memberData['vip']).'</small>') : 'No tienes ninguna suscripci&oacute;n activa'; ?>. Tienes <?php echo $session->memberData['coins']; ?> cr&eacute;ditos. 
        </div>
      </div>
    </div>
    <!-- PLANES -->
    <div class="row">
      <form action="<?php echo Core::model('extra', 'core')->generateUrl('members', 'vip');?>" method="post">
        <?php foreach($memberships as $i => $vip) { ?>
        <div class="col s12 m<?php echo $cols; ?>">
          <div class="card">
            <div class="card-content center">
              <h5><?php echo $vip['title']; ?></h5>
            </div>
            <ul class='collection center'>
              <li class='collection-item'>
                <strong class="blue-text"><?php echo $vip['coins']; ?></strong> Cr&eacute;ditos
              </li>
              <li class='collection-item'>
                <strong><?php echo round(($vip['coins']/$vip['days'])); ?></strong> por d&iacute;a
              </li>
            </ul>
            <div class="card-content center">
              <div class="row">
                <div class="col s12">
                  <?php if($session->memberData['coins'] >= $vip['coins']) { ?>
                  <button type="submit" class='btn blue' name="plan" value="<?php echo $i; ?>">Adquirir</button>
                  <?php } else { ?>
                    <strong class="red-text">Necesitas m&aacute;s cr&eacute;ditos para suscribirte</strong>
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'coins'); ?>" class="modal-close waves-effect waves-blue btn red darken-4">Comprar cr&eacute;ditos</a>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      </form>
    </div>
  </div>
</section>
<!-- / Body -->

<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->
