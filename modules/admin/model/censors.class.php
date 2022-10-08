<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\model\censors.class.php    \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado al filtro de texto
 *
 *
*/

class Censors extends Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }

    
    
    /**
     * Registra una censura
     * 
     * @param string $text_from
     * @param string $text_to
     * @param string $reason
     * @return boolean/integer
     */
    function newCensor($text_from = null, $text_to = null, $reason = null)
    {
        //
        $query = $this->db->query('INSERT INTO `site_censors` (`text_from`, `text_to`, `reason`, `date`) VALUES (\''.$this->db->real_escape_string($text_from).'\', \''.$this->db->real_escape_string($text_to).'\', \''.$this->db->real_escape_string($reason).'\', UNIX_TIMESTAMP()) ');
        //
        if ($query == true)
        {
            return $this->db->insert_id;
        }
        //
        return false;
    }
}