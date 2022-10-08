<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\core\model\bot.class.php         \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar las acciones de los bots
 *
 *
*/

class Bot extends Model
{
    /**
     * Establece la configuración del bot
     * 
     * @param array $bot        // DATOS DEL BOT
     * @param class $cImage     // CLASE DE IMAGENES
     * @return string
     */
    var $bot = array(); // DATOS DEL USUARIO BOT
    var $config = array(); // CONFIGURACION DEL PUBLICADOR DEL BOT
    var $removeDays = 7; // DIAS PARA REMOVER NOTIFICACIONES LEIDAS 
    
    /**
     * Inicializa el bot y sus funciones
     */
    function __construct()
    {
        parent::__construct();
        $this->session = $this->getSession();
    }
}