<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\controller\account.php   \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador de sección "Contraseña" en la cuenta
 *
 *
 */

// ACTUALIZAR EMAIL
if ($session->memberData['email'] !== $_POST['email'])
{
    // Comprobar formato del email
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        if (Core::model('member', 'members')->checkUserExists($session->memberData['name'], $_POST['email']) === false)
        {
            if( Core::model('account', 'members')->setMemberInput($_POST['email'], 'email', $session->memberData['member_id']) === true)
            {
                $message[] = array(
                    'Email actualizado',
                    'success'
                );
            }
        }
        else
        {
            $message[] = array(
                'El email ya est&aacute; en uso',
                'error'
            );
        }
    }
    else
    {
        $message[] = array(
            'El email es incorrecto',
            'error'
        );
    }
}
// ACTUALIZAR PASSWORD
//if (isset($_POST['currentPassword']) && !empty($_POST['currentPassword']))
if(3>2) #TEMPORAL
{
    if (!empty($_POST['newPassword']) && !empty($_POST['confirmPassword']))
    {
        if (strlen($_POST['newPassword']) >= 6)
        {
            if($_POST['newPassword'] == $_POST['confirmPassword'])
            {
                // Verificar que la contraseña actual sea la introducida
                //if (password_verify($_POST['currentPassword'], $session->memberData['password']) === true)
                if(3>2) #TEMPORAL
                {
                    if (Core::model('account', 'members')->setMemberInput(password_hash($_POST['newPassword'], PASSWORD_DEFAULT), 'password', $session->memberData['member_id']) === true)
                    {
                        $message[] = array(
                            'Contrase&ntilde;a actualizada',
                            'success'
                        );
                    }
                    else
                    {
                        $message[] = array(
                            'No se ha podido guardar la contra&ntilde;a',
                            'error'
                        );
                    }
                }
                else
                {
                    $message[] = array(
                        'La contrase&ntilde;a actual introducida es incorrecta',
                        'error'
                    );
                }
            }
            else
            {
                $message[] = array(
                    'La nueva contrase&ntilde;a no coincide',
                    'error'
                );
            }
        }
        else
        {
            $message[] = array(
                'La nueva contrase&ntilde;a debe tener al menos 6 caracteres',
                'error'
            );
        }
    }
    else
    {
        $message[] = array(
            'Para actualizar la contrase&ntilde;a debe rellenar todos los campos',
            'error'
        );
    }
}