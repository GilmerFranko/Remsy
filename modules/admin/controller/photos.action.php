<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\admin\controller\photos.php      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Controlador principal de acciones de las fotos
 *
 *
 */

// COMPROBAR SI SE HA ESPECIFICADO ACCION
if (isset($_GET['do']))
{
    // AÑADIR NUEVA
    if ($_GET['do'] == 'new')
    {
        // VALIDAR ALGUNOS CAMPOS
        if ( isset($_POST['author']) && !empty($_POST['author']) && (isset($_POST['photo']) || isset($_FILES['photo']) ) )
        {
            // NOMBRE DE LA AUTORA
            $photo['author_name'] = Core::model('extra', 'core')->cleanVar($_POST['author']);
            // OBTENER ID DE LA AUTORA
            $photo['author'] = Core::model('member', 'members')->isMember(null, $photo['author_name'], true);
            if($photo['author'] > 0)
            {
                // GENERAR NOMBRE PARA LA FOTO
                $photo['image_name'] = $photo['author'].'-'.uniqid().'.jpg';
                // FECHA DE EXPIRACIÓN
                $photo['date_expires'] = strtotime($_POST['date']);
                // DESCRIPCIÓN (no se filtra para permitir HTML)
                $photo['description'] = $_POST['description'];

                // SI ES UNA RUTA
                if( isset($_POST['photo']) && !empty($_POST['photo']) )
                {
                    // CREAR RUTA DE LA FOTO
                    $photo['image_path'] = 'filestore/bots/' . $_POST['author'] . '/' . $_POST['photo'];
                    // COMPROBAR SI LA FOTO EXISTE
                    if(file_exists($photo['image_path']))
                    {
                        // MOVER FOTO AL DIRECTORIO DE FOTOS
                        if( rename($photo['image_path'], $config['photos_path'] . DS . $photo['image_name']) )
                        {
                            // GENERAR VARIABLE DE CONTINUADO
                            $continue = true;
                        }
                        else
                        {
                            $message[] = array('No se movi&oacute; la foto', 'error');
                        }
                    }
                    else
                    {
                        $message[] = array('La foto no existe', 'error');
                    }
                }
                // SI ES UN ARCHIVO
                elseif( isset($_FILES['photo']) && !empty($_FILES['photo']['name']) )
                {
                    // COMPROBAR SI SE HA SUBIDO CORRECTAMENTE
                    if(is_uploaded_file( $_FILES[ 'photo' ][ 'tmp_name' ] ))
                    {
                        // MOVER FOTO AL DIRECTORIO
                        if( move_uploaded_file( $_FILES[ 'photo' ][ 'tmp_name' ], $config['photos_path'] . DS . $photo['image_name']) )
                        {
                            // GENERAR VARIABLE DE CONTINUADO
                            $continue = true;
                        }
                        else
                        {
                            $message[] = array('No se movi&oacute; la foto subida', 'error');
                        }
                    }
                    else
                    {
                        $message[] = array('No se detecta el archivo subido', 'error');
                    }
                }
                // SI NO SE CONOCE LA FOTO
                else
                {
                    $message[] = array('No se reconoce la foto', 'error');
                }

                // SI LAS VALIDACIONES FUERON BIEN
                if( isset($continue) )
                {
                    // REGISTRAR FOTO
                    $addPhoto = Core::model('photos', 'admin')->newPhoto($photo);
                    // SI SE HA AGREGADO CORRECTAMENTE LA FOTO
                    if ($addPhoto > 0)
                    {
                        // BUSCAR SEGUIDORES DE LA BOT Y NOTIFICARLES
                        $message[] = array('Foto agregada: #' . $addPhoto, 'success');
                    }
                    // SI HAY ALGUN ERROR AL AGREGAR LA FOTO
                    else
                    {
                        $message[] = array('No se agreg&oacute; la foto', 'error');
                    }
                }
                else
                {
                    $message[] = array('No se puede continuar', 'error');
                }
            }
            else
            {
                $message[] = array('El usuario no existe', 'error');
            }
        }
        else
        {
            $message[] = array( 'No se ha especificado una foto', 'error' );
        }

    }
    // ELIMINAR FOTO
    elseif ($_GET['do'] == 'delete' && ctype_digit($_GET['id']))
    {
        // OBTENER DATOS DE LA FOTO
        $photo = Core::model('db', 'core')->getColumns('photos', 'image', array('id', $_GET['id']));
        if( !empty($photo) )
        {
            // BORRAR FOTO DE LA BASE DE DATOS
            $deletePhoto = Core::model('db', 'core')->deleteRow('photos', $_GET['id']);
            // SI SE HA PODIDO ELIMINAR DE LA BD
            if ($deletePhoto == true)
            {
                // ELIMINAR ARCHIVO DEL SERVIDOR
                $imagePath = BG_UPLOADS . DS .'photos' . DS . $photo;
                if( file_exists($imagePath) )
                {
                    unlink($imagePath);
                    $message[] = array( 'Foto eliminada', 'success' );
                }
                else
                {
                    $message[] = array( 'Borrada de la base de datos, pero no se encuentra en el servidor.', 'error' );
                }
            }
            // SI NO SE HA PODIDO ELIMINAR
            else
            {
                $message[] = array( 'No se ha podido borrar la foto', 'error' );
            }
        }
        else
        {
            $message[] = array( 'La imagen no existe', 'error' );
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
Core::model('extra', 'core')->generateUrl('admin', 'photos', NULL, array( 'save' => $message[0][1] ) , true);