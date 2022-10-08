<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\global\model\member.class.php    \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo contiene funciones relacionadas al usuario
 *
 *
*/

class Member extends Session
{    
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }
    
    /**
     * Comprueba si existe un usuario registrado con los datos proporcionados
     * 
     * @param string $username
     * @param string $email
     * @param int    $member_id
     * @return boolean
     */
    function checkUserExists($username = '', $email = '', $member_id = 0)
    {
        // ID DE USUARIO
        $memberData['member_id'] = $member_id > 0 ? $member_id : $this->session->memberData['member_id'];
        // CONSULTA A BD
        $query = $this->db->query('SELECT `member_id` FROM `members` WHERE ( LOWER(name) = \'' . $this->db->real_escape_string($username) . '\' || LOWER(email) = \'' . $this->db->real_escape_string($email) . '\' ' . ($this->session->is_admod == 1 || $this->config['check_clon'] == '0' ? '' : '|| `ip_address` = \''.$this->db->real_escape_string( Core::model('extra', 'core')->getIp() ).'\'' ) . ') && `member_id` != \''.$memberData['member_id'].'\' LIMIT 1');
        //
        if($query == true && $query->num_rows > 0)
        {
            return true;
        }
        //
        return false;
    }

    /**
     * Comprueba si un usuario existe
     * 
     * @param int $member_id
     * @param string $username
     * @return array
     */
    function isMember($member_id = 0, $username = '', $return_id = false)
    {
        // ESTABLECE LA CONDICIÓN
        $where = empty($member_id) ? 'LOWER(`name`) = \'' . $this->db->real_escape_string(strtolower($username)) . '\'' : '`member_id` = \'' . $member_id . '\'';
        // EJEUTA LA CONSULTA
        $query = $this->db->query('SELECT `member_id` FROM `members` WHERE ' . $where . ' LIMIT 1');
        //
        if ($query == true && $query->num_rows > 0)
        {
            if ($return_id == true)
            {
                $result = $query->fetch_row();
                //
                return $result[0];
            }
            //
            return true;
        }
        //
        return false;
    }
    
    /**
     * Extrae alguna información de un usuario con su nombre o email.
     * 
     * @param string $user (user or email)
     * @return array
     */
    function getMemberData($user = null)
    {
        $query = $this->db->query('SELECT `member_id`, `name`, `email`, `password`, `password_phpost`, `group_id`, `banned`, `session` FROM `members` WHERE LOWER(name) = \'' . $this->db->real_escape_string($user) . '\' || LOWER(email) = \'' . $this->db->real_escape_string($user) . '\' LIMIT 1');
        //
        if($query == true && $query->num_rows > 0)
        {
            return $query->fetch_assoc();
        }
        //
        return false;
    }

    /**
     * Obtiene el avatar de un usuario
     * 
     * @param int $member_id
     * @return string
     */
    function getAvatar($member_id = 0, $thumb = true)
    {
        if ($member_id === $this->memberData['member_id'])
        {
            $avatar = $this->memberData['pp_main_photo'];
        }
        else
        {
            if ($member_id > 0)
            {
                $thumb = $thumb == true ? 'thumb' : 'main';
                $query = $this->db->query('SELECT `pp_'.$thumb.'_photo` FROM `members` WHERE `member_id` = \'' . $member_id . '\' LIMIT 1');
                //
                if ($query == true && $query->num_rows > 0)
                {
                    $result = $query->fetch_row();
                    $avatar = $result[0];
                }
            }
        }
        //
        if (!empty($avatar))
        {
            return $avatar;
        }
        //
        $avatar_thumb = Core::model('account', 'members')->generateAvatar($member_id, true);
        // FIX: TEMPORALMENTE DESACTIVADO PARA EVITAR FALSOS POSITIVOS EN EL BUSCADOR
        /*$avatar = Core::model('account', 'members')->generateAvatar($member_id);
        // GUARDAR AVATAR EN LA BASE DE DATOS
        Core::model('account', 'members')->setAvatar($avatar, $avatar_thumb, 0, $member_id);*/
        return $avatar_thumb;
    }

    /**
     * @name setMenciones
     * @access public
     * @param string
     * @return string
     * @info PONE LOS LINKS A LOS MENCIONADOS
     */
    function setMentions($string)
    {
        // CONVIERTE
        $string = preg_replace('/\B@([a-zA-Z0-9_-]{4,30}+)\b/', '<a href="' . Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => '$1')) . '">@$1</a>', $string);
        
        // RETORNA EL TEXTO CON ENLACES
        return $string;
    }
}
