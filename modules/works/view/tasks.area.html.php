<?php
/**
°══════════════°---------------------
║  file        ║  /modules/works/view/tasks.area.html.php
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
║  Description ║  Vista general de las Tareas pendientes
°══════════════°---------------------
**/

?>
<style>
	.tasklist .col{
		text-align: center;
	}
</style>

<div class="center">
	<!--BOTON AGREGAR-->
	<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#trailerModal">
		Agregar
	</button>
	<!--/BOTON AGREGAR-->
	<div class="row box" style="border-radius: 16px;">
		<div class="col s2 l1" style="text-align:center;">#</div>
		<div class="col s2 l1" style="text-align:center;">ID G</div>
		<div class="col s2 l3" style="text-align:center;">Tarea</div>
		<div class="col s2 l2" style="text-align:center;">Descripcion</div>
		<div class="col s2" style="text-align:center;">Tiempo gastado</div>
		<div class="col s2" style="text-align:center;"></div>
	</div>
	<?php
	foreach($work_pending['data'] AS $task){
		?>

		<!-- SI YA ESTA INICIADA LA TAREA(SI EL TIEMPO ES MAYOR QUE 0)-->
		<div class="row tasklist <?php echo $task['time']>0 ? 'work-ini' : ''; ?>">
			<div class="col s2 l1" style="text-align:center;">
				<span> <?php echo $task['id']; ?> </span>
			</div>
			<!--/-->

			<!-- group id -->
			<div class="col s1 l1" style="text-align:center;">
				<span>
					<a href="<?php echo $mCore->m('extra')->generateUrl('works','groups','',array('group' => $task->workgroup_id)) ?>"> <?php echo $task['workgroup_id']; ?> </a>
				</span>
			</div>
			<!-- description1 -->
			<div class="col s2 l3" title="<?php echo $task['work']; ?>" style="text-align:center;">
				<input id="IT-Work_<?php echo $task['id']; ?>" type="text" name="" value="<?php echo $task['work']; ?>">
				<a href="javascript:saveTextWork(<?php echo $task['id'] ?>,$('#IT-Work_<?php echo $task['id']; ?>').val());"><i class="fa fa-save"></i></a>
			</div>
			<!-- description2 -->
			<div class="col s2 l2" style="text-align:center; background-color:#f0f8ff21">
				<span onclick="openModal_updateDescription(<?php echo $task['id'] ?>, '<?php echo rawurlencode($task['description']) ?>')">
					<input type="text" value="<?php echo $task['description_txt']; ?>" style="text-align: center;" disabled="">
				</span>
			</div>
			<!-- time -->
			<div class="col s4 l3">
				<div style="display: flex;justify-content: space-between;">
					<span id="clockTime<?php echo $task['id'] ?>" class="clockTime btn black" data-id="<?php echo $task['id'] ?>" data-init_time="<?php echo $task['stopwatch_time'] ?>"><?php echo Core::model('date', 'core')->getTime('h:m:s', $task['stopwatch_time']) ?></span>
					<input id="textTime<?php echo $task['id']; ?>" class="button_addtime" type="text" name="" disabled="" value="<?php echo Core::model('date', 'core')->getTime('h : m : s', $task['net_time']); ?>" data-id="<?php echo $task['id']; ?>" style="width: 90px;">
					<button class="button_addtime btn btn-success" onclick="openModal_addTime(<?php echo $task['id'] ?>, <?php echo $task['net_time'] ?>)">
						<i class="material-icons">timer</i>
					</button>
				</div>
				<div style="display: flex;justify-content: flex-start;">
					<button id="stopClock<?php echo $task['id'] ?>" class="button_addtime btn-small modal-trigger blue" style="color: white;" onclick="initClock($('#clockTime<?php echo $task['id'] ?>'))">
						<i class="material-icons">play_arrow</i>
					</button>
					<button class="button_addtime btn-small modal-trigger" style="padding: 0 6px;" onclick="deleteClockTime('<?php echo $task['id'] ?>')">
						<i class="material-icons">delete</i>
					</button>
				</div>
			</div>
			<div class="col-1">
				<span><a class="btn btn-dark" href="task.php?endwork=<?php echo $task['id'] ?>" class="btn"><i class="material-icons">delete</i></a></span>
			</div>
		</div>
		<div class="row">
			<div class="col"><br></div>
		</div>
	<?php } ?>
</div>
