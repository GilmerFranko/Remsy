<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\core\model\db.class.php          \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo incluye funciones variadas MySQL
 * 
 *
*/

class Db extends Model
{

	public function __construct()
	{
		parent::__construct();
		$this->session = Core::model('session', 'core');
	}


  /**
   * Obtiene la cuenta de una columna
   *
   * @param string $table
   * @param string $column
   * @param array $where
   * @return string/int/array $input
   */
  public function getCount($table = null, $column = null, $where = null)
  {
  	$query = $this->db->query('SELECT COUNT(`'.$column.'`) FROM `'.$table.'` WHERE `'.$where[0].'` = \''.$this->db->real_escape_string($where[1]).'\'');
  		if ($query == true && $query->num_rows > 0)
  		{
  			$result = $query->fetch_row();
            //
  			return $result[0];
  		}

  		return 0;
  	}

 /**
   * Obtiene uno o más columnas de una fila
   *
   * @param string $table
   * @param string/array $columns
   * @param array $where
   * @return string/int/array $input
   */
 public function getColumns($table = null, $input = null, $where = null, $limit = 1, $sentence = false)
 {
 	$columns = is_array($input) ? implode('`,`', $input) : $input;
 	$where = is_null($where) ? 'ORDER BY RAND()' : 'WHERE `'.$where[0].'` = \''.$this->db->real_escape_string($where[1]).'\'';
 	$query = $this->db->query('SELECT `'.$columns.'` FROM `'.$table.'` '.$where.' LIMIT '.$limit);
 	if ($query == true)
 	{
 		if($query->num_rows > 0)
  	{
  		$result = $sentence == true ? $query : $query->fetch_assoc();
  		return is_array($input) ? $result : $result[$input];
  	}
  	else
  	{
  		die('La consulta se ejecuto con exíto pero devolvió 0 filas');
  		return false;
  	}
  }

  return false;
}

  /**
   * Elimina una fila de la base de datos
   *
   * @param string $table     // NOMBRE DE LA TABLA
   * @param string $where     // NOMBRE COLUMNA WHERE
   * @param int $id           // ID A ELIMINAR
   * @param int $limit        // LIMITE A ELIMINAR
   * @return boolean/integer
   */
  function deleteRow($table = null, $id = null, $where = 'id', $limit = 1)
  {
        // BORRAR FILA
  	$query = $this->db->query('DELETE FROM `'.$table.'` WHERE `'.$where.'` = \''.$id.'\' LIMIT '.$limit);
        //
  	if ($query == true && $this->db->affected_rows > 0)
  	{
  		return true;
  	}
        // RETORNA FALSE SI NO SE HA ELIMINADO NADA
  	return false;
  }

  /**
   * Suma o Resta valor a un campo de una tabla
   *
   * @param string $table
   * @param string $column
   * @param int $id
   * @param string $value
   * @param string $where
   * @param int $limit
   * @return boolean
   */
  function updateCount($table = null, $column = null, $id = null, $value = '+1', $where = 'id', $limit = 1)
  {
  	$query = $this->db->query('UPDATE `'.$table.'` SET `'.$column.'` = `'.$column.'` '.$value.' WHERE `'.$where.'` = \''.$id.'\' LIMIT '.$limit);
        // RETORNAR
  	if ($query == true && $this->db->affected_rows > 0)
  	{
  		return true;
  	}
        //
  	return false;
  }
  /**
   * Obtiene una o mas columnas de una una cantidad solicitada de filas
   *
   * @param string $table
   * @param string/array $columns
   * @param array $where
   * @return string/int/array $input
   */
  public function getAllRows($table = null, $input = null, $limit = 1, $sentence = false)
  {
  	$columns = is_array($input) ? implode('`,`', $input) : $input;
    	//$where = is_null($where) ? '' : 'WHERE `'.$where[0].'` = \''.$this->db->real_escape_string($where[1]).'\'';
  	$query = $this->db->query('SELECT '.$columns.' FROM `'.$table.'`');
  	if ($query == true && $query->num_rows > 0)
  	{
  		while($row = $query->fetch_assoc())
  		{
  			$groups['data'][] = $row;
  			$groups['rows'] = $query->num_rows;
  		}
  		return $groups;
  	}
  	return false;
  }


  public function get_last_id($table = 'members')
  {
  	$query = $this->db->query('SELECT * FROM `'.$table.'` ORDER BY DESC LIMIT 1');
  	if ($query == true && $query->num_rows > 0)
  	{
  		return $query;
  	}
  	return false;
  }

  /// Prueba, se cargan las sql dependiendo de la tabla ///)

  public function clients()
  {
  	$hola = 0;
  	return $hola;
  }
  public function members()
  {

  }
  public function members_groups()
  {

  }
  public function members_notes()
  {

  }
  public function setting()
  {

  }
  public function site_configuration()
  {

  }
  public function works_pending()
  {

  }
  public function work_done()
  {

  }
  public function work_group()
  {

  }
}

