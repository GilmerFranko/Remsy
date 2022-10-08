<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\controller\logout.php     \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador del registro de usuarios
 *
 *
 */

$page['name'] = 'Registro';
$page['code'] = 'membersRegister';
//
if( isset($_POST['register']) )
{
    if( !empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['email']) )
    {
        // COMPROBAR NOMBRE Y EMAIL CORRECTOS
        if( preg_match("/^([a-zA-Z ]{4,30}+)$/isu", $_POST['name'])  && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) )
        {
            if(strlen($_POST['password']) > 5)
            {
                if($_POST['password'] === $_POST['confirmPassword'])
                {
                    /* Se definen y limpian las variables */
                    $memberData = array_map('htmlspecialchars', $_POST);
                    $memberData['password'] = password_hash($memberData['password'], PASSWORD_DEFAULT);
                    $memberData['gender'] = ($memberData['gender'] == '1') ? 1 : 0;
                    $memberData['email'] = strtolower($memberData['email']);
                    //
                    if( Core::model('member', 'members')->checkUserExists($memberData['name'], $memberData['email']) === false ) 
                    {
                        $memberData['member_id'] = Core::model('access', 'members')->signIn($memberData);
                        //
                        if( is_numeric($memberData['member_id'])  )
                        {
                            // VALIDAR CUENTA POR CORREO
                            if( $config['reg_validate'] == '1' )
                            {
                                if( $hash = Core::model('access', 'members')->setRecover($memberData['member_id'], $memberData['email'], 2) )
                                {
                                    /* Enviamos el email de bienvenida / confirmación */
                                    Core::model('email', 'core')->sendEmail( 'welcome', $memberData['email'], array('name' => $memberData['name'], 'password' => $memberData['password'], 'hash' => $hash) );
                                    $message[] = array('Has sido registrado. Recibir&aacute; instrucciones en su correo electr&oacute;nico para validar la cuenta', 'success');
                                }
                                else
                                {
                                    $message[] = array('Has sido registrado. Sin embargo, no hemos podido enviar la confirmaci&oacute;n de la cuenta. Por favor, solicita una nueva', 'warning');
                                }
                            }
                            else
                            {
                                // Identifica al usuario
                                Core::model('access', 'members')->login($memberData['member_id']);
                                // Redirige a la cuenta
                                Core::model('extra', 'core')->generateUrl('members', 'account', null, null, true);
                            }
                        } else {
                            $message[] = array('No hemos podido registrarte', 'error');
                        }
                    } else {
                        $message[] = array('Ya existe un usuario registrado con este nombre, o ha ocurrido un error. Int&eacute;ntalo m&aacute;s tarde.', 'error');
                    }
                } else {
                    $message[] = array('Las contrase&ntilde;as no coinciden', 'error');
                }
            } else {
                $message[] = array('Contrase&ntilde;a: m&iacute;nimo 4 caracteres.', 'error');
            }
        } else {
            $message[] = array('Nombre o email no v&aacute;lidos.', 'error');
        }
    } else {
         $message[] = array('Debes rellenar todos los campos', 'error');
    }

    // ESTABLECER MENSAJE EN LA SESION
    $extra->setToast($message);

    // MOSTRAR MENSAJE
    echo Core::model('extra', 'core')->getToast($message);
}
