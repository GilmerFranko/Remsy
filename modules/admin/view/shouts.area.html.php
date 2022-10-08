<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\members.html.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página de usuarios
 *
 *
*/
?>
<div id="contentShouts">
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Autora</th>
                <th>Descripci&oacute;n</th>
                <th>Im&aacute;genes</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php if($shouts['rows'] > 0) { while( $shout = $shouts['data']->fetch_assoc() ) { ?>
            <tr id="shout_<?php echo $shout['id']; ?>"<?php if($shout['bot'] == 0) { echo 'style="background: rgba(46, 125, 50, 0.2);"'; } ?>>
                <td><?php echo $shout['id']; ?></td>
                <td>
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => $shout['member_id'])); ?>"><?php echo $shout['name']; ?></a>
                </td>
                <td><?php echo $shout['description']; ?></td>
                <td><?php echo $shout['images_count']; ?></td>
                <td <?php if($shout['date'] > time()) { echo 'style="background: #90a4ae;"'; } ?>><?php echo Core::model('date', 'core')->getTimeAgo($shout['date']) . ' &raquo; <small>'.date('d\/m \a \l\a\s H:i', $shout['date']).'</small>'; ?></td>
            </tr>
            <?php } }else echo '<tr><td colspan="9">'.$message[0][0].'</td></tr>'; ?>
        </tbody>
    </table>
    <!--paginador-->
    <?php echo $shouts['pages']['paginator']; ?>
    <!--fin_paginador-->
</div>