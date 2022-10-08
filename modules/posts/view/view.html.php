<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\posts\view\view.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2021 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista principal de un Post
 *
 *
 */
// HEADER
require Core::view('head', 'core');
// MENU
require Core::view('menu', 'core');
?>
<section style="margin-top: 50px;">
  <?php if ($post != false): ?>
    <div class="container center">
      <div class="row">
        <div class="col s12">
          <div class="card">
            <br>
            <div class="card-title center"><strong><?php echo Core::model('post', 'posts')->cleanVarPostHTML(utf8_encode($post['title'])); ?></strong></div><br>
            <div class="card-content center contentPost">
              <p><?php echo utf8_encode($post['content']); ?>
            </p>
            <div class="card-footer center"><?php //echo $post['link']; ?></div>
          </div>
        </div>
      </div>
    </div>
    <a class="btn-small blue" href="<?php echo $extra->getLastUrl(); ?>">Volver</a><br><br>
  </div>
  <?php else: ?>
    <div class="container">
      <blockquote>Publicaci&oacute;n inexistente &nbsp; <a class="btn-small blue" href="<?php echo $extra->getLastUrl(); ?>">Volver</a></blockquote>
    </div>
  <?php endif ?>
</section>

<!-- FOOTER -->
<?php require Core::view('footer', 'core'); ?>
