<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\model\groups.class.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a los rangos de usuarios
 *
 *
*/

class Groups extends Model {
    
    /**
     * Obtiene todos los rangos del sitio
     */
    function getGroups()
    {
        $query = $this->db->query('SELECT * FROM `members_groups` ORDER BY `g_id`');
        //
        if ($query == true)
        {
            $result['data'] = $query;
            $result['rows'] = $query->num_rows;
            //
            return $result;
        }
        //
        return false;
    }
    
    /**
     * Obtiene información de un rango concreto
     */
    function getGroup($id = null)
    {
        $query = $this->db->query('SELECT * FROM `members_groups` WHERE `g_id` = \'' . $id . '\' LIMIT 1');
        //
        if ($query == true && $query->num_rows > 0)
        {
            return $query->fetch_assoc();
        }
        //
        return false;
    }
    
    /**
     * Registra un nuevo rango
     */
    function newGroup($group = array())
    {
        $insert = Core::model('extra', 'core')->getIUP($group, '', 'insert');
        //
        $query = $this->db->query('INSERT INTO `members_groups` (`g_title`, `g_colour`, `g_permissions`, `g_max_messages`, `g_max_shout_images`, `g_count_permissions`, `g_updated`) VALUES('.$insert.', \'' . time() . '\') ');
        //
        if ($query == true)
        {
            $message = array('Rango creado. <a href="'.Core::model('extra', 'core')->generateUrl('admin', 'groups').'" class="btn-flat toast-action">Actualizar</a>', '1');
        }
        else
        {
            $message = array('No se ha podido registrar el rango', '0');
        }
        //
        return $message;
    }
    
    /**
     * Editar un rango existente
     */
    function editGroup($group = array(), $group_id = 0)
    {
        $updates = Core::model('extra', 'core')->getIUP($group, '', 'update');
        //
        $query = $this->db->query('UPDATE `members_groups` SET ' . $updates . ', `g_updated` = \'' . time() . '\' WHERE `g_id` = \'' . $group_id . '\' LIMIT 1');
        //
        if ($query == true)
        {
            $message = array('Rango guardado. <a href="'.Core::model('extra', 'core')->generateUrl('admin', 'groups').'" class="btn-flat toast-action">Actualizar</a>', '1');
        }
        else
        {
            $message = array('No se ha podido actualizar el rango', '0');
        }
        //
        return $message;
    }
    
    /**
     * Eliminar un rango existente
     */
    function deleteGroup($group_id = 0)
    {
        $query = $this->db->query('DELETE FROM `members_groups` WHERE `g_id` = \'' . $group_id . '\' LIMIT 1');
        //
        if ($query == true)
        {
            if($group_id == $this->config['reg_group'])
            {
                if($this->defaultGroup(3) === true)
                {
                    return true;
                }
                else
                {
                    return $this->deleteGroup($group_id);
                }
            }
            //
            return true;
        }
        //
        return false;
    }
    
    /**
     * Establecer un rango como predeterminado
     */
    function defaultGroup($group_id = 0)
    {
        $query = $this->db->query('UPDATE `site_configuration` SET `reg_group` = \'' . $group_id . '\' WHERE `id` = \'' . $this->config['id'] . '\' LIMIT 1');
        //
        if ($query == true)
        {
            return true;
        }
        //
        return false;
    }
    
    /**
     * Sumar o restar número de usuarios a un rango
     */
    function alterCountGroup($group_id = 0, $type = false)
    {
        if( is_bool($type) )
        {
            // ESTABLECE EL TIPO DE ALTERACIÓN
            $type = $type == true ? '+1' : '-1';
            // EJECUTA LA CONSULTA
            $query = $this->db->query('UPDATE `members_groups` SET `g_count_members` = `g_count_members` ' . $type . '  WHERE `g_id` = \'' . $group_id . '\' LIMIT 1');
            //
            if ($query == true)
            {
                return true;
            }
        }
        //
        return false;
    }
}