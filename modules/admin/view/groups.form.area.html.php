<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\groups.form.html.php  \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista del formulario encargado de editar y agregar rangos
 *
 *
*/
?>

<div class="groupNewEdit">
    <form action="javascript:admin.groups.saveForm('<?php echo $group['g_id']; ?>');" method="post" class="form-horizontal">
        <div class="row">
            <div class="input-field col s9">
                <input name="g_title" id="groupTitle<?php echo $group['g_id']; ?>" type="text" class="validate" value="<?php echo $group['g_title']; ?>" required>
                <label class="active" for="groupTitle<?php echo $group['g_id']; ?>">Nombre de rango</label>
            </div>
            <div class="input-field col s3">
                <input name="colour" id="groupColour<?php echo $group['g_id']; ?>" type="color" class="validate" value="<?php echo $group['g_colour']; ?>" required>
                <label class="active" for="groupColour<?php echo $group['g_id']; ?>">Color</label>
            </div>
            <div class="input-field col s6">
                <input name="max_messages" id="groupMaxMessages<?php echo $group['g_id']; ?>" type="number" class="validate" value="<?php echo $group['g_max_messages']; ?>" required disabled>
                <label class="active" for="groupMaxMessages<?php echo $group['g_id']; ?>">M&aacute;ximo de mensajes</label>
            </div>
            <div class="input-field col s6">
                <input name="max_shout_images" id="groupMaxShoutImages<?php echo $group['g_id']; ?>" type="number" class="validate" value="<?php echo $group['g_max_shout_images']; ?>" required disabled>
                <label class="active" for="groupMaxShoutImages<?php echo $group['g_id']; ?>">Im&aacute;genes por Shout</label>
            </div>
        </div>
        <div class="tabla-listaPermisos">
            <table class="striped responsive-table">
                <thead>
                    <tr>
                        <th colspan="1">
                            <div class="inline">
                                <a href="#" title="Marcar todo" onclick="setCheckbox(true); return false;"><i class="material-icons">check_box</i></a>
                                <a href="#" title="Desmarcar todo" onclick="setCheckbox(false); return false;"><i class="material-icons">check_box_outline_blank</i></a>
                            </div>
                        </th>
                        <th>
                            Permisos
                        </th>
                    </tr>
                </thead>
                <tbody class="permissions">
                    <tr>
                        <td>
                            <input type="checkbox" name="permission[<?php echo $group['g_id']; ?>][]" id="perm[admin][<?php echo $group['g_id']; ?>]" value="admin" <?php echo isset($group['permissions']['admin']) ? 'checked="checked"' : ''; ?> />
                            <span></span>
                        </td>
                        <td>
                            <label for="perm[admin][<?php echo $group['g_id']; ?>]" class="permissions">Permisos de administraci&oacute;n (incluye tambi&eacute;n el resto)</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="permission[<?php echo $group['g_id']; ?>][]" id="perm[mod][<?php echo $group['g_id']; ?>]" value="mod" <?php echo isset($group['permissions']['mod']) ? 'checked="checked"' : ''; ?> />
                            <span></span>
                        </td>
                        <td>
                            <label for="perm[mod][<?php echo $group['g_id']; ?>]" class="permissions">Permisos de moderaci&oacute;n</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="permission[<?php echo $group['g_id']; ?>][]" id="perm[maintenance][<?php echo $group['g_id']; ?>]" value="maintenance" <?php echo isset($group['permissions']['maintenance']) ? 'checked="checked"' : ''; ?>/>
                            <span></span>
                        </td>
                        <td>
                            <label for="perm[maintenance][<?php echo $group['g_id']; ?>]" class="checkbox inline permissions">Acceder cuando el sitio est&aacute; en mantenimiento</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="permission[<?php echo $group['g_id']; ?>][]" id="perm[post_shout][<?php echo $group['g_id']; ?>]" value="post_shout" <?php echo isset($group['permissions']['post_shout']) ? 'checked="checked"' : ''; ?> / >
                            <span></span>
                        </td>
                        <td>
                            <label for="perm[post_shout][<?php echo $group['g_id']; ?>]" class="checkbox inline permissions">Publicar Shouts</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="permission[<?php echo $group['g_id']; ?>][]" id="perm[edit_shout][<?php echo $group['g_id']; ?>]" value="edit_shout" <?php echo isset($group['permissions']['edit_shout']) ? 'checked="checked"' : ''; ?> />
                            <span></span>
                        </td>
                        <td>
                            <label for="perm[edit_shout][<?php echo $group['g_id']; ?>]">Editar Shouts</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="permission[<?php echo $group['g_id']; ?>][]" id="perm[remove_shout][<?php echo $group['g_id']; ?>]" value="remove_shout" <?php echo isset($group['permissions']['remove_shout']) ? 'checked="checked"' : ''; ?> />
                            <span></span>
                        </td>
                        <td>
                            <label for="perm[remove_shout][<?php echo $group['g_id']; ?>]">Eliminar Shouts</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="permission[<?php echo $group['g_id']; ?>][]" id="perm[post_shout_comment][<?php echo $group['g_id']; ?>]" value="post_shout_comment" <?php echo isset($group['permissions']['post_shout_comment']) ? 'checked="checked"' : ''; ?> />
                            <span></span>
                        </td>
                        <td>
                            <label for="perm[post_shout_comment][<?php echo $group['g_id']; ?>]" class="checkbox inline permissions">Publicar comentarios en Shout</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="permission[<?php echo $group['g_id']; ?>][]" id="perm[remove_shout_comment][<?php echo $group['g_id']; ?>]" value="remove_shout_comment" <?php echo isset($group['permissions']['remove_shout_comment']) ? 'checked="checked"' : ''; ?> />
                            <span></span>
                        </td>
                        <td>
                            <label for="perm[remove_shout_comment][<?php echo $group['g_id']; ?>]">Eliminar comentarios en Shouts</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="permission[<?php echo $group['g_id']; ?>][]" id="perm[give_shout_like][<?php echo $group['g_id']; ?>]" value="give_shout_like" <?php echo isset($group['permissions']['give_shout_like']) ? 'checked="checked"' : ''; ?> />
                            <span></span>
                        </td>
                        <td>
                            <label for="perm[give_shout_like][<?php echo $group['g_id']; ?>]">Dar Like en Shouts</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="permission[<?php echo $group['g_id']; ?>][]" id="perm[follow_members][<?php echo $group['g_id']; ?>]" value="follow_members" <?php echo isset($group['permissions']['follow_members']) ? 'checked="checked"' : ''; ?> />
                            <span></span>
                        </td>
                        <td>
                            <label for="perm[follow_members][<?php echo $group['g_id']; ?>]">Seguir usuarios</label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--boton enviar-->
        <div class="control-group">
            <button type="submit" name="save" class="btn waves-effect waves-red grey darken-3 w100">Continuar</button>
        </div>
        <!--fin boton enviar-->
    </form>
</div>