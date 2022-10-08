<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------
 * @file        modules\works\controller\pending_tasks.php
 * @package     One V
 * @author      Gilmer <gilmerfranko@hotmail.com>
 * @copyright   (c) 2020 Gilmer Franco
 *
 *=======================================================
 *
 * @Description Controlador principal de las tareas pendientes
 *
 *
 */
$page['name'] = 'Tareas Pendientes';
$page['code'] = 'pending_tasks';

$mWork = new mWork;
$mCore = new mCore;
// SI ES UNA PETICIÓN AJAX
if(isset($_POST['ajax']) AND !empty($_POST['ajax']))
{
	// Actualiza cronometro
	if(isset($_GET['add-stopWatch']) AND !empty($_GET['add-stopWatch']) AND isset($_GET['idTask']) AND !empty($_GET['idTask']) AND isset($_GET['timer']) AND is_numeric($_GET['timer']))
	{
		echo Core::model('pending_tasks', 'works')->setStopWatch($_GET['idTask'], $_GET['timer']);
	}

	// Actualiza los segundos gastados de una tarea
	if (isset($_GET['add-time']) AND isset($_GET['idTask']) AND !empty($_GET['idTask']) AND is_numeric($_GET['idTask']))
	{
		// VARIABLES
		$id      = $_GET['idTask'];
		$hours   = (isset($_GET['hours']) AND !empty($_GET['hours'])) ? $_GET['hours'] : 0;
		$minutes = (isset($_GET['minutes']) AND !empty($_GET['minutes'])) ? $_GET['minutes'] : 0;
		$hours   = ($hours*60)*60;
		$minutes = $minutes*60;
		$total   = $hours+$minutes;
		echo Core::model('pending_tasks', 'works')->addTime($id, $total);
	}

	if (isset($_GET['addvalue']) )
	{
		$value=$_POST['value'];
		$id=$_POST['id'];
		$query=mysqli_query($connect,"UPDATE work_done SET value='$value' WHERE id='$id'");
	}
	if (isset($_GET['addWork']) )
	{
		$work = $_POST['work'];
		$description = $_POST['description'];
		$numGroup = $_POST['numGroup'];
		$date = date('Y-m-d');

		$query=mysqli_query($connect,"INSERT INTO works_pending (workgroup_id,work,done,description,date,time) VALUES ('$numGroup', '$work', '0' , '$description', '$date' , '0') ");
		if ($query) {
			echo json_encode(['status' => true,'message' => 'La tarea se ha agregado correctamente' ]);
		}
		else
		{
			echo json_encode(['status' => false,'message' => 'ERROR ' ]);
		}
	}
	if (isset($_GET['saveTextWork'])){
		$query=mysqli_query($connect,"UPDATE works_pending SET work=\"". $_POST['wText'] ."\" WHERE id=\"". $_POST['wID'] ."\"");
		if($query)
		{
			$message = array(true,'Se guardaron los cambios correctamente','','success');
		}
		else
		{
			$message = array(false,'ha ocurrido un problema','','info');
		}
		echo json_encode($message);
	}
	// Actualiza descripción de una tarea
	if (isset($_GET['saveDescription']))
	{
		if(isset($_POST['idTask']) AND !empty($_POST['idTask']) AND is_numeric($_POST['idTask']))
		{
			if(isset($_POST['text']) AND !empty($_POST['text']))
			{
				if(Core::model('pending_tasks', 'works')->updateDescription($_POST['idTask'], array('description' => $_POST['text'])))
				{
					$message = array(true,'Descripci&oacute;n guardada con exito','','info');
				}
				else
				{
					$message = array(false,'ha ocurrido un problema','','info');
				}
			}
			else
			{
				$message = array(false,'ha ocurrido un problema','','info');
			}
		}
		else
		{
			$message = array(false,'ha ocurrido un problema','','info');
		}
		echo json_encode($message);
		return false;
	}
}


else
{
	// OBTIENE EL ULTIMO WORKGROUP
	$lastGroup = Core::model('db','core')->getColumns('work_group', 'id', 'ORDER BY id DESC', 1);
	$work_pending  = Core::model('pending_tasks', 'works')->getTasksPending();

	//TERMINAR TRABAJO
	if (isset($_GET['endwork']) and !empty($_GET['endwork']) )
	{
		$id_endwork=$_GET['endwork'];
		$time=time();
		$consult=mysqli_query($connect, "SELECT * FROM works_pending WHERE id='$id_endwork'");
		if ($consult)
		{
			$work_pending = mysqli_fetch_assoc($consult);
			if ($work_pending['done']==0)
			{
				$result=mysqli_query($connect, "UPDATE works_pending SET done=1 WHERE id='$id_endwork'");
				if ($result)
				{
					mysqli_query($connect,"INSERT INTO work_done (workpending_id,member_id,description,date,time) values ('$id_endwork','1','$work_pending[work]','2021-5-1','$work_pending[time]')");
				}
			}
		}
	}
}

