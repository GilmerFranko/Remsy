<?php defined('SUPERNATURAL') || exit;
/**
 *-------------------------------------------------------/
 * @file        includes\libray\date.class.php           \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Esta clase se encarga de manejar errores de todo tipo
 *
 *
 */

class Errors
{
	public $codError =
	array(
		'error.no_defined'    => 'Error no identificado.',
		'bd-conection'        => 'Error en la conexión con la Bases de datos.',
		'bd-syntax'           => 'Algo está equivocado en su sintaxis.',
		'bd-syntax.where'     => 'Ha habido un problema en la sintaxis SQL: La clausula WHERE no es correcta o esta vacia.',
		'bd-syntax.no_arrows' => 'La consulta no ha devuelto ningun resultado.',
		'argument.invalid'    => 'El tipo de dato pasado como parametro no coincide con el esperado',
	);
	public $message  = '';
	public $errors    = [];
	public $nivel    = 1;


	public function __construct()
	{

	}

	public function setError(String $error, $line, $file, $set = true)
	{
		/**
		 * Comprueba si existe el parametro registrado
		 */
		if(isset($codError[$error]) AND !empty($codError[$error]))
		{
			$this->errors[] = array($this->codError[$error], $line, $file, $error);
			if($set)
			{
				$this->regError();
			}
		}
		/**
		 * Si el error no fue identificado
		 */
		else
		{
			$this->errors[] = array($this->codError['error.no_defined'], $line, $file, $error);
		}

	}

	public function regError()
	{
		/*Registra en la bases de datos el error, la linea en donde ocurrio el error, el archivo, la fecha hora, ip, envia email*/
		//Core::model('extra', 'core')->setToast($this->errors);
		echo($this->errors[0][0] . ' Numero de linea: <strong>' . $this->errors[0][1] . '</strong>. Codigo de error: <strong>' . $this->errors[0][3]) . '</strong>. En el archivo ' . $this->errors[0][2];
	}

	public function getError()
	{

	}

}
