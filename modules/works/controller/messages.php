<?php

define('JSON', 'C:\xampp\htdocs\mymove\filestore\messages_facebook\robertfranco.json');

if($data = @file_get_contents(JSON)){
  $items = json_decode($data, true);
}
//lista de items a recorrer
$message = $items["messages"];
$cnt = (count($message)-340);

?>
