<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\global\model\access.class.php    \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar la identificación o registro del usuario/visitante
 *
 *
*/

class Access extends Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }
    
    /**
     * Identifica a un usuario
     * 
     * @param int $member_id
     * @param string $uuid
     */
    function login($member_id = 0, $uuid = null)
    {
        /* Generamos un identificador único de 28 carácteres */
        $uuid = empty($uuid) ? Core::model('extra', 'core')->generateUUID(28) : $uuid;
        
        /* Asociamos el identificador generado a la sesión del usuario */
        $query = $this->db->query('UPDATE `members` SET `session` = \'' . $uuid . '\', `last_login` = UNIX_TIMESTAMP() WHERE `member_id` = \'' .$member_id . '\' LIMIT 1');
        
        if($query == true)
        {
            /* Establecemos la cookie */
            setcookie($this->config['cookie_name'], $uuid, time() + 60 * 60 * 24 * $this->config['cookie_time'], '/');
            //
            return true;
        }
        //
        return false;
    }
    
    /**
     * Cierra la sesión actual
     */
    function logout($member_id = 0)
    {
        /* Eliminamos el identificador asociado a la sesión del usuario */
        //$query = $this->db->query('UPDATE `members` SET `session` = \'\' WHERE `member_id` = \'' .$member_id . '\' LIMIT 1');
        
        //if($query == true){
            /* Eliminamos la cookie */
            setcookie($this->config['cookie_name'], '', time() - 1, '/');
            //
            return true;
        //}
        //return false;
    }
    
    /**
     * Registra a un usuario
     * 
     * @param string $username
     * @param string $password
     * @param string $email
     * @return integer/boolean
     */
    function signIn($member = array())
    {
        // RANGO PREEDETERMINADO
        $member_group = $this->config['reg_validate'] == '1' ? '0' : $this->config['reg_group'];

        // REGISTRA EN LA BASE DE DATOS
        $query = $this->db->query('INSERT INTO `members` (`name`, `password`, `group_id`, `email`, `ip_address`, `pp_full_name`, `pp_main_photo`, `pp_thumb_photo`, `pp_gender`, `pp_joined`) VALUES (\'' . $this->db->real_escape_string($member['name']) . '\', \'' . $this->db->real_escape_string($member['password']) . '\', \'' . $member_group . '\', \'' . $this->db->real_escape_string($member['email']) . '\', \'' . $this->db->real_escape_string( Core::model('extra', 'core')->getIp() ) . '\', \'' . $this->db->real_escape_string($member['name']) . '\', \'' . $this->db->real_escape_string( Core::model('account', 'members')->generateAvatar($member['email'], 2) ) . '\', \'' . $this->db->real_escape_string( Core::model('account', 'members')->generateAvatar($member['email'], 2) ) . '\', \'' . $member['gender'] . '\',  \'' . time() . '\') ');
        //
        if ($query == true)
        {
            $user_id = $this->db->insert_id;
            // SUMA AL RANGO
            if($member_group > 0)
            {
                $this->db->query('UPDATE `members_groups` SET `g_count_members` = `g_count_members` + 1  WHERE `g_id` = \'' . $member_group . '\' LIMIT 1');
            }

            // Retorna el ID de usuario
            return $user_id;
        }
        //
        return false;
    }

    /**
     * Actualiza la contraseña de PHPost a BellasGram
     * 
     * @param int $member
     * @param string $password
     * @return boolean
     */
    function convertPassword($member = null, $password = null)
    {
        $query = $this->db->query('UPDATE `members` SET `password` = \''.$this->db->real_escape_string($password).'\', `password_phpost` = \'\' WHERE `member_id` = \''.$member.'\' LIMIT 1');
        //
        if ($query == true)
        {
            return true;
        }
        //
        return false;
    }
    
    /**
     * Registra un recuperador de acceso, ya sea para confirmar la cuenta o para recuperar la contraseña
     * 
     * @param integer $member_id
     * @param string  $email
     * @param integer $type
     * @return string/boolean
     */
    function setRecover($member_id = 0, $email = NULL, $type = 0)
    {
        $hash = Core::model('extra', 'core')->generateUUID(30);
        //
        $query = $this->db->query('INSERT INTO `site_recovers` (`id`, `member_id`, `email`, `date`, `type`, `ip_address`) VALUES (\'' . $hash . '\', \'' . $member_id . '\', \'' . $this->db->real_escape_string($email) . '\', \'' . time() . '\', \'' . $type . '\', \'' . $this->db->real_escape_string( Core::model('extra', 'core')->getIp() ) . '\') ');
        //
        if ($query == true)
        {
            return $hash;
        }
        //
        return false;
    }
    
    /**
     * Comprueba si el código de recuperación es válido
     * 
     * @param string  $hash
     * @param integer $type (2 = Validar cuenta, 1 = Restablecer contraseña)
     * @return boolean
     */
    function checkRecover($hash = '', $type = 0)
    {
        $query = $this->db->query('SELECT `member_id`, `email` FROM `site_recovers` WHERE `id` = \'' . $this->db->real_escape_string($hash) . '\' && `type` = \'' . $type . '\' LIMIT 1');
        //
        if ($query == true && $query->num_rows > 0)
        {
            return true;
        }
        //
        return false;
    }
    
    /**
     * Elimina un código de validación
     * 
     * @param string  $hash
     * @param integer $type (2 = Validar cuenta, 1 = Restablecer contraseña)
     * @return string/boolean
     */
    function deleteRecover($hash = '', $type = 0)
    {
        $query = $this->db->query('DELETE FROM `site_recovers` WHERE `id` = \'' . $this->db->real_escape_string($hash) . '\' && `type` = \'' . $type . '\' LIMIT 1');
        //
        if ($query == true && $this->db->affected_rows > 0)
        {
            return true;
        }
        //
        return false;
    }

    /**
     * Elimina un usuario
     * 
     * @param integer $member_id
     * @return boolean
     */
    function deleteAccount($member = null, $group_id = null)
    {
        // PREDEFINIR ERRORES
        $error = array();

        # ELIMINACION DE SHOUTS
        // OBTENER SHOUTS
        $query = $this->db->query('SELECT `id` FROM `shouts` WHERE `member` = \'' . $member . '\'');
        // COMPROBAR SI TIENE SHOUTS
        if ($query == true && $query->num_rows > 0)
        {
            // ELIMINAR SHOUTS
            while( $shout = $query->fetch_assoc() )
            {
                Core::model('shout', 'shouts')->deleteShout($shout);
            }
        }
        // ELIMINACIONES RESTANTES
        $array = array(
            // COMENTARIOS
            'DELETE FROM `shouts_comments` WHERE `author_id` = \''.$member.'\'',
            // DESCARGAS
            'DELETE FROM `shouts_downloads` WHERE `member` = \''.$member.'\'',
            // COMPRAS
            'DELETE FROM `members_coins` WHERE `member` = \''.$member.'\'',
            // ELIMINAR BLOQUEOS Y BLOQUEADOS
            'DELETE FROM `members_blocks` WHERE `block_from` = \''.$member.'\' || `block_to` = \''.$member.'\'',
            // ELIMINAR LIKES
            'DELETE FROM `shouts_likes` WHERE `member` = \''.$member.'\'',
            // REPORTES
            'DELETE FROM `site_reports` WHERE `member` = \''.$member.'\'',
            // NOTIFICACIONES
            'DELETE FROM `members_notifications` WHERE `to_member` = \''.$member.'\' || `from_member` = \''.$member.'\'',
            // SIGUIENDO Y SEGUIDORES
            'DELETE FROM `members_follows` WHERE `follow_from` = \''.$member.'\' || `follow_to` = \''.$member.'\'',
            // RECOVERS
            'DELETE FROM `site_recovers` WHERE `member_id` = \''.$member.'\'',
            // PERFIL / CUENTA
            'DELETE FROM `members` WHERE `member_id` = \''.$member.'\' LIMIT 1',
            // RESTAR USUARIO AL GRUPO
            'UPDATE `members_groups` SET `g_count_members` = `g_count_members` - 1 WHERE `g_id` = \''.$group_id.'\' LIMIT 1'
            );

        // RECORRER CONSULTAS
        foreach($array as $sql)
        {
            // EJECUTAR CONSULTA
            if( $this->db->query($sql) == false )
            {
                $error[] = '<strong>SQL:</strong> '.$sql.'. <strong>Error:</strong> '.$this->db->error;
                break; // DEJAR DE EJECUTAR CONSULTAS
            }
        }

        // SI TODO HA IDO BIEN
        if(empty($error))
        {
            return true;
        }

        // CONVERTIR ERRORES EN TEXTO
        $msg = 'Problema al eliminar usuario: <br/>';
        $msg .= implode('<br/>', $error);

        // SI ALGO FALLÓ, NOTIFICAR AL ADMIN
        $this->db->query('INSERT INTO `members_notifications` (`to_member`, `from_member`, `not_key`, `content`, `sent_time`) VALUES (\'1\', \''.$member.'\', \'deleteAccount\', "'.$this->db->real_escape_string($msg).'", UNIX_TIMESTAMP()) ');

        // RETORNAR FALSE
        return false;
    }

    /**
     * Buscar un email mediante nombre de usuario y contraseña
     * 
     * @param string  $username
     * @param string  $password
     * @return string $email
     */
    function searchEmail($username = '', $password = '')
    {
        // OBTENER TODOS LOS USUARIOS CON ESE NOMBRE
        $query = $this->db->query('SELECT `email`, `password` FROM `members` WHERE LOWER(name) = \'' . $this->db->real_escape_string($username) . '\' LIMIT 50');
        //
        if ($query == true && $query->num_rows > 0)
        {
            while( $memberData = $query->fetch_assoc() )
            {
                if (password_verify($password, $memberData['password']) === true)
                {
                    return $memberData['email'];
                }
            }
        }
        //
        return false;
    }
    
}