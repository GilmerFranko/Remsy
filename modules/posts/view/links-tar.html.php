<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\posts\view\links-tar.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2021 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de los creditos
 *
 *
 */
// HEADER
require Core::view('head', 'core');
// MENU
require Core::view('menu', 'core');
?>

<section style="margin-top: 50px;">
  <?php if(!isset($_GET['group'])): ?>
    <div class="lighten-4 red-text text-darken-4 flow-text center-align">
      <h5><p class="center">Aqui podras Cargar y/o Actualizar todos los links en busca de nuevos Posts</p></h5>
    </div>
   <div class="container">
    <div class="row">
     <?php foreach($group AS $group): ?>
       <div class=" col s12 m4">
        <div class="card">
          <div class="card-content center">
            <span id="nameGroup<?php echo $group['index_id'] ?>">Grupo <?php echo $group['index_id']; ?></span>
          </div>

          <div class="card-footer center">
            <?php if($group['status'] == 1):?>
              <a id="btnLoad<?php echo $group['index_id']; ?>" class="btn green" href="javascript:initScrap(<?php echo $group['index_id']; ?>);">Actualizar</a>
              <br>
              <i>Ultima actualización el <?php echo Core::model('date', 'core')->getDate($group['last_load']); ?></i>

              <br>
              <i>Toca para actualizar></i>
            <?php else: ?>
              <a id="btnMain<?php echo $group['index_id']; ?>" href="javascript:initScrap(<?php echo $group['index_id']; ?>);" class="btn blue"><span id="btnLoad<?php echo $group['index_id']; ?>" class="preloader-wrapper circle">

                <div class="spinner-layer spinner-white-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></span><span id="textLoad<?php echo $group['index_id']; ?>">Cargar</span></a>
                <br><br><br><br>
            <?php endif ?>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div>
<?php endif ?>
</section>
<!-- FOOTER -->
<?php require Core::view('footer', 'core'); ?>
