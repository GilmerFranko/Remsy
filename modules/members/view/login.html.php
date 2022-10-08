<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\view\login.html.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página principal
 *
 *
*/

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<section style="margin-top: 50px;">
  <div class="row">
    <form action="<?php echo Core::model('extra', 'core')->generateUrl('members', 'login'); ?>" method="post">
      <div class="row">
        <div class="input-field col s12">
          <input id="email" name="email" type="email" class="validate" value="<?php echo Core::model('extra', 'core')->getInputValue('email'); ?>">
          <label for="email">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="password" name="password" type="password" class="validate">
          <label for="password">Contrase&ntilde;a</label>
        </div>
      </div>
      <div  class="row">
        <div class="col s12">
          <button class="btn btn-large w100 waves-effect waves-light blue darken-3" type="submit" name="login">Acceder
          <i class="material-icons right">send</i>
          </button>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <label for ="keepOpen">
            <input name="keepOpen" type="checkbox" class="filled-in" id="keepOpen" value="1" checked="checked">
            <span>Mantener sesiones anteriores abiertas</span>
          </label>
        </div>
      </div>
      <br /><br />
      <div class="row">
        <!-- Modal RECUPERAR CONTRASEÑA -->
        <form action="" method="post">
        <div id="modalRecover" class="modal modal-fixed-footer">
          <div class="modal-content">
            <h4>Recuperar contrase&ntilde;a o Email</h4>
              <div class="row">
                <span>Si olvidaste tu contrase&ntilde;a, escribe tu email (correo) y toca el boton RECUPERAR</span>
                <div class="input-field col s12">
                  <input id="recover" name="recover" type="email" class="validate">
                  <label for="recover">Email</label>
                </div>
              </div>
              <span>Si olvidaste tu email (correo), escribe tu nombre de usuario y la contrase&ntilde;a y toca el boton RECUPERAR y se te dara tu correo</span>
              <div class="row">
                <div class="input-field col s12 l6">
                  <input id="recoverEmail" name="recoverEmail" type="text" class="validate">
                  <label for="recoverEmail">Nombre de usuario</label>
                </div>
                <div class="input-field col s12 l6">
                  <input id="recoverEmailPass" name="recoverEmailPass" type="password" class="validate">
                  <label for="recoverEmailPass">Contrase&ntilde;a</label>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-blue btn-flat">Cancelar</a>
            <button class="waves-effect waves-light btn w50 grey darken-3 autodisabled" type="submit" name="recoverBtn">Recuperar
            <i class="material-icons right">fingerprint</i>
          </button>
          </div>
        </div>
      </form>
        <!-- BOTONES INFERIORES -->
      <div class="row col s12">
        <a class="modal-trigger waves-effect waves-light btn w100 grey darken-3" href="#modalRecover"><i class="material-icons right">fingerprint</i>Olvide mi contrase&ntilde;a / Email</a>
      </div>
      <div class="row col s12">
        <a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'register'); ?>" class="waves-effect waves-light btn w100 blue darken-3"><i class="material-icons right">group_add</i>Crear cuenta</a>
        </div>
      </div>
    </form>
  </div>
</section>
<!-- / Body -->

<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->
