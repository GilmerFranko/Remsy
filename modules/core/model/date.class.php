<?php
defined('SUPERNATURAL') || exit;
/**
 *-------------------------------------------------------/
 * @file        includes\libray\date.class.php           \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Esta clase formatea las fechas
 *
 *
 */
class Date

// extends Model

{
	public function __construct()

	{
		// parent::__construct();
		// $this->session = Core::model('session', 'core');
	}
	function getDate($content = null)
	{
		$days = array(
			'Domingo',
			'Lunes',
			'Martes',
			'Mi&eacute;rcoles',
			'Jueves',
			'Viernes',
			'S&aacute;bado'
		);
		$months = array(
			1 => 'Enero',
			'Febrero',
			'Marzo',
			'Abril',
			'Mayo',
			'Junio',
			'Julio',
			'Agosto',
			'Septiembre',
			'Octubre',
			'Noviembre',
			'Diciembre'
		);
		$text = $days[date('w', $content) ] . ', ' . date('d', $content) . ' de ' . $months[date('n', $content) ] . ' del ' . date('Y', $content);
		return $text;
	}

	/**
	 * Formatea una fecha legible por humanos (v2)
	 *
	 * @param int $date
	 * @param boolean $format
	 * @return string
	 */
	function getTimeAgo($datetime = '', $full = false)
	{
		$now = new DateTime;
		$ago = new DateTime;
		$ago->setTimestamp($datetime);
		$diff = $now->diff($ago);
		$diff->w = floor($diff->d / 7);
		$diff->d-= $diff->w * 7;
		$string = array(
			'y' => 'a&ntilde;o',
			'm' => 'mes',
			'w' => 'semana',
			'd' => 'dia',
			'h' => 'hora',
			'i' => 'minuto',
			's' => 'segundo',
		);
		foreach($string as $k => & $v)
		{
			if ($diff->$k)
			{
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			}
			else
			{
				unset($string[$k]);
			}
		}
		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? ($ago > $now ? 'Dentro de ' : 'Hace ') . implode(', ', $string) : 'Hace unos segundos';
	}

	function getTime($select = null, $seconds = null)
  {
    // Transforma de segundos a Minutos y Horas
    $seconds = ($seconds == null) ? time() : $seconds;
    $hours = floor($seconds/ 3600);
    $minutes = floor(($seconds - ($hours * 3600)) / 60);
    $seconds = $seconds - ($hours * 3600) - ($minutes * 60);

    // Tranforma a string y formatea
    $seconds = (strlen($seconds) == 1) ? '0' . $seconds : $seconds;
    $minutes = (strlen($minutes) == 1) ? '0' . $minutes : $minutes;

    $params = array('h' => $hours, 'm' => $minutes, 's' => $seconds);
    $result = '';
    for($i=0;$i<strlen($select);$i++)
    {
      if(isset($params[$select[$i]]))
      {
        $result .= $params[$select[$i]];
      }
      else
      {
        $result .= $select[$i];
      }

    }
    return $result;
  }

	/**
	 * Formatea una fecha legible por humanos
	 *
	 * @param int $date
	 * @param boolean $format
	 * @return string
	 */
	/*function time_elapsed_string($date, $format = false)
	{
		$_meses = array(
			'',
			'enero',
			'febrero',
			'marzo',
			'abril',
			'mayo',
			'junio',
			'julio',
			'agosto',
			'septiembre',
			'octubre',
			'noviembre',
			'diciembre'
		);
		$_dias = array(
			'Domingo',
			'Lunes',
			'Martes',
			'Miercoles',
			'Jueves',
			'Viernes',
			'Sabado'
		);
		// FORMATO?
		if ($format != false)
		{
			// VARS
			$dia = date('d', $date);
			$mes = date('m', $date);
			$mes_int = date('n', $date);
			$ano = date('Y', $date);
			// PARSE
			switch ($format)
			{
				// 29 de Septiembre de 2010
			case 'd_Ms_a':
				$e_ano = date("Y", time());
				$ano = ($e_ano == $ano) ? '' : ' de ' . $ano;
				$return = $dia . ' de ' . $_meses[$mes_int] . $ano;
				break;
			}
			// REGRESAMOS
			return $return;
		}
		else
		{
			$ahora = time();
			$tiempo = $ahora - $date;
			//
			$dias = round($tiempo / 86400);
			// HOY
			if ($dias <= 0)
			{
				// HACE MENOS DE 1 HORA
				if (round($tiempo / 3600) <= 0)
				{
					// HACE MENOS DE 1 MINUTO
					if (round($tiempo / 60) <= 0)
					{
						if ($tiempo <= 60)
						{
							$hace = "Hace unos segundos";
						}
						// HACE X MINUTOS
					}
					else
					{
						$can = round($tiempo / 60);
						if ($can <= 1)
						{
							$word = "minuto";
						}
						else
						{
							$word = "minutos";
						}
						$hace = 'Hace ' . $can . " " . $word;
					}
					// HACE X HORAS
				}
				else
				{
					$can = round($tiempo / 3600);
					if ($can <= 1)
					{
						$word = "hora";
					}
					else
					{
						$word = "horas";
					}
					$hace = 'Hace ' . $can . " " . $word;
				}
			}
			// MENOS DE 7 DIAS
			else if ($dias <= 7)
			{
				// AYER
				if ($dias < 2)
				{
					$hace = 'Ayer a las ' . date("H", $date) . ":" . date("i", $date);
					// HACE MENOS DE 5 DIAS
				}
				else
				{
					$hace = 'El ' . $_dias[date("w", $date) ] . ' a las ' . date("H", $date) . ":" . date("i", $date);
				}
				// HACE MAS DE UNA SEMANA
			}
			else
			{
				$hace = "El " . date("d", $date) . " de " . $_meses[date("n", $date) ] . " a las " . date("H", $date) . ":" . date("i", $date);
			}
			//
			return $hace;
		}
	}*/
	/** FIN CLASE **/
}
