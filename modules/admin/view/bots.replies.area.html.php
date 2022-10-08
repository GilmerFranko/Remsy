<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\bots.html.php         \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página de las respuestas de las palabras de bots
 *
 *
*/

?>
<div id="contentBots">
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Respuesta</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($replies['data'])){
                while( $reply = $replies['data']->fetch_assoc() ) { ?>
            <tr id="Reply_<?php echo $reply['ba_id']; ?>">
                <td><?php echo $reply['ba_id']; ?></td>
                <td><?php echo $reply['ba_comment']; ?></td>
                <td><?php echo date('d/m/Y H:i', $reply['ba_time']); ?></td>
                <td>
                    <div class="inline">
                        <!-- BOTON ELIMINAR RESPUESTA -->
                        <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'bots', 'action', array('do' => 'delete', 'type' => 'reply', 'reply' => $reply['ba_id'], 'search' => $replies['word']['bw_id']));?>" onclick="admin.bots.delete('<?php echo $reply['ba_id']; ?>', 'reply', '<?php echo $replies['word']['bw_id']; ?>'); return false;" >
                        <i class="material-icons">delete</i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php } } ?>
        </tbody>
    </table>
    <!--paginador-->
    <?php echo $replies['pages']['paginator']; ?>
    <!--fin_paginador-->
</div>