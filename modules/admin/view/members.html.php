<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\members.html.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página de usuarios
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
<!-- CARGA EDITOR DE USUARIO -->
<?php if(isset($_GET['edit']) && ctype_digit($_GET['edit'])){ ?>
    <script>
        window.onload = function(e){
            admin.forms.get('Member', '<?php echo $_GET['edit']; ?>');
        }
    </script>
<?php } ?>
<!-- FIN DE CARGA EDITOR DE USUARIO -->
<section id="adminMembers">
    <!-- BUSCADOR -->
    <nav class="teal darken-1">
        <div class="nav-wrapper">
            <form class="" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'members');?>" method="post">
                <div class="input-field">
                    <input id="search" name="search" type="search" placeholder="Buscar..." value="<?php echo $search; ?>">
                    <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                    <i class="material-icons">close</i>
                </div>
            </form>
        </div>
    </nav>
    <!-- ./BUSCADOR -->
    <!-- BOTON PARA VER BOTS -->
    <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'members') . ($bots == true ? '' : '&bots=true'); ?>" class="waves-effect waves-light btn grey darken-4 w100"><i class="material-icons left">bubble_chart</i>Ver <?php echo $bots == true ? 'Todos' : 'los Bots'; ?></a>
    <!-- ./BOTON PARA VER BOTS -->
    <blockquote>Usuarios online: <?php echo $online; ?></blockquote>
    <div class="sectionMembers">
        <?php include Core::view('members.area'); ?>
    </div>
    <div id="onceMember" style="display: none;"></div>
    <!-- BOTON DE NUEVO -->
    <div class="fixed-action-btn">
        <button class="btn red darken-3" id="btnEditMember" type="button" style="display: none;" onclick="admin.forms.get('Member', '', true);">Cancelar</button>
    </div>
</section>

<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url'];?>/static/js/admin.js"/></script>