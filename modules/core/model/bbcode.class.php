<?php
/**
 *-------------------------------------------------------/
 * @file        modules\core\model\bot.class.php         \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de manipular el lenguaje de marca BBCodes
 *
 *
*/
include "bbcode.inc.php";
class BBCode extends Parser\BBCode
{
	public function generateSCEditor($text = "")
	{
		return "hola";
	}
}
