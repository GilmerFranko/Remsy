<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\groups.html.php       \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página de rangos en la administración
 *
 *
*/

?>

    <div id="contentGroups">
                <table class="striped responsive-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Usuarios</th>
                            <th>Permisos</th>
                            <th>Mensajes</th>
                            <th>Actualizado</th>
                            <th>Acciones</th>
                        </tr>
                   </thead>
                   <tbody>
                    <?php while( $group = $groups['data']->fetch_assoc() ) { ?>
                        <tr id="Group_<?php echo $group['g_id']; ?>">
                        	<td><?php echo $group['g_id']; ?></td>
                            <td><span style="color:<?php echo $group['g_colour']; ?>"><?php echo $group['g_title']; ?></span></td>
                            <td><?php echo $group['g_count_members']; ?></td>
                            <td><?php echo $group['g_count_permissions']; ?></td>
                            <td><?php echo $group['g_max_messages']; ?></td>
                            <td><?php echo date('d/m/Y', $group['g_updated']); ?></td>
                            <td>
                            	<div class="inline">
                                    <a href="<?php echo ($group['g_id'] == $config['reg_group']) ? '#' : Core::model('extra', 'core')->generateUrl('admin', 'groups', 'default', array('id' => $group['g_id'])); ?>" title="Predeterminado">
                                    <i class="material-icons<?php if($group['g_id'] == $config['reg_group']) echo ' grey-text'; ?>">assignment_turned_in</i>
                                </a>
                                    <!-- EDITAR RANGO -->
                                	<a href="#" onclick="admin.forms.get('Group', '<?php echo $group['g_id']; ?>'); return false;" title="Editar"><i class="material-icons">edit</i></a>
                                    <!-- ELIMINAR RANGO -->
                                    <?php if($group['g_id'] > 3) { ?>
                                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'groups', 'delete', array('id' => $group['g_id'])); ?>" onclick="admin.groups.delete('<?php echo $group['g_id']; ?>'); return false;" title="Eliminar">
                                    <i class="material-icons">delete</i>
                                </a>
                                <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                   </tbody>
                </table>
          </div>