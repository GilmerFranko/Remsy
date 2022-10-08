<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\view\index.html.php        \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de la página principal de la administración
 *
 *
*/

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<section><!--section_cuerpo-->
	<div class="container">
        <?php include Core::view('index.sidebar'); ?>
    </div>
</section>
<!-- / Body -->

<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->