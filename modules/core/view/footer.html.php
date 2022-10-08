<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        footer.html.php                          \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Archivo que incluye el pie de página
 *
 *
*/

var_dump(db('member')->getOnlines());
if($config['debug_mode'] == 1): ?>
	<span class="grey-text text-lighten-4 right" style="position: fixed;right: 0;    bottom: 0; background: rgba(0, 0, 0, 0.5); padding: 5px 5px 0 5px;">
		<?php Core::model('debug', 'core')->show($config['debug_mode']); ?>
		<br>
		<?php if (isset($_SESSION['models_used'])): ?>
			<?php foreach ($_SESSION['models_used'] as $key => $value): ?>
				<?php echo $value ?><br>
			<?php endforeach ?>
		<?php endif ?>
		<?php unset($_SESSION['models_used']); ?>
	</span>
<?php endif; ?>


<?php if($session->is_member == false) { ?>
	<footer class="page-footer blue darken-2 center">
		<div class="footer-copyright">
			<div class="container">
				&copy; <?php echo date('Y') . PHP_EOL . $config['script_name']; ?>
			</div>
		</footer>
	<?php } ?>
	<div id="google_translate_element2"></div>
	<script type="text/javascript">
		function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'es',autoDisplay: true}, 'google_translate_element2');}
	</script><script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>
	<!-- Translate -->
	<script type="text/javascript" src="<?php echo $config['base_url'];?>/static/js/translate.js"></script>
</body>
</html>
<?php

?>
