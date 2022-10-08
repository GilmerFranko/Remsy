<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\config.html.php       \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página de configuración de la administración
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

<section>
    <div class="sectionConfiguration">
          <blockquote class="flow-text">
              Guardado por <?php echo $save_name; ?> el <?php echo $save_date; ?>
          </blockquote>
          <div class="row">
           <form action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'configuration');?>" method="post" class="col s12">

            <!-- NOMBRE DEL SITIO -->
            <div class="row">
              <div class="input-field col s12">
                <input id="script_name" name="script_name" type="text" class="validate" value="<?php echo $config['script_name']; ?>" required="required">
                <label for="script_name" class="active">Nombre del sitio</label>
              </div>
            </div>
            <!-- NOMBRE DE LA COOKIE -->
            <div class="row">
              <div class="input-field col s6">
                <input id="cookie_name" name="cookie_name" type="text" class="validate" value="<?php echo $config['cookie_name']; ?>" required="required">
                <label for="cookie_name" class="active">Nombre de cookie</label>
              </div>
              <div class="input-field col s6">
                <input id="cookie_time" name="cookie_time" type="number" class="validate" value="<?php echo $config['cookie_time']; ?>" required="required">
                <label for="cookie_time" class="active">Tiempo de cookie (d&iacute;as)</label>
              </div>
            </div>
            <!-- CONFIGURACIÓN EXTRA -->
            <div class="row">
              <div class="input-field col s6">
                <div class="switch">
                  <label>
                    <input type="checkbox" value="1" name="maintenance" id="maintenance" <?php echo $config['maintenance'] == 1 ? 'checked="checked"' : ''; ?>>
                    <span class="lever"></span>
                    
                  </label>
                </div>
                <label for="maintenance" class="active">Mantenimiento</label>
              </div>
              <div class="input-field col s6">
                <div class="switch">
                  <label>
                    
                    <input type="checkbox" value="1" name="debug_mode" id="debug_mode" <?php echo $config['debug_mode'] == 1 ? 'checked="checked"' : ''; ?>>
                    <span class="lever"></span>
                    
                  </label>
                </div>
                <label for="debug_mode" class="active">Depuraci&oacute;n</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <div class="switch">
                  <label>
                    <input type="checkbox" value="1" name="reg_validate" id="reg_validate" <?php echo $config['reg_validate'] == 1 ? 'checked="checked"' : ''; ?>>
                    <span class="lever"></span>
                    
                  </label>
                </div>
                <label for="reg_validate" class="active">Validar por correo</label>
              </div>
              <div class="input-field col s6">
                <div class="switch">
                  <label>
                    <input type="checkbox" value="1" name="check_clon" id="check_clon" <?php echo $config['check_clon'] == 1 ? 'checked="checked"' : ''; ?>>
                    <span class="lever"></span>
                    
                  </label>
                </div>
                <label for="check_clon" class="active">Comprobar clon en registro</label>
              </div>
            </div>
            <!-- CONFIGURACION DE VEROTEL -->
            <blockquote class="flow-text">Verotel</blockquote>
            <div class="row">
              <!-- SIGNATUREKEY - FIRMA -->
              <div class="input-field col s6">
                <input id="verotel_signature" name="verotel_signature" type="text" class="validate" value="<?php echo $config['verotel_signature']; ?>" required="required">
                <label for="verotel_signature" class="active">Firma (signatureKey)</label>
              </div>
              <!-- ID DE LA TIENDA -->
              <div class="input-field col s6">
                <input id="verotel_shop_id" name="verotel_shop_id" type="number" class="validate" value="<?php echo $config['verotel_shop_id']; ?>" required="required">
                <label for="verotel_shop_id" class="active">ID de tienda (ShopID)</label>
              </div>
            </div>
            <!-- CONFIGURACION DE AVATAR -->
            <blockquote class="flow-text">Avatar</blockquote>
            <div class="row">
              <!-- TAMAÑO MÍNIMO DE AVATAR -->
              <div class="input-field col s6">
                <input id="avatar_min_size" name="avatar_min_size" type="number" class="validate" value="<?php echo $config['avatar_min_size']; ?>" step="0.1" required="required">
                <label for="avatar_min_size" class="active">Tama&ntilde;o m&iacute;nimo (MB)</label>
              </div>
              <!-- TAMAÑO MÁXIMO DE AVATAR -->
              <div class="input-field col s6">
                <input id="avatar_max_size" name="avatar_max_size" type="number" class="validate" value="<?php echo $config['avatar_max_size']; ?>" step="0.1" required="required">
                <label for="avatar_max_size" class="active">Tama&ntilde;o m&aacute;ximo (MB)</label>
              </div>
              <!-- ANCHO MÍNIMO DE AVATAR -->
              <div class="input-field col s6">
                <input id="avatar_min_x" name="avatar_min_x" type="number" class="validate" value="<?php echo $config['avatar_min_x']; ?>" required="required">
                <label for="avatar_min_x" class="active">Ancho m&iacute;nimo en p&iacute;xeles</label>
              </div>
              <!-- ANCHO MÁXIMO DE AVATAR -->
              <div class="input-field col s6">
                <input id="avatar_max_x" name="avatar_max_x" type="number" class="validate" value="<?php echo $config['avatar_max_x']; ?>" required="required">
                <label for="avatar_max_x" class="active">Ancho m&aacute;ximo</label>
              </div>
              <!-- ALTO MÍNIMO DE AVATAR -->
              <div class="input-field col s6">
                <input id="avatar_min_y" name="avatar_min_y" type="number" class="validate" value="<?php echo $config['avatar_min_y']; ?>" required="required">
                <label for="avatar_min_y" class="active">Alto m&iacute;nimo</label>
              </div>
              <!-- ALTO MÁXIMO DE AVATAR -->
              <div class="input-field col s6">
                <input id="avatar_max_y" name="avatar_max_y" type="number" class="validate" value="<?php echo $config['avatar_max_y']; ?>" required="required">
                <label for="avatar_max_y" class="active">Alto m&aacute;ximo</label>
              </div>
            </div>
            <!-- CONFIGURACIÓN DE SHOUTS -->
            <blockquote class="flow-text">Shouts</blockquote>
            <div class="row">
              <!-- PRECIO DE CADA FOTO -->
              <div class="input-field col s6">
                <input id="shouts_price_photo" name="shouts_price_photo" type="number" class="validate" value="<?php echo $config['shouts_price_photo']; ?>" min="0" max="1000" required="required">
                <label for="shouts_price_photo">Precio de cada foto</label>
              </div>
              <div class="input-field col s6">
                <input id="shouts_earnings_downloads" name="shouts_earnings_downloads" type="number" class="validate" value="<?php echo $config['shouts_earnings_downloads']; ?>" min="0" max="1000" required="required">
                <label for="shouts_earnings_downloads">Ganancias por 100 descargas (100 = &dollar;1)</label>
              </div>
              <div class="input-field col s6">
                <input id="shouts_video_max_size" name="shouts_video_max_size" type="number" class="validate" value="<?php echo $config['shouts_video_max_size']; ?>" min="0" max="50" step="0.1" required="required">
                <label for="shouts_video_max_size">Tama&ntilde;o m&aacute;ximo (MB)</label>
              </div>
              <div class="input-field col s6">
                <input id="shouts_max_char" name="shouts_max_char" type="number" class="validate" value="<?php echo $config['shouts_max_char']; ?>" min="0" required="required">
                <label for="shouts_max_char">Cantidad de caracteres</label>
              </div>
            </div>
            <!-- PUBLICIDAD -->
            <blockquote class="flow-text">Publicidad</blockquote>
            <div class="row">
              <div class="input-field col s12">
                <textarea id="ad300250" name="ad_300x250" class="materialize-textarea"><?php echo $config['ad_300x250']; ?></textarea>
                <label for="ad300250">Publicidad 300x250</label>
              </div>
            </div>
            <!-- BOT -->
            <blockquote class="flow-text">Bots</blockquote>
            <div class="row">
              <!-- PROBABILIDAD DE PUBLICACIÓN -->
              <div class="input-field col s6">
                <input id="shouts_percent_day" name="shouts_percent_day" type="number" class="validate" value="<?php echo $config['shouts_percent_day']; ?>" min="0" max="100" required="required">
                <label for="shouts_percent_day">Porcentaje de publicaci&oacute;n</label>
              </div>
              <div class="input-field col s6">
                <input id="shouts_percent_night" name="shouts_percent_night" type="number" class="validate" value="<?php echo $config['shouts_percent_night']; ?>" min="0" max="100" required="required">
                <label for="shouts_percent_night">Porcentaje nocturno</label>
              </div>
            </div>
            <!-- BOTON QUE REGALA CREDITOS -->
            <blockquote class="flow-text">Bot&oacute;n de cr&eacute;ditos</blockquote>
            <div class="row">
              <div class="input-field col s12">
                <input id="coins_per_click" name="coins_per_click" type="number" class="validate" value="<?php echo $config['coins_per_click']; ?>" min="0" max="255" required="required">
                <label for="coins_per_click">Cr&eacute;ditos por clic</label>
              </div>
            </div>


            <!-- BOTON GUARDAR -->
            <button class="btn waves-effect waves-light grey darken-3" type="submit" name="save">Guardar cambios
              <i class="material-icons right">save</i>
            </button>
         </form>
       </div>
    </div>
</section>


<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url'];?>/static/js/admin.js"/></script>