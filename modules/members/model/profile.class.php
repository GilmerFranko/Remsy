<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\model\profile.class.php  \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado al perfil
 *
 *
*/

class Profile extends Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }
    
    /**
     * Obtiene información del perfil del usuario
     * 
     * @param string $username
     * @return array/boolean
     */
    function getMemberProfile($user = '')
    {
        // BUSCAR POR ID O NOMBRE
        $where = ctype_digit($user) ? ('m.`member_id` = \''.(int)$user.'\'') : ('LOWER(m.`name`) = \''.$this->db->real_escape_string($user).'\'');

        $query = $this->db->query('SELECT m.`member_id`, m.`name`, m.`group_id`, m.`email`, m.`banned`, m.`last_activity`, m.`last_login`, m.`newbies_content`, m.`follows`, m.`coins`, m.`shouts_downloads`, m.`pp_full_name`, m.`pp_main_photo`, m.`pp_thumb_photo`, m.`pp_photo_type`, m.`pp_setting_preferences`, m.`pp_gender`, m.`pp_joined`, m.`bot`, m.`bot_response`, r.`g_title`, r.`g_colour` FROM `members` AS m LEFT JOIN `members_groups` AS r ON r.`g_id` = m.`group_id` WHERE ' . $where . ' LIMIT 1');
        //
        if ($query == true && $query->num_rows > 0)
        {
            $memberData = $query->fetch_assoc();
            $memberData['gender'] = $memberData['pp_gender'] == '1' ? 'Femenino' : 'Masculino';
            //
            return $memberData;
        }
        //
        return false;
    }
    
    
    /**
     * Retorna la edad del usuario en número
     * 
     * @param integer $age
     * @return array
     */
    function getAge($age = 0)
    {
        $now = new DateTime();
        $date = date('Y-m-d', $age);
        $born = new DateTime($date);
        $result = date_diff($now, $born);

        return $result->y;
    }

    /**
     * Extrae los seguidores/bloqueados o a quien sigue o tiene bloquedao a un usuario
     * 
     * @param integer $member_id
     * @param integer $member_to
     * @param integer $kind (0 = seguidores, 1 = siguiendo)
     * @param integer $limit
     * @param string $type
     * @return boolean
     */
    function getFollowsBlocks($member_from = 0, $member_to = 0, $kind = 0, $type = 'follow', $limit = 15)
    {
        // SIGUIENDO
        $where = $member_from > 0 ? ($type.'.`'.$type.'_from` = \'' . $member_from . '\' ')  : '' ;

        // SE SIGUEN
        if($member_from > 0 && $member_to > 0)
        {
            $where .= ' && ';
            $limit = 1;
        }
        else { $allData = true; }

        // SEGUIDORES
        $where .= $member_to > 0 ? ($type.'.`'.$type.'_to` = \'' . $member_to . '\' ')  : '' ;

        // PREPARA LA CONSULTA
        if(isset($allData))
        {
            $sql = 'SELECT '.$type.'.'.$type.'_id, m.member_id, m.name, m.pp_full_name, m.pp_thumb_photo FROM `members_'.$type.'s` AS '.$type.' LEFT JOIN `members` AS m ON '.$type.'.'.$type.'_'.($kind == 0 ? 'from' : 'to').' = m.member_id WHERE '.$where.' LIMIT ' . $limit;
        }
        else
        {
            $sql = 'SELECT '.$type.'.* FROM `members_'.$type.'s` AS '.$type.' WHERE '.$where.' LIMIT ' . $limit;
        }
        // CONSULTA A LA BD
        $query = $this->db->query($sql);

        // SI LA CONSULTA ES CORRECTA
        if ($query == true && $query->num_rows > 0)
        {
            return ($limit > 1) ? $query : true;
        }
        //
        return false;
    }

    /**
     * Seguir o bloquear a un usuario
     * 
     * @param integer $member_from
     * @param integer $member_to
     * @return boolean
     */
    function setFollowBlock($member_from = null, $member_to = null, $type = 'follow')
    {
        // REGISTRA SEGUIMIENTO
        $query = $this->db->query('INSERT INTO `members_'.$type.'s` (`'.$type.'_from`, `'.$type.'_to`, `'.$type.'_date`) VALUES (\''.$member_from.'\', \''.$member_to.'\', UNIX_TIMESTAMP()) ');

        // RETORNAR
        if ($query == true)
        {
            return $this->db->insert_id;
        }
        //
        return false;
    }

    /**
     * Dejar de seguir o desbloquear a un usuario
     * 
     * @param integer $member_from
     * @param integer $member_to
     * @return boolean
     */
    function setUnfollowBlock($member_from = null, $member_to = null, $type = 'follow')
    {
        // ELIMINA SEGUIMIENTO
        $query = $this->db->query('DELETE FROM `members_'.$type.'s` WHERE `'.$type.'_from` = \''.$member_from.'\' && `'.$type.'_to` = \''.$member_to.'\' LIMIT 1');

        // RETORNAR
        if ($query == true)
        {
            return true;
        }
        //
        return false;
    }

    /**
     * Comprueba si existe bloqueo entre dos usuarios
     * 
     * @param integer $member1
     * @param integer $member2
     * @return boolean
     */
    function checkBlock($member1 = null, $member2 = null)
    {
        // COMPROBAR QUE LOS USUARIOS SEAN DIFERENTES (NO PUEDO BLOQUEARME A MI MISMO)
        if($member1 !== $member2)
        {
            $query = $this->db->query('SELECT `block_id` FROM `members_blocks` WHERE (`block_from` = \''.$member1.'\' && `block_to` = \''.$member2.'\') || (`block_from` = \''.$member2.'\' && `block_to` = \''.$member1.'\') LIMIT 1');
            // RETORNAR TRUE SI EXISTE BLOQUEO ENTRE ALGUNO DE ELLOS
            if ($query == true && $query->num_rows > 0)
            {
                return true;
            }
        }
        //
        return false;
    }
}