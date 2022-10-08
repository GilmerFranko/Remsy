<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\photos.area.html.php  \
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

?>
<div id="contentPhotos">
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Autora</th>
                <th>Foto</th>
                <th>Descripci&oacute;n</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($photos['data'])){
                while( $photo = $photos['data']->fetch_assoc() ) { ?>
            <tr id="Photo_<?php echo $photo['id']; ?>">
                <td><?php echo $photo['id']; ?></td>
                <td><a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => $photo['author'])); ?>"><?php echo $photo['author_name']; ?></a></td>
                <td>
                    <img data-caption="<?php echo $config['photos_url'] . '/' . $photo['image']; ?>" class="materialboxed responsive-img circle" width="50" src="<?php echo $config['photos_url'] . '/' . $photo['image']; ?>">
                </td>
                <td><?php echo htmlspecialchars($photo['description']); ?></td>
                <td><?php echo Core::model('date', 'core')->getTimeAgo($photo['date_start']); ?></td>
                <td><?php echo Core::model('date', 'core')->getTimeAgo($photo['date_expires']); ?></td>
                <td>
                    <!-- BOTON ELIMINAR FOTO -->
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'photos', 'action', array('do' => 'delete', 'id' => $photo['id']));?>" onclick="admin.photos.delete('<?php echo $photo['id']; ?>'); return false;" >
                    <i class="material-icons">delete</i>
                    </a>
                </td>
            </tr>
            <?php } } ?>
        </tbody>
    </table>
    <!--paginador-->
    <?php echo $photos['pages']['paginator']; ?>
    <!--fin_paginador-->
</div>