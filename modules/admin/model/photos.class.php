<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\model\photos.class.php    \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a las fotos regaladas
 *
 *
*/

class Photos extends Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }

    
    /**
     * Registra una foto regalada
     * 
     * @param array $photo
     * @return boolean/integer
     */
    function newPhoto( $photo = null )
    {
        $query = $this->db->query('INSERT INTO `photos` (`author`, `author_name`, `description`, `image`, `date_start`, `date_expires`) VALUES (\''.(int)$photo['author'].'\', \''.$this->db->real_escape_string($photo['author_name']).'\', \''.$this->db->real_escape_string($photo['description']).'\', \''.$this->db->real_escape_string($photo['image_name']).'\', UNIX_TIMESTAMP(), \''.$this->db->real_escape_string($photo['date_expires']).'\') ');
        // SI SE HA AGREGADO CORRECTAMENTE
        if ($query == true)
        {
            $photoID = $this->db->insert_id;
            // NOTIFICAR A SUS SEGUIDORES
            $query2 = $this->db->query('SELECT `follow_from` FROM `members_follows` WHERE `follow_to` = \''.$photo['author'].'\' ');
            // SI TIENE SEGUIDORES
            if($query2->num_rows > 0)
            {
                while($follower = $query2->fetch_assoc())
                {
                    // SUMAR NOTIFICACIÓN AL USUARIO
                    Core::model('db', 'core')->updateCount('members', 'notifications', $follower['follow_from'], '+1' , 'member_id');
                }
            }

            return $photoID;
        }
        //
        return false;
    }
}