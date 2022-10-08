<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\global\view\register.html.php    \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página de registro
 *
 *
*/

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<section id="membersRegister">
  <div class="container">
    <h2>Registro</h2>
  <form class="form col s12" action="" method="post">
    <div class="row">
        <div class="input-field col s12">
          <input placeholder="Tu Nombre y Apellido o Apodo" name="name" id="username" type="text" value="<?php echo Core::model('extra', 'core')->getInputValue('name', 'post'); ?>" class="validate" pattern="[ A-Za-z]{4,30}"
         title="Nombre. De entre: 4. A: 30 Letras" required>
          <label for="username">Tu Nombre y Apellido o Apodo. Ejemplo: Juan perez</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input placeholder="Correo electr&oacute;nico" name="email" id="email" type="email" value="<?php echo Core::model('extra', 'core')->getInputValue('email', 'post'); ?>" class="validate" required>
          <label for="username">Tu Email (Correo Electronico)</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6">
          <input id="password" name="password" type="password" class="validate" minlength="6" required>
          <label for="password">Elije una Contrase&ntilde;a</label>
        </div>
        <div class="input-field col s6">
          <input id="confirmPassword" name="confirmPassword" type="password" class="validate" minlength="6" required>
          <label for="confirmPassword">Repite la Contrase&ntilde;a</label>
        </div>
      </div>
      <div class="row">
        <label>
          <input name="gender" type="radio" value="0" required/>
          <span>Soy Hombre</span>
        </label>
        <label>
          <input name="gender" type="radio" value="1" required/>
          <span>Soy Mujer</span>
        </label>
      </div>

      <div class="row">
        <span class="grey-text">
          Al hacer clic en Crear Cuenta, aceptas y confirmas tener 18 a&ntilde;os y aceptas nuestros <a href="<?php echo Core::model('extra', 'core')->generateUrl('site', 'pages', null, array('name' => 'terms')); ?>">T&eacute;rminos del servicio</a>. Obt&eacute;n m&aacute;s informaci&oacute;n en la <a href="<?php echo Core::model('extra', 'core')->generateUrl('site', 'pages', null, array('name' => 'privacy')); ?>">Pol&iacute;tica de privacidad</a>.
        </span>
      </div>

      <div class="row">
        <div class="col s12">
          <button class="btn waves-effect waves-light blue darken-3 w100 btn-large" type="submit" name="register">Crear cuenta
            <i class="material-icons right">person_add</i>
          </button>
        </div>
      </div>
    </form>
    <a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'login'); ?>" class="waves-effect waves-light btn btn-small w100 brown darken-3"><i class="material-icons right">lock</i>Ya tienes cuenta? Ingresa</a>
	<br/><br/>
    <a href="<?php echo Core::model('extra', 'core')->generateUrl('site', 'pages', null, array('name' => 'explica')); ?>" class="waves-effect waves-light btn btn-small w100 purple darken-3"><i class="material-icons right">thumb_up_alt</i>No puedes registrarte? toca aqui!</a><br/><br/>
</div>
</section>

<!-- MODAL DE EDAD -->
<!-- OCULTO
<button data-target="modalAge" class="btn modal-trigger hide" id="btnModalAge"></button>
<div id="modalAge" class="modal modal-fullscreen modal-fixed-footer">
	<div class="modal-content">
		<h4>Mayor&iacute;a de Edad</h4>
		<p>
			<label>
				<input type="checkbox" id="indeterminate-checkbox" />
				<span>Antes de continuar confirma que tienes m&aacute;s de 18 a&ntilde;os, toca el cuadro y luego continuar.</span>
			</label>
		</p>
    </div>
	<div class="modal-footer">
		<a href="#!" id="btnAge" class="modal-close waves-effect waves-blue btn-flat">Continuar</a>
 	</div>
</div>
OCULTO -->
<!-- / MODAL DE EDAD -->

<!-- / Body -->
<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->
