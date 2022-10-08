<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\bulkemail.html.php   \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página del envío de correos masivos
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
<section id="adminBulkemail">
    <div class="sectionBulkemail">
        <blockquote class="flow-text">Correos masivos</blockquote>
        <blockquote><strong>Puedes usar las variables:</strong><br />
                - {site_name} = nombre de la web<br/>
                - {site_url} = url de la web<br/>
                - {user_name} = nombre de usuario<br/>
                - {user_id} = id de usuario<br/>
                *<small>Se establecer&aacute; que el ID sea 0 y el nombre sea "Usuario" para correos separados por comas o no encontrados. </small>

        </blockquote>
        <!-- NUEVO CORREO -->
        <form class="col s12" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'bulkemails', 'action', array('do' => 'new'));?>" method="post" enctype="multipart/form-data">
            <!-- PRIMER PÁRRAFO -->
            <div class="row">
                <!-- ASUNTO DEL CORREO -->
                <div class="input-field col s12 l12">
                    <i class="material-icons prefix">subject</i>
                    <input type="text" name="subject" id="subject" required>
                  <label for="subject">Asunto del correo</label>
                </div>
                <!-- CONTENIDO DEL CORREO -->
                <div class="input-field col s12 l12">
                    <i class="material-icons prefix">email</i>
                    <textarea id="content" name="content" class="materialize-textarea" required></textarea>
                    <label for="content" class="active">Contenido del correo</label>
                </div>
                <!-- DÍA DE ENVÍO -->
                <div class="input-field col s12" id="divDate">
                    <i class="material-icons prefix">date_range</i>
                    <input type="date" name="date" id="date" min="<?php echo date('Y-m-d', strtotime('+1 days')); ?>" value="<?php echo date('Y-m-d', strtotime('+1 days')); ?>">
                    <label for="date">D&iacute;a de env&iacute;o</label>
                        <span class="helper-text">Programar un d&iacute;a para enviarlo junto al bot. Tambi&eacute;n podr&aacute;s enviarlo manualmente una vez registrado el correo.</span>
                </div>
            </div>
            <div class="row">
                <!-- TIPO DE DESTINATARIO -->
                <div class="input-field col s12 l6" id="divType">
                    <i class="material-icons prefix">import_contacts</i>
                    <select name="addressees_type" id="addressees_type" required="required">
                        <option disabled selected>Seleccionar</option>
                        <option value="1">A toda la web</option>
                        <option value="2">Seguidores de</option>
                        <option value="3">Escribir manualmente</option>
                        <option value="4">Subir archivo</option>
                    </select>
                    <label for="addressees_type">Tipo de env&iacute;o</label>
                </div>
                <!-- DESTINATARIOS MANUAL/SEGUIDORES -->
                <div class="input-field col s12 l6" id="divAddressees">
                    <i class="material-icons prefix">contact_mail</i>
                    <input type="text" name="addressees" id="addressees">
                  <label for="addressees">Destinatario(s)</label>
                  <span class="helper-text"></span>
                </div>
                <!-- SUBIR ARCHIVO -->
                <div class="file-field input-field col s12 l6" id="uploadAddressees" style="display: none;">
                  <div class="btn grey" style="width: auto;">
                    <i class="material-icons">attach_file</i>
                    <input name="addressees" id="uAddressees" type="file" accept=".csv">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Seleccionar archivo">
                  </div>
                </div>
                <!-- ESPECIFICACIÓN DE COLUMNAS -->
                <div id="divColumns" style="display: none;">
                    <div class="input-field col s4">
                        <input type="number" name="col_id" id="col_id" value="0" min="0">
                      <label for="col_id">ID</label>
                      <span class="helper-text">Columna donde almacena el ID de usuario</span>
                    </div>
                    <div class="input-field col s4">
                        <input type="number" name="col_name" id="col_name" value="0" min="0">
                      <label for="col_id">Nombre</label>
                      <span class="helper-text">Columna donde almacena el NOMBRE de usuario</span>
                    </div>
                    <div class="input-field col s4">
                        <input type="number" name="col_email" id="col_email" value="0" min="0">
                      <label for="col_id">Email</label>
                      <span class="helper-text">Columna donde almacena el EMAIL de usuario</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- BOTÓN ENVIAR -->
                <div class="col s12">
                    <button class="btn waves-effect waves-light brown darken-4 w100" type="submit" name="register">Registrar env&iacute;o
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </form>
        <!--./ NUEVO FILTRO -->
        <?php include Core::view('bulkemails.area'); ?>
    </div>
    <!-- MODAL DE VISTA PREVIA Y DESTINATARIOS -->
    <?php if( isset($addressees) && !empty($addressees) ) { ?>
      <button id="btnModalAddressees" data-target="modalAddressees" class="btn modal-trigger hide"></button>
    <div id="modalAddressees" class="modal modal-fullscreen modal-fixed-footer">
        <div class="modal-content">
            <h4>Destinatarios de #<?php echo $_GET['id']; ?></h4>
            <p><strong>Tiempo estimado:</strong> <?php echo $addressees_time; ?> segundos</p>
            <table class="striped responsive-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                     <?php 
                    foreach ($addressees as $user) { ?>
                    <tr id="Addresse_<?php echo $user[0]; ?>">
                        <td><?php echo $user[0]; ?></td>
                        <td><?php echo $user[1]; ?></td>
                        <td><?php echo $user[2]; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'bulkemails', 'action', array('do' => 'send', 'id' => $_GET['id']));?>" class="waves-effect waves-red btn red darken-3">Enviar ahora</a>
            <a href="#!" class="modal-close waves-effect waves-blue btn blue darken-3">Mantener programado</a>
        </div>
    </div>
    <?php } ?>
    <!-- ./MODAL DE VISTA PREVIA Y DESTINATARIOS -->
</section>
<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url'];?>/static/js/admin.js"/></script>

<script>
    <?php if(isset($addressees)) { ?>
    window.onload = function(e){
        $('#btnModalAddressees').click();
    }
    <?php } ?>
$(document).ready(function() {

    $('.modal').modal();

    $('.tooltipped').tooltip();

    /*$('#btnSchedule').click(function() {
        // COMPROBAR SI YA SE LE HA DADO CLIC
        if($(this).attr('status') == '0')
        {
            $(this).attr('status', '1');
        }
        else
        {
            // PROGRAMAR ENVÍO
            $('form').submit();
            
        }
        // MOSTRAR CAMPO DE FECHA
        $('#divDate').slideDown();
    });*/

    $('select').formSelect();

    /*$('#addressees_type').change(function() {
         $('#addressees_type').val();
      });*/

    // AL CAMBIAR TIPO DE DESTINATARIO
    $("#addressees_type").on('change', function() {
        // TIPO DE DESTINATARIO
        var type = $(this).val();
        // ACCIONES PREDEFINIDAS
        $('#divAddressees').show();
        $('#divType').addClass('l6');
        $('#uploadAddressees').hide(); // OCULTAR BOTON SUBIDA
        // OCULTAR COLUMNAS
        $('#divColumns').slideUp();
        
        // ENVIAR A TODO EL MUNDO
        if(type == 1)
        {
            $('#divAddressees').hide();
            $('#divType').removeClass('l6');
        }
        // ENVIAR A SEGUIDORES DE X
        else if(type == 2)
        {
            
        }
        // ENVIAR MANUALMENTE
        else if(type == 3)
        {
            
        }
        // SUBIR ARCHIVO
        else if(type == 4)
        {
            // OCULTAR CAMPO DESTINATARIOS
            $('#divAddressees').hide();
            // MOSTRAR BOTON PARA SUBIR
            $('#uploadAddressees').show();
            // MOSTRAR COLUMNAS
            $('#divColumns').fadeIn();
        }
        // OTRO
        else
        {
            swal.fire('','Selecciona tipo de destinatario','');
        }
    });

});
</script>
