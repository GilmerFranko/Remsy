<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\site\view\search.html.php        \
 * @package     One V                                     \
 * @author      Gilmer                  |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de buscador de usuarios
 *
 *
*/

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<section id="<?php echo $page['code']; ?>">
    <!-- BUSCADOR -->
    <nav class="teal darken-1">
        <div class="nav-wrapper">
            <form action="<?php echo Core::model('extra', 'core')->generateUrl('site', 'search');?>" method="post">
                <div class="input-field">
                    <input id="search" name="search" type="search" placeholder="Buscar..." value="<?php echo $search; ?>">
                    <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                    <i class="material-icons">close</i>
                </div>
            </form>
        </div>
    </nav>
    <!-- ./BUSCADOR -->

    <div class="row">
        <?php if(!empty($members['data'])) {
            $c = 0;
            while( $member = $members['data']->fetch_assoc() ) { ?>
        <div class="col s6 l3">
            <div class="card" id="member_<?php echo $member['member_id']; ?>">
                <!-- IMAGEN RINCIPAL DEL SHOUT -->
                <div class="card-image">
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => $member['member_id'])); ?>">
                        <img class="responsive-img circle" src="<?php echo (!empty($member['pp_thumb_photo']) ? $member['pp_thumb_photo'] : Core::model('member', 'members')->getAvatar($member['member_id'])); ?>" onerror="this.src='<?php echo $config['avatar_url']; ?>/default_1.jpg'"/>
                    </a>
                </div>
                <div class="card-action grey lighten-5 center-align notranslate">
                    <!-- NOMBRE DE USUARIO Y CANTIDAD DE FOTOS -->
                    <?php echo $member['name']; ?>
                </div>
            </div>
        </div>
        <?php ++$c;
        if($c%8==0) {
            echo '<div class="col s12">'.html_entity_decode($config['ad_300x250'], ENT_NOQUOTES).'</div>';
        }?>
        <?php } } else echo '<blockquote class="flow-text">No hay usuarios</blockquote>'; ?>
    </div>
    <!--paginador-->
    <?php echo $members['pages']['paginator']; ?>
    <!--fin_paginador-->
</section>
<!-- / Body -->

<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->