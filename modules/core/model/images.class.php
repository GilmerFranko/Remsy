<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\core\model\extra.class.php       \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo incluye funciones variadas con utilización frecuente
 *
 *
*/

class Images
{
    function resize($img = null, $destination = null, $quality = 100, $max_width = 600, $max_height = 400)
    {
        //Crear variable
        $original = imagecreatefromjpeg($img);

        //Medir la imagen
        list($width,$height)=getimagesize($img);

        //Ratio
        $x_ratio = $max_width / $width;
        $y_ratio = $max_height / $height;

        //Proporciones
        if(($width <= $max_width) && ($height <= $max_height) ){
            $final_width = $width;
            $final_height = $height;
        }
        else if(($x_ratio * $height) < $max_height){
            $final_height = ceil($x_ratio * $height);
            $final_width = $max_width;
        }
        else {
            $final_width = ceil($y_ratio * $width);
            $final_height = $max_height;
        }

        //Crear un lienzo
        $lienzo=imagecreatetruecolor($final_width,$final_height); 

        //Copiar original en lienzo
        imagecopyresampled($lienzo,$original,0,0,0,0,$final_width, $final_height, $width, $height);
         
        //Destruir la original
        imagedestroy($original);
        
        //Crear la imagen y guardar en directorio upload/
        imagejpeg($lienzo, $destination, $quality);

        return true;
    }

    /**
     * Fuerza la descarga de un archivo
     * 
     * @param 
     * @return
     */
    public function download($file, $filename)
    {
        /*header('Cache-Control: public');
        header('Content-Description: File Transfer');
        header('Content-Transfer-Encoding: Binary');*/
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/force-download');
        header("Content-Disposition: attachment; filename=\"$filename\"\n");
        readfile($file);

        return true;
    }
}