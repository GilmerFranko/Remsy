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
<section id="adminBots">
    <div class="sectionBots">
        <blockquote class="flow-text">Bots</blockquote>
        <!-- NUEVA PALABRA -->
        <?php if(!empty($bots['answers'])) { ?>
        <form class="col s12" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'bots', 'action', array('do' => 'new', 'type' => 'word'));?>" method="post">
            <div class="row">
                <div class="col s4">
                    <select class="browser-default" name="bot" required>
                        <option value="" disabled selected>Elige Bot</option>
                        <?php while( $bot = $bots['answers']->fetch_assoc() ) {
                            echo '<option value="'.$bot['member_id'].'">'.$bot['name'].'</option>';
                            } ?>
                    </select>
                </div>
                <div class="col s6">
                    <input placeholder="Hermosa" id="word" name="word" type="text" class="validate" required>
                </div>
                <div class="col s2">
                    <button class="btn waves-effect waves-light" type="submit" name="action">
                    <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </form>
        <?php } else { echo '<blockquote class="flow-text">No hay bots de comentarios</blockquote>' ;} ?>
        <!--./ NUEVA PALABRA -->
        <?php include Core::view('bots.area'); ?>
    </div>
    <div id="onceBot" style="display: none;"></div>
</section>
<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url'];?>/static/js/admin.js"/></script>