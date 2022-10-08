<?php defined('SUPERNATURAL') || exit;

/**
 * @file        members.class
 * @package     One V
 * @author      Gilmer <gilmerfranko@hotmail.com>
 * @copyright   (c) 2020 Gilmer Franco
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a la tabla Members
 *
 *
*/

class Members extends Models
{
    
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }
    
    /**
     * Obtiene todos los usuarios del sitio
     * @param string $search
     * @param int $max (Cantidad de usuarios a mostrar)
     */
    function getMembers($search = '', $max = 20, $bots = false)
    {
        // PREFERENCIAS DE BÚSQUEDA
        //$where = empty($search) ? '' : 'WHERE ' . (ctype_digit($search) ? '`member_id` = \'' . $search . '\'' : 'MATCH(`name`, `email`) AGAINST(\''.$search.'\' IN BOOLEAN MODE)');
        $where = empty($search) ? '' : 'WHERE ' . (ctype_digit($search) ? '`member_id` = \'' . $search . '\'' : '`name` LIKE \'%'.$search.'%\' || `email` LIKE \'%'.$search.'%\'');
        if($bots == true) {
            $bot = ' WHERE `bot` > 0 || `bot_response` > 0 ';
            $max = 100;
        } else { $bot = ''; }
        // MIEMBROS TOTALES
        $query = $this->db->query('SELECT COUNT(*) FROM `members`' . $where . $bot);
        list($result['total']) = $query->fetch_row();
        // PAGINADOR
        $result['pages'] = Core::model('paginator', 'core')->pageIndex( array('admin', 'members', null, array('search' => $search)), $result['total'], $max);
        // EJECUTA LA CONSULTA
        $query = $this->db->query('SELECT m.`member_id`, m.`name`, m.`email`, m.`group_id`, m.`banned`, m.`pp_thumb_photo`, m.`pp_joined`, m.`bot`, m.`bot_response`, g.`g_title`, g.`g_colour` FROM `members` AS m LEFT JOIN `members_groups` AS g ON g.`g_id` = m.`group_id` ' . $where . $bot . ' ORDER BY `member_id` DESC LIMIT ' . $result['pages']['limit']);
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
    function getMember($id)
    {
        $query = $this->db->query('SELECT * FROM `members` WHERE `member_id` = \'' . $id . '\' LIMIT 1');
        //
        if ($query == true && $query->num_rows > 0)
        {
            return $query->fetch_assoc();
        }
        //
        return false;
    }
    
    /**
     * Actualiza las preferencias básicas de un usuario
     * 
     * @param array   $values
     * @param integer $member_id
     * @return boolean
     */
    function editMember($values = array(), $member_id = 0)
    {
        $updates = Core::model('extra', 'core')->getIUP($values, '');
        //
        $query = $this->db->query('UPDATE `members` SET '.$updates.' WHERE `member_id` = \'' . $member_id . '\' LIMIT 1');
        //
        if ($query == true)
        {
            return true;
        }
        //
        return false;
    }

    /**
     * Obtiene cantidad de usuarios conectados
     * 
     * @param int $min
     * @return int
     */
    function getOnlines($min = 5)
    {
        $time = time()-(60*$min);
        $query = $this->db->query('SELECT COUNT(`member_id`) FROM `members` WHERE `last_activity` > '. $time . ' LIMIT 1');
        //
        if ($query == true)
        {
            return $query->fetch_row()[0];
        }
        //
        return 0;
    }
}
