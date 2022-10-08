<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\photos.html.php       \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página del envío de fotos
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

<?php
if( isset($_GET['save']) && isset($_SESSION['message']))
{
    echo Core::model('extra', 'core')->getToast($_SESSION['message']);
} ?>
<section id="adminPhotos">
    <div class="sectionPhotos">
        <blockquote class="flow-text">Regalar fotos</blockquote>
        <!-- NUEVO REGALO -->
        <form class="col s12" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'photos', 'action', array('do' => 'new'));?>" method="post" enctype="multipart/form-data">
            <!-- PRIMER PÁRRAFO -->
            <div class="row">
                <!-- DESCRIPCIÓN DE LA FOTO -->
                <div class="input-field col s12 l6">
                    <i class="material-icons prefix">comment</i>
                    <textarea id="description" name="description" class="materialize-textarea"></textarea>
                    <label for="description" class="active">Descripci&oacute;n</label>
                </div>
                <!-- FECHA DE EXPIRACIÓN DE LA FOTO -->
                <div class="input-field col s12 l6">
                    <i class="material-icons prefix">date_range</i>
                    <input type="datetime-local" id="date" name="date" class="validate" value="<?php echo date('Y-m-d\TH:i', strtotime('+1 hours')); ?>" min="<?php echo date('Y-m-d\TH:i', strtotime('+1 hours')); ?>" max="<?php echo date('Y-m-d\TH:i', strtotime('+7 days')); ?>" required>
                    <label for="date" class="active">&iquest;Hasta cu&aacute;ndo?</label>
                </div>
            </div>
            <!-- SEGUNDO PÁRRAFO -->
            <div class="row">
                <!-- NOMBRE DE LA AUTORA -->
                <div class="input-field col s10 l5">
                  <i class="material-icons prefix">account_circle</i>
                  <input type="text" name="author" id="author" class="autocomplete" required>
                  <label for="author">Nombre autora</label>
                </div>
                <div class="col s2 l1">
                    <a class="waves-effect waves-light btn btn-small" href="javascript:searchUsers();" id="btnSearch"><i class="material-icons">search</i></a>
                </div>
                <!-- RUTA MANUAL DE LA FOTO -->
                <div class="input-field col s10 l5" id="pathPhoto" style="display: none;">
                    <i class="material-icons prefix">photo</i>
                    <input type="text" name="photo" id="photo" class="autocomplete" disabled>
                  <label for="photo">Ruta de la foto</label>
                </div>
                <div class="col s2 l1" id="btnSwitch" style="display:none;">
                    <a class="waves-effect waves-light btn btn-small" href="javascript:switchMode();" id="btnSwitch"><i class="material-icons">file_upload</i></a>
                </div>
                <!-- SUBIR FOTO -->
                <div class="file-field input-field col s11 l5" id="uploadPhoto" style="display: none;">
                  <div class="btn purple" style="width: auto;">
                    <i class="material-icons">add_a_photo</i>
                    <input name="photo" id="uPhoto" type="file" accept="image/*">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Seleccionar foto">
                  </div>
                </div>
                <!-- BOTÓN ENVIAR -->
                <div class="col s12">
                    <button class="btn waves-effect waves-light" type="submit" name="action">Enviar
                    <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </form>
        <!--./ NUEVO FILTRO -->
        <?php include Core::view('photos.area'); ?>
    </div>
</section>
<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url'];?>/static/js/admin.js"/></script>

<script>
$(document).ready(function() {

    // BOTS
    $('#author').autocomplete({
        data: {
            <?php
            while ($member = $members['data']-> fetch_assoc()) {
                echo '"'.$member['name'].
                '": "'.$member['pp_thumb_photo'].
                '",';
            } ?>
        },
        onAutocomplete: function() {
            getPhotos();
        }
    });
});


function searchUsers() {
    // SI HAY MÁS DE 3 LETRAS
    if ($('#author').val().length > 3) {
        // DESHABILITAR TEMPORALMENTE BOTON
        $('#btnSearch').attr('disabled', true);
        // BUSCAR USUARIOS CON ESE NICK
        $.post(global.url + '/index.php?app=admin&section=photos&area=load', 'ajax=true' + '&search=' + encodeURIComponent($('#author').val()), function(a) {
            success: {
                // SI SE HAN OBTENIDO FOTOS
                if (a.charAt(0) == '1') {
                    // CARGAR AUTOCOMPLETAR DE LOS USUARIOS
                    $('#author').autocomplete({
                        data: JSON.parse(a.substring(2)),
                        onAutocomplete: function() {
                            getPhotos()
                        },
                    });
                    // HACER CLIC PARA ABRIR LISTA 
                    $('#author').click();
                } else {
                    // MOSTRAR MENSAJE DE ERROR
                    swal.fire('',a.substring(2),'');
                }
                // HABILITAR BOTON
                $('#btnSearch').removeAttr('disabled');
            }
        });
    }
    else
    {
        swal.fire('',a.substring(2),'');
    }
}

function switchMode()
{
    // MOSTRAR CAMPO PARA SUBIR FOTO
    $('#uploadPhoto').slideDown('slow');
    // OCULTAR CAMPO PARA ESCRIBIR RUTA
    $('#pathPhoto').slideUp('slow');
    // OCULTAR BOTÓN PARA SUBIR FOTOS
    $('#btnSwitch').slideUp('slow');
    // HACER OBLIGATORIA LA SUBIDA DE FOTO
    $('#uPhoto').attr('required', true);
    // ELIMINAR OBLIGATORIEDAD DE RUTA DE FOTO
    $('#photo').removeAttr('required');
}

function getPhotos() {
    // ESTABLECER NOMBRE AUTOR
    var author = encodeURIComponent($('#author').val());
    // VACIAR CAMPO DE LA RUTA
    $('#photo').val('');
    // ELIMINAR ARCHIVO DE LA FOTO
    $('#uPhoto').val('');
    // BUSCAR FOTOS DEL NOMBRE ESCRITO
    $.post(global.url + '/index.php?app=admin&section=photos&area=load', 'ajax=true' + '&name=' + author, function(a) {
        success: {
            // SI SE HAN OBTENIDO FOTOS
            if (a.charAt(0) == '1') {
                var photos = JSON.parse(a.substring(2));
                // MOSTRAR CAMPO PARA AUTOCOMPLETAR FOTO
                $('#pathPhoto').slideDown('slow');
                // MOSTRAR BOTÓN PARA SUBIR FOTOS
                $('#btnSwitch').slideDown('slow');
                // OCULTAR CAMPO PARA SUBIR FOTO
                $('#uploadPhoto').slideUp('slow');
                // HACER OBLIGATORIA LA RUTA
                $('#photo').attr('required', true);
                // ELIMINAR OBLIGATORIEDAD DE SUBIR FOTO
                $('#uPhoto').removeAttr('required');
                // CARGAR AUTOCOMPLETAR DE LAS RUTAS DE LAS FOTOS
                $('#photo').val('').removeAttr('disabled').autocomplete({
                    data: photos,
                });
                // INDICAR CANTIDAD DE FOTOS
                swal.fire('',a.substring(2),'');
            } else {
                // ACCIONES PARA SUBIR FOTO
                switchMode();
                // MOSTRAR MENSAJE DE ERROR
                swal.fire('',a.substring(2),'');
            }
        }
    });
}
</script>