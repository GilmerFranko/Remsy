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
<div id="contentMembers">
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rango</th>
                <th>Estado</th>
                <th>Registrado</th>
                <th>Bot - Fotos/D&iacute;a</th>
                <th>Bot - Auto-respuesta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if($members['rows'] > 0) { while( $member = $members['data']->fetch_assoc() ) { ?>
            <tr id="member_<?php echo $member['member_id']; ?>">
                <td><?php echo $member['member_id']; ?>
                </td>
                <td><a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => $member['member_id'])); ?>"><?php echo Core::model('extra', 'core')->getHighlight($search, $member['name']); ?></a>
                </td>
                <td class="truncate"><?php echo Core::model('extra', 'core')->getHighlight($search, $member['email']); ?>
                </td>
                <td><span style="color:<?php echo $member['g_colour']; ?>"><?php echo $member['g_title']; ?></span>
                </td>
                </td>
                <td><span style="color: <?php echo $member['banned'] > 0 ? 'red' : ($member['group_id'] == '0' ? 'purple' : 'gray'); ?>"><?php echo ($member['banned'] > 0) ? ('Ban: ' . date('d-m H:i', $member['banned'])) : ($member['group_id'] == '0' ? 'Inactivo' : 'Normal'); ?></span>
                </td>
                <td><?php echo Core::model('date', 'core')->getTimeAgo($member['pp_joined']); ?></td>
                <td><?php echo $member['bot']; ?></td>
                <td><?php echo ($member['bot_response'] > 0 ? 'S&iacute;' : 'No'); ?></td>
                <td>
                    <div class="inline">
                        <a href="#" onclick="admin.forms.get('Member', '<?php echo $member['member_id']; ?>'); return false;" title="Editar"><i class="material-icons">edit</i></a>
                        <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'members', 'login', array('user' => $member['member_id'], 'token' => $session->token)); ?>" onclick="admin.members.login('<?php echo $member['member_id']; ?>'); return false;" title="Acceder como <?php echo $member['name']; ?>"><i class="material-icons">vpn_key</i></a>
                    </div>
                </td>
            </tr>
            <?php } }else echo '<tr><td colspan="9">'.$message[0][0].'</td></tr>'; ?>
        </tbody>
    </table>
    <!--paginador-->
    <?php echo $members['pages']['paginator']; ?>
    <!--fin_paginador-->
</div>