<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\model\coins.class.php    \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a los creditos
 *
 *
*/

class Coins extends Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }
    
    /**
     * Obtiene las compras de un usuario
     * 
     * @param integer $member_id
     * @param integer $limit
     * @param string $plan
     * @return boolean
     */
    function getPurchases($member = null, $limit = 15, $plan = null)
    {
        // CONSULTA A BD
        $query = $this->db->query('SELECT * FROM `members_coins` WHERE `member` = \''.$member.'\' ORDER BY `id` DESC LIMIT ' . $limit);

        // SI LA CONSULTA ES CORRECTA
        if ($query == true && $query->num_rows > 0)
        {
            return ($limit > 1) ? $query : true;
        }
        //
        return false;
    }

    /**
     * Registrar compra de créditos
     * 
     * @param string $data
     * @return boolean
     */
    function newBuy($data = null)
    {
        // EJECUTA SQL
        $query = $this->db->query('INSERT INTO `members_coins` (`currency`, `price`, `payment_intent`, `type`, `source`, `date`) VALUES (\''.$this->db->real_escape_string($data['currency']).'\', \''.$this->db->real_escape_string($data['price']).'\', \''.$this->db->real_escape_string($data['payment_intent']).'\', \''.$this->db->real_escape_string($data['type']).'\', \''.$this->db->real_escape_string($data['source']).'\', \''.$this->db->real_escape_string($data['date']).'\') ');

        // RETORNAR
        if ($query == true)
        {
            return $this->db->insert_id;
        }
        //
        return false;
    }

    /**
     * Actualiza una compra
     * 
     * @param string $buy
     * @param string $data
     * @return boolean
     */
    function updateBuy($buy = null, $data = null)
    {
        // PREPARA COLUMNAS SQL
        $update = Core::model('extra', 'core')->getIUP($data);

        // EJECUTA SQL
        $query = $this->db->query('UPDATE `members_coins` SET '.$update.' WHERE `id` = \''.$buy.'\' LIMIT 1');

        // RETORNAR
        if ($query == true && $this->db->affected_rows > 0)
        {
            return true;
        }
        //
        return false;
    }
}