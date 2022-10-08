<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\works\model\pending_tasks.class.php        \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a las tareas del usuario
 *
 *
*/

	class Pending_tasks extends Model
	{

		public function __construct()
		{
			parent::__construct();
			$this->session = Core::model('session', 'core');
		}

    /**
     * Devuelve un array de las tareas pendientes del usuarios
     * @return [type] [description]
     */
    public function getTasksPending($id = null)
    {
    	$query = $this->db->query("SELECT *, works_pending.`id` AS `wp_id` FROM `works_pending` WHERE `done` = '0' ORDER BY `wp_id` DESC, `workgroup_id` DESC");
    	if($query == true && $query->num_rows > 0)
    	{
    		while($row = $query->fetch_assoc())
    		{
    			$BBCode = Core::model('bbcode', 'core');
    			$BBCode->setText($row['description']);
    			$BBCode->setRestriction(array());
  				$row['description_txt'] = $BBCode->getAsText();
    			$tasks['data'][] = $row;
    			$tasks['rows'] = $query->num_rows;
    		}
    		return $tasks;
    	}
    }

    public function setStopWatch($idTask = null, $timer = null)
    {
    	$query = $this->db->query("UPDATE `works_pending` SET `stopwatch_time` = \"". $this->db->real_escape_string($timer) ."\" WHERE `id` = \"". $this->db->real_escape_string($idTask) ."\"");
    	if($query)
    	{
    		return true;
    	}
    	return false;
    }

    public function addTime($idTask = null, $time_add = 0)
    {
    	$idTask = $this->db->real_escape_string($idTask);
    	$time_add = $this->db->real_escape_string($time_add);

    	// Verifica que exista el task
    	$query = $this->db->query("SELECT `id` FROM `works_pending` WHERE `id` = \"". $idTask ."\"");
    	if($query AND $query->num_rows)
    	{
	    	// Actualiza los segundos
	    	$query = $this->db->query("UPDATE `works_pending` SET `net_time` = `net_time` + \"". $time_add ."\" WHERE id = \"". $idTask ."\"");

				// Si se agrego con exito
	    	if ($query)
	    	{
					// Seleccionar "net_time"
	    		$query = $this->db->query("SELECT `net_time` FROM `works_pending` WHERE `id` = \"". $idTask ."\"");
					//
	    		if ($query AND $query->num_rows > 0)
	    		{
	    			$newTime = mysqli_fetch_assoc($query);
						// Devolver mensaje
	    			return json_encode(['status' => true,'message' => 'Tiempo agregado', 'newTime' => $newTime['net_time'], false]);

	    		}
					// SI ALGO FALLO
	    		else
	    		{
						// Devolver mensaje de error
	    			return json_encode(['status' => true, 'message' => 'Se agrego el Tiempo pero no se pudo devolver la consulta' ]);
	    		}
	    	}
	    	// De no poder actualizar la fila
	    	else
	    	{
	    		// Devolver mensaje de error
	    		return json_encode(['status' => false,'message' => 'No se pudieron hacer cambios, intente denuevo.']);
	    	}
	    }
	    // De no existir la fila
	    else
	    {
	    	// Devolver mensaje de error
	    	return json_encode(['status' => false,'message' => 'La fila a actualizar no existe']);
	    }
	  }

	  /**
	   * Actualiza la descripcion de una tarea
	   * @param  int  		$idTask
	   * @param  string 	$description
	   * @return boolean
	   */
	  public function updateDescription($idTask = null, $description = array())
    {
    	$description['description'] = $this->clearText($description['description']);
    	$updates = Core::model('extra', 'core')->getIUP($description, '');
    	$query = $this->db->query("UPDATE `works_pending` SET ".$updates." WHERE id = \"". $idTask ."\"");
    	if($query) return true;
    	return false;
    }

    public function clearText($text = "")
    {
    	$text = htmlspecialchars($text, ENT_COMPAT|ENT_QUOTES, 'UTF-8');
    	//	$text = preg_replace("[\n|\r|\n\r]", "", $text);
    	return $text;
    }
    public function getAllGroups()
    {
			$Groups = Core::model('db','core')->getAllRows('work_group', '*', 1000);
			if($Groups)
    	{
    		return $Groups;
    	}
    }
  }
