<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------
 * @file        modules\works\controller\groups.php
 * @package     One V
 * @author      Gilmer <gilmerfranko@hotmail.com>
 * @copyright   (c) 2020 Gilmer Franco
 *
 *=======================================================
 *
 * @Description Controlador principal de los grupos de tareas
 *
 *
 */
$page['name'] = 'Grupos';
$page['code'] = 'groups';

$mWork = new mWork;
$mCore = new mCore;

$groups = $mWork->m('pending_tasks')->getAllGroups();
?>
