<?php defined('SUPERNATURAL') || exit;
/**
 *-------------------------------------------------------/
 * @file        bot.php                                  \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Se publican bots del día siguiente
 *
 */

// OBTIENE LA CONFIGURACIÓN DEL BOT
$config['bot'] = $db->query('SELECT `shouts_percent_day`, `shouts_percent_night` FROM `site_configuration` ORDER BY `id` DESC LIMIT 1')->fetch_assoc();
$config['bot']['sleep'] = 1; // SEGUNDOS DE PAUSA ENTRE CADA EJECUCIÓN
$config['bot']['simulation'] = false;

// INCLUIR REDIMENSIONADOR
require BG_DIR . 'modules' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'images.class.php';

// INICIALIZAR REDIMENSIONADOR
$cImage = new Images();

// OBTIENE CANTIDAD DE SHOUTS QUE DEBEN PUBLICARSE
$query1 = $db->query('SELECT SUM(`bot`) FROM `members` WHERE `bot` > 0');
$totalBots = $query1->fetch_row() [0];
// OBTIENE TODOS LOS BOTS QUE PUBLICAN SHOUTS
$bots = $db->query('SELECT `member_id`, `name`, `bot`  FROM `members` WHERE `bot` > 0');
// CANTIDAD DE BOTS OBTENIDOS
// $totalBots = $bots->num_rows;
// PORCENTAJE DE BOTS QUE PUBLICARÁN
$botsCount = round($totalBots * $config['bot']['shouts_percent_day'] / 100);
// PORCENTAJE DE BOTS QUE PUBLICARÁN DE NOCHE
$botsCountNight = 100 - $config['bot']['shouts_percent_night'];
/** CONFIGURACION DIURNA **/
$day['botsCount'] = round($botsCount * $botsCountNight / 100); // PORCENTAJE DE BOTS QUE PUBLICARÁN DE DÍA $botsCount Y NOCHE ($botsCountNight)
$day['botsPerHour'] = round($day['botsCount'] / 17, 0, PHP_ROUND_HALF_DOWN); // CANTIDAD DE SHOUTS QUE SE PUBLICAN CADA HORA DURANTE LAS 18-1 HORAS DIURNAS
$day['botsEveryMinute'] = 60 / $day['botsPerHour']; // CADA CUANTOS MINUTOS PUBLICAR
$day['botsEverySeconds'] = round($day['botsEveryMinute']) * 60; // CADA CUANTOS SEGUNDOS
$day['lastDate'] = strtotime(date('d-m-Y', strtotime(date('d-m-Y').'+ 1 days')) . ' 05:01:02') - $day['botsEverySeconds']; // FECHA INICIAL DE PUBLICACIÓN DIURNA (CADA CUANTO PUBLICA MENOS LA PRIMERA PUBLICACION)
// HORARIO DIARIO DE LOS SHOUTS
$day['schedules'] = '<strong>Horario diurno</strong>: cada ' . ($day['botsEveryMinute'] - 2) . '-' . ($day['botsEveryMinute'] + 2) . ' minutos<br/>';
/** CONFIGURACION NOCTURNA **/
$night['botsCount'] = $botsCount - $day['botsCount']; // PORCENTAJE DE BOTS QUE PUBLICARÁN DE MADRUGADA
$night['botsPerHour'] = round($night['botsCount'] / 5, 0, PHP_ROUND_HALF_DOWN); //  CANTIDAD DE SHOUTS QUE SE PUBLICAN CADA HORA DURANTE LAS 5-1 HORAS NOCTURNAS
$night['botsEveryMinute'] = 60 / $night['botsPerHour']; // CADA CUANTOS MINUTOS PUBLICAR
$night['botsEverySeconds'] = round($night['botsEveryMinute']) * 60; // CADA CUANTOS SEGUNDOS PUBLICAR
$night['lastDate'] = strtotime(date('d-m-Y', strtotime(date('d-m-Y').'+ 1 days')) . ' 00:01:02') - $night['botsEverySeconds']; // FECHA INICIAL DE PUBLICACIÓN NOCTURNA (CADA CUANTO PUBLICA MENOS LA PRIMERA PUBLICACION)
$night['schedules'] = '<strong>Horario nocturno</strong>: cada ' . ($night['botsEveryMinute'] - 1) . '-' . ($night['botsEveryMinute'] + 3) . ' minutos<br/>'; // HORARIO NOCTURNO DE LOS SHOUTS
$html = 'De d&iacute;a (17 horas) se publicar&aacute;n ' . $day['botsCount'] . ', ' . $day['botsPerHour'] . ' cada hora. 1 cada ' . $day['botsEveryMinute'] . ' minutos (' . $day['botsEverySeconds'] . ' segundos)<br/>';
$html .= 'De noche (7 horas) se publicar&aacute;n ' . $night['botsCount'] . ', ' . $night['botsPerHour'] . ' cada hora. 1 cada ' . $night['botsEveryMinute'] . ' minutos (' . $night['botsEverySeconds'] . ' segundos)<br/>';
$html .= $day['schedules'] . $night['schedules'];
// CONVERTIR DATOS MYSQL EN ARRAY
// for ($allShouts = array(); $row = $bots->fetch_assoc(); $allShouts[] = $row);
$allShouts = array();
while ($row = $bots->fetch_assoc())
{
	// BUCLE PARA PUBLICAR TANTOS SHOUTS COMO SE HAYAN INDICADO EN LA ADMIN
	for ($i = 0; $i < $row['bot']; ++$i)
	{
		$allShouts[] = $row;
	}
}
// OBTENER BOTS ALEATORIOS (CANTIDAD DE PORCENTAJE ESPECIFICADA)
$randShouts = array_rand($allShouts, $botsCount);
// ALEATORIZAR MÁS
shuffle($randShouts);
// RELLENAR ARRAY ALEATORIO CON DATOS DE BOTS
$shouts = array();
foreach($randShouts as $key)
{
	$shouts[] = $allShouts[$key];
}
// ELIMINAR ARRAY DE TODOS LOS SHOUTS
unset($allShouts);
// PREDEFINIR VARIABLES
$e = 0; // ERRORES
$n = 0; // NOTIFICACIONES REGISTRADAS
$s = 0; // SHOUTS PUBLICADOS
$sd = 0; // SHOUTS PUBLICADOS DE DÍA
$sn = 0; // SHOUTS PUBLICADOS DE NOCHE
$bi = array(); // BOTS SIN IMAGENES
// RECORREMOS LOS BOTS
foreach($shouts as $key => $bot)
{
	// NOMBRE DEL BOT
	$shout['name'] = $bot['name'];
	// OBTENER IMAGEN DEL SHOUT
	$shout['image'] = getShoutImage($bot, $cImage);
	// COMPROBAR QUE HAYA IMAGENES
	if ($shout['image'] != false)
	{
		/** PREPARAR DATOS **/
		$shout['member'] = $bot['member_id'];
		/**
		 * ESTABLECER FECHA
		 *
		 * PRIMERO DE DIA Y LUEGO DE NOCHE
		 *
		 */
		if ($s <= $day['botsCount'])
		{
			// GENERAR SI SE SUMA O SE RESTAN MINUTOS
			$shout['minutes'] = mt_rand(($day['botsEverySeconds'] - (60*2)) , ($day['botsEverySeconds'] + (60*2)));
			// FECHA DEL SHOUT (MÍNIMO 2 MINUTOS ANTES Y MÁXIMO 2 MINUTOS DESPUÉS DEL ANTERIOR)
			$shout['date'] = $day['lastDate'] + $shout['minutes'];
			// ELIMINAR VARIABLE
			unset($day['lastDate']);
			// FECHA DEL ULTIMO SHOUT
			$day['lastDate'] = $shout['date'];
			// INDICAR HORARIO EN HTML
			$day['schedules'] .= ($s + 1) . '. ' . $bot['name'] . ': ' . date('d-m-Y H:i', $shout['date']) . ' ('.$shout['image'].') <br/>';
			// INCREMENTAR BOTS PUBLICADOS DE DÍA
			++$sd;
		}
		else
		{
			// MINUTOS ALEATORIOS
			$shout['minutes'] = mt_rand($night['botsEverySeconds'] - (60*3), ($night['botsEverySeconds'] + (60*3)));
			// FECHA DEL SHOUT (MÍNIMO 1 MINUTO ANTES Y MÁXIMO 3 MINUTOS DESPUÉS DEL ANTERIOR)
			$shout['date'] = $night['lastDate'] + $shout['minutes'];
			// ELIMINAR VARIABLE
			unset($night['lastDate']);
			// FECHA DEL ULTIMO SHOUT
			$night['lastDate'] = $shout['date'];
			// INDICAR HORARIO EN HTML
			$night['schedules'].= ($s + 1) . '. ' . $bot['name'] . ': ' . date('d-m-Y H:i', $shout['date']) . '<br/>';
			// INCREMENTAR BOTS PUBLICADOS DE NOCHE
			++$sn;
		}
		if($config['bot']['simulation'] == false)
		{
			// INSERTAR SHOUT
			$query = $db->query('INSERT INTO `shouts` (`member`, `images`, `date`, `bot`) VALUES (\'' . $shout['member'] . '\', \'' . $db->real_escape_string($shout['image']) . '\', \'' . $shout['date'] . '\', \'1\') ');
			$shout['id'] = $db->insert_id;
			// COMPROBAR SI SE HA INSERTADO
			if ($query == true && $shout['id'] > 0)
			{
				// INCREMENTAR SHOUTS PUBLICADOS
				++$s;
				// OBTENER LISTA DE SEGUIDORES
				$query2 = $db->query('SELECT `follow_from` FROM `members_follows` WHERE `follow_to` = \'' . $shout['member'] . '\' ');
				// SI TIENE SEGUIDORES
				if ($query2->num_rows > 0)
				{
					// NOTIFICAR A SEGUIDORES
					while ($follower = $query2->fetch_assoc())
					{
						// GENERAR CONTENIDO HTML
						$content = '';
						// INSERTAR NOTIFICACIÓN
						$query = $db->query('INSERT INTO `members_notifications` (`to_member`, `from_member`, `not_key`, `item_id`, `subitem_id`, `content`, `sent_time`) VALUES (\'' . $follower['follow_from'] . '\', \'' . $shout['member'] . '\', \'newShout\', \'' . $shout['id'] . '\', \'0\', \'' . $db->real_escape_string($content) . '\', \'' . $shout['date'] . '\') ');
						if ($query == true)
						{
							// INCREMENTAR NOTIFICADOS
							++$n;
						}
					}
				}
			}
			else
			{
				// SI HAY UN ERROR
				++$e;
			}

			// PAUSAR 1 SEGUNDO
			sleep($config['bot']['sleep']);
		}
		else
		{
			// SIMULA QUE SE HA PUBLICADO
			++$s;
		}
		
	}
	else
	{
		// AÑADIR BOT A BOTS SIN IMAGENES
		$bi[] = $shout['name'];
	}
	// ELIMINAR VARIABLE
	unset($shout);
}
