<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\controller\coins.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2021 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal del sraping a taringa
 *
 *
 */
$page['name'] = 'Posts de Taringa +ecologia';
$page['code'] = 'postTg';

$group = Core::model('post', 'posts')->getRobotsTa();

// INICIA EL SCRAPPING
if(isset($_GET['group']) AND !empty($_GET['group']) AND is_numeric($_GET['group']))
{
  Core::model('post', 'posts')->getPostTg('https://taringa.net/smaps/taringa-sitemap-story-index.'. $_GET['group'] .'.xml', $_GET['group']);
}
// DEVUELVE LA CANTIDAD DE POSTS SCRAPEADOS
if(isset($_GET['returnPostsGroup']) AND !empty($_GET['returnPostsGroup']) AND is_numeric($_GET['returnPostsGroup']))
{
  echo Core::model('extra', 'core')->db->query("SELECT * FROM `content_scrapped`")->num_rows;
}
?>
