<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\controller\coins.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2021 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista principal de todos los Posts no Añadidos a la sección Posts
 *
 *
 */
// HEADER
require Core::view('head', 'core');
// MENU
require Core::view('menu', 'core');
?>
<section>
  <br>
  <div class="container center">
    <a class="btn red" href="<?php echo $extra->generateUrl('posts', 'posts-no-added', null, array('cronAddPosts' => 'true')); ?>">Ejecutar CRON</a>
    <?php if($posts != false)foreach ($posts['data'] as $post): ?>
      <div class="row center">
        <div class="col s12 l12">
          <div class="card">
            <br>
            <div class="card-title center"><i><strong><?php echo Core::model('post', 'posts')->cleanVarPostHTML(utf8_encode($post['title'])); ?></strong></i></div><br>
            <!-- imagen -->
            <div class="imgPost" style="background: url('<?php echo $extra->getFirstImgHtml($post['content'], true); ?>') no-repeat;background-position: center;    background-size: cover;">
                <?php echo $extra->getFirstImgHtml($post['content']); ?>
              </div>
            <!-- /imagen -->
            <div class="card-content center contentPost">
              <blockquote><?php echo $extra->curtText(Core::model('post', 'posts')->cleanVarPostHTML(utf8_encode($post['content'])),314); ?>
              <a href="<?php echo Core::model('extra', 'core')->generateUrl('posts', 'view', null, array('postID' => $post['id'], 'scContent' => 'true')); ?>">Seguir Leyendo</a>
              </blockquote>
            <div class="card-footer center"><?php //echo $post['link']; ?></div>
          </div>
        </div>
      </div>
      <a class="btn green" href="<?php echo Core::model('extra', 'core')->generateUrl('posts', 'view', null, array('postID' => $post['id'], 'scContent' => 'true')); ?>">Ver publicaci&oacute;n</a>
    </div>
    <br><br>
  <?php endforeach; ?>
  </div>
  <?php echo $posts['pages']['paginator']; ?>
<!-- FOOTER -->
<?php require Core::view('footer', 'core'); ?>
</section>


