<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\contacts.html.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la lista de formularios de contacto
 *
 *
*/
?>
<div id="contentContacts">
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>T&iacute;tulo</th>
                <th>Contenido</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if($contacts['rows'] > 0) { while( $contact = $contacts['data']->fetch_assoc() ) { ?>
            <tr id="contact_<?php echo $contact['id']; ?>">
                <td>#<?php echo $contact['id']; ?></td>
                <td><?php echo $contact['member_id']; ?></td>
                <td><?php echo Core::model('extra', 'core')->getHighlight($search, $contact['name']); ?></td>
                <td><?php echo Core::model('extra', 'core')->getHighlight($search, $contact['email']); ?></td>
                <td><?php echo $contact['title']; ?></td>
                <td id="content<?php echo $contact['id']; ?>" class="truncate content alter"><?php echo $contact['content']; ?></td>
                <td><?php echo date('d/m/Y H:i', $contact['date']); ?></td>
                <td>
                    <!-- BOTON ELIMINAR CONTACTO -->
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'contacts', 'action', array('do' => 'delete', 'id' => $contact['id']));?>" onclick="admin.contacts.delete('<?php echo $contact['id']; ?>'); return false;" >
                    <i class="material-icons">delete</i>
                </td>
            </tr>
            <?php } }else echo '<tr><td colspan="8">'.$message[0][0].'</td></tr>'; ?>
        </tbody>
    </table>
    <!--paginador-->
    <?php echo $contacts['pages']['paginator']; ?>
    <!--fin_paginador-->
</div>