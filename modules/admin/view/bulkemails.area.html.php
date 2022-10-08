<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\bulkemail.area.html.php
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

?>
<div id="contentBulkemails">
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Asunto</th>
                <th>Destinatarios</th>
                <th>Archivo</th>
                <th>Contenido</th>
                <th>Enviados</th>
                <th>Programado</th>
                <th>Enviado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($bulkemails['data'])){
                while( $bulkemail = $bulkemails['data']->fetch_assoc() )
                {
                    // DESTINATARIO
                    if($bulkemail['addressees_type'] == 1)
                    {
                        $bulkemail['addressees'] = 'Toda la web';
                    }
                    elseif($bulkemail['addressees_type'] == 2)
                    {
                        $bulkemail['addressees'] = 'Seguidores de ' . $bulkemail['addressees'];
                    }
                    ?>
            <tr id="BulkEmail_<?php echo $bulkemail['id']; ?>">
                <td><?php echo $bulkemail['id']; ?></td>
                <td><?php echo $bulkemail['subject']; ?></td>
                <td><?php echo $bulkemail['addressees']; ?></td>
                <td><?php echo $bulkemail['addressees_file']; ?></td>
                <td><?php echo $bulkemail['content']; ?></td>
                <td><?php echo $bulkemail['addressees_sent'] . '/' . $bulkemail['addressees_count']; ?></td>
                <td><?php echo Core::model('date', 'core')->getTimeAgo($bulkemail['date']); ?></td>
                <td><?php echo empty($bulkemail['date_sent']) ? '-:-' : Core::model('date', 'core')->getTimeAgo($bulkemail['date_sent']); ?></td>
                <td>
                    <!-- BOTON ELIMINAR FOTO -->
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'bulkemails', 'action', array('do' => 'delete', 'id' => $bulkemail['id']));?>" class="waves-effect waves-light red btn modal-trigger red darken-4 tooltipped" data-position="left" data-tooltip="Eliminar correo #<?php echo $bulkemail['id']; ?>" onclick="admin.bulkEmails.delete('<?php echo $bulkemail['id']; ?>'); return false;" >
                    <i class="material-icons">delete</i>
                    </a>
                    <!-- BOTON VER DESTINATARIOS -->
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'bulkemails', null, array('id' => $bulkemail['id']));?>" class="waves-effect waves-light btn modal-trigger light-blue darken-2 tooltipped" data-position="bottom" data-tooltip="Ver destinatarios de #<?php echo $bulkemail['id']; ?>">
                    <i class="material-icons">contact_mail</i>
                    </a>
                    <!-- BOTON ENVIAR CORREOS -->
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'bulkemails', 'action', array('do' => 'send', 'id' => $bulkemail['id']));?>" class="waves-effect waves-light btn modal-trigger blue darken-2 tooltipped<?php if($bulkemail['date_sent'] > 0) { echo ' disabled'; } ?>" data-position="top" data-tooltip="Enviar correo #<?php echo $bulkemail['id']; ?>" onclick="admin.bulkEmails.send('<?php echo $bulkemail['id']; ?>'); return false;" >
                    <i class="material-icons">send</i>
                    </a>
                </td>
            </tr>
            <?php } } ?>
        </tbody>
    </table>
    <!--paginador-->
    <?php echo $bulkemails['pages']['paginator']; ?>
    <!--fin_paginador-->
</div>
