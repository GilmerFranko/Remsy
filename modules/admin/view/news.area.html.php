<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\news.html.php         \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página de las noticias
 *
 *
*/

?>
<div id="contentNews">
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Noticia</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($news['data'])){
                while( $new = $news['data']->fetch_assoc() ) { ?>
            <tr id="New_<?php echo $new['id']; ?>">
                <td><?php echo $new['id']; ?></td>
                <td><?php echo htmlspecialchars($new['content']); ?></td>
                <td><?php echo date('d/m/Y H:i', $new['date']); ?></td>
                <td>
                    <!-- BOTON ELIMINAR PALABRA -->
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'news', 'action', array('do' => 'delete', 'id' => $new['id']));?>" onclick="admin.news.delete('<?php echo $new['id']; ?>'); return false;" >
                    <i class="material-icons">delete</i>
                    </a>
                </td>
            </tr>
            <?php } } ?>
        </tbody>
    </table>
    <!--paginador-->
    <?php echo $news['pages']['paginator']; ?>
    <!--fin_paginador-->
</div>