<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\site\model\search.class.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado al buscador
 *
 *
*/

class Search extends Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }
    

    /**
     * Obtiene todos los miembros de forma aleatoria
     * 
     * @param int $id
     * @return array $shout
     */
    public function getAllMembers($search = '', $limit = 20)
    {
        // DONDE BUSCAR
        $where = empty($search) ? '&& `pp_gender` = \'1\'' : '&& `name` LIKE \'%'.$search.'%\'';
        $order = empty($search) ? 'RAND()' : '`pp_thumb_photo`, `name` ASC';
        //SELECT `member_id`, `name`, `pp_thumb_photo` FROM `members` WHERE `member_id` > 0 && `pp_gender` = '1' ORDER BY RAND(),`pp_thumb_photo` ASC LIMIT 0,20

        // DECIDIR TIPO DE CONSULTA (SI HE O ME HAN BLOQUEADO)
        if($this->session->memberData['blocks'] > 0)
        {
            $sql = 'SELECT COUNT(m.`member_id`)  FROM `members` AS m LEFT OUTER JOIN `members_blocks` AS b ON (b.`block_to` = m.`member_id` && b.`block_from` = \''.$this->session->memberData['member_id'].'\') || (b.`block_from` = m.`member_id` && b.`block_to` = \''.$this->session->memberData['member_id'].'\') WHERE b.block_id IS NULL '.$where;
        }
        else
        {
            $sql = 'SELECT COUNT(`member_id`) FROM `members` WHERE `member_id` > 0 ' . $where;
        }

        // USUARIOS TOTALES
        $query = $this->db->query($sql);
        list($result['total']) = $query->fetch_row();

        // PAGINADOR
        $result['pages'] = Core::model('paginator', 'core')->pageIndex( array('site', 'search', null, array('search' => $search)), $result['total'], $limit);

        // DECIDIR TIPO DE CONSULTA (SI HE O ME HAN BLOQUEADO)
        if($this->session->memberData['blocks'] > 0)
        {
            $sql = 'SELECT m.`member_id`, m.`name`, m.`pp_thumb_photo` FROM `members` AS m LEFT JOIN `members_blocks` AS b ON (b.`block_to` = m.`member_id` && b.`block_from` = \''.$this->session->memberData['member_id'].'\') || (b.`block_from` = m.`member_id` && b.`block_to` = \''.$this->session->memberData['member_id'].'\') WHERE b.block_id IS NULL '.$where.' ORDER BY '.$order.' LIMIT ' . $result['pages']['limit'];
        }
        else
        {
            $sql = 'SELECT `member_id`, `name`, `pp_thumb_photo` FROM `members` WHERE `member_id` > 0 '.$where.' ORDER BY '.$order.' LIMIT ' . $result['pages']['limit'];
        }
        
        // EJECUTA CONSULTA QUE OBTIENE LOS DATOS DE LOS SHOUTS
        $query = $this->db->query($sql);

        if($query == true && $query->num_rows > 0)
        {
            $result['data'] = $query;
            $result['rows'] = $query->num_rows;
            //
            return $result;
        }

        return false;
    }
}