<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\contacts.html.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de los formularios de contacto
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

<section id="adminContacts">
    <!-- BUSCADOR -->
    <nav class="teal darken-1">
        <div class="nav-wrapper">
            <form class="" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'contacts');?>" method="post">
                <div class="input-field">
                    <input id="search" name="search" type="search" placeholder="Buscar..." value="<?php echo $search; ?>">
                    <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                    <i class="material-icons">close</i>
                </div>
            </form>
        </div>
    </nav>
    <!-- ./BUSCADOR -->
    <div class="sectionContacts">
        <?php include Core::view('contacts.area'); ?>
    </div>
</section>

<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url'];?>/static/js/admin.js"/></script>