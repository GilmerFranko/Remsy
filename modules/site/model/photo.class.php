<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\site\model\photos.class.php        \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a las fotos del sitio
 *
 *
*/

class Photo extends Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }
    

    /**
     * Obtiene una foto
     * 
     * @param int $id
     * @return array $photo
     */
    public function getPhoto($id = 0, $thumb = false)
    {
        $query = $this->db->query('SELECT p.*, f.`follow_id` FROM `photos` AS p LEFT JOIN `members_follows` AS f ON p.`author` = f.`follow_to` WHERE `id` = \''.$id.'\' && f.`follow_from` = \''.$this->session->memberData['member_id'].'\' && p.`date_expires` > UNIX_TIMESTAMP() LIMIT 1');

        if($query == true && $query->num_rows > 0)
        {
            $photo = $query->fetch_assoc();

            // CONVERTIR IMAGES EN ENLACES
            $photo['image_url'] = $this->config['photos_url'] . '/' . $photo['image'];

            return $photo;
        }

        return false;
    }
}