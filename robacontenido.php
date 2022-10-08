<?php
/*function feed($feedURL,$fp){
	$storys = simplexml_load_file($feedURL);
	$a = 0;
	$links='';
	foreach($storys->sitemap as $story) {
		$i = 0;
		$filter="+ecologia"; // filtra la categoria
		if ($i < 1) {
			$rss = simplexml_load_file($story->loc);
			foreach($rss->url as $url) {
				$link = $url->loc;
				if (stripos($link, $filter)) { 
					$links.=$link . PHP_EOL;
					echo $link . '<br>';
				}
				$i++;
			}
		}
		$a++;
	}
	return $links;
}
// SI EL ARCHIVO NO ABRE MOSTRAR UN ERROR
if (!$fp = fopen("links.txt", "w+")){
	die("No se ha podido abrir el archivo");
}
//fwrite($fp,feed("https://taringa.net/smaps/taringa-sitemap-story-index.35.xml",$fp));
fclose($fp);
*/

function downloadFile($src, $dst) {
  //abrimos un fichero donde guardar la descarga de la web

	if(!$fp=fopen($dst, "w+")){
		echo "No se pudo abrir o no se localizo el archivo " + $dst + ". Revise los permisos del archivo solicitado";
	}

	// Se crea un manejador CURL
	$ch=curl_init();

	// Se establece la URL y algunas opciones
	curl_setopt($ch, CURLOPT_URL, $src);
	//determina si descargamos las cabeceras del servidor [0-No mostramos|1-mostramos]
	curl_setopt($ch, CURLOPT_HEADER, 0);
	//determina si mostramos el resultado en el nevagador [0-mostramos|1-NO mostramos]
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	//determina donde guardar el fichero
	curl_setopt($ch, CURLOPT_FILE, $fp);

	//verificar https http
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

	// Se obtiene la URL indicada
	$hola = curl_exec($ch);

	// Se cierra el recurso CURL y se liberan los recursos del sistema
	curl_close($ch);

	//se cierra el manejador de ficheros
	fclose($fp);
}
//downloadFile('https://taringa.net/smaps/taringa-sitemap-story-index.35.xml','links.txt');

  function file_get_contents_curl($url){
      $ch = curl_init();
      //curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
  }
  function limpiarString($String){
      $String = str_replace(array("|","|","[","^","´","`","¨","~","]","'","#","{","}",".",""),"",$String);
      return $String;
  }
  function BBCODE($String){
      $String = str_replace('<',"[",$String);
      $String = str_replace('>',"]",$String);
      return $String;
  }
  $url 	=	'https://www.taringa.net/+ecologia/desmintiendo-todo-post-serio-veganos_fteiz';
  // GUARDO EL HTML
  $html 	= 	file_get_contents_curl($url);
  // LO CONVIERTO EN OBJETO
  $doc 	= 	new DOMDocument();
  @$doc->loadHTML($html);

  //Selecciono el Titulo
  $nodes 	= 	$doc->getElementsByTagName('h1');
  $title 	= 	limpiarString($nodes->item(0)->nodeValue);
  $divs 	= 	$doc->getElementsByTagName('div');
  for ($i = 0; $i < $divs->length; $i++):

  	$div = $divs->item($i);

  	if($div->getAttribute('class') == 'classic')

  		$content = $div->ownerDocument->saveHTML($div);

  endfor;
  //echo $title;

  require '../chat/prueba.php';
  //echo "KEYWORDS :<br>".$keywords;
