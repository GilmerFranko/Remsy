<?php defined('SUPERNATURAL') || exit;

/**
 *
 *=======================================================\
 *  Sin Nombre                                           |
 *-------------------------------------------------------/
 * @file        footer.html.php                          \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com          |
 * @copyright   (c) 2021 Gilmer Franco                   /
 *                                                            /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar sesión del usuario/visitante
 *
 *
*/

class Session extends Model
{
    var $memberData = array(); // SI EL USUARIO ES MIEMBRO CARGAMOS DATOS DE LA TABLA
    var $memberGroup = array(); // SI EL USUARIO ES MIEMBRO CARGAMOS DATOS DE LA TABLA
    var $is_member = false; // EL USUARIO ESTA IDENTIFICADO?
    var $is_vip = false; // EL USUARIO ES VIP
    var $is_admod = 0; // EL USUARIO ES MODERADOR/ADMINISTRADOR?
    var $is_banned = 0; // EL USUARIO ESTÁ BANEADO?
    var $token = 0; // CÓDIGO DE SEGURIDAD IDENTIFICATIVO PARA LA SESIÓN
    var $platform = 'pc'; // PLATAFORMA POR DEFECTO
    
    function __construct()
    {
        parent::__construct();
        $this->session = $this->getSession();
    }

    
    function getSession()
    {
        /* En caso de no retornar datos la sesión es de visitante */
        $this->memberData = array(
            'name' => 'Visitante',
            'email' => '',
            'group_id' => '0',
            'member_id' => '0',
            'permissions' => array(),
            'newbie' => true,
            'pp_timezone' => 'America/Los_Angeles',
        );

        //
        /*if(isset($_SESSION))
        {
                $this->memberData = $_SESSION;

            // ¿ES MIEMBRO?
                $this->is_member = $this->memberData['member_id'] != '0' ? 1 : 0;
                // CóDIGO DE SEGURIDAD
                $this->token = md5('token' . $this->memberData['session']);
                // ¿ES MODERADOR - ADMINISTRADOR?
                $this->is_admod = $this->getLevel();
        }
        else*/
        if (isset($_COOKIE[$this->config['cookie_name']]))
        {
            $query = $this->db->query('SELECT m.*, g.* FROM `members` AS m LEFT JOIN `members_groups` AS g ON m.`group_id` = g.`g_id` WHERE m.`session` = \'' . $this->db->real_escape_string($_COOKIE[$this->config['cookie_name']]) . '\' && m.`banned` = 0 LIMIT 1');
            //
            if ($query == true && $query->num_rows > 0)
            {
                $this->memberData = $query->fetch_assoc();
                // PERMISOS EN UN ARRAY
                $this->memberData['permissions'] = explode(',', $this->memberData['g_permissions']);
                // ¿ESTÁ BANEADO?
                $this->is_banned= $this->memberData['banned'] > 0 ? true : false;
                // ¿ES MIEMBRO?
                $this->is_member = $this->memberData['member_id'] != '0' ? true : false;
                // CóDIGO DE SEGURIDAD
                $this->token = md5('token' . $this->memberData['session']);
                // ¿ES MODERADOR - ADMINISTRADOR?
                $this->is_admod = $this->getLevel();
                // ZONA HORARIA PREDETERMINADA
                $this->memberData['pp_timezone'] = empty($this->memberData['pp_timezone']) ? 'America/Los_Angeles' : $this->memberData['pp_timezone'];
                // CANTIDAD DE NOTIFICACIONES DE FOTOS
                $this->memberData['notifications_photos'] = $this->memberData['notifications'];
                // CANTIDAD DE NOTIFICACIONES TOTALES
                $this->memberData['notifications'] = $this->getNotificationsCount($this->memberData['member_id']);
                // CANTIDAD DE DÍAS REGISTRADO
                //$this->memberData['registered_days'] = round(((time()-$this->memberData['pp_joined'])/60/60/24), 0, PHP_ROUND_HALF_DOWN);
                $this->memberData['newbie'] = $this->memberData['pp_joined'] > (time()-259200) ? true : false;
                // ACTUALIZAR ÚLTIMA ACTIVIDAD
                $query = $this->db->query('UPDATE `members` SET `last_activity` = UNIX_TIMESTAMP() WHERE `member_id` = \'' . $this->memberData['member_id']. '\' LIMIT 1');

                //$_SESSION = serialize($this->memberData);
            }
        }
        //
        return $this->memberData;
    }

    function getNotificationsCount($member = null)
    {
        $query = $this->db->query('SELECT COUNT(`id`) FROM `members_notifications` WHERE `to_member` = \''.$member.'\' && `read_time` = \'0\' && `sent_time` < UNIX_TIMESTAMP() LIMIT 50');

        if($query == true && $query->num_rows > 0)
        {
            $nots = $query->fetch_row();
            return /*$this->memberData['notifications'] + */$nots[0];
        }

        return 0;
    }

    function getLevel()
    {
        if ($this->isAllowed('admin') === true)
        {
            return 1;
        }
        elseif ($this->isAllowed('mod') === true)
        {
            return 2;
        }
        //
        return 0;
    }

    function isAllowed($permission = null)
    {
        if ($this->is_admod === 1 || in_array($permission, $this->memberData['permissions']))
        {
            return true;
        }
        //
        return false;
    }

    function checkToken($token = '')
    {
        $token = empty($token) && isset($_GET['token']) ? $_GET['token'] : $token;
        //
        if ($token == $this->token)
        {
            return true;
        }
        //
        return false;
    }
}
