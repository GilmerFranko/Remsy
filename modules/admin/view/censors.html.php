<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\censors.html.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página de las censuras
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
<section id="adminCensors">
    <div class="sectionCensors">
        <blockquote class="flow-text">Filtro de palabras</blockquote>
        <!-- NUEVO FILTRO -->
        <form class="col s12" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'censors', 'action', array('do' => 'new'));?>" method="post">
            <div class="row">
                <div class="input-field col s6">
                    <input placeholder="Fals([o|a])" id="text_from" name="text_from" type="text" class="validate" required>
                    <label for="text_from" class="active">Texto original (expresi&oacute;n regular)</label>
                </div>
                <div class="input-field col s6">
                    <input placeholder="Hermos$1" id="text_to" name="text_to" type="text" class="validate" required>
                    <label for="text_to" class="active">Texto convertido</label>
                </div>
                <div class="input-field col s10">
                    <input placeholder="Convierte Falso/a en Hermoso/a" id="reason" name="reason" type="text" class="validate" required>
                    <label for="reason" class="active">Raz&oacute;n</label>
                </div>
                <div class="col s2">
                    <button class="btn waves-effect waves-light" type="submit" name="action">
                    <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </form>
        <!--./ NUEVO FILTRO -->
        <?php include Core::view('censors.area'); ?>
    </div>
    <div id="onceCensor" style="display: none;"></div>
</section>
<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url'];?>/static/js/admin.js"/></script>