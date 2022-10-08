<?php
defined('SUPERNATURAL') || exit;
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
        $query = $this->db->query('SELECT * FROM `members_coins` WHERE `member` = \'' . $member . '\' ORDER BY `id` DESC LIMIT ' . $limit);
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
        $query = $this->db->query('INSERT INTO `members_coins` (`member`, `email`, `currency`, `price`, `product`, `coins`, `payment_intent`, `type`, `platform`, `status`, `source`, `source_status`, `date`) VALUES (
            \'' . (int)$data['member'] . '\', 
            \'' . $this->db->real_escape_string($data['email']) . '\', 
            \'' . $this->db->real_escape_string($data['priceCurrency']) . '\', 
            \'' . $this->db->real_escape_string($data['priceAmount']) . '\', 
            \'' . (int)$data['product'] . '\', 
            \'' . (int)$data['coins'] . '\', 
            \'' . $this->db->real_escape_string($data['payment_intent']) . '\', 
            \'' . $this->db->real_escape_string($data['type']) . '\', 
            \'PayPal\', 
            \'' . $this->db->real_escape_string($data['status']) . '\', 
            \'' . $this->db->real_escape_string($data['source']) . '\', 
            \'' . $this->db->real_escape_string($data['source_status']) . '\', 
            UNIX_TIMESTAMP()
        ) ');

        // RETORNAR
        if ($query == true)
        {
            return $this->db->insert_id;
        }
        //
        return false;
    }
    /**
     * Genera Hash de firma
     *
     * @param array $data
     * @return string
     */
    function genSignature($data = null, $type = ':', $signatureKey = '')
    {
        $str = $signatureKey;
        foreach($data as $key => $val)
        {
            $str.= $type . strval($key) . '=' . $val;
        }
        return $str;
    }
}