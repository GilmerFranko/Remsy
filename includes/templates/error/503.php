<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\error\4503.php                    \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este archivo mostrará un error 503 (Temporalmente no disponible)
 *
 *
*/

 header('HTTP/1.1 503 Service Temporarily Unavailable');
 header('Retry-After: 500');
 //
 $page['name'] = '503 - Servicio no disponible';
 //
 //require Core::view('head', 'core');
 //require Core::view('menu', 'core');
 //
 $message = !empty($message[0]) ? $message[0] : 'P&aacute;gina no disponible temporalmente';
?>

<!-- Body -->
<section>
	<div class="container">
        <h1 style="text-align: center; padding: 21.1% 0 32% 0;"><?php echo $message; ?></h1>
    </div>  
</section>
<!-- / Body -->

<!-- Footer -->
<?php //require Core::view('footer', 'core');?>
<!-- / Footer -->