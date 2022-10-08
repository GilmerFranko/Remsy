
<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\controller\coins.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de todos los Posts
 *
 *
 */
$page['name'] = 'Posts';
$page['code'] = 'viewPost';

$posts = Core::model('post', 'posts')->getAllPosts(true);

