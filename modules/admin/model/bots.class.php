<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\model\bots.class.php       \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a los bots que responden
 *
 *
*/

class Bots extends Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }

    /**
     * Obtiene los bots que deben responder
     */
    function getAnswersBots()
    {
        $query = $this->db->query('SELECT `member_id`, `name` FROM `members` WHERE `bot_response` > 0 LIMIT 50');
        //
        if ($query == true && $query->num_rows > 0)
        {
            return $query;
        }
        //
        return false;
    }
    
    /**
     * Obtiene los bots que responden
     * @param int $max (Cantidad de bots a mostrar)
     */
    function getWords($max = 10)
    {
        // PALABRAS TOTALES
        $query = $this->db->query('SELECT COUNT(*) FROM `bots_words`');
        list($result['total']) = $query->fetch_row();
        // PAGINADOR
        $result['pages'] = Core::model('paginator', 'core')->pageIndex( array('admin', 'bots'), $result['total'], $max);
        // EJECUTA LA CONSULTA
        $count = ''; //',  (SELECT COUNT(*) FROM bots_answers WHERE a.`ba_id` = w.`bw_word`) AS bw_count';
        $query = $this->db->query('SELECT w.`bw_id`, w.`bw_word`, w.`bw_count`, w.`bw_time`, m.`member_id`, m.`name` '.$count.' FROM `bots_words` AS w LEFT JOIN `members` AS m ON  m.`member_id` = w.`bw_member` ORDER BY m.`name`, w.`bw_word` ASC LIMIT ' . $result['pages']['limit']);
        //
        if ($query == true)
        {
            $result['data'] = $query;
            $result['rows'] = $query->num_rows;
            //
            return $result;
        }
        //
        return false;
    }
    
    /**
     * Obtiene las respuestas de una palabra de bot
     */
    function getReplies($word = null, $max = 10)
    {
        // RESPUESTAS TOTALES
        $query = $this->db->query('SELECT COUNT(*) FROM `bots_replies` WHERE `ba_word_id` = \''.$word.'\'');
        list($result['total']) = $query->fetch_row();
        // PAGINADOR
        $result['pages'] = Core::model('paginator', 'core')->pageIndex( array('admin', 'bots', 'replies', array('search' => $word) ), $result['total'], $max);
        // EJECUTA LA CONSULTA
        $query = $this->db->query('SELECT `ba_id`, `ba_comment`, `ba_time` FROM `bots_replies` WHERE `ba_word_id` = \''.$word.'\' ORDER BY `ba_id` DESC LIMIT ' . $result['pages']['limit']);
        //
        if ($query == true)
        {
            // DECLARAR DATOS
            $result['data'] = $query;
            $result['rows'] = $query->num_rows;
            // OBTENER PALABRA Y BOT
            $result['word'] = $this->db->query('SELECT `bw_id`, `bw_member`, `bw_word` FROM `bots_words` WHERE `bw_id` = \''.$word.'\' LIMIT 1')->fetch_assoc();
            // OBTENER NOMBRE BOT
            $result['word']['bot_name'] = Core::model('db', 'core')->getColumns('members', 'name', array('member_id', $result['word']['bw_member']));
            //
            return $result;
        }
        //
        return false;
    }
    
    /**
     * Registra una palabra
     * 
     * @param integer $bot
     * @param string  $word
     * @return boolean
     */
    function newWord($bot = null, $word = null)
    {
        //
        $query = $this->db->query('INSERT INTO `bots_words` (`bw_member`, `bw_word`, `bw_time`) VALUES (\''.$bot.'\', \''.$this->db->real_escape_string($word).'\', UNIX_TIMESTAMP()) ');
        //
        if ($query == true)
        {
            return $this->db->insert_id;
        }
        //
        return false;
    }

    /**
     * Registra una respuesta
     * 
     * @param integer $word
     * @param string  $comment
     * @return boolean
     */
    function newReply($word = null, $comment = null)
    {
        //
        $query = $this->db->query('INSERT INTO `bots_replies` (`ba_word_id`, `ba_comment`, `ba_time`) VALUES (\''.$word.'\', \''.$this->db->real_escape_string($comment).'\', UNIX_TIMESTAMP()) ');
        //
        if ($query == true)
        {
            $reply = $this->db->insert_id;
            // ACTUALIZAR CANTIDAD DE RESPUESTAS EN LA PALABRA
            $this->db->query('UPDATE `bots_words` SET `bw_count` = `bw_count` + 1 WHERE `bw_id` = \''.$word.'\' LIMIT 1');

            return $reply;
        }
        //
        return false;
    }

    /**
     * Borra una palabra y sus respuestas
     * 
     * @param integer $word_id
     * @return boolean
     */
    function deleteWord($word_id = null)
    {
        // BORRAR PALABRA
        $query = $this->db->query('DELETE FROM `bots_words` WHERE `bw_id` = \''.$word_id.'\' LIMIT 1');
        //
        if ($query == true)
        {   // BORRAR RESPUESTAS
            $query = $this->db->query('DELETE FROM `bots_replies` WHERE `ba_word_id` = \''.$word_id.'\'');
            //
            if ($query == true)
            {
                // RETORNA 1 SI SE HA ELIMINADO TODO
                return 1;
            }
            // SI SOLO SE HA BORRADO LA PALABRA, PERO NO SUS RESPUESTAS
            return 2;
        }
        // RETORNA FALSE SI NO SE HA ELIMINADO NADA
        return false;
    }

    /**
     * Borra una respuesta
     * 
     * @param integer $reply_id
     * @param integer $word_id
     * @return boolean
     */
    function deleteReply($word_id = null, $reply_id = null)
    {
        // BORRAR RESPUESTA
        $query = $this->db->query('DELETE FROM `bots_replies` WHERE `ba_id` = \''.$reply_id.'\' LIMIT 1');
        //
        if ($query == true)
        {   // ACTUALIZAR CANTIDAD DE RESPUESTAS EN LA PALABRA
            $query = $this->db->query('UPDATE `bots_words` SET `bw_count` = `bw_count` -1 WHERE `bw_id` = \''.$word_id.'\' LIMIT 1');
            //
            if ($query == true)
            {
                // RETORNA 1 SI SE HA ELIMINADO LA RESPUESTA
                return 1;
            }
            // SI SOLO SE HA BORRADO LA RESPUESTA, PERO NO SE HA ACTUALIZADO
            return 2;
        }
        // RETORNA FALSE SI NO SE HA HECHO NADA
        return false;
    }
}