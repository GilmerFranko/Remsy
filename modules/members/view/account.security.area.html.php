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
 * @Description Vista del área "Contraseña" de la sección "Contraseña" en la cuenta
 *
 *
*/
?>

<article id="memberAccountSecurity">
    <div class="content">
        <div class="row">
            <div class="row">
                <div class="input-field col s12">
                    <input name="email" id="email" type="email" class="validate" value="<?php echo $session->memberData['email']; ?>" required>
                    <label for="email">Email</label>
                </div>
            </div>
            <!--<div class="row">
                <div class="input-field col s12">
                    <input name="currentPassword" placeholder="Contrase&ntilde;a actual" id="currentPassword" type="password" class="validate" autocomplete="new-password">
                    <label for="currentPassword">Contrase&ntilde;a actual</label>
                </div>
            </div>-->
            <div class="row">
                <div class="input-field col s6">
                    <input name="newPassword" id="newPassword" type="password" class="validate">
                    <label for="newPassword">Nueva contrase&ntilde;a</label>
                </div>
                <div class="input-field col s6">
                    <input name="confirmPassword" id=confirmPassword type="password" class="validate">
                    <label for="confirmPassword">Confirme contrase&ntilde;a</label>
                </div>
            </div>
            <div class="row">
                <p class="flow-text red-text" id="msgDelete"></p>
                <a class="waves-effect waves-light btn red darken-4 w100" href="javascript:deleteAccount();" id="deleteAccount">Eliminar Cuenta</a>
            </div>
        </div>
    </div>
</article>

<script>
    var token = '<?php echo $session->token; ?>';
</script>