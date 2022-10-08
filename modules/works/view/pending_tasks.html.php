<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\posts\view\links-tar.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2021 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista principal del apartado Tareas Pendientes
 *
 *
 */
// TASKS
require Core::view('tasks.area', 'works');
// MODAL ADD-TIME
require Core::view('add-time.modal', 'works');
// MODAL ADD-TASK
require Core::view('add-task.modal', 'works');
// MODAL Agregar Description
require Core::view('add-description.modal', 'works');


