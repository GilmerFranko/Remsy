<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\model\admin.class.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado al panel de administración
 *
 *
*/

class Configuration extends Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }
    
    /**
     * Actualiza las preferencias del sitio
     * 
     * @param array   $values
     * @return boolean
     */
    function saveConfig($values = array())
    {
        $inserts = Core::model('extra', 'core')->getIUP($values, '', 'insert');
        //
        $query = $this->db->query('INSERT INTO `site_configuration` VALUES (\'' . ($this->config['id']+1) . '\', '.$inserts.')');
        //
        if ($query == true)
        {
            return $this->db->insert_id;
        }
        //
        return false;
    }
    
    /**
     * Elimina una configuración
     * 
     * @param integer  $id
     * @return boolean
     */
    function deleteConfig($id = 0)
    {
        $query = $this->db->query('DELETE FROM `site_configuration` WHERE `id` = \'' . $id . '\' LIMIT 1');
        //
        if ($query == true)
        {
            return true;
        }
        //
        return false;
    }
}