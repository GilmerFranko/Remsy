<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        menu.html.php                            \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Archivo que incluye parte de la cabecera
 *
 *
*/
?>
<header><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta charset="UTF-8">
  <!-- menu desplegable -->
  <ul id="userOptions" class="dropdown-content">
    <li><a href="<?php echo $extra->generateUrl('posts', 'links-tar');?>">Actualizar Posts</a></li>
    <li><a href="<?php echo $extra->generateUrl('posts', 'posts-no-added', null,null); ?>">Posts Scrapeados</a></li>
    <li><a href="<?php echo $extra->generateUrl('works', 'messages', null,null); ?>">Mensages</a></li>
  </ul>
  <!--/menu desplegable -->
  <nav class="nav-fixed blue darken-3">
    <div>
      <div class="nav-wrapper">
        <!-- IZQUIERDA -->
        <div class="left">

            <div class="margin-r-5 center">
              <h5><a class="" target="_blank" href=""/><?php echo $config['script_name']; ?></a></h5>
            </div>
        </div>
        <ul class="right ">

          <li><a class="" href="<?php echo Core::model('extra', 'core')->generateUrl('posts', 'list'); ?>"><i class="material-icons">home</i></a></li>

          <!--<li><a onclick="getNotifications(); return false;" href=""><i class="material-icons notranslate">notifications_none</i></a></li>
          <li><a href="" title="Buscar personas"><i class="material-icons notranslate">search</i></a></li>
          <li><a href="" title="Contacto"><i class="material-icons notranslate">contact_mail</i></a></li>
          <li><a href="" title="Preguntas Frecuentes"><i class="material-icons notranslate">live_help</i></a></li>
          <!-- Dropdown Trigger -->
          <li>
            <a class="dropdown-trigger" href="#!" data-target="userOptions" title="Perfil">
              <i class="material-icons">settings</i><i class="material-icons right notranslate">arrow_drop_down</i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

</header>
<style>
  @media screen and (max-width: 640px){
    nav a.left, nav a.right{
      width: 50%;
    }
  }
</style>
