<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\sidebar.html.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista del sidebar de la administración
 *
 *
*/

?>
<li class="grey darken-4">
    <ul class="collapsible collapsible-accordion">
      <li <?php if($sModule == 'admin') { echo ' class="active"'; } ?>>
        <a class="collapsible-header white-text waves-effect waves-blue "><i class="material-icons white-text">settings_applications</i>Admin <i class="material-icons right white-text" style="margin-right:0;">arrow_drop_down</i></a>
        <div class="collapsible-body z-depth-1">
          <ul>
            <li <?php if($sSection == 'configuration') { echo ' class="active"'; } ?>>
              <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'configuration');?>">
              <i class="material-icons">settings</i>
              Configuraci&oacute;n
              </a>
            </li>
            <li <?php if($sSection == 'news') { echo ' class="active"'; } ?>>
              <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'news');?>">
              <i class="material-icons">info</i>
              Noticias
              </a>
            </li>
            <li <?php if($sSection == 'members') { echo ' class="active"'; } ?>>
              <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'members');?>">
              <i class="material-icons">group</i>
              Usuarios
              </a>
            </li>
            <li <?php if($sSection == 'groups') { echo ' class="active"'; } ?>>
              <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'groups');?>">
              <i class="material-icons">stars</i>
              Grupos
              </a>
            </li>
            <li <?php if($sSection == 'shouts') { echo ' class="active"'; } ?>>
              <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'shouts');?>">
              <i class="material-icons">photo_library</i>
              Shouts
              </a>
            </li>
            <li <?php if($sSection == 'censors') { echo ' class="active"'; } ?>>
              <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'censors');?>">
              <i class="material-icons">block</i>
              Censuras
              </a>
            </li>
            <li <?php if($sSection == 'contacts') { echo ' class="active"'; } ?>>
              <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'contacts');?>">
              <i class="material-icons">contact_mail</i>
              Contactos
              </a>
            </li>
            <li <?php if($sSection == 'bots') { echo ' class="active"'; } ?>>
              <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'bots');?>">
              <i class="material-icons">textsms</i>
              Bots Comentarios
              </a>
            </li>
            <li <?php if($sSection == 'photos') { echo ' class="active"'; } ?>>
              <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'photos');?>">
              <i class="material-icons">send</i>
              Regalar fotos
              </a>
            </li>
            <li <?php if($sSection == 'bulkemails') { echo ' class="active"'; } ?>>
              <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'bulkemails');?>">
              <i class="material-icons">email</i>
              Correos masivos
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </li>