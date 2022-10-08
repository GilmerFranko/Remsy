<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\model\bulkemails.class.php \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a los correos
 *
 *
*/

class BulkEmails extends Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
        $this->database = Core::model('db', 'core');
    }

    
    /**
     * Registra un correo enviado
     * 
     * @param array $photo
     * @return boolean/integer
     */
    function newEmail( $email = null )
    {
        $query = $this->db->query('INSERT INTO `site_bulk_emails` (`subject`, `addressees`, `addressees_file`, `addressees_type`, `addressees_count`, `content`, `date`, `date_sent`) VALUES (\''.$email['subject'].'\', \''.$this->db->real_escape_string($email['addressees']).'\', \''.$this->db->real_escape_string($email['addressees_file']).'\', \''.$email['addressees_type'].'\', \''.$email['addressees_count'].'\', \''.$this->db->real_escape_string($email['content']).'\', \''.$email['date'].'\', 0) ');
        // SI SE HA AGREGADO CORRECTAMENTE
        if ($query == true)
        {
            return $this->db->insert_id;
        }
        //
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
                $this->config['script_name'],
                $this->config['base_url'],
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
     * Obtiene la lista de gente a los que enviar el correo
     * 
     * @param id $bulkemail
     * @return array
     */
    function listAddressees( $bulkemail = null )
    {
        // REALIZAR CONSULTA
        $query = $this->db->query('SELECT `addressees_file` FROM `site_bulk_emails` WHERE `id` = \''.$bulkemail.'\' LIMIT 1');

        // SI HAY RESULTADOS
        if ($query == true && $query->num_rows > 0)
        {
            // ASOCIAR DATOS
            $csv = $query->fetch_assoc();

            // ABRIR ARCHIVO
            $addressees = array_map('str_getcsv', file($this->config['bulkemails_path'] . DS . $csv['addressees_file']));

            // ORDENAR ID "<"
            asort($addressees);

            // RETORNAR DATOS
            return $addressees;
        }

        // SI ALGO FALLÓ
        return false;
    }

    /**
     * Obtiene la lista de gente a los que enviar el correo
     * 
     * @param string $type
     * @param string $addressee
     * @param array $bulkemail
     * @param boolean $generate
     * @return array
     */
    function getAddressees($type = null, $addressee = null, $bulkemail = null )
    {
        // PARA "TODA LA WEB"
        if($type == '1')
        {
            $users = $this->db->query('SELECT `member_id`, `name`, `email` FROM `members`');
        }
        // PARA "SEGUIDORES DE"
        elseif($type == '2')
        {
            // OBTENER ID DE LA SEGUIDA
            $following = Core::model('member', 'members')->isMember(null, $addressee, true);

            $users = $this->db->query('SELECT m.`member_id`, m.`name`, m.`email` FROM `members` AS m LEFT JOIN `members_follows` AS f ON m.`member_id` = f.`follow_from` WHERE f.`follow_to` = \''.$following.'\'');

        }
        // PARA "DESTINATARIOS MANUALES"
        elseif($type == '3')
        {
            // CREA UN ARRAY CON LA SEPARACIÓN DE COMAS
            $addressees1 = explode(',', $addressee);
            // AÑADE ID Y NOMBRES VIRTUALES
            foreach ($addressees1 as $row) { $addressees[] = array('member_id' => 0, 'name' => 'Usuario', 'email' => $row); }
        }
        // PARA "ARCHIVO SUBIDO"
        elseif($type == '4')
        {
            // ABRIR ARCHIVO
            $csv = array_map('str_getcsv', file($this->config['bulkemails_path'] . DS . $bulkemail['addressees_file']));

            // GENERAR ARRAY CON LOS DATOS LEÍDOS
            foreach ($csv as $user)
            {
                $addressees[] = array(
                    'member_id' => is_numeric($user[$bulkemail['col_id']]) ? $user[$bulkemail['col_id']] : 0,
                    'name' => strlen($user[$bulkemail['col_name']]) >= 4 ? $user[$bulkemail['col_name']] : 'Usuario',
                    'email' => $user[$bulkemail['col_email']]
                );
            }

            /**
            // PREDEFINIR VARIABLE CONTADOR            
            $i = 0;

            // ABRIR ARCHIVO
            $csv = fopen($this->config['bulkemails_path'] . DS . $bulkemail['addressees'], 'r');
            
            // EXTRAER LOS DATOS
            while( ($user = fgetcsv($csv, ',') ) == true) 
            {
                // CANTIDAD DE USUARIOS
                $num = count($user);
                ++$i;

                // SI YA SE HAN ESPECIFICADO LAS COLUMNAS
                if( isset($emailCol) )
                {
                    $addressees[] = array(
                        'member_id' => is_numeric($user[0]) ? $user[0] : 0,
                        'name' => empty($user[1]) ? 'Usuario' : $user[1],
                        'email' => $user[$emailCol]
                    );
                }
                // BUSCAR COLUMNAS
                else
                {
                    // RECORRER COLUMNAS DE ESA LINEA
                    for( $col = 0; $col < $num; ++$col ) 
                    {
                        // BUSCAR CORREO Y VARIALIZAR COLUMNA
                        if( filter_var($user[$col], FILTER_VALIDATE_EMAIL) )
                        {
                            // ESTABLECER COLUMNA DONDE ESTÁN LOS CORREOS
                            $emailCol = $col;
                            // AÑADIR CORREO AL ARRAY
                            $addressees[] = array('member_id' => $user[0], 'name' => $user[1], 'email' => $user[$emailCol]);
                        }
                    }
                }
            }

            // CERRAR ARCHIVO
            fclose($csv);
            **/
            
        }

        // SI ES UN RESULTADO MYSQL, CONVERTIR EN ARRAY
        if( isset($users) && is_object($users) )
        {
            for($addressees = array (); $row = $users->fetch_assoc(); $addressees[] = $row);
        }

        // RETORNAR ARRAY DE DESTINATARIOS
        return $addressees;
    }

    /**
     * Genera un archivo con destinatarios
     * 
     * @param array $addressees
     * @param string $file
     * @return boolean
     */
    function genAddressees( $addressees = null, $file = null )
    {
        // ABRIR FICHERO CSV
        $csv = fopen($this->config['bulkemails_path'] . DS . $file, 'w');
        // PREDEFINIR
        $i = 0;
        // ESCRIBIR TODO
        foreach( $addressees as $addressee )
        {
            if( fputcsv($csv, array($addressee['member_id'], $addressee['name'], $addressee['email']), ',') !== FALSE )
            {
                ++$i;
            }
        }
        // CERRAR ARCHIVO
        fclose($csv);

        return $i;
    }

    /**
     * Envía los correos
     * 
     * @param array $bulkemail
     * @param array $addressees
     * @param integer $sleep
     * @return boolean
     */
    function sendBulkemails($bulkemail = null, $addressees = null, $sleep = 5)
    {
        // PREDEFINE VARIABLES
        $i = 0;
        // BUCLE ENVIANDO CORREOS
        foreach ($addressees as $addressee)
        {
            // CONVERTIR VARIABLES DEL ASUNTO
            $bulkemail['subject'] = $this->setVars($bulkemail['subject'], $addressee);
            // CONVERTIR VARIABLES DEL CONTENIDO
            $bulkemail['content'] = $this->setVars($bulkemail['content'], $addressee);

            // ENVIAR EMAIL
            $email = Core::model('email', 'core')->sendEmail( 'normal', $addressee[2], null, $bulkemail['subject'], $bulkemail['content']);

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

        // ACTUALIZAR ETADÍSTICAS
        $this->db->query('UPDATE `site_bulk_emails` SET `addressees_sent` = \''.$i.'\', `date_sent` = UNIX_TIMESTAMP() WHERE `id` = \''.$bulkemail['id'].'\' LIMIT 1');

        // RETORNAR RESULTADO
        return $i;
    }
}