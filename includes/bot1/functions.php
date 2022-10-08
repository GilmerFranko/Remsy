<?php
defined('SUPERNATURAL') || exit;
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
 *
 */
/**
 * Copia una imagen aleatoria para el bot
 *
 * @param array $bot 		// DATOS DEL BOT
 * @param class $cImage 	// CLASE DE IMAGENES
 * @return string
 */
function getShoutImage($bot = null, $cImage = null)
{
	global $config;
	// NOMBRE DE LA IMAGEN
	$imgName = $bot['member_id'] . '-' . uniqid();
	// ORIGEN DE LA IMAGEN ORIGINAL
	$source = getRandomImage($bot);
	if ($source != false)
	{
		// DESTINO DE LA IMAGEN ORIGINAL
		$destination = BG_IMAGES . 'uploads' . DIRECTORY_SEPARATOR . 'shout' . DIRECTORY_SEPARATOR . $imgName . '.jpg';
		// DESTINO DE LA IMAGEN MINIATURA
		$destination_thumb = BG_IMAGES . 'uploads' . DIRECTORY_SEPARATOR . 'shout' . DIRECTORY_SEPARATOR . $imgName . '_thumb.jpg';
		// REDIMENSIONAR Y COMPRIMIR
		$cImage->resize($source, $destination_thumb, 80);
		// COPIAR IMAGEN ORIGINAL AL DIRECTORIO  DE SHOUTS
		if (copy($source, $destination))
		{
			// COMPROBAR SI NO ES UNA SIMULACION
			if ($config['bot']['simulation'] == false)
			{
				// ELIMINAR IMAGEN ORIGINAL
				unlink($source);
			}
		}
		else
		{
			return false;
		}
		// RETORNAR IMAGEN
		return $imgName;
	}
	return false;
}
/**
 * Obtiene una imagen aleatoria de bots
 *
 * @param array $bot 		// DATOS DEL BOT
 * @return string
 */
function getRandomImage($bot = null)
{
	$dir = BG_IMAGES . 'bots' . DIRECTORY_SEPARATOR . $bot['name'];
	// BUSCAR IMAGENES JPG O PNG
	$files = glob($dir . DIRECTORY_SEPARATOR . '*.{jpg,png,JPG,PNG}', GLOB_BRACE);
	if (!empty($files))
	{
		$file = array_rand($files);
		return $files[$file];
	}
	// SI NO HAY IMAGENES
	return false;
}

function deleteNotifications($days = 7)
{
	global $db;
	// GENERA TIMESTAMP DE LOS DIAS A ELIMINAR
	$time = time() - 60 * 60 * 24 * $days;
	// ELIMINAR NOTIFICACIONES
	$db->query('DELETE FROM `members_notifications` WHERE `sent_time` < ' . $time);
	// RETORNA CANTIDAD ELIMINADA
	return $db->affected_rows;
}
function deleteRecovers($days = 1)
{
	global $db, $config;
	// GENERA TIMESTAMP DE LOS DIAS A ELIMINAR
	$time = time() - 60 * 60 * 24 * $days;
	// ELIMINAR RECOVERS
	$db->query('DELETE FROM `site_recovers` WHERE `date` < ' . $time);
	// RETORNA CANTIDAD ELIMINADA
	return $db->affected_rows;
}

/**
 * Elimina las fotos regaladas
 *
 * @param NaN
 * @return boolean
 */
function deletePhotosGifts()
{
	global $db, $config;
	// OBTENER LAS IMAGENES QUE HAYAN EXPIRADO

	$photos = $db->query('SELECT `id`, `image` FROM `photos` WHERE `date_expires` < UNIX_TIMESTAMP()');
	// DIRECTORIO DE LAS IMAGENES
	$pathImages = BG_IMAGES . 'uploads' . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR;
	// RECORRER FOTOS PARA ELIMINARLAS DEL SERVIDOR
	while ($photo = $photos->fetch_assoc())
	{
		unlink($pathImages.$photo['image']);
	}

	// ELIMINARLAS DE LA BASE DE DATOS
	$db->query('DELETE FROM `photos` WHERE `date_expires` < UNIX_TIMESTAMP()');

	// RETORNA CANTIDAD ELIMINADA
	return $db->affected_rows;
}
/**
 * Elimina baneados
 *
 * @param int $days
 * @return boolean
 */
function deleteBanned($days = 30)
{
	global $db;
	// GENERA TIMESTAMP DE LOS DIAS A ELIMINAR
	$time = time() - 60 * 60 * 24 * $days;
	// PREDEFINIR CANTIDAD DE ELIMINADOS Y ERRORES
	$i = 0;
	$error = array();
	// OBTENER USUARIOS SUSPENDIDOS DE MÁS DE UN MES
	$members = $db->query('SELECT `member_id`, `group_id` FROM `members` WHERE `banned` > 0 && `banned` < ' . $time);

	// SI HAY DATOS PARA ELIMINAR
	if($members->num_rows > 0)
	{
		// RECORRER USUARIOS PARA ELIMINARLOS
		while ($member = $members->fetch_assoc())
		{
			// ELIMINACIONES
			$array = array(
				// COMENTARIOS
				'DELETE FROM `shouts_comments` WHERE `author_id` = \'' . $member['member_id'] . '\'',
				// DESCARGAS
				'DELETE FROM `shouts_downloads` WHERE `member` = \'' . $member['member_id'] . '\'',
				// COMPRAS
				'DELETE FROM `members_coins` WHERE `member` = \'' . $member['member_id'] . '\'',
				// ELIMINAR BLOQUEOS Y BLOQUEADOS
				'DELETE FROM `members_blocks` WHERE `block_from` = \'' . $member['member_id'] . '\' || `block_to` = \'' . $member['member_id'] . '\'',
				// ELIMINAR LIKES
				'DELETE FROM `shouts_likes` WHERE `member` = \'' . $member['member_id'] . '\'',
				// REPORTES
				'DELETE FROM `site_reports` WHERE `member` = \'' . $member['member_id'] . '\'',
				// NOTIFICACIONES
				'DELETE FROM `members_notifications` WHERE `to_member` = \'' . $member['member_id'] . '\' || `from_member` = \'' . $member['member_id'] . '\'',
				// SIGUIENDO Y SEGUIDORES
				'DELETE FROM `members_follows` WHERE `follow_from` = \'' . $member['member_id'] . '\' || `follow_to` = \'' . $member['member_id'] . '\'',
				// RECOVERS
				'DELETE FROM `site_recovers` WHERE `member_id` = \'' . $member['member_id'] . '\'',
				// PERFIL / CUENTA
				'DELETE FROM `members` WHERE `member_id` = \'' . $member['member_id'] . '\' LIMIT 1',
				// RESTAR USUARIO AL GRUPO
				'UPDATE `members_groups` SET `g_count_members` = `g_count_members` - 1 WHERE `g_id` = \'' . $member['group_id'] . '\' LIMIT 1'
			);
			// RECORRER CONSULTAS
			foreach($array as $sql)
			{
				// EJECUTAR CONSULTA
				if ($db->query($sql) == false)
				{
					$error[] = '<strong>SQL:</strong> ' . $sql . '. <strong>Error:</strong> ' . $db->error;
					break; // DEJAR DE EJECUTAR CONSULTAS
				}
			}
			// SI TODO HA IDO BIEN
			if (empty($error))
			{
				++$i;
			}
			else
			{
				// CONVERTIR ERRORES EN TEXTO
				$msg = 'Problema al eliminar usuario: <br/>';
				$msg.= implode('<br/>', $error);
				// SI ALGO FALLÓ, NOTIFICAR AL ADMIN
				$this->db->query('INSERT INTO `members_notifications` (`to_member`, `from_member`, `not_key`, `content`, `sent_time`) VALUES (\'1\', \'' . $member['member_id'] . '\', \'deleteAccount\', "' . $this->db->real_escape_string($msg) . '", UNIX_TIMESTAMP()) ');
			}
		}
	}
	

	// RETORNA CANTIDAD ELIMINADA
	return $i;
}
function deleteShouts($days = 7)
{
	global $db, $config;
	// PREDEFINIR VARIABLES
	$d = 0; // CANTIDAD DE SHOUTS ELIMINADOS
	$time = time() - 60 * 60 * 24 * $days; // GENERA TIMESTAMP DE LOS DIAS A ELIMINAR
	// OBTENER LOS SHOUTS DE MÁS DE 7 DÍAS
	$shouts = $db->query('SELECT `id`, `images`, `date`, `vip` FROM `shouts` WHERE `date` < ' . $time);
	// DIRECTORIO DE LAS IMAGENES
	$pathImages = BG_IMAGES . 'uploads' . DIRECTORY_SEPARATOR . 'shout' . DIRECTORY_SEPARATOR;
	// RECORRER SHOUTS PARA ELIMINAR LOS DE MÁS DE 7 DÍAS
	while ($shout = $shouts->fetch_assoc())
	{
		// ELIMINAR SOLO SI NO ES VIP O ES VIP Y TIENE MAS DE 365 DIAS
		if ($shout['vip'] == 0 || $shout['date'] < time() - 31536000)
		{
			// ELIMINAR SHOUTS
			$db->query('DELETE FROM `shouts` WHERE `id` = \'' . $shout['id'] . '\' LIMIT 1');
			// ELIMINAR COMENTARIOS DE SHOUTS
			$db->query('DELETE FROM `shouts_comments` WHERE `shout_id` = \'' . $shout['id'] . '\'');
			// ELIMINAR LIKES DE SHOUTS
			$db->query('DELETE FROM `shouts_likes` WHERE `obj` = \'' . $shout['id'] . '\'');
			// ELIMINAR DENUNCIAS DE SHOUTS
			$db->query('DELETE FROM `site_reports` WHERE `obj` = \'' . $shout['id'] . '\' && `type` = \'shout\'');
			// ELIMINAR NOTIFICACIONES
			$db->query('DELETE FROM `members_notifications` WHERE `item_id` = \'' . $shout['id'] . '\' && `not_key` = \'newShout\'');
			// ELIMINAR REGISTRO DE DESCARGAS
			$db->query('DELETE FROM `shouts_downloads` WHERE `shout` = \'' . $shout['id'] . '\'');
			// ELIMINAR IMAGENES DE SHOUTS
			if (!empty($shout['images']))
			{
				$shout['images'] = explode(',', $shout['images']);
				foreach($shout['images'] as $imgName)
				{
					// ELIMINAR IMAGEN
					unlink($pathImages . $imgName . '.jpg');
					// ELIMINAR MINIATURA
					unlink($pathImages . $imgName . '_thumb.jpg');
				}
			}
			// ELIMINAR VIDEO DE SHOUT
			if (!empty($shout['video']))
			{
				unlink($pathImages . $shout['video'] . '.mp4');
			}
			// PAUSAR 1 SEGUNDO
			sleep($config['bot']['sleep']);
			++$d;
		}
	}
	// RETORNAR CANTIDAD DE SHOUTS ELIMINADOS
	return $d;
}

/**
 * Envia los correos pendientes
 *
 * @return int
 */
function sendBulkemails($limit = 1, $sleep = 5)
{
	global $db;

	// OBTENER UN
    $query = $db->query('SELECT * FROM `site_bulk_emails` WHERE `date` > UNIX_TIMESTAMP() && `date_sent` = \'0\' LIMIT '.$limit);

    // SI HAY RESULTADOS
    if ($query == true && $query->num_rows > 0)
    {
    	// ASOCIAR DATOS
    	$bulkemail = $query->fetch_assoc();

        // ABRIR ARCHIVO
        $addressees = array_map('str_getcsv', file(BG_DIR . 'filestore' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'bulkemails' . DIRECTORY_SEPARATOR . $bulkemail['addressees_file']));

        // ORDENAR ID "<"
        asort($addressees);

        // PREDEFINE VARIABLES
        $i = 0;

        // BUCLE ENVIANDO CORREOS
        foreach ($addressees as $addressee)
        {
            // CONVERTIR VARIABLES DEL ASUNTO
            $bulkemail['subject'] = setVars($bulkemail['subject'], $addressee);
            // CONVERTIR VARIABLES DEL CONTENIDO
            $bulkemail['content'] = setVars($bulkemail['content'], $addressee);

            // ENVIAR EMAIL
            $email = sendEmail( $addressee[2], $bulkemail['subject'], $bulkemail['content']);

            // SI EL EMAIL SE ENVIÓ CORRECTAMENTE
            if($email == true)
            {
                ++$i;

                // PAUSA X SEGUNDOS CADA 1000 ENVÍOS
                if($i%1 == 0)
                {
                    sleep($sleep);
                }
            }
        }

        // ACTUALIZAR ESTADÍSTICAS
        $db->query('UPDATE `site_bulk_emails` SET `addressees_sent` = \''.$i.'\', `date_sent` = UNIX_TIMESTAMP() WHERE `id` = \''.$bulkemail['id'].'\' LIMIT 1');

        return $i;
    }

    return false;
}


	/**
	 * Convierte variables del asunto y contenido
     * 
     * @param string $string
     * @param string $addressee
     * @return string
     */
    function setVars($string = null, $addressee = null)
    {
    	// DEFINE CONFIGURACIÓN BÁSICA
		$config['base_url']     = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, -10);

        $string = str_ireplace(
            // VARIABLE ORIGINAL
            array(
                '{site_name}',
                '{site_url}',
                '{user_name}',
                '{user_id}',
            ),
            // VARIABLE CONVERTIDA
            array(
                'SUPERNATURAL',
                $config['base_url'],
                $addressee[1],
                $addressee[0],
            ),
            // TEXTO ORIGINAL
            $string
        );

        // RETORNAR TEXTO CONVERTIDO
        return $string;
    }


    /**
     * Envía un correo electrónico
     * 
     * @param string $email
     * @return boolean
     */
    function sendEmail( $email = NULL, $subject = null, $content = null )
    {
        // CABECERAS
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:' . "\r\n";
        // ENVIAR EMAIL
        $mail = mail($email, $subject, $content, $headers);
        return $mail;
    }
