<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\view\notifications.html.php
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de las notificaciones del usuario
 *
 *
*/

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<section id="viewNotifications">
 <ul class="collection">
    <?php
    if(!empty($notifications)){
  foreach($notifications as $notification) {
    echo '<li class="collection-item avatar '.($notification['read_time'] > 0 ? '' : 'light-blue lighten-5').'" id="not'.$notification['id'].'">
      <a href="'.Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => $notification['from_member'])).'">
        <img src="'.Core::model('member', 'members')->getAvatar($notification['from_member']).'" alt="Avatar" class="circle">
        </a>
        <span class="title">'.(empty($notification['content']) ? Core::model('notifications', 'members')->generateNotification($notification['to_member'], $notification['from_member'], $notification['not_key'], $notification['item_id'], $notification['subitem_id']) : $notification['content']).'</span>
      <span class="secondary-content">'.Core::model('date', 'core')->getTimeAgo($notification['sent_time']).'<i class="material-icons right">date_range</i></span>
      <!--<span class="secondary-content">'.date('d-m-y H:i', $notification['sent_time']).'<i class="material-icons right">date_range</i></span>-->
    </li>';
  }
}
else
{
  echo '<blockquote class="flow-text">No hay notificaciones</blockquote>';
}
?>
</ul>
</section>
<!-- / Body -->

<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->