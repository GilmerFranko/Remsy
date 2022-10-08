<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        sidenav.html.php                         \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Archivo que incluye el ménú lateral
 *
 *
*/
?>
<ul id="user-menu" class="sidenav<?php if($sModule == 'admin' || $sModule == 'mod') { echo ' sidenav-fixed'; } ?>">
  <!-- MENU DE USUARIO O VISITANTE -->
  <li class="sidenav-header blue-grey darken-4">
  </li>
  <li>
    <ul>
      
       <!-- IDIOMAS -->
  <div class="row">
      <div class="input-field col s12">
        <select class="browser-default" onchange="doGTranslate(this);">
          <option value="">Idioma / Language</option>
          <option value="en|en">English</option>
          <option value="en|fr">French</option>
          <option value="en|it">Italian</option>
          <option value="en|pt">Portuguese</option>
          <option value="en|es">Espa&ntilde;ol</option>
        </select>
      </div>
    </div>
  <!-- ./IDIOMAS -->
  
      <li>
        <a class="waves-effect waves-blue" href="#!">
        <i class="material-icons">attach_money</i>
        </a>
      </li>
      
      <?php if($session->platform == 'app') { ?>
	<span> <li>
        <a class="waves-effect waves-blue" href="https://natural-worlds.com/">
        <i class="material-icons">call_missed</i>Volver al inicio
        </a>
      </li><?php } ?>
    </ul>
  </li>
</ul>
