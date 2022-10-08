<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\site\controller\contact.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador de sección "Contacto" del sitio
 *
 *
 */

$page['name'] = 'Contacto';
$page['code'] = 'siteContact';

if(isset($_SESSION['message']) && !empty($_SESSION['message']))
{
    echo Core::model('extra', 'core')->getToast($_SESSION['message']);
}

// SI SE RECIBE EL FORMULARIO
if(isset($_POST['contact']))
{
	if($session->is_member == true)
	{
		$contact['member_id'] = $session->memberData['member_id'];
		$contact['name'] = $session->memberData['name'];
		$contact['email'] = $session->memberData['email'];
	}
	else
	{
		$contact['member_id'] = 0;

		if(isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

			$contact['name'] = Core::model('extra', 'core')->cleanVar($_POST['name']);
			$contact['email'] = Core::model('extra', 'core')->cleanVar($_POST['email']);
		}
		else
		{
			$message[] = array('Debes indicar tu nombre y email', 'error');
		}

	}
	if(isset($_POST['title']) && !empty($_POST['title']) && isset($_POST['content']) && !empty($_POST['content']))
	{
		$contact['title'] = Core::model('extra', 'core')->cleanVar($_POST['title']);
		$contact['content'] = Core::model('extra', 'core')->cleanVar($_POST['content']);
		
		// REGISTRAR CONTACTO SIN AVISAR POR EMAIL
		$contact = Core::model('site', 'site')->newContact($contact, false);

		// SI SE HA REGISTRADO
		if($contact > 0)
		{
			$message[] = array('Hemos recibido tu consulta', 'success');
		}
		else
		{
			$message[] = array('No hemos podido registrar la consulta', 'error');
		}
	}
	else
	{
		$message[] = array('Debe ingresar t&iacute;tulo y mensaje', 'error');
	}

	if(isset($message[0][0]))
	{
		// ESTABLECER MENSAJE EN LA SESION
    	Core::model('extra', 'core')->setToast($message);

		if($message[0][1] == 'success')
		{
			// REDIRECCIONAR
			Core::model('extra', 'core')->generateUrl('shouts', 'list', NULL, NULL, true);
		}
	}
	
}