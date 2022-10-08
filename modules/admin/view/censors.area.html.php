<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\censors.html.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página de los filtros de palabras
 *
 *
*/

?>
<div id="contentCensors">
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Texto original</th>
                <th>Texto convertido</th>
                <th>Raz&oacute;n</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($censors['data'])){
                while( $censor = $censors['data']->fetch_assoc() ) { ?>
            <tr id="Censor_<?php echo $censor['id']; ?>">
                <td><?php echo $censor['id']; ?></td>
                <td><?php echo $censor['text_from']; ?></td>
                <td><?php echo $censor['text_to']; ?></td>
                <td><?php echo $censor['reason']; ?></td>
                <td><?php echo date('d/m/Y', $censor['date']); ?></td>
                <td>
                    <!-- BOTON ELIMINAR PALABRA -->
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'censors', 'action', array('do' => 'delete', 'id' => $censor['id']));?>" onclick="admin.censors.delete('<?php echo $censor['id']; ?>'); return false;" >
                    <i class="material-icons">delete</i>
                    </a>
                </td>
            </tr>
            <?php } } ?>
        </tbody>
    </table>
    <!--paginador-->
    <?php echo $censors['pages']['paginator']; ?>
    <!--fin_paginador-->
</div>