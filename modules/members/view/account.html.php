<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\view\account.html.php    \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la configuración del usuario
 *
 *
*/

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<section id="memberAccount">
    <div class="row">
        <form action="<?php echo Core::model('extra', 'core')->generateUrl('members', 'account', 'save');?>" method="post" enctype="multipart/form-data">
            <div class="card">
                <div class="card-image">
                    <img id="img1" src="<?php echo Core::model('member', 'members')->getAvatar($session->memberData['member_id']); ?>" alt="avatar" class="responsive-img materialboxed" data-caption="Avatar de <?php echo $session->memberData['name'];?>">
                    <!--<span class="card-title">Tu perfil</span>-->
                    <div class="file-field input-field btn-floating halfway-fab waves-effect waves-light red pulse">
                        <i class="material-icons">add_a_photo</i>
                        <input name="avatar_pc" id="file1" type="file" accept="image/*" onchange="$('#btnSaveAccount').click();">
                    </div>
                </div>
                <!--<div class="card-content">
                    <p>Aqu&iacute; puedes editar la informaci&oacute;n de tu perfil</p>
                    </div>-->
                <div class="card-tabs">
                    <ul class="tabs tabs-fixed-width">
                        <li class="tab"><a href="#tinfo">Informaci&oacute;n</a></li>
                        <li class="tab"><a href="#tpass" <?php echo $sSection == 'account.password' ? 'class="active"' : ''; ?>>Seguridad</a></li>
                        <!--<li class="tab disabled"><a href="#tpriv">Privacidad</a></li>-->
                        <li class="tab"><a href="#tblocks">Bloqueados</a></li>
                    </ul>
                </div>
                <div class="card-content grey lighten-4">
                    <!-- Tab INFO -->
                    <div id="tinfo">
                        <?php include Core::view('account.profile.area'); ?>
                    </div>
                    <!-- TAB SEGURIDAD -->
                    <div id="tpass">
                        <?php include Core::view('account.security.area'); ?>
                    </div>
                    <!-- TAB PRIVACIDAD -->
                    <!--<div id="tpriv">
                        <?php include Core::view('account.privacy.area'); ?>
                    </div>-->
                    <!-- TAB BLOQUEADOS -->
                    <div id="tblocks">
                        <?php include Core::view('account.blocks.area'); ?>
                    </div>
                </div>
                
                <!-- BOTON DE PERFIL -->
                <div class="card-action">
                    <a href="https://bellasgram.com/" class="waves-effect waves-light btn grey darken-2 w80"><i class="material-icons left">account_circle</i>Ver fotos xxx</a>
                </div>
                
                <!-- BOTON DE PERFIL -->
                <div class="card-action">
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'profile', NULL, array('user' => $session->memberData['member_id'])); ?>" class="waves-effect waves-light btn grey darken-2 w80"><i class="material-icons left">account_circle</i>Ver Perfil</a>
                </div>
                <!-- BOTON DE GUARDADO -->
                <div class="fixed-action-btn">
                  <button type="submit" class="btn-floating btn-large grey darken-4" name="saveAccount" id="btnSaveAccount"><i class="large material-icons">save</i></button>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- / Body -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url'];?>/static/js/images.js"/></script>

<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->