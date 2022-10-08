<?php defined('SUPERNATURAL') || exit;

/**
 * @file        autoload_tables_model.class.php
 * @package     One V
 * @author      Gilmer <gilmerfranko@hotmail.com>
 * @copyright   (c) 2020 Gilmer Franco
 *
 * @Description Este modelo se encarga de cargar las clases correspondientes a las tablas de la db
 *
 *
*/
Class LoadTable
{
	/**
   * Modelos cargados
   *
   * @var objects
   */
  public static $oModels = array();

	/**
	 * Cargar modelo de tabla
	 */
	public static function model($sModel)
	{

		$sFile = self::file(BG_MODT . $sModel . '.class.php');

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

      /* Retornar Modelo */
      return self::$oModels[$sHash];
    }
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
}
?>
