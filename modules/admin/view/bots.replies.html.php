<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\bots.html.php         \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página de bots que responden
 *
 *
*/

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- CSS ADICIONAL -->
<link type="text/css" rel="stylesheet" href="<?php echo $config['base_url']; ?>/static/css/admin.css" />

<?php
if( isset($_GET['save']) && isset($_SESSION['message']))
{
    echo Core::model('extra', 'core')->getToast($_SESSION['message']);
} ?>
<section id="adminBotsReplies">
  <div class="sectionBotsReplies">
    <blockquote class="flow-text">Respuestas de <?php echo $replies['word']['bot_name'] . ' a "'.$replies['word']['bw_word']; ?>"</blockquote>
    <!-- NUEVA PALABRA -->
    <div class="row">
      <form class="col s12" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'bots', 'action', array('do' => 'new', 'type' => 'reply'));?>" method="post">
        <div class="row">
          <div class="col s12" id="botReplies">
            <input type="hidden" name="word" value="<?php echo $_GET['search']; ?>">
            <input placeholder="Gracias 😛" id="reply" name="reply[]" type="text" class="validate" required>
          </div>
        </div>
        <div class="row" id="botRepliesAction">
          <div class="col s6">
            <a href="javascript:addInput('Bot');" class="btn waves-effect waves-light blue darken-2 w100" id="btnAddInputBot" data-cant="0">
            <i class="material-icons">add</i>
            </a>
          </div>
          <div class="col s6">
            <button class="btn waves-effect waves-light w100" type="submit" name="action">
            <i class="material-icons">send</i>
            </button>
          </div>
        </div>
      </form>
    </div>
    <!--./ NUEVA RESPUESTA -->
    <!-- INCLUYE LA LISTA DE RESPUESTAS -->
    <?php include Core::view('bots.replies.area'); ?>
  </div>
  <div id="onceBotReply" style="display: none;"></div>
</section>
<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->
<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url'];?>/static/js/admin.js"/></script>