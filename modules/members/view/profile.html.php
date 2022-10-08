<?php defined('SUPERNATURAL') || exit;

// INDICACION TEMPORAL
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'com.BelGram.android')
{
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">


<center> <H4> <font color="blue">Esta secci&oacute;n, es solo visible desde nuestra nueva app de BellasGram (Google nos elimino la anterior), para ingresar sigue los pasos descritos abajo y despu&eacute;s <a href="https://play.google.com/store/apps/details?id=com.bellas.gram.app.android">descarga la APP AQUI</a> ya luego borra la app actual e ingresa solo desde la nueva.

    <hr />
     Si ya tienes la nueva APP pero no recuerdas tu contrase&ntilde;a y se te dificultan los pasos para una nueva, entonces aun no elimines la app y <br/> enviale un mensaje a <a href="https://bellasgram.com/chat/newchat.php?id=196558">ANDREA MARTINEZ</a> y pidele una contrase&ntilde;a nueva, ella te ayudara, (las contrase&ntilde;as estan cifradas con seguridad y no te puede decir tu contrase&ntilde;a actual, pero si te puede dar una nueva, no perder&aacute;s nada de lo que tenias).
    <hr />
    La nueva app es mas r&aacute;pida, y salen menos anuncios al ver fotos en BellasGram y el Chat, adem&aacute;s ya no te saldr&aacute;n anuncios de video al tocar la lupa en BellasGram para ver una foto.
        <hr />
    No te olvides darnos 5 estrellas<br/><br/>
    <hr />
    <br/><br/>
    PASOS A SEGUIR:
    <br/><br/>
    <hr />
    Nuestra aplicaci&iacute;n en la PlayStore o Google Play se llama 
<br/><a href="https://play.google.com/store/apps/details?id=com.bellas.gram.app.android">BellasGram </a><br/>(Puedes buscarla en la PlayStore o toca las letras azules para ir a Google Play) 
<hr />

Instala la APP y la abres e ignora el contenido (a simple vista se ve como si fuera un app de un v&iacute;deojuego, pero lo rico esta oculto)<br/> <br/>
1: toca la lupa que sale arriba a la derecha
<br/><br/>
<img src="static/images/1.png">


<hr />
2: Toca donde donde "buscar"
<br/><br/>
<img src="static/images/2.png">
<hr />
Y escribe bellasgram y espera que salga la manzana (al escribir bellasgram saldr&aacute; una manzana) y la tocas para entrar a BellasGram, Ya puedes entrar con tu correo y contrase&ntilde;a, si no recuerdas la contrase&ntilde;a puedes pedir una nueva como se indica arriba.
<br/><br/>
<img src="static/images/3.png">
<hr />


';
	exit;
}

/* FIN INDICACION TEMPORAL*/

/**
 *-------------------------------------------------------/
 * @file        modules\members\view\profile.html.php    \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista del perfil de un usuario
 *
 *
*/

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<script>
  var pName = '<?php echo $memberData['name']; ?>', pID = <?php echo $memberData['member_id']; ?>, pGender = <?php echo $memberData['pp_gender']; ?>
</script>

<!-- Body -->
<section id="memberProfile">
      <div class="card">
        <div class="card-image avatar">
          <img class="responsive-img materialboxed" src="<?php echo Core::model('member', 'members')->getAvatar($memberData['member_id'], false); ?>">
          <span class="card-title notranslate"><?php echo $memberData['name']; ?></span>
        </div>
        <div class="card-content">
          <p class="flow-text">
            Informaci&oacute;n
            <?php if($session->is_admod == 1) { ?>
            <?php if($memberData['bot'] > 0 || $memberData['bot_response'] > 0) { echo '-> Es bot'; }; ?>
            <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'members', null, array('edit' => $memberData['member_id'])); ?>" class="waves-effect waves-light btn brown darken-3 right"><i class="material-icons left">edit</i>Editar</a>
            <?php } ?>
        </p>
        </div>
        <!-- ACCIONES SOBRE EL USUARIO -->
        <?php if($memberData['member_id'] !== $session->memberData['member_id']) { ?>
        <div class="card-action">
          <div class="row">
            <div class="col s4">
                <?php if(Core::model('profile', 'members')->getFollowsBlocks($session->memberData['member_id'], $memberData['member_id']) === false) { ?>
                <a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'profile', 'follow', array('user' => $memberData['member_id'], 'action' => 'follow', 'token' => $session->token)); ?>" class="waves-effect waves-light btn blue darken-3"><i class="material-icons left">visibility</i><span class="hide-on-small-only">Seguir</span></a>
                <?php } else { ?>
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'profile', 'follow', array('user' => $memberData['member_id'], 'action' => 'unfollow', 'token' => $session->token)); ?>" class="waves-effect waves-light btn red darken-2"><i class="material-icons left">visibility</i><span class="hide-on-small-only">No Seguir</span></a>
                <?php } ?>
            </div>
            <!-- BLOQUEO -->
            <div class="col s4">
                <a class="waves-effect waves-light btn modal-trigger red darken-3" href="#modalBlock"><i class="material-icons left">block</i><span class="hide-on-small-only">Bloquear</span></a>
                <div id="modalBlock" class="modal bottom-sheet">
                  <div class="modal-content">
                    <h4>Bloquear a <?php echo $memberData['name']; ?></h4>
                    <p>&iquest;Seguro que quieres bloquear a <?php echo $memberData['name']; ?>?</p>
                  </div>
                  <div class="modal-footer">
                    <a href="#!" class="modal-close waves-effect waves-blue btn">Cancelar</a>
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'profile', 'block', array('user' => $memberData['member_id'], 'action' => 'block', 'token' => $session->token)); ?>" class="modal-close waves-effect waves-red btn red darken-3">Bloquear</a>
                  </div>
                </div>
            </div>
            <!-- ./BLOQUEO -->
            <!-- DENUNCIA -->
            <div class="col s4">
                <a class="waves-effect waves-light btn orange darken-3 modal-trigger" href="#modalReport" ><i class="material-icons left">warning</i><span class="hide-on-small-only">Denunciar</span></a>
                <!-- MODAL DENUNCIA -->
                <div id="modalReport" class="modal modal-fullscreen modal-fixed-footer">
                  <form action="<?php echo Core::model('extra', 'core')->generateUrl('site', 'report', null, array('type' => 'user', 'obj' => $memberData['member_id'], 'action' => 'new')); ?>" method="post">
                  <div class="modal-content">
                    <h4>Denunciar a <?php echo $memberData['name']; ?></h4>
                    <div class="row">
                      <div class="input-field col s12">
                        <input type="hidden" name="token" value="<?php echo $session->token; ?>">
                        <textarea name="reason" id="reason" class="materialize-textarea" required></textarea>
                        <label for="reason">Motivo de la denuncia</label>
                        <span class="helper-text">La autora del shout <strong>NO VER&Aacute;</strong> la denuncia. <strong>No utilice este sistema para enviar mensajes a la autora.</strong></span>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <a href="#!" class="modal-close waves-effect waves-blue btn">Cancelar</a>
                    <button class="waves-effect waves-orange btn orange darken-3 autodisabled" type="submit" name="report">Denunciar
                      <i class="material-icons right">warning</i>
                    </button>
                  </div>
                </form>
                </div>
                <!-- ./MODAL DENUNCIA -->
            </div>
            <!-- ./DENUNCIA -->
            </div>
        </div>
        <?php } ?>
        <!-- ./ ACCIONES SOBRE EL USUARIO -->
        <div class="card-tabs">
      <ul class="tabs tabs-fixed-width">
        <li class="tab"><a href="#pinfo" id="cInfo">Info</a></li>
        <?php if($memberData['pp_gender'] == 1) {
          echo '<li class="tab"><a href="#pfollowers">'.$memberData['follows'].' Seguidores</a></li>
                <li class="tab"><a href="#pshouts" id="cShouts">Shouts</a></li>
                <li class="tab"><a href="#pshoutsVip" id="cShoutsVip">Shouts VIP</a></li>';
        } else {
          echo '<li class="tab"><a href="#pfollowing">Siguiendo</a></li>';
        }
        ?>
      </ul>
    </div>
    <div class="card-content grey lighten-4">
      <div id="pinfo">
        <?php include Core::view('profile.info.area'); ?>
      </div>
      <?php if($memberData['pp_gender'] == 1) { ?>
      <div id="pfollowers">
          <?php include Core::view('profile.followers.area'); ?>
      </div>
      <div id="pshouts">
          <blockquote class="flow-text">No tiene shouts</blockquote>
      </div>
      <div id="pshoutsVip">
          <blockquote class="flow-text">No tiene shouts Vip</blockquote>
      </div>
    <?php } else { ?>
      <div id="pfollowing">
          <?php include Core::view('profile.following.area'); ?>
      </div>
    <?php } ?>
    </div>
</div>

<?php if($memberData['member_id'] === $session->memberData['member_id']) { ?>
<!-- BOTON DE EDITAR PERFIL -->
<div class="fixed-action-btn">
  <a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'account'); ?>" class="btn-floating btn-large grey darken-4">
    <i class="large material-icons">mode_edit</i>
  </a>
</div>
<?php } ?>

</section>
<!-- / Body -->

<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->
