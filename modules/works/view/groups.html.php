<?php
/**
°══════════════°---------------------
║  file        ║
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
║  Description ║  Vista general de los grupos de tareas
°══════════════°---------------------
**/
?>
<style>
	.group-card{
		transition: .3s all;
	}
	.group-card:hover{
		transform: translateY(-10px);
	}
</style>
<br>
<br>
<div style="display:flex;flex-wrap:wrap;justify-content:center;">
	<?php
	foreach($groups['data'] AS $group){
		$group = (object) $group;
		?>
		<a href="<?php echo $mCore->m('extra')->generateUrl('works','pending_tasks') ?>">
			<div class="group-card card" style="width: 200px; height: 130px; position: relative; margin: 20px;background: linear-gradient(<?php echo rand(0,180) ?>deg, rgba(<?php echo rand(0,100) ?>, <?php echo rand(0,100) ?>, <?php echo rand(0,100) ?>, 1) 0%, rgba(<?php echo rand(0,100) ?>, <?php echo rand(0,100) ?>, <?php echo rand(0,100) ?>, 1) 50%);">
				<div style="background-color:#00000030">
					<div class="head" style="display: flex;flex-wrap: nowrap;justify-content: space-between;margin: 5px 10px;">
						<div class="" style="color:white"><?php echo $group->tecnology ?></div>
						<div class="" style="font-style: italic; font-size:11px; color:white"><?php echo $group->date ?></div>
					</div>
				</div>
				<div class="body" style="height: 100px;
				display: flex;
				justify-content: center;
				align-items: center;
				/* margin: 5px 10px; */
				/*background-color: cadetblue;*/
				color: aliceblue;
				font-family: monospace;
				font-style: italic;
				font-size:11px">
				<div class="center"  style="padding: 5px"><?php echo $mCore->m('extra')->curtText($group->description, 64) ?></div>
			</div>
			<div class="" style="font-style: italic; font-size:11px;"></div>
		</div>
	</a>
	<?php } ?>
</div>
