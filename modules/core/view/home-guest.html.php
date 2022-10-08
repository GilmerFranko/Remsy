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
 * @Description Controlador principal de los creditos
 *
 *
 */
// HEADER
require Core::view('head', 'core');
// MENU
require Core::view('menu', 'core');
?>

<section>
    <a href="<?php echo Core::model('extra', 'core')->generateUrl('posts', 'list',null,null,true);exit; ?>">page</a>
</section>
<br>

<!-- FOOTER -->
<?php require Core::view('footer', 'core'); ?>
