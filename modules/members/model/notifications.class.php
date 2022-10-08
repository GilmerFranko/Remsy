<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\global\model\notifications.class.php
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo contiene funciones relacionadas a las notificaciones
 *
 *
*/

class Notifications extends Session
{
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }
    
    /**
     * Obtiene las notificaciones de un usuario
     * 
     * @param int $limit
     * @param int $member
     * @return array
     */
    function getNotifications($limit = 10, $member = 0)
    {
        $member = empty($member) ? $this->session->memberData['member_id'] : $member;
        // CONSULTA A BD
        $query = $this->db->query('SELECT * FROM `members_notifications` WHERE `to_member` = \''.$member.'\' && `sent_time` < UNIX_TIMESTAMP() ORDER BY `sent_time` DESC LIMIT ' . $limit);

        // RESETEAR NOTIFICACIONES
        $this->db->query('UPDATE `members` SET `notifications` = \'0\' WHERE `member_id` = \''.$member.'\' LIMIT 1');
        //
        if($query == true && $query->num_rows > 0)
        {
            while($row = $query->fetch_assoc())
            {
                // CONVERTIR EN TEXTO
                $row['content'] = empty($row['content']) ? $this->generateNotification($row['to_member'], $row['from_member'], $row['not_key'], $row['item_id'], $row['subitem_id']) : $row['content'];
                $notification[] = $row;
            }

            return $notification;
        }
        //
        return false;
    }

    /**
     * Obtiene las fotos regaladas a un usuario
     * 
     * @param int $limit
     * @param int $member
     * @return array
     */
    function getPhotos($limit = 10)
    {
        // OBTENER LAS FOTOS QUE HAN REGALADO DE LAS AUTORAS QUE SIGO
        $query = $this->db->query('SELECT p.*, f.`follow_id` FROM `photos` AS p LEFT JOIN `members_follows` AS f ON p.`author` = f.`follow_to` WHERE f.`follow_from` = \''.$this->session->memberData['member_id'].'\' && p.`date_expires` > UNIX_TIMESTAMP() ORDER BY p.`id` DESC LIMIT ' . $limit);

        // GENERAR TEXTO DE LAS NOTIFICACIOENS
        if($query == true && $query->num_rows > 0)
        {
            while($row = $query->fetch_assoc())
            {
                // CONVERTIR EN TEXTO
                $row['content'] = $this->generateNotification($this->session->memberData['member_id'], $row['author'], 'photoGift', $row['id']);
                $notification[] = $row;
            }

            return $notification;
        }
        //
        return false;
    }

    /**
     * Se marcan como leídas las notificaciones de un usuario
     * 
     * @param int $member
     * @return boolean
     */
    function setReadNotifications($member = 0)
    {
        $member = empty($member) ? $this->session->memberData['member_id'] : $member;
        // CONSULTA A BD
        $query = $this->db->query('UPDATE `members_notifications` SET `read_time` = UNIX_TIMESTAMP() WHERE `to_member` = \''.$member.'\' && `sent_time` < UNIX_TIMESTAMP()');

        if($query == true)
        {
            return true;
        }
        //
        return false;
    }

    /**
     * Se eliminan las notificaciones antiguas
     * 
     * @param int $member
     * @param int $days
     * @param boolean $all // Elimina todas o sólo las leídas
     * @return boolean
     */
    function removeOldNotifications($member = 0, $days = 7, $all = false)
    {
        $member = empty($member) ? $this->session->memberData['member_id'] : $member;
        $time = time() - ($days*86400); //24*60*60
        // CONSULTA A BD
        $query = $this->db->query('DELETE `members_notifications` WHERE `to_member` = \''.$member.'\' && `'.($all == true ? 'sent' : 'read').'_time` < \''.$time.'\' ');

        echo 'DELETE `members_notifications` WHERE `to_member` = \''.$member.'\' && `'.($all == true ? 'sent' : 'read').'_time` < \''.$time.'\' '; exit;

        if($query == true)
        {
            return true;
        }
        //
        return false;
    }

    /**
     * Se registra una notificación
     * 
     * @param int $to_member
     * @param int $from_member
     * @param string $key
     * @param int $item
     * @param int $subitem
     * @param text $content
     * @param boolean $myself (soy yo)
     * @param boolean $check (comprobar si ya existe)
     * @param int $time (Fecha de notificación)
     * @return boolean
     */
    function newNotification($to_member = null, $from_member = null, $key = 'general', $item = 0, $subitem = 0, $content = '', $myself = false, $check = false, $time = 'UNIX_TIMESTAMP()')
    {
        // EVITAR ENVIARME A MÍ MISMO
        if($to_member != $from_member || $myself == true)
        {
            // GENERAR TEXTO DE NOTIFICACIÓN
            //$content = $this->generateNotification($to_member, $from_member, $key, $item, $subitem);
            $content = '';

            // COMPROBAR SI YA EXISTE EN UN PERIODO DE UN MINUTO
            if($check == true)
            {
                //$qcheck = $this->db->query('SELECT `id` FROM `members_notifications` WHERE `to_member` =  \''.$to_member.'\' && `from_member` = \''.$from_member.'\' && `not_key` = \'' . $this->db->real_escape_string($key) . '\' && `item_id` = \''.$item.'\' && `subitem_id` = \''.$subitem.'\' && `sent_time` > '.(time()-60).' LIMIT 1');
                $qcheck = $this->db->query('SELECT `id` FROM `members_notifications` WHERE `to_member` = \''.$to_member.'\' && `sent_time` > '.(time()-60).' && `content` =  \'' . $this->db->real_escape_string($content) . '\' LIMIT 1');

                if($qcheck->num_rows > 0)
                {
                    return true;
                }

            }
            
            // CONSULTA A BD
            $query = $this->db->query('INSERT INTO `members_notifications` (`to_member`, `from_member`, `not_key`, `item_id`, `subitem_id`, `content`, `sent_time`) VALUES (\''.$to_member.'\', \''.$from_member.'\', \'' . $this->db->real_escape_string($key) . '\', \''.$item.'\', \''.$subitem.'\', \'' . $this->db->real_escape_string($content) . '\', '.$time.') ');

            if($query == true)
            {
                // SUMAR ESTADÍSTICA A USUARIO
                $this->db->query('UPDATE `members` SET `notifications` = `notifications` + 1 WHERE `member_id` = \''.$to_member.'\' LIMIT 1');

                // TODO BIEN
                return true;
            }
        }
        //
        return false;
    }

    /**
     * Genera HTML de notificacion
     * 
     * @param int $to_member
     * @param int $from_member
     * @param string $key
     * @param int $item
     * @param int $subitem
     * @return boolean
     */
    function generateNotification($to_member = null, $from_member = null, $key = 'general', $item = 0, $subitem = 0)
    {
        $url['users'] = Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => '%1$s') );
        $url['shouts'] = Core::model('extra', 'core')->generateUrl('shouts', 'view', null, array('id' => '%1$s') );
        $url['photos'] = Core::model('extra', 'core')->generateUrl('site', 'photo', null, array('id' => '%1$s') );
        $msg = 'Contenido desconocido';
        switch($key)
        {
            case 'general':
                $msg = 'Contenido perdido';
                break;
            // NUEVO SHOUT
            case 'newShout':
            // NUEVO SHOUT VIP
            case 'newShoutVip':
            // NUEVO SHOUT DE VIDEO
            case 'newShoutVideo':
            // NUEVO SHOUT DE VIDEO VIP
            case 'newShoutVideoVip':
                $name = Core::model('db', 'core')->getColumns('members', 'name', array('member_id', $from_member));
                $msg = '<a href="'.sprintf($url['users'], $from_member).'">' . $name . '</a> public&oacute; un <a href="'.$url['shouts'].'">'.(strpos($key, 'Video') ? '<span class="blue-text">Video</span>' : 'Shout').(strpos($key, 'Vip') ? ' <span class="red-text">VIP</span>' : '').'</a>';
                break;
            // NUEVA DESCARGA
            case 'newDownload':
                $name = Core::model('db', 'core')->getColumns('members', 'name', array('member_id', $from_member));
                $msg = 'Has descargado una imagen del <a href="'.$url['shouts'].'">Shout</a> de <a href="'.sprintf($url['users'], $from_member).'">' . $name . '</a>';
                break;
            // NUEVA COMPRA
            case 'newBuy':
                $msg = 'Has comprado %1$s cr&eacute;ditos';
                break;
            // NUEVO SEGUIDOR
            case 'follow':
                $name = Core::model('db', 'core')->getColumns('members', 'name', array('member_id', $from_member));
                $msg = '<a href="'.sprintf($url['users'], $from_member).'">' . $name . '</a> te sigue';
                break;
            // NUEVO COMENTARIO
            case 'shoutComment':
                $name = Core::model('db', 'core')->getColumns('members', 'name', array('member_id', $from_member));
                $msg = '<a href="'.sprintf($url['users'], $from_member).'">' . $name . '</a> coment&oacute; tu <a href="'.$url['shouts'].'">Shout</a>';
                break;
            // NUEVO LIKE EN SHOUT
            case 'shoutLike':
                $name = Core::model('db', 'core')->getColumns('members', 'name', array('member_id', $from_member));
                $msg = 'A <a href="'.sprintf($url['users'], $from_member).'">' . $name . '</a> le gusta tu <a href="'.$url['shouts'].'">Shout</a>';
                break;
            // NUEVO LIKE EN COMENTARIO
            case 'commentLike':
                $name = Core::model('db', 'core')->getColumns('members', 'name', array('member_id', $from_member));
                $msg = 'A <a href="'.sprintf($url['users'], $from_member).'">' . $name . '</a> le gusta tu comentario en un <a href="'.$url['shouts'].'"><span class="indigo-text">Shout</span></a>';
                break;
            // NUEVA DENUNCIA DE SHOUT
            case 'shoutReport':
                // ITEM = ID DE SHOUT
                // SUBITEM = ID DE REPORTE
                $name = Core::model('db', 'core')->getColumns('members', 'name', array('member_id', $from_member));
                $msg = '<a href="'.sprintf($url['users'], $from_member).'">' . $name . '</a> ha denunciado un <a href="'.$url['shouts'].'">Shout</a>';
                break;
            // NUEVA DENUNCIA DE USUARIO
            case 'userReport':
                // ITEM = ID DE USUARIO
                // SUBITEM = ID DE REPORTE
                $name = Core::model('db', 'core')->getColumns('members', 'name', array('member_id', $from_member));
                $userReported = Core::model('db', 'core')->getColumns('members', 'name', array('member_id', $item));
                $msg = '<a href="'.sprintf($url['users'], $from_member).'">' . $name . '</a> ha denunciado a <a href="'.sprintf($url['users'], $item).'">' . $userReported . '</a>';

                break;
            // NUEVA FOTO REGALADA
            case 'photoGift':
                $name = Core::model('db', 'core')->getColumns('members', 'name', array('member_id', $from_member));
                $msg = '<a href="'.sprintf($url['users'], $from_member).'">' . $name . '</a> te ha regalado una <a href="'.$url['photos'].'">imagen</a> <i class="material-icons red-text">favorite</i>';
                break;
        }
        $msg = sprintf($msg, $item, $subitem);
        return $msg;
    }
}
