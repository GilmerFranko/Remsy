<?php defined('SUPERNATURAL') || exit;

/**
   °══════════°══════════════════════════════════°
   ║ @file    ║modules/posts/model/post.class.php║
   °══════════°══════════════════════════════════°
   °══════════°═══════════════════════════════°
   ║ @version ║v1.0                           ║
   °══════════°═══════════════════════════════°
   °══════════°═══════════════════════════════°
   ║ @author  ║Gilmer gilmerfranko@hotmail.com║
   °══════════°═══════════════════════════════°
   °══════════°═══════════════════════════════°
   ║ @copyrig ║(c) 2020 Gilmer Franco         ║
   °══════════°═══════════════════════════════°
   °══════════════°═══════════════════════════°
   ║Este modelo se encarga de gestionar lo    ║
   ║relacionado a los posts                   ║
   °══════════════°═══════════════════════════°
  */

class Post extends Model
{

  public function __construct()
  {
    parent::__construct();
    $this->session = Core::model('session', 'core');
  }


    /**
     * devuelve todos los posts
     * 
     * @param int $shout
     * @param int $member
     * @return boolean
     */
    public function getAllPosts($thumb = false, $limit = 10, $member = 0, $array = true, $vip = false)
    {
      $sql = "SELECT COUNT(`id`) FROM `members_posts`";

        // POSTS TOTALES
      $query = $this->db->query($sql);
      list($result['total']) = $query->fetch_row();
      // PAGINADOR
      $posts['total'] = $result['total'];
      //echo $post['total'];
      $posts['pages'] = Core::model('paginator', 'core')->pageIndex( array('posts', 'list'), $result['total'], $limit);

      $sql = "SELECT * FROM members_posts LIMIT " . $posts['pages']['limit'];

        // EJECUTA CONSULTA QUE OBTIENE LOS DATOS DE LOS POSTS
      $query = $this->db->query($sql);
      if($query == true && $query->num_rows > 0)
      {
        if($array == false) return $query;

        while($row = $query->fetch_assoc()){

                // GENERAR ENLACE DE SHOUT
                //$row['url'] = Core::model('extra', 'core')->generateUrl('shouts', 'view', null, array('id' => $row['id']));
          //$row['url'] .= "&user=". $row["member"] ;

          $posts['data'][] = $row;
          $posts['rows'] = $query->num_rows;
        }

        return $posts;
      }

      return false;
    }
    /**
    * devuelve todos los posts scrapeados
    *
    * @param array
    * @param boolean
    * @return int
    */
    public function getAllPostsNoAdded($thumb = false, $limit = 40, $member = 0, $array = true, $vip = false)
    {

      $WHERE = "WHERE added = '0'";

      $sql = "SELECT COUNT(`id`) FROM `content_scrapped` $WHERE";

        // POSTS TOTALES
      $query = $this->db->query($sql);
      list($result['total']) = $query->fetch_row();
      // PAGINADOR
      $posts['total'] = $result['total'];
      //echo $post['total'];
      $posts['pages'] = Core::model('paginator', 'core')->pageIndex( array('posts', 'posts-no-added'), $result['total'], $limit);

      $sql = "SELECT * FROM content_scrapped $WHERE LIMIT " . $posts['pages']['limit'];

        // EJECUTA CONSULTA QUE OBTIENE LOS DATOS DE LOS POSTS
      $query = $this->db->query($sql);
      if($query == true && $query->num_rows > 0)
      {
        if($array == false) return $query;

        while($row = $query->fetch_assoc()){

                // GENERAR ENLACE DE SHOUT
                //$row['url'] = Core::model('extra', 'core')->generateUrl('shouts', 'view', null, array('id' => $row['id']));
          //$row['url'] .= "&user=". $row["member"] ;

          $posts['data'][] = $row;
          $posts['rows'] = $query->num_rows;
        }

        return $posts;
      }

      return false;
    }

    /**
     * Obtiene un post
     * @param string $table
     * @param int $id
     * @return array $post
     */
    public function getPost($table = null, $id = null)
    {
      $WHERE = ($id == null) ? "ORDER BY RAND()" : "WHERE `id` = '$id'";
      $query = $this->db->query("SELECT * FROM `$table` $WHERE LIMIT 1");

      if($query == true && $query->num_rows > 0)
      {
        $shout = $query->fetch_assoc();

        return $shout;
      }

      return false;
    }

    /**
     * Obtiene un post no añadido a la tabla members_posts
     * @param string $table
     * @param int $id
     * @return array $post
     */
    public function getPostNoAdded($rand = false)
    {
      $orderby = $rand == true ? 'ORDER BY RAND()' : '';
      $query = $this->db->query("SELECT * FROM `content_scrapped` WHERE `added` = '0' $orderby LIMIT 1");

      if($query == true && $query->num_rows > 0)
      {
        $shout = $query->fetch_assoc();

        return $shout;
      }

      return false;
    }


    /**
     * Agrega nuevo Post
     * 
     * @param array $shout
     * @param boolean $notify
     * @return int $shout_id
     */
    public function newPost($post = null, $notify = true)
    {
      $query = $this->db->query('INSERT INTO `members_posts` (`member`, `title`, `content`, `type`, `time`) VALUES ("0",\'' . $this->db->real_escape_string($post['title']) . '\', \'' . $this->db->real_escape_string($post['content']) . '\', \'' . 1 . '\', UNIX_TIMESTAMP())');
    }
    /**
    * Añade x Posts de la tabla `content_scrapped` a `members_posts`
    *
    * @param array
    * @param boolean
    * @return int
    */
    public function addPostScrap($count)
    {
      // AÑADE x Posts
      for ($i=0; $i < $count; $i++)
      {
        // SELECCIONO UN POST ALEATORIO
        $post = $this->getPostNoAdded(true);

        // SI $post NO ESTA VACIO
        if($post != false)
        {
          // AÑADO EL POST
          $this->newPost($post);

          // ACTUALIZO EL POST COMO AÑADIDO
          $this->db->query("UPDATE `content_scrapped` SET `added` = '1' WHERE `id` = '$post[id]'");
        }
        // SI NO CIERRA EL ARCHIVO
        else
        {
          exit;
        }
      }
    }

    /**
    * Agrega un nuevo post scrapeado
    *
    * @param array
    * @param boolean
    * @return int
    */
    public function newPostSC($post = null)
    {
      $query = $this->db->query('INSERT INTO `content_scrapped` (`title`, `content`, `link`, `date`) VALUES (\'' . $this->db->real_escape_string(utf8_decode($post['title'])) . '\', \'' . $this->db->real_escape_string(utf8_decode($post['content'])) . '\', \'' . $post['link'] . '\', UNIX_TIMESTAMP())');
    }
    /**
    * Scrapea el sitio taringa.net/+ecologia
    *
    * @param string
    * @return null
    */
    public function getPostTg($feedURL = null, $group_id)
    {
      $flood = false;
      // ESTABLESCO EL TIEMPO GATEWAY A 10min (EVITA ERROR 502)
      //set_time_limit(1000);
      // CARGA LA PAGINA Y LA TRANSFORMA EN OBJETO XML
      $stories = simplexml_load_string($this->donwloadHTML($feedURL));
      $a = 0;

      // SI HAY QUE DEVOLVER TODAS LAS STORIES VERSIONS

      // RECORRE EL OBJETO XML
      foreach($stories->sitemap as $story)
      {
        // REINICIA
        $i = 0;

        // FILTRO DE LA CATEGORIA
        $filter="+ecologia";

        // CARGA EL SEGUNDO OBJETO COMO XML
        $rss = simplexml_load_string($this->donwloadHTML($story->loc));
        if($a == 0)echo 3;
        // RECORRE EL OBJETO
        foreach($rss->url as $url)
        {
          if($i == 0)echo 4;
          // ALMACENA EL LINK DEL POST
          $link = $url->loc;

          //FILTRA LA CATEGORIA
          if (stripos($link, $filter))
          {
            // SI EL LINK NO ESTA REGISTRADO
            if($this->db->query("SELECT link FROM `content_scrapped` WHERE `link` = '$link'")->num_rows == 0)
            {
              // GUARDO EL HTML
              $html   =   $this->donwloadHTML($link);
              // LO CONVIERTO EN OBJETO
              $doc  =   new DOMDocument();
              @$doc->loadHTML($html);

              // ALMACENO EL TITULO
              $nodes  =   $doc->getElementsByTagName('h1');
              $title  =   $nodes->item(0)->nodeValue;
              // ALMACENO TODOS LOS DIVS
              $divs   =   $doc->getElementsByTagName('div');
              for ($i = 0; $i < $divs->length; $i++):

                $div = $divs->item($i);

                // SELECCIONO EL QUE TENGA EL CONTENIDO DEL POST
                if($div->getAttribute('class') == 'classic')
                {
                  // ALMACENO EL CONTENIDO
                  $content = $div->ownerDocument->saveHTML($div);

                  break;
                }

              endfor;

              // AGREGA EL POST
              $this->newPostSC(array('title' => utf8_decode($title), 'content' => utf8_decode($content), 'link' => $link));
            }
          }
          $i++;
        }
        $a++;
      }
      // ACTUALIZA EL GRUPO DE LINKS
      $this->updateLinkGroups($group_id);
    }
    public function downloadFile($src = '', $save = false, $dst = '')
    {
      //abrimos un fichero donde guardar la descarga de la web

      if($save AND !$fp=fopen($dst, "w+")){
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
      if($save) curl_setopt($ch, CURLOPT_FILE, $fp);

      //verificar https http
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

      // Se obtiene la URL indicada
      $html = curl_exec($ch);

      // Se cierra el recurso CURL y se liberan los recursos del sistema
      curl_close($ch);

      //se cierra el manejador de ficheros
      if($save)fclose($fp);

      return $html;
    }

    /**
    * devuelve todos los grupos de links
    *
    * @param array
    * @param boolean
    * @return int
    */
    public function getRobotsTa()
    {

      $sql = "SELECT * FROM `robots_ta`";

      // EJECUTA CONSULTA QUE OBTIENE LOS DATOS DE LOS POSTS
      $query = $this->db->query($sql);
      if($query == true && $query->num_rows > 0)
      {
        while ($row = $query->fetch_assoc())
        {
          $r[] = $row;
        }
        return $r;
      }

      return false;
    }
    /**
    * actualiza la fecha del grupo de link
    *
    * @param array
    * @param boolean
    * @return int
    */
    public function updateLinkGroups($id)
    {
      // OPTIENE EL GRUPO DE LINKS SI EXISTE
      $query = $this->db->query("SELECT index_id FROM `robots_ta` WHERE `index_id` = '$id'");
      // COMPRUEBA QUE EXISTA
      if ($query AND $query->num_rows > 0)
      {
        // ACTUALIZA FECHA
        $query = $this->db->query("UPDATE `robots_ta` SET `status` = '1', `last_load` = UNIX_TIMESTAMP() WHERE `index_id` = '$id'");
      }

      // SI NO EXISTE
      else
      {
        // REGISTRA EL GRUPO
        $query = $this->db->query("INSERT INTO `robots_ta` SET (`index_id`, `status`, `last_load`) VALUES ('$id', '1', UNIX_TIMESTAMP()");
      }
    }

    /**
    * descarga una pagina y devuelve el html
    *
    * @param array
    * @param boolean
    * @return int
    */
    public function donwloadHTML($url) {


      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 (.NET CLR 3.5.30729)');
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
      curl_setopt($ch, CURLOPT_TIMEOUT, 15);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

      $html = curl_exec($ch);

      $res = array();

      $curlErrorCode = curl_errno($ch);

      return $html;
    }

    /**
    * recibe un texto que posiblemente es html y limpia algunas etiquetas
    *
    * @param string (html)
    * @return string
    */
    public function filterWords($string)
    {
      $badWords = array('Taringa','taringa','Tringa','Tarnga','tringa','tarnga');
      $string = str_replace($badWords,' SuperNatural ',$string);
      unset($badWords);
      $badWords = array('/taringer[^>]*?/','/Taringer[^>]*?/');
      $string = preg_replace($badWords,'Poster',$string);
      return $string;
    }
    public function cleanVarPostHTML($text)
    {
      // DECLARO TODAS LAS ETIQUETAS QUE QUIERO ELIMINAR
      $Tags = array('span','iframe','video','a','img','strong','h','p','div','ul','li','html','body','style','script','i','nav');

      // LIBERO ETIQUETAS
      foreach($Tags AS $Tags)
      {
        $tag = array('@<'.$Tags.'[^>]*?>@','@</'.$Tags.'[^>]*?>@','@<'.$Tags.'[^>]*?>.*?</'.$Tags.'>@');
        $text = preg_replace($tag,'', $text);
      }

      return $this->clean_bad_content($text);

    }
    public function clean_bad_content($string)
    {


      $szPostContent  = $string;

      $szRemoveFilter = array("~<p[^>]*>\s?</p>~","~<blockquote[^>]*>\s?</blockquote>~", "~<a[^>]*>\s?</a>~", "~<font[^>]*>~", "~<\/font>~", "~style\=\"[^\"]*\"~", "~<span[^>]*?>\s?</span>~");

      $szPostContent  = preg_replace($szRemoveFilter, '', $szPostContent);

      return $szPostContent;

    }

  }
