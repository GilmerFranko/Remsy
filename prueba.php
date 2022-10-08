<?php

require_once 'includes/library/JBBCode/Parser.php';
require_once 'includes/library/JBBCode/definitions/Video.php';
require_once 'includes/library/JBBCode/validators/ColorValidator.php';
require_once 'includes/library/JBBCode/validators/UrlValidator.php';
require_once 'includes/library/JBBCode/validators/AlignValidator.php';
require_once 'includes/library/JBBCode/validators/SizeValidator.php';
require_once 'includes/library/JBBCode/validators/SwfValidator.php';
require_once 'includes/library/JBBCode/validators/ImgValidator.php';
require_once 'includes/library/JBBCode/validators/FontValidator.php';

/**
 * Clase responsable de la conversión de texto en formato
 * de marcado BBCode a XHTML para creración de contenido
 * usado en posts, fotos, comentarios, etc.
 *
 * Extiende de la clase jBBCode para facilitar el uso de
 * todas las herramientas disponibles para la conversión
 * además de su excelente seguridad para el script.
 *
 * @author Kmario19 y PHPost.
 */
class BBCode {

    /**
     * String texto BBcode
     */
    private $text;

    /**
     * BBCodes permitidos
     */
    private $restriction;

    /**
     * jBBCode
     */
    private $parser;


    public function __construct() {
        $this->restriction = array();
        $this->parser = new JBBCode\Parser();
    }

    /**
     * Prepara el texto con el que se trabajará
     *
     * @param string $text  texto a parsear
     */
    public function setText($text) {
        $this->text = $text;
        $this->unclosedTags();
    }

    /**
     * Modificar restricciones de BBCode
     *
     * @param Array string $restriccion  lista de tags permitidos
     */
    public function setRestriction($array) {
        $this->restriction = $array;

        $this->addBBcodes();
    }

    /**
     * Elimina etiquetas BBcode y deja el texto plano
     *
     * @return string
     */
    public function getAsText() {
        $this->parser->parse($this->text);

        $this->text = $this->parser->getAsText();

        $this->delExtraTags();

        return htmlspecialchars_decode(strip_tags($this->text));
    }

    /**
     * Obtiene el texto en HTML
     *
     * @return string
     */
    public function getAsHtml() {
        $this->parser->parse($this->text);

        $this->text = $this->parser->getAsHtml();

        $this->setExtraTags();

        return nl2br($this->text);
    }

    /**
     * Fix para tags que no tienen etiqueta de cierre
     * y para tags de YouTube de la versión anterior
     */
    private function unclosedTags() {
        $this->text = preg_replace("/[\.com]+\/v\//i", ".com/watch?v=", $this->text);
        $this->text = preg_replace("/\[swf=(http|https)?(\:\/\/)?www\.youtube\.com\/watch\?v([A-z0-9=\-]+?)\]/i", "[video]$1$2www.youtube.com/watch?v$3[/video]", $this->text);

        $this->text = preg_replace("/\[img\=(.+?)\]/i", "[img]$1[/img]", $this->text);
        $this->text = preg_replace("/\[swf\=(.+?)\]/i", "[swf]$1[/swf]", $this->text);

        $this->text = str_replace('&#039;', '\'', $this->text);
    }

    /**
     * Parsea tag de línea de división
     * saltos de línea
     */
    private function setExtraTags() {
        if (in_array('hr', $this->restriction)) {
            $this->text = str_replace('[hr]', '<hr />', $this->text);
        }

        $this->text = str_replace('\n', '<br />', $this->text);
    }

    /**
     * Elimina tag de línea de división
     * saltos de línea
     * espacios vacíos
     */
    private function delExtraTags() {
        $this->text = str_replace(array('[hr]', '\n', '\r'), ' ', $this->text);
        $this->text = preg_replace('!\s+!', ' ', $this->text);
        $this->text = preg_replace('/((http|https|www)[^\s]+)/', '', $this->text);
    }

    /**
     * Agrega y valida los BBcodes a parsear.
     *
     * Si el bbcode se encuentra en el array de la restricción, será permitido.
     * Si no es válido lo que se pasa por parametro o contenido se verá el bbcode
     * sin ser parseado. Ejemplo: [a]no es link[/a] => [a]no es link[/a]
     *
     * Cada bbcode tiene su configuración de:
     *
     * TagName: Nombre del tag de bbcode.
     * Replace: En qué formrato HTML se reemplazará.
     *          Usar como variables de referencia {option} y {param}.
     * UseOption: Si el tag usa parámetro ({option}).
     * ParseContent: Si el contenido del tag también será parseado.
     * NestLimit: Límite de cuantas veces se repite este tag en su contenido (incluyendose).
     * OptionValidator: Clase con la cual se valida lo que se pasa por parámetro.
     * BodyValidator: Clase con la cual se valida lo que se pasa como contenido del tag.
     */
    public function addBBcodes() {
        $urlValidator = new \JBBCode\validators\UrlValidator();
        $colorValidator = new \JBBCode\validators\ColorValidator();
        $sizeValidator = new \JBBCode\validators\SizeValidator();
        $alignValidator = new \JBBCode\validators\AlignValidator();
        $swfValidator = new \JBBCode\validators\SwfValidator();
        $imgValidator = new \JBBCode\validators\ImgValidator();
    $fontValidator = new \JBBCode\validators\FontValidator();

        $tagCodes = array(
            array('tag' => 'b', 'replace' => '<strong>{param}</strong>'),
            array('tag' => 'i', 'replace' => '<i>{param}</i>'),
            array('tag' => 'u', 'replace' => '<u>{param}</u>'),
            array('tag' => 's', 'replace' => '<s>{param}</s>'),
            array('tag' => 'sub', 'replace' => '<sub>{param}</sub>'),
            array('tag' => 'sup', 'replace' => '<sup>{param}</sup>'),
            array('tag' => 'table', 'replace' => '<table class="bbctab"><tbody>{param}</tbody></table>'),
            array('tag' => 'tr', 'replace' => '<tr>{param}</tr>'),
            array('tag' => 'td', 'replace' => '<td>{param}</td>'),
            array('tag' => 'ul', 'replace' => '<ul>{param}</ul>'),
            array('tag' => 'li', 'replace' => '<li>{param}</li>'),
            array('tag' => 'ol', 'replace' => '<ol>{param}</ol>'),
            array('tag' => 'url', 'replace' => '<a href="{param}" target="_blank">{param}</a>', 'parse' => false, 'validParam' => $urlValidator),
            array('tag' => 'url', 'replace' => '<a href="{option}" target="_blank">{param}</a>', 'option' => true, 'validOption' => $urlValidator),
            array('tag' => 'img', 'replace' => '<img src="{param}" onload="if(this.width > 735) {this.width=735}"/>', 'parse' => false, 'validParam' => $imgValidator),
            array('tag' => 'color', 'replace' => '<span style="color: {option}">{param}</span>', 'option' => true, 'validOption' => $colorValidator),
            array('tag' => 'size', 'replace' => '<span style="font-size: {option}pt; line-height: {option}pt">{param}</span>', 'option' => true, 'validOption' => $sizeValidator),
            array('tag' => 'align', 'replace' => '<div style="text-align: {option}">{param}</div>', 'option' => true, 'validOption' => $alignValidator),
            array('tag' => 'font', 'replace' => '<span style="font-family: {option}">{param}</span>', 'option' => true, 'validOption' =>$fontValidator),
            array('tag' => 'code', 'replace' => '<pre class="code">{param}</pre>', 'parse' => false, 'limit' => 1),
            array('tag' => 'swf', 'replace' => '<embed src="{param}" quality="high" width="640px" height="390px" type="application/x-shockwave-flash" allowfullscreen="true" allownetworking="internal" autoplay="false" wmode="transparent">', 'parse' => false, 'validParam' => $swfValidator),
            array('tag' => 'spoiler', 'replace' => '<div class="spoiler"><div class="title"><a href="#" onclick="spoiler($(this)); return false;">Spoiler:</a></div><div class="body">{param}</div></div>'),
            array('tag' => 'quote', 'replace' => '<blockquote><div class="cita"><strong>Cita:</strong></div><div class="citacuerpo"><p>{param}</p></div></blockquote>'),
            array('tag' => 'quote', 'replace' => '<blockquote><div class="cita"><strong>{option} dijo:</strong></div><div class="citacuerpo"><p>{param}</p></div></blockquote>', 'option' => true),
            array('tag' => 'notice', 'replace' => '<div class="bbcmsg notice">{param}</div>'),
            array('tag' => 'info', 'replace' => '<div class="bbcmsg info">{param}</div>'),
            array('tag' => 'warning', 'replace' => '<div class="bbcmsg warning">{param}</div>'),
            array('tag' => 'error', 'replace' => '<div class="bbcmsg error">{param}</div>'),
            array('tag' => 'success', 'replace' => '<div class="bbcmsg success">{param}</div>')
        );

        foreach ($tagCodes as $bbcode) {
            if (in_array($bbcode['tag'], $this->restriction) || !$this->restriction) {
                $tag = $bbcode['tag'];
                $replace = $bbcode['replace'];
                $option = isset($bbcode['option']) ? $bbcode['option'] : false;
                $parse = isset($bbcode['parse']) ? $bbcode['parse'] : true;
                $limit = isset($bbcode['limit']) ? $bbcode['limit'] : -1;
                $validOption = isset($bbcode['validOption']) ? $bbcode['validOption'] : null;
                $validParam = isset($bbcode['validParam']) ? $bbcode['validParam'] : null;

                $this->parser->addBBCode($tag, $replace, $option, $parse, $limit, $validOption, $validParam);
            }
        }
        // Tag de video independiente
        if (in_array('video', $this->restriction) || !$this->restriction) {
            $this->parser->addCodeDefinition(new Video());
        }
    }

    /**
     * @name parseMentions
     * @access public
     * @param string
     * @return string
     * @info PONE LOS LINKS A LOS MENCIONADOS
     */
    public function parseMentions() {
        global $tsUser;

        $founds = array();

        $this->text .= ' ';

        preg_match_all('/\B@([a-zA-Z0-9_-]{4,16}+)\b/', $this->text, $users);

        foreach ($users[1] as $user) {
            if (!in_array($user, $founds)) {
                $uid = $tsUser->getUserID($user);
                if (!empty($uid)) {
                    $find = '@' . $user . ' ';
                    $replace = '@<a href="' . $this->settings['url'] . '/perfil/' . $user . '" class="hovercard" uid="' . $uid . '">' . $user . '</a> ';
                    $this->text = str_replace($find, $replace, $this->text);
                }
                $founds[] = $user;
            }
        }

        $this->text = substr($this->text, 0, -1);
    }

    /**
     * @name parseSmiles()
     * @access public
     * @description Convierte los Smiles
     */
  public function parseSmiles(){
     global $tsCore;
    // SMILEYS
    $bbcode = array();
    $html = array();
        //
        $pre = '<img src="'.$tsCore->settings['smiles'].'/';
        $end = '" align="absmiddle"/>';
    // SMILES DEFAULT
        $bbcode[] =":)"; $html[] = $pre."001.png".$end;
        $bbcode[] =":D"; $html[] = $pre."002.png".$end;
        $bbcode[] =";)"; $html[] = $pre."003.gif".$end;
        $bbcode[] =":O"; $html[] = $pre."004.png".$end;
        $bbcode[] ="(H)"; $html[] = $pre."006.png".$end;
        $bbcode[] =":P"; $html[] = $pre."104.png".$end;
        $bbcode[] ="8o|"; $html[] = $pre."049.png".$end;
        $bbcode[] =":S"; $html[] = $pre."009.png".$end;
        $bbcode[] =":$"; $html[] = $pre."008.png".$end;
        $bbcode[] =":("; $html[] = $pre."010.png".$end;
        $bbcode[] =":'("; $html[] = $pre."011.gif".$end;
        $bbcode[] =":|"; $html[] = $pre."012.png".$end;
        $bbcode[] ="(6)"; $html[] = $pre."013.png".$end;
        $bbcode[] ="8-|"; $html[] = $pre."050.png".$end;
        $bbcode[] =":-/"; $html[] = $pre."083.png".$end;
        $bbcode[] ="^o)"; $html[] = $pre."051.png".$end;
        // EXTRAS SMILES
        $bbcode[] = "(A)"; $html[] = $pre."014.png".$end;
        $bbcode[] = ":["; $html[] = $pre."043.png".$end;
        $bbcode[] = ":-#"; $html[] = $pre."048.png".$end;
        $bbcode[] = ":-*"; $html[] = $pre."052.png".$end;
        $bbcode[] = "+o("; $html[] = $pre."053.png".$end;
        $bbcode[] = "(brb)"; $html[] = $pre."066.gif".$end;
        $bbcode[] = ":^)"; $html[] = $pre."072.gif".$end;
        $bbcode[] = "*-)"; $html[] = $pre."073.gif".$end;
        $bbcode[] = "<o)"; $html[] = $pre."075.gif".$end;
        $bbcode[] = "8-)"; $html[] = $pre."076.gif".$end;
        $bbcode[] = "|-)"; $html[] = $pre."078.gif".$end;
        $bbcode[] =";-/"; $html[] = $pre."082.png".$end;
        $bbcode[] ="(jk)"; $html[] = $pre."084.png".$end;
        $bbcode[] = "(j)"; $html[] = $pre."086.png".$end;
        $bbcode[] = "(V)"; $html[] = $pre."087.png".$end;
        $bbcode[] = "(lol)"; $html[] = $pre."089.gif".$end;
        $bbcode[] = "(xD)"; $html[] = $pre."090.png".$end;
        $bbcode[] = ":8)"; $html[] = $pre."088.png".$end;
        $bbcode[] = "(ff)"; $html[] = $pre."091.gif".$end;
        $bbcode[] = "(fm)"; $html[] = $pre."092.gif".$end;
        $bbcode[] = ":'|"; $html[] = $pre."093.gif".$end;
        $bbcode[] = ":]"; $html[] = $pre."094.gif".$end;
        $bbcode[] = ":}"; $html[] = $pre."095.png".$end;
        $bbcode[] = "(BOO)"; $html[] = $pre."096.png".$end;
        $bbcode[] = "*|"; $html[] = $pre."097.gif".$end;
        $bbcode[] = "*\\"; $html[] = $pre."098.png".$end;
        $bbcode[] = "(wm)"; $html[] = $pre."100.png".$end;
        $bbcode[] = "(xo)"; $html[] = $pre."101.gif".$end;
        // OBJECTOS
        $bbcode[] = "(l)"; $html[] = $pre."015.png".$end;
        $bbcode[] = "(u)"; $html[] = $pre."016.png".$end;
        $bbcode[] = "(@)"; $html[] = $pre."018.png".$end;
        $bbcode[] = "(&)"; $html[] = $pre."019.png".$end;
        $bbcode[] = "(S)"; $html[] = $pre."020.png".$end;
        $bbcode[] = "(*)"; $html[] = $pre."021.png".$end;
        $bbcode[] = "(~)"; $html[] = $pre."022.png".$end;
        $bbcode[] = "(8)"; $html[] = $pre."023.png".$end;
        $bbcode[] = "(E)"; $html[] = $pre."024.png".$end;
        $bbcode[] = "(F)"; $html[] = $pre."025.png".$end;
        $bbcode[] = "(W)"; $html[] = $pre."026.png".$end;
        $bbcode[] = "(O)"; $html[] = $pre."027.gif".$end;
        $bbcode[] = "(K)"; $html[] = $pre."028.png".$end;
        $bbcode[] = "(G)"; $html[] = $pre."029.png".$end;
        $bbcode[] = "(^)"; $html[] = $pre."030.png".$end;
        $bbcode[] = "(P)"; $html[] = $pre."031.png".$end;
        $bbcode[] = "(I)"; $html[] = $pre."032.png".$end;
        $bbcode[] = "(C)"; $html[] = $pre."033.png".$end;
        $bbcode[] = "(T)"; $html[] = $pre."034.png".$end;
        $bbcode[] = "({)"; $html[] = $pre."035.png".$end;
        $bbcode[] = "(})"; $html[] = $pre."036.png".$end;
        $bbcode[] = "(B)"; $html[] = $pre."037.png".$end;
        $bbcode[] = "(D)"; $html[] = $pre."038.png".$end;
        $bbcode[] = "(Z)"; $html[] = $pre."039.png".$end;
        $bbcode[] = "(X)"; $html[] = $pre."040.png".$end;
        $bbcode[] = "(Y)"; $html[] = $pre."041.png".$end;
        $bbcode[] = "(N)"; $html[] = $pre."042.png".$end;
        $bbcode[] = "(nnh)"; $html[] = $pre."044.png".$end;
        $bbcode[] = "(#)"; $html[] = $pre."046.png".$end;
        $bbcode[] = "(R)"; $html[] = $pre."047.png".$end;
        $bbcode[] = "(sn)"; $html[] = $pre."054.png".$end;
        $bbcode[] = "(tu)"; $html[] = $pre."055.png".$end;
        $bbcode[] = "(pl)"; $html[] = $pre."056.png".$end;
        $bbcode[] = "(||)"; $html[] = $pre."057.png".$end;
        $bbcode[] = "(pi)"; $html[] = $pre."058.png".$end;
        $bbcode[] = "(so)"; $html[] = $pre."059.png".$end;
        $bbcode[] = "(au)"; $html[] = $pre."060.png".$end;
        $bbcode[] = "(ap)"; $html[] = $pre."061.png".$end;
        $bbcode[] = "(um)"; $html[] = $pre."062.png".$end;
        $bbcode[] = "(ip)"; $html[] = $pre."063.png".$end;
        $bbcode[] = "(co)"; $html[] = $pre."064.png".$end;
        $bbcode[] = "(mp)"; $html[] = $pre."065.png".$end;
        $bbcode[] = "(st)"; $html[] = $pre."067.png".$end;
        $bbcode[] = "(pu)"; $html[] = $pre."102.png".$end;
        $bbcode[] = "(yn)"; $html[] = $pre."068.png".$end;
        $bbcode[] = "(h5)"; $html[] = $pre."069.gif".$end;
        $bbcode[] = "(mo)"; $html[] = $pre."070.png".$end;
        $bbcode[] = "(bah)"; $html[] = $pre."071.png".$end;
        $bbcode[] = "(li)"; $html[] = $pre."074.gif".$end;
        $bbcode[] = "(wo)"; $html[] = $pre."077.png".$end;
        $bbcode[] = "'.'"; $html[] = $pre."080.png".$end;
        $bbcode[] = "(bus)"; $html[] = $pre."045.png".$end;
        $bbcode[] = "*p*"; $html[] = $pre."079.png".$end;
        $bbcode[] ="*s*"; $html[] = $pre."085.png".$end;
        $bbcode[] = "(M)"; $html[] = $pre."017.png".$end;
        $bbcode[] = "(xx)"; $html[] = $pre."103.png".$end;

    // REEMPLAZAMOS SMILEYS
        $this->text = str_replace($bbcode, $html, $this->text);
  }
}

/**$bbcode = new BBCode();
$bbcode->setText('[color=#4a4a4a][font=monospace][color=#770088][font=monospace][url=http://localhost/phpmyadmin/url.php?url=https://dev.mysql.com/doc/refman/8.0/en/select.html][color=#235a81]SELAECT[/color][/url][/font][/color][color=#444444][font=monospace] [/font][/color][color=#ff00ff][font=monospace]*[/font][/color][color=#444444][font=monospace] [/font][/color][color=#770088][font=monospace]FROM[/font][/color][color=#444444][font=monospace] [/font][/color][color=#0055aa][font=monospace]`works_pending`[/font][/color][color=#444444][font=monospace] [/font][/color][color=#770088][font=monospace]ORDER[/font][/color][color=#444444][font=monospace] [/font][/color][color=#770088][font=monospace]BY[/font][/color][color=#444444][font=monospace] [/font][/color][color=#0055aa][font=monospace]`done`[/font][/color][color=#444444][font=monospace] [/font][/color][color=#770088][font=monospace]ASC[/font][/color] [/font][/color]');
$bbcode->setRestriction(array());

echo $bbcode->getAsText();
*/
define('DS', DIRECTORY_SEPARATOR);
function copyFile($dir_copy = null, $dir_paste = null, $filename = null)
	{
		$filename = ($filename === null) ? basename($dir_copy) : $filename;
		// Comprueba que existe el archivo
		if(file_exists($dir_copy))
		{
			// Comprueba que existe la ruta a pegar
			if (file_exists($dir_paste))
			{
				// Si el archivo se copio con exito
				if(copy($dir_copy, $dir_paste.DS.$filename))
				{
					return $dir_paste;
				}
				else
				{
					return false;
				}
			}
		}
	}
	function copyDirectory($dir_copy = null, $dir_paste = null, $filename = null)
	{
		// Si es un directorio
		if (is_dir($dir_copy))
		{
			// Crea carpeta de no existir
			@mkdir( $dir_paste );
			// Recorre lista de archivos de este directorio
			$d = dir( $dir_copy );
			while (FALSE !== ($entry = $d->read()))
			{
				if ($entry == '.' || $entry == '..' )
				{
					continue;
				}
				$Entry = $dir_copy . DS . $entry;
				// Si es un directorio, repetir proceso
				if (is_dir($Entry))
				{
					copyDirectory( $Entry, $dir_paste.DS.$entry);
					continue;
				}
				// Sino, copiar archivo
				copyFile( $Entry, $dir_paste, $entry );
				//echo $dir_paste.DS.$entry . PHP_EOL;
			}

			$d->close();
		}
		elseif($filename != null)
		{
			copyFile( $dir_copy, $dir_paste, $filename);
		}
	}

	/**
	 * Comprueba si dos archivos son iguales en tipo, tamaño y contenido
	 * @param  string $path_a
	 * @param  string $path_b
	 * @return boo    Devuelve true si son iguales
	 */
	function diffFiles($path_a = null, $path_b = null)
	{
		if(!defined('READ_LEN')) define('READ_LEN', 4096);
		if(file_exists($path_a) AND file_exists($path_b))
		{
			// Si los archivos son de tipos diferentes
			if(filetype($path_a) !== filetype($path_b))
				return false;
			// Si el tamaño de los archivos son diferentes
			if(filesize($path_a) !== filesize($path_b))
				return false;
			// Si no se puede abrir el archivo
			if(!$fp1 = fopen($path_a, 'rb'))
				return false;
			// Si no se puede abrir el archivo
			if(!$fp2 = fopen($path_b, 'rb')) {
				fclose($fp1);
				return false;
			}

			$same = TRUE;
			while (!feof($fp1) and !feof($fp2)){
				if(fread($fp1, READ_LEN) !== fread($fp2, READ_LEN)) {
					$same = false;
					break;
				}
			}
			if(feof($fp1) !== feof($fp2))
				$same = false;

			fclose($fp1);
			fclose($fp2);
			return $same;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Hace una comparacion de dos directorios para identifar archivos distintos o no existentes
	 * Copia los archivos distintos en una subcarpeta
	 * @param  string $path_primary   Directorio principal
	 * @param  string $path_secondary Directorio a examinat
	 * @param  null $dir_diff       null
	 * @return null                 nul-
	 */
	function diffDirectories($path_primary = null, $path_secondary = null, $dir_primary = "", $dir_secondary = "")
	{
		// Nombre de carpeta en donde se guardaran los resultados
		define('FOLDER_SV', 'Guardado');
		// Comprueba que existan los dos directorio
		if(file_exists($path_primary) AND file_exists($path_secondary))
		{
			// Optiene todos los archivos y subcarpetas
			$dir_a = getAllDirectories($path_primary, false, true);
			$dir_b = getAllDirectories($path_secondary, false, true);
			// Crea carpeta temporal
			@mkdir($path_primary.DS.FOLDER_SV);

			// Recorre directorio principal en busca de diferencias
			foreach ($dir_a as $key_a => $DIR_A) {
				// Establece variable de coincidencias en false
				$boo = false;
				// Recorre segundo directorio (path_secondary) comprobando cada archivo (ruta) con el primer directorio (path_primary)
				for ($i=0; $i < (count($dir_b) -1); $i++)
				{
					// Comprueba si existe x ruta(elemento) en $path_secondary(array)
					if(($dir_b[$i]['full-path'] == $DIR_A['full-path']))
					{
						/**
						 * Ahora se comprobara si el archivo coincide con el primario en tipo, tamaño y contenido
						 */
						if(diffFiles($dir_b[$i]['full-path'], $DIR_A['full-path']))
						{
							// Establece coicidencias en verdadero
							$boo = true;
						}
						// Si los archivos son distintos
						else
						{
							// Rompe bucle
							break;
						}
					}
					//echo $dir_b[$i][0] . PHP_EOL;
				}
				// Si no hubo coincidencias, crea el archivo y guardalo
				if($boo)
				{
					createFile($path_primary.DS.FOLDER_SV.DS.dirname($DIR_A['full-path']), basename($DIR_A['full-path']), $DIR_A['content']);
				}
				else
				{
					echo $dir_b[$i]['relative-path'] . PHP_EOL;
				}
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * Devuelve todas las rutas de un directorio
	 * @param  string $dir_a
	 * @param  stirng $dir_b
	 * @return array
	 */
	function getAllDirectories($dir_a = null, $isFile = false, $boo = false)
	{
		// Solo un uso, extrare directorio relarivo, ejemp
		// C:/hola1/hola2/hol3
		// a
		// hola1/hola2/hol3
		if($boo)
		{
			$explode = explode(DS,$dir_a);
			$path_relative = $explode[(count($explode)-1)];
		}
		else
		{
			$path_relative = "ñ";
		}
		$directories = array();

		// Si es un directorio
		if (is_dir($dir_a))
		{
			// Recorre lista de archivos de este directorio
			$d = dir( $dir_a );
			while (FALSE !== ($entry = $d->read()))
			{
				// Ignora estos directorios
				if ($entry == '.' || $entry == '..' )
				{
					continue;
				}
				$full_path = $dir_a .DS. $entry;

				// Si es un directorio, repetir proceso
				if (is_dir($full_path))
				{
					$new_path = getAllDirectories($full_path, true);
					//
					if($new_path == null) continue;
					// Si es un array de rutas
					elseif(is_array($new_path))
					{
						foreach ($new_path as $path) {
							array_push($directories, $path);
						}
					}
					elseif(is_string($new_path)){
						array_push($directories, $new_path);
					}
				}
				else{
					// Sino, almacenar directorio
					array_push($directories, array('full-path' => $full_path, 'content' => file_get_contents($full_path), 'relative-path' => $path_relative));
				}
			}
			$d->close();
		}
		elseif($dir_a != null AND $isFile)
		{
			return $dir_a;
		}
		return $directories;
	}

	function createFile($path_file = "", $filename = "",  $file_content = "")
	{

		// Crear carpeta de no existir
		if(!file_exists($path_file))
		{
			mkdir($path_file, 0777, true);
		}
		// Abrir archivo, nombre archivo, modo apertura *Si no, crealo
		$File = fopen($path_file.DS.$filename,'w');
		fwrite($File,	$file_content);
		fclose($File);
	}

	function clearPath($full_path = "", $relative_path = "")
	{
		return str_replace($full_path, "", $relative_path);
	}
	//function getFileContent
	//echo clearPath('C:\xampp\htdocs\temp1', 'temp1/hola/h.php');
	diffDirectories('../temp/temp2', '../temp/temp1', 'temp1', 'temp2');

	//$h = getAllDirectories('../temp/temp2', false);

	//foreach ($h as $key => $value) {
		//echo $value['full-path']. PHP_EOL;
	//}
