<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\groups.html.php       \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página de rangos en la administración
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
if( isset($_GET['default']) && isset($_SESSION['message']))
{
    echo Core::model('extra', 'core')->getToast($_SESSION['message']);
} ?>
<section id="adminGroups">
    <div class="sectionGroups">
        <blockquote class="flow-text">Rangos</blockquote>
        <!-- NUEVO GRUPO -->
        <div id="newGroupForm" style="display: none;">
            <?php include Core::view('groups.form.area'); ?>
        </div>
        <!--./ NUEVO GRUPO -->
        <?php include Core::view('groups.area'); ?>
    </div>
    <div id="onceGroup" style="display: none;"></div>
    <!-- BOTON DE NUEVO -->
    <div class="fixed-action-btn">
        <button id="btnNewGroup" class="btn-floating btn-large grey darken-4" onclick="$('#newGroupForm').slideToggle('slow');"><i class="large material-icons">add</i></button>
        <button class="btn red darken-3" id="btnEditGroup" type="button" style="display: none;" onclick="admin.forms.get('Group', '', true);">Cancelar</button>
    </div>
</section>

<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url'];?>/static/js/admin.js"/></script>