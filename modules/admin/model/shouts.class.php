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

class Shouts extends Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }
    
    /**
     * Obtiene todos los shouts del sitio
     * @param int $max (Cantidad de shouts a mostrar)
     */
    function getShouts($max = 20)
    {
        // CANTIDAD TOTAL
        $query = $this->db->query('SELECT COUNT(*) FROM `shouts`');
        list($result['total']) = $query->fetch_row();
        // PAGINADOR
        $result['pages'] = Core::model('paginator', 'core')->pageIndex( array('admin', 'shouts'), $result['total'], $max);
        // EJECUTA LA CONSULTA
        $query = $this->db->query('SELECT m.`member_id`, m.`name`, s.`id`, s.`description`, s.`images`, s.`images_count`, s.`date`, s.`bot` FROM `members` AS m RIGHT JOIN `shouts` AS s ON s.`member` = m.`member_id` ORDER BY s.`date` DESC LIMIT ' . $result['pages']['limit']);
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
}