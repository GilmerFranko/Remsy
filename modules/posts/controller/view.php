<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\posts\controller\view.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2021 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de la vista de un post
 *
 *
 */
$page['name'] = 'Post';
$page['code'] = 'viewPost';

if (isset($_GET['postID']) AND !empty($_GET['postID']))
{
	$postID = $_GET['postID'];

  $table = (isset($_GET['scContent']) AND $_GET['scContent']=='true') ? 'content_scrapped' : 'members_posts';

	$post = Core::model('post', 'posts')->getPost($table ,$postID);
}
else
{
	$extra->generateUrl('posts', 'list',null,null,true);
}
?>
