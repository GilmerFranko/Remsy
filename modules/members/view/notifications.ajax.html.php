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

?>1:<div id="viewNotificationsAjax">
 <ul class="collection">
    <a class="btn waves-effect waves-light btn-large w100 grey darken-4" onclick="getNotifications('close');">Cerrar</a>
  <?php 
  if(!empty($photos)){
    foreach($photos as $photo) {
    echo '<li class="collection-item avatar deep-orange lighten-5" style="border-bottom: 2px dotted #6f6f6f">
      <a href="'.Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => $photo['author'])).'">
        <img src="'.Core::model('member', 'members')->getAvatar($photo['author']).'" alt="Avatar" class="circle">
        </a>
        <span class="title">'.$photo['content'].'</span>
    </li>';
    }
  }
  if(!empty($notifications)){
    foreach($notifications as $notification) {
      echo '<li class="collection-item avatar '.($notification['read_time'] > 0 ? '' : 'light-blue lighten-5').'" id="not'.$notification['id'].'">
      <a href="'.Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => $notification['from_member'])).'">
        <img src="'.Core::model('member', 'members')->getAvatar($notification['from_member']).'" alt="Avatar" class="circle">
        </a>
        <span class="title">'.(empty($notification['content']) ? Core::model('notifications', 'members')->generateNotification($notification['to_member'], $notification['from_member'], $notification['not_key'], $notification['item_id'], $notification['subitem_id']) : $notification['content']).'</span>
      <!--<a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>-->
    </li>';
  }
}
else
{
  echo '<blockquote class="flow-text">No hay notificaciones</blockquote>';
}
?>
</ul>
</div>
