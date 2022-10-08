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
<div class="userNewEdit">
  <form action="javascript:admin.forms.save('Member', '<?php echo $member['member_id']; ?>');" id="form-Members" method="post">
    <div class="row">
      <div class="input-field col s6">
        <input name="member[<?php echo $member['member_id']; ?>][]" id="name<?php echo $member['member_id']; ?>" type="text" class="validate" data-key="name" value="<?php echo $member['name']; ?>" required>
        <label class="active" for="name<?php echo $member['member_id']; ?>">Nombre de usuario</label>
      </div>
      <div class="input-field col s6">
          <input type="hidden" id="memberGender<?php echo $member['member_id']; ?>" name="member[<?php echo $member['member_id'];?>][]" data-key="pp_gender" value="<?php echo $member['pp_gender'];?>"/>
          <select data-placeholder="<?php echo $member['pp_gender']; ?>" class="browser-default" onchange="$('#memberGender<?php echo $member['member_id']; ?>').val($(this).val())">
            <option value="0">Hombre</option>
            <option value="1" <?php if($member['pp_gender'] == 1) echo 'selected="selected"'; ?>>Mujer</option>
          </select>
          <label for="memberGender<?php echo $member['member_id']; ?>" class="active">Sexo</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input name="member[<?php echo $member['member_id']; ?>][]" id="email<?php echo $member['member_id']; ?>" data-key="email" type="email" class="validate" value="<?php echo $member['email']; ?>" required>
        <label class="active" for="email<?php echo $member['member_id']; ?>">Email</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input name="member[<?php echo $member['member_id']; ?>][]" id="password<?php echo $member['member_id']; ?>" data-key="password" type="password" class="validate">
        <label for="password<?php echo $member['member_id']; ?>">Contrase&ntilde;a</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s9">
        <input type="hidden" id="memberGroup<?php echo $member['member_id']; ?>" name="member[<?php echo $member['member_id'];?>][]" data-key="group_id" value="<?php echo $member['group_id'];?>"/>
        <select data-placeholder="<?php echo $member['g_title']; ?>" class="browser-default" onchange="$('#memberGroup<?php echo $member['member_id']; ?>').val($(this).val())">
          <?php while( $group = $groups['data']->fetch_assoc() ) { ?>
          <option value="<?php echo $group['g_id']; ?>" <?php if($group['g_id'] == $member['group_id']) echo 'selected="selected"'; ?>><?php echo $group['g_title']; ?></option>
          <?php } ?>
          <optgroup label="Otro">
            <option value="0" <?php if($member['group_id'] == '0') echo 'selected="selected"'; ?>>No activado</option>
          </optgroup>
        </select>
        <label for="memberGroup<?php echo $member['member_id']; ?>" class="active">Rango</label>
      </div>
      <div class="input-field col s3">
        <label>
        <input name="member[<?php echo $member['member_id']; ?>][]" id="banned<?php echo $member['member_id']; ?>" type="checkbox" class="filled-in" data-key="banned" id="memberBanned" value="1" <?php echo $member['banned'] > 0 ? 'checked="checked"' : ''; ?>>
        <span>Suspendido</span>
        </label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s6">
        <label>
        <input type="checkbox" class="filled-in" data-key="bot_response" name="member[<?php echo $member['member_id']; ?>][]" <?php echo $member['bot_response'] == 1 ? 'checked="checked"' : ''; ?>>
        <span>Auto-Respuesta</span>
        </label>
      </div>
      <div class="input-field col s6">
        <input id="bot<?php echo $member['member_id']; ?>" type="number" min="0" class="validate" name="member[<?php echo $member['member_id']; ?>][]" data-key="bot" value="<?php echo $member['bot']; ?>">
        <label for="bot<?php echo $member['member_id']; ?>" class="active">Fotos por d&iacute;a</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s6">
        <input id="shouts_downloads<?php echo $member['member_id']; ?>" type="number" min="0" class="validate" name="member[<?php echo $member['member_id']; ?>][]" data-key="shouts_downloads" value="<?php echo $member['shouts_downloads']; ?>">
        <label for="shouts_downloads<?php echo $member['member_id']; ?>" class="active">Fotos que le han comprado</label>
      </div>
      <div class="input-field col s6">
        <input id="coins<?php echo $member['member_id']; ?>" type="number" min="0" class="validate" name="member[<?php echo $member['member_id']; ?>][]" data-key="coins" step="0.2" value="<?php echo $member['coins']; ?>">
        <label for="coins<?php echo $member['member_id']; ?>" class="active">Cr&eacute;ditos</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <label>
        <input type="checkbox" class="filled-in" id="newbies_content<?php echo $member['member_id']; ?>" data-key="newbies_content" name="member[<?php echo $member['member_id']; ?>][]" <?php echo $member['newbies_content'] == 1 ? 'checked="checked"' : ''; ?>>
        <span>Nuevos no ven sus shouts en 5 d&iacute;as</span>
        </label>
      </div>
    </div>
    <!--<div class="row">
      <div class="input-field col s12">
        <input id="newbies_content<?php echo $member['member_id']; ?>" type="number" class="validate" data-key="newbies_content" name="member[<?php echo $member['member_id']; ?>][]" value="<?php echo $member['newbies_content']; ?>">
        <label for="newbies_content<?php echo $member['member_id']; ?>" class="active">Nuevos no ven sus shouts en {X} d&iacute;as</label>
      </div>
    </div>-->
    <br />
    <!--boton enviar-->
    <div class="control-group">
      <button type="submit" name="save" class="btn blue darken-4 w100">Continuar</button>
    </div>
    <!--fin boton enviar-->
  </form>
</div>