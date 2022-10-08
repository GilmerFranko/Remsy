<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\core\model\extra.class.php       \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo incluye funciones variadas con utilización frecuente
 * 
 * NOTA: ESTA CLASE NO ES UNICA; SE PARTICIONARÁ
*/

class Extra extends Model
{

	public function __construct()
	{
		parent::__construct();
		$this->session = Core::model('session', 'core');
		$this->session->platform = $this->getPlatform();

		/*if(count($_SESSION) > 1):

			if($_SESSION['lastUrl'][1] != $this->getCurrentUrl()) $_SESSION['lastUrl'][] = $this->getCurrentUrl();

			if(count($_SESSION['lastUrl'])>1 AND $_SESSION['lastUrl'][1] != $this->getCurrentUrl()) array_shift($_SESSION['lastUrl']);

		endif;

		if(count($_SESSION['lastUrl'])>2) array_shift($_SESSION['lastUrl']);*/
	}


  /**
   * Muestra un mensaje informativo TOAST MATERIALIZECSS
   */
  public function getToast($messages = array())
  {
  	$messages = !empty($messages) ? $messages : (isset($_SESSION['message']) ? $_SESSION['message'] : '');

  	if(!empty($messages)){
  		$html = '<script>window.onload = function() {';
  		foreach ($messages as $key => $msg) {
  			if(!empty($msg[0])){
  				$html .= "M.toast({html: '".$msg[0]."'}); ";
  			}
  		}
  		$html .= '};</script>';

  		unset($_SESSION['message']);

  		return $html;
  	}

  	return '';
  }


  function setToast($message = array())
  {
  	/* Eliminar vacios */
  	$message = array_filter($message);

  	if( !empty($message) )
  	{
  		/* Ordenar array */
  		sort($message);

  		/* Establece el mensaje en la sesión */
  		$_SESSION['message'][] = $message;

  		return true;
  	}

  	return false;
  }


    /**
     * Obtiene y retorna el valor de un input
     */
    function getInputValue($name = null, $type = 'post', $alt = null)
    {
        // VALOR PREDETERMINADO
    	$value = $alt;
        // SI HAY CONTENIDO EN FORMULARIO
    	if( ($type == 'post' || $type = 'both') && isset($_POST[$name]) )
    	{
    		$value = $_POST[$name];
    	}
        // SI HAY CONTENIDO EN PARÁMETROS URL
    	if( ($type == 'get' || $type = 'both') && isset($_GET[$name]) )
    	{
    		$value = $_GET[$name];
    	}
        //
    	return htmlspecialchars($value);
    }
    
    /**
     * Genera un enlace
     */
    function generateUrl($app = NULL, $section = NULL, $area = NULL, $params = NULL, $redirect = false)
    {
    	$url  = $this->config['base_url'] . '/index.php?app=';
    	$url .= (isset($app) ? $app : 'core') . '&section=';
    	$url .= isset($section) ? $section : 'index';
    	$url .= isset($area) ? '&area=' . $area : '';
        //
    	if(isset($params) && is_array($params))
    	{
    		foreach($params as $key => $val)
    		{
    			$url .= '&' . $key . '=' . $val;
    		}
    	}
        //
    	if($redirect == true)
    	{
    		$this->redirectTo($url);
    	}
        //
    	return $url;
    }
    
    /**
     * Genera un identificador único
     */
    function generateUUID($length = 28)
    {
    	$key = substr(md5(uniqid(true) . microtime()), 0, $length);
        //
    	return $key;
    }
    
    /**
     * Limpia una cadena de caracteres
     */
    function cleanVar($var)
    {
    	if( is_numeric($var) || ctype_digit($var) )
    	{
    		$var = (int)$var;
    	}
        //
        //filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        //
    	$var = htmlspecialchars($var);
        //
    	return $var;
    }

    /**
     * Controla el flood
     * 
     * @param 
     * @return string | boolean
     */
    public function antiFlood($type = 'general', $msg = '', $print = true, $flood = 5)
    {
        // SI SOY MOD/ADMIN NO TENGO ANTIFLOOD
    	if($this->session->is_admod == true)
    	{
    		return true;
    	}

        // REDECLARAR VARIABLE
    	$_SESSION['flood'][$type] = isset($_SESSION['flood'][$type]) ? $_SESSION['flood'][$type] : time()-$flood;
        // TIEMPO ACTUAL
    	$now = time();
        // MENSAJE DE FLOOD
    	$msg = empty($msg) ? 'No puedes realizar tantas acciones en tan poco tiempo.' : $msg;
        // TIEMPO TRANSCURRIDO
    	$transcurrido = $now - $_SESSION['flood'][$type];
        // TIEMPO RESTANTE
    	$restante = $flood - $transcurrido;
        // COMPROBAR FLOOD
    	if($transcurrido < $flood)
    	{
    		$msg = '0: '.$msg.': '.$restante.' segundos.';
            // TERMINAR O RETORNAR VALOR
    		if($print) die($msg);
    		else return $restante;
    	}
    	else
    	{
            // ACTUALIZAR ANTIFLOOD
    		if(empty($_SESSION['flood'][$type])) {
    			$_SESSION['flood'][$type] = time();
    		} else $_SESSION['flood'][$type] = $now;

            // TODO BIEN
    		return true;
    	}
    }
    
    /**
     * Se establece el nivel de acceso a la página | MIEMBROS o VISITANTES
	*/
    function setLevel($level = 0, $message = false, $redirTo = null)
    {
    	if( is_string($level) )
    	{
    		if( $this->session->isAllowed($level) === true) return true;
    		else
    		{
    			if( empty($message) ) $message = 'No tienes permisos para acceder aqu&iacute;.';
    		}
    	}
		// CUALQUIERA
    	if($level == 0) return true;
		// SÓLO VISITANTES
    	elseif($level == 1)
    	{
            //var_dump($this->memberData); exit;
    		if($this->session->is_member == false) return true;
    		else
    		{
    			if( isset($redirTo) ) $this->redirectTo('/');
    			if( empty($message) ) $message = 'Esta p&aacute;gina s&oacute;lo puede ser vista por visitantes.';
    		}
    	}
		// SÓLO MIEMBROS
    	elseif($level == 2)
    	{
    		if($this->session->is_member == true) return true;
    		else
    		{
    			if( isset($redirTo) ) $this->redirectTo($this->generateUrl('members', 'login', NULL, array('r' => $this->getCurrentUrl())));
    			if( empty($message) ) $message = 'Para poder ver esta p&aacute;gina debes identificarte.';
    		}
    	}
		// SÓLO MODERADORES Y ADMINISTRADORES
    	elseif($level == 3)
    	{
    		if($this->session->is_admod) return true;
    		else
    		{
    			if( isset($redirTo) ) $this->redirectTo('/');
    			if( isset($message) ) $message = 'Est&aacute;s en un &aacute;rea restringida s&oacute;lo para moderadores.';
    		}
    	}
		// SÓLO ADMINISTRADORES
    	elseif($level == 4)
    	{
    		if($this->session->is_admod == 1) return true;
    		else
    		{
    			if( isset($redirTo) ) $this->redirectTo('/');
    			if( isset($message) ) $message = 'Est&aacute;s intentando algo no permitido.';
    		}
    	}
    	else
    	{
    		$message = 'Error desconocido';
    	}
		//
    	return array('title' => 'Error', 'message' => $message);
    }
    
    /**
     * Redireccionar a un enlace
     */
    function redirectTo($url)
    {
    	$url = urldecode($url);
    	if(isset($_POST['ajax']) || isset($_GET['page'])) {
    		echo "0: Redirigiendo... <script>window.location.href = '$url'</script>";
    	} else {
    		header("Location: $url");
    	}
    	exit;
    }
    

    /**
     * Devuelve el enlace de la página actual
     * 
     * @return string
     */
    function getCurrentUrl($encode = true)
    {
    	$current_url_domain = $_SERVER['HTTP_HOST'];
    	$current_url_path = $_SERVER['REQUEST_URI'];
    	$current_url_querystring = $_SERVER['QUERY_STRING'];
    	$current_url = "http://".$current_url_domain.$current_url_path;
    	$current_url = isset($encdode) ? urlencode($current_url) : $current_url;
        //
    	return $current_url;
    }
    
    /**
     * Retorna la estructura generada para una consulta con varias columnas
	 */
    function getIUP($array, $prefix = '', $type = 'update'){
        //unset($array['ajax']);
		// NOMBRE DE LOS CAMPOS
    	$fields = array_keys($array);
		// VALOR PARA LAS TABLAS
    	$values = array_values($array);
		// DÍGITOS Y CARACTERES
    	foreach($values as $i => $val)
    	{
    		if($type === 'update')
    		{
    			if(!is_numeric($val)) $sets[$i] = $prefix.$fields[$i] . " = '" . $this->db->real_escape_string($val) . "'";
    			else $sets[$i] = $prefix.$fields[$i] . " = '" . $val . "'";
    		}
    		else
    		{
    			$sets[$i] = " '" . $this->db->real_escape_string($val) . "'";
            //if(!is_numeric($val)) $sets[$i] = " '" . $this->db->real_escape_string($val) . "'";
			//else $sets[$i] = ' '.$val;
    		}
    	}
        //
    	$values = implode(', ', $sets);
		//
    	return $values;
    }
    

    function getIp()
    {
    	return isset($_SERVER['X_FORWARDED_FOR']) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    }
    
    function checkLoad()
    {
    	if( empty($this->config['id']) )
    	{
    		if($this->session->isAllowed('admin'))
    		{
                // MENSAJE DE ADVERTENCIA
    			echo '<h1 style="color: red;">No se ha podido cargar la configuraci&oacute;n, por lo que debe crear una nueva</h1>';
                // INCLUYE EL ÁREA DE CONFIGURACIÓN
    			require Core::view('configuration.area', 'admin');
    			exit;
    		}
    		else
    		{
    			die('No se ha podido cargar la configuraci&ocaute;n del sitio. Contacte con el administrador.');
    		}
    	}
    	elseif($this->config['maintenance'] === '1' && $this->session->isAllowed('maintenance') === false)
    	{
    		$config = $this->config;
    		$message[0] = 'Sitio web en mantenimiento';
            //
    		require BG_TEMPLATES . 'error' . DS . '503.php';
    		exit;
    	}
    }
    
    /**
     * Aplica texto resaltado en el contenido de una variable
     */
    function getHighlight($what = null, $where = null)
    {
    	if( !empty($what) && !empty($where) )
    	{
            // HTML RESALTADO
    		$highlight = '<span class="yellow accent-2">'.$what.'</span>';
            // RETORNAR STRING RESALTADO
    		return str_ireplace($what, $highlight, $where);
    	}
        // RETORNAR LO TRAIDO
    	return $where;
    }

    /** OBTIENE LA PLATAFORMA ACTUAL **/

    public function getPlatform()
    {
    	if(isset($_SESSION['platform']))
    	{
    		return $_SESSION['platform'];
    	}

        // SI ESTOY EN LA APP
    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'link de app')
    	{
    		$platform = 'app';
    	}
        // SI ESTOY EN NAVEGADOR MOVIL
    	elseif($this->isMobile() == true)
    	{
    		$platform = 'mobile';
    	}
        // SI ESTOY EN ANDROID
    	elseif(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'android') !== false)
    	{
    		$platform = 'android';
    	}
        // SI ESTOY EN PC
    	else
    	{
    		$platform = 'pc';
    	}

        // ESTABLECER SESION (evitar sobrecargas)
    	$_SESSION['platform'] = $platform;
        // RETORNAR RESULTADO
    	return $platform;
    }

    /**
     * Comprueba si es movil
     */
    public function isMobile()
    {
    	if(isset($_SESSION['mobile']))
    	{
    		return $_SESSION['mobile'];
    	}

    	$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
        // POSIBLES
    	$mobiles = array(
    		'midp',
    		'240x320',
    		'blackberry',
    		'netfront',
    		'nokia',
    		'panasonic',
    		'portalmmm',
    		'sharp',
    		'sie-',
    		'sonyericsson',
    		'symbian',
    		'windows ce',
    		'windows phone',
    		'benq',
    		'mda',
    		'mot-',
    		'opera mini',
    		'philips',
    		'pocket pc',
    		'sagem',
    		'samsung',
    		'sda',
    		'sgh-',
    		'vodafone',
    		'xda',
    		'iphone',
    		'android'
    	);

    	foreach($mobiles as $mobile)
    	{
            if( strpos($userAgent, $mobile) ) //strstr
            {
            	$_SESSION['mobile'] = true;
            	return true;
            }
          }
        // NO ES MOVIL
          $_SESSION['mobile'] = false;
          return false;
        }

    /**
    * Corta un texto x caracteres
    *
    * @param string #texto a cortar
    * @param int #logitud a cortar
    * @return string
    */
    public function curtText($input = null, $limit = 128)
    {

    	if(strlen($input) > $limit)
    	{
    		$input=substr($input, 0, $limit);
    		$input = $input . "...";
    		return $input;
    	}
    	else
    	{
    		return $input;
    	}
    }
    /**
    * Devuelve la primera imagen\iframe\video de un html o la url de este
    *
    * @param string #html
    * @param boolean
    * @return <img>
    */
    public function getFirstImgHtml($html = null, $returnUrl = false)
    {

    	$doc    =   new DOMDocument();
    	@$doc->loadHTML($html);


    	$imgs = $doc->getElementsByTagName('img');
    	$iframes = $doc->getElementsByTagName('iframe');
    	$video = $doc->getElementsByTagName('video');

    	if(isset($imgs) AND !empty($imgs) AND count($imgs) > 0):
    		if($returnUrl)
    		{
    			return $imgs->item(0)->getAttribute('src');
    		}
    		else
    		{
    			return '<img src="'. $imgs->item(0)->getAttribute("src") .'" style="filter: opacity(0);">';
    		}

        //
    	elseif(isset($iframes) AND !empty($iframes) AND count($iframes) > 0):

    		if($returnUrl)
    		{
    			return $iframes->item(0)->getAttribute("src");
    		}
    		else
    		{

    			return '<iframe src="'. $iframes->item(0)->getAttribute("src") .'"></iframe>';
    		}

    	else:

    		return '';

    	endif;
    }
    /**
    * devuelve la ultima url
    *
    * @param string (url)
    */
    public function getLastUrl()
    {
      // DEVUELVE EL PRIMER ELEMENTO DEL ARRAY Y LO ELIMINA
    	$last = $_SESSION['lastUrl'][0];
    	return $last;
    }
  }
