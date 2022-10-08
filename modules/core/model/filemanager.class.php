<?php defined('SUPERNATURAL') || exit;
/**
   °══════════════°---------------------
   ║  file        ║  this/C/xampp/htdocs/mymove2/modules/core/model 
   °══════════════°--------------------------
   °══════════════°-------------------------------
   ║  version     ║  v1.0                           
   °══════════════°------------------------------------
   °══════════════°-----------------------------------------
   ║  author      ║  Gilmer gilmerfranko@hotmail.com
   °══════════════°-----------------------------------------
   °══════════════°------------------------------------
   ║  copyrig     ║  (c) 2022 Gilmer Franco         
   °══════════════°-------------------------------
   °══════════════°--------------------------
   ║  Description ║  Este modelo se encarga del manejo de archivos
   °══════════════°---------------------
**/

Class FileManager{

	function copyFile($dir_copy = null, $dir_paste = null, $filename = null)
	{
		$filename = ($filename === null) ? basename($dir_copy) : $filename;
		// Comprueba que existe el archivo
		if(file_exists($dir_copy))
		{
			// Comprueba que existe la ruta a pegar
			if (file_exists($dir_paste))
			{
				// Si el archivo se copio con exito
				if(copy($dir_copy, $dir_paste))
				{
					return $dir_paste;
				}
				else
				{
					return false;
				}
			}
		}
	}
	function copyDirectory($dir_copy = null, $dir_paste = null)
	{
		// Comprueba que existe el directorio
		if(file_exists($dir_copy))
		{
			// Comprueba que existe la ruta a pegar
			if (file_exists($dir_paste))
			{
				// Almacenar archivos del directorio
				$files= glob($dir_copy . '*.*');
				// Recorrer
				foreach ($files AS $file)
				{
					$file_to_copy = str_replace($dir_copy, $dir_paste, $file);
					copy($file, $file_to_copy);
				}
			}
		}
	}
}
