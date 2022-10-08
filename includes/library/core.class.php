<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        core.class.php                           \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo ayudará a cargar archivos y evitar algunas lineas de código
 *
 *
*/

final class Core
{
    /**
     * Módulo actual
     * 
     * @var string
     */
    public static $sModule = 'core';
    
    /**
     * Sección actual
     * 
     * @var string
     */
    public static $sSection = 'posts';
    
    /**
     * Config
     * 
     * @var array
     */
    private static $aConfig = array();
    
    /**
     * Modelos cargados
     * 
     * @var objects
     */
    public static $oModels = array();
    

    /**
     * Establecer módulo
     */
    public static function setModule($sModule, $sSection, $config)
    {
        self::$sModule = $sModule;
        //
        self::$sSection = $sSection;
        //
        self::$aConfig = $config;
    }

    /**
     * Cargar controlador
     */
    public static function controller($sController = 'index', $sModule = '')
    {
        $sFile = BG_MODS . ( !empty($sModule) ? $sModule : self::$sModule ) . DS . 'controller' . DS . $sController . '.php';
        
        return self::file($sFile);
    }
    
    /**
     * Cargar modelo
     */
    public static function model($sModel, $sModule = '')
    {
        $sFile = self::file(BG_MODS . (($sModule) ? $sModule : self::$sModule) . DS . 'model' . DS . $sModel . '.class.php');
        
        if($sFile)
        {
        		/* Guarda el hash del archivo */
            $sHash = md5($sModel);

            /**
             * Si ya se ha incluido con anterioridad este modelo, retorna la
             * instancia de la clase pre-almacenada para ahorrar recursos.
             */
            if(isset(self::$oModels[$sHash]))
            {
                return self::$oModels[$sHash];
            }
            
            /* Incluye el archivo */
            require $sFile;

            /* Instancía la clase */
            self::$oModels[$sHash] = new $sModel();
            
            /**
            * Guardar en la sesion los
            * modelos utilizados por cada carga.
            * Solo en modo debug
            **/
            if(isset($_SESSION['debug_mode']) AND $_SESSION['debug_mode'])
            {
            	$_SESSION['models_used'][] = ($sModel);
            }

            /* Retornar Modelo */
            return self::$oModels[$sHash];
        }
    }
    /**
     * Cargar plantilla
     */
    public static function view($sTemplate, $sModule = '', $alternative = false)
    {
        $sFile = BG_MODS . (($sModule) ? $sModule : self::$sModule) . DS . 'view' . DS . $sTemplate . '.html.php';
        
        return self::file($sFile, $alternative);
    }
    
    /**
     * Cargar Archivo
     */
    public static function file($sFile, $alternative = false)
    {
        if(file_exists($sFile))
        {
            return $sFile;
        }
        else
        {
            if($alternative == false)
            {
                echo 'Lo sentimos el archivo <strong>'.$sFile.'</strong> no fue localizado.';
                exit;
            }
            else
            {
                $alternative = is_string($alternative) ? $alternative : 'index';
                $section = isset($_GET['section']) ? stripslashes($_GET['section']) : 'index';
                //
                return self::view($alternative, '', $section);
            }
        }

        return false;
    }
    
    /**
     * Configs
     */
    public static function config($sName)
    {
        if(isset(self::$aConfig[$sName]))
        {
            return self::$aConfig[$sName];
        }
        
        exit('Falta la variable: ' . $sName);
    }
}
