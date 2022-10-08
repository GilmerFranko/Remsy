<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\view\profile.html.php    \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista del área "Bloqueados" de la sección "Cuenta"
 *
 *
*/
?>
<ul class="collection">
	<?php if(!empty($blocked)) {
		while( $member = $blocked->fetch_assoc() ) { ?>
    	<li class="collection-item avatar">
	      <img src="<?php echo $member['pp_thumb_photo']; ?>" alt="Avatar" class="circle" onerror="this.src='<?php echo $config['avatar_url'] . '/default_1.jpg'; ?>';">
	      <span class="title"><?php echo $member['name']; ?></span>
	      <p><?php echo $member['pp_full_name']; ?></p>
	      <a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'profile', 'block', array('user' => $member['member_id'], 'action' => 'unblock', 'token' => $session->token)); ?>" class="secondary-content btn blue darken-2" title="Desbloquear"><i class="material-icons">do_not_disturb_off</i></a>
	    </li>
	<?php }
} else { echo '<blockquote class="flow-text">No has bloqueado a nadie</blockquote>'; } ?>
</ul>
