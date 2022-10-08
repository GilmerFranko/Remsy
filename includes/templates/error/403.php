<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\error\403.php                    \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este archivo mostrará un error de acceso prohibido (Forbidden)
 *
 *
*/

 header('HTTP/1.1 403 Forbidden');
 //
 $page['name'] = '403 - Prohibido';
 //
 require Core::view('head', 'core');
 require Core::view('menu', 'core');
?>

<!-- Body -->
<section>
	<div class="container">
        <h1 style="text-align: center; padding: 21.1% 0 32% 0;">Acceso prohibido</h1>
    </div>
</section>
<!-- / Body -->

<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->