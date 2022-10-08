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
 * @Description Vista principal de todos los Posts
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
  <div class="container">
    <?php if($posts != false)foreach ($posts['data'] as $post): ?>
      <div class="row center">
        <div class="col s12 l12">
          <div class="card">
            <br>
            <div class="card-title center"><i><strong><?php echo Core::model('post', 'posts')->cleanVarPostHTML(utf8_encode($post['title'])); ?></strong></i></div><br>
            <!-- imagen -->
            <div class="center card-image">
              <div class="imgPost" style="background: url('<?php echo $extra->getFirstImgHtml($post['content'], true); ?>') no-repeat;background-position: center;    background-size: cover;">
                <?php echo $extra->getFirstImgHtml($post['content']); ?>
              </div>
            </div>
            <!-- /imagen -->
            <div class="card-content center contentPost">
              <blockquote><?php echo $extra->curtText(Core::model('post', 'posts')->cleanVarPostHTML(utf8_encode($post['content'])),256); ?>
              <a href="<?php echo Core::model('extra', 'core')->generateUrl('posts', 'view', null, array('postID' => $post['id'])); ?>">Seguir leyendo</a>
              </blockquote>
            <div class="card-footer center"><i><?php echo Core::model('date', 'core')->getDate($post['time']); ?></i></div>
          </div>
        </div>
      </div>
      <a class="btn green" href="<?php echo Core::model('extra', 'core')->generateUrl('posts', 'view', null, array('postID' => $post['id'])); ?>">Ver publicaci&oacute;n&oacute;n</a>
    </div>
    <br><br>
    <?php endforeach;?>
  </div>
  <?php echo $posts['pages']['paginator']; ?>
<!-- FOOTER -->
<?php require Core::view('footer', 'core'); ?>
</section>


