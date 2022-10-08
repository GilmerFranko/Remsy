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
 * @Description Vista de la página de las palabras de los bots que responden
 *
 *
*/

?>
<div id="contentBots">
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Palabra</th>
                <th>Respuestas</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($bots['data'])){
                while( $bot = $bots['data']->fetch_assoc() ) { ?>
            <tr id="Word_<?php echo $bot['member_id']; ?>">
                <td><?php echo $bot['bw_id']; ?></td>
                <td><a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => $bot['member_id'])); ?>" title="<?php echo $bot['member_id']; ?>"><?php echo $bot['name']; ?></a></td>
                <td><?php echo $bot['bw_word']; ?></td>
                <td><?php echo empty($bot['bw_count']) ? '<span class="red-text">Ninguna</span>' : $bot['bw_count']; ?></td>
                <td><?php echo date('d/m/Y', $bot['bw_time']); ?></td>
                <td>
                    <div class="inline">
                        <!-- BOTON AGREGAR RESPUESTA -->
                        <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'bots', 'replies', array('search' => $bot['bw_id']));?>">
                        <i class="material-icons">add</i>
                        </a>
                        <!-- BOTON ELIMINAR PALABRA -->
                        <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'bots', 'action', array('do' => 'delete', 'type' => 'word', 'id' => $bot['bw_id']));?>" onclick="admin.bots.delete('<?php echo $bot['bw_id']; ?>', 'word'); return false;" >
                        <i class="material-icons">delete</i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php } } ?>
        </tbody>
    </table>
    <!--paginador-->
    <?php echo $bots['pages']['paginator']; ?>
    <!--fin_paginador-->
</div>