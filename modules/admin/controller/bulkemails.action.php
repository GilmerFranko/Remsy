<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\controller\bulkemail.php  \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de acciones de los correos masivos
 *
 *
 */
// COMPROBAR SI SE HA ESPECIFICADO ACCION
if (isset($_GET['do']))
{
    /** ============== NUEVO CORREO ============== **/
    if ($_GET['do'] == 'new')
    {
        // VALIDAR ALGUNOS CAMPOS
        if ( isset($_POST['subject'], $_POST['content'], $_POST['addressees_type']) && !empty($_POST['subject']) && !empty($_POST['content'] && !empty($_POST['addressees_type'])) )
        {
            // COMPROBAR TIPO
            if($_POST['addressees_type'] >= 1 && $_POST['addressees_type'] <= 4)
            {
                // ELIMINAR ESPACIOS EN FORMULARIO
                $bulkemail = array_map('trim', $_POST);

                // GENERAR RUTA AL ARCHIVO CSV
                $bulkemail['addressees_file'] = uniqid() . '.csv';

                // SI ES TIPO ARCHIVO
                if(isset($_FILES['addressees']['tmp_name']) && !empty($_FILES['addressees']['tmp_name']))
                {
                    // NOMBRE DEL ARCHIVO ORIGINAL
                    $bulkemail['addressees'] = $_FILES['addressees']['name'];

                    // MOVER ARCHIVO ORIGINAL
                    if( !move_uploaded_file($_FILES['addressees']['tmp_name'], $config['bulkemails_path'] . DS . $bulkemail['addressees_file']) )
                    {
                        $message[] = array( 'No se ha podido subir el archivo', 'error') ;
                    }
                }
                
                // OBTENER DESTINATARIOS
                $addressees = Core::model('bulkemails', 'admin')->getAddressees($_POST['addressees_type'], $_POST['addressees'], $bulkemail);

                // COMPROBAR QUE HAY DESTINATARIOS
                if(!empty($addressees))
                {
                    // CANTIDAD DE CORREOS
                    $bulkemail['addressees_count'] = count($addressees);
                    // FECHA DE ENVÍO
                    $bulkemail['date'] = isset($_POST['action']) ? time() : strtotime($bulkemail['date']);
                    // REGISTRAR CORREO EN LA BASE DE DATOS
                    $bulkemail['id'] = Core::model('bulkemails', 'admin')->newEmail($bulkemail);
                    // SI SE HA REGISTRADO CORRECTAMENTE
                    if($bulkemail['id'] > 0)
                    {
                        // GUARDAR ARCHIVO DE DESTINATARIOS
                        $genAddressees = Core::model('bulkemails', 'admin')->genAddressees($addressees, $bulkemail['addressees_file']);

                        // SI ALGO FALLÓ AL REGISTRAR EN EL CSV
                        if( $genAddressees != $bulkemail['addressees_count'])
                        {
                            $message[] = array('Usuarios que lo recibir&aacute;n: ' . $genAddressees . '/' . $bulkemail['addressees_count'], 'warning');
                        }
                        
                        // MENSAJE DE CONFIRMACIÓN
                        $message[] = array('Correos programados', 'success');
                    }
                    else
                    {
                        $message[] = array('No se ha podido registrar el correo', 'error');
                    }
                }
                else
                {
                    // ELIMINAR ARCHIVO TEMPORAL
                    unlink($config['bulkemails_path'] . DS . $bulkemail['addressees_file']);

                    $message[] = array('No se han encontrado destinatarios', 'error');
                }
            }
            else
            {
                $message[] = array('No se ha podido determinar el tipo de destinatario', 'error');
            }
        }
        else
        {
            $message[] = array( 'No se ha especificado t&iacute;tulo o contenido', 'error' );
        }

    }
    /** ============== ENVIAR CORREOS ============== **/
    elseif ($_GET['do'] == 'send' && ctype_digit($_GET['id']))
    {
        // OBTENER DATOS DEL CORREO
        $bulkemail = Core::model('db', 'core')->getColumns('site_bulk_emails', array('id', 'subject', 'content'), array('id', $_GET['id']));
        if( !empty($bulkemail['id']) )
        {
            // OBTENER DESTINATARIOS
            $addressees = Core::model('bulkemails', 'admin')->listAddressees($bulkemail['id']);
            // ENVIAR CORREOS
            $sendBulkemails = Core::model('bulkemails', 'admin')->sendBulkemails($bulkemail, $addressees);
            // INDICAR CORREOS ENVIADOS
            $message[] = array( 'Correos enviados: ' . $sendBulkemails, 'success' );
        }
        else
        {
            // NO SE ENCUENTRA EL CORREO
            $message[] = array( 'No se encuentra el correo', 'error' );
        }
    }
    /** ============== ELIMINAR CORREO ============== **/
    elseif ($_GET['do'] == 'delete' && ctype_digit($_GET['id']))
    {
        // OBTENER DATOS DEL CORREO
        $bulkemail = Core::model('db', 'core')->getColumns('site_bulk_emails', array('addressees_file', 'addressees_type'), array('id', $_GET['id']));
        if( !empty($bulkemail) )
        {
            // BORRAR CORREO DE LA BASE DE DATOS
            $deleteBulkEmail = Core::model('db', 'core')->deleteRow('site_bulk_emails', $_GET['id']);
            // SI SE HA PODIDO ELIMINAR DE LA BD
            if ($deleteBulkEmail == true)
            {
                // ELIMINAR DEL DIRECTORIO
                if( unlink($config['bulkemails_path'] . DS . $bulkemail['addressees_file']) == FALSE )
                {
                    // MENSAJE DE CONFIRMACIÓN
                    $message[] = array( 'Falt&oacute; eliminar el archivo ' . $bulkemail['addressees_file'], 'warning' );
                }
                

                // MENSAJE DE CONFIRMACIÓN
                $message[] = array( 'Correo eliminado', 'success' );
                
            }
            // SI NO SE HA PODIDO ELIMINAR
            else
            {
                $message[] = array( 'No se ha podido borrar el correo', 'error' );
            }
        }
        else
        {
            $message[] = array( 'El correo no existe', 'error' );
        }
    }
    // NO SE ENCUENTRA LA ACCIÓN DEL USUARIO
    else
    {
        $message[] = array( 'Tipo desconocido', 'error') ;
    }
}
// SI NO SE HA ESPECIFICADO EL PARÁMETRO "DO"
else
{
    $message[] = array('Faltan par&aacute;metros', 'error' );
}

// ESTABLECE UN MENSAJE EN CASO DE HABERLO
Core::model('extra', 'core')->setToast($message);
// REDIRIGIR
Core::model('extra', 'core')->generateUrl('admin', 'bulkemails', NULL, array( 'save' => $message[0][1], 'id' => $bulkemail['id']) , true);