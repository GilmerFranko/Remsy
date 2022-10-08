<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\controller\account.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de la cuenta
 *
 *
 */

$page['name'] = 'Mi cuenta';
$page['code'] = 'memberAccount';

// OBTENER BLOQUEADOS
$blocked = Core::model('profile', 'members')->getFollowsBlocks($session->memberData['member_id'], 0, 1, 'block');