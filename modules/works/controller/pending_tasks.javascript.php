<script type="text/javascript">
	let id=0;
	$(document).ready(function() {

		$(".button_addtime").on("click", function(e){
			id=$(this).data('id');
		});

		/* Crea un evento al cerrar el modal de actualizar descripción*/
		var elems = document.getElementById('update-description');
    var instances = M.Modal.init(elems, {onCloseStart: () =>{
    	// Quita ID Task
    	$("#modal_add-description").removeAttr('data-idtask')
    	// Borrar Editor SCEditor
    	destroySCEditor('modal_add-description_description')
    	// Borrar text
    	$("#modal_add-description_description").html("")
    }});
	})
	function addTime(idTask = null, hours = null, minutes = null){
		if (id != 0 && hours) {
			$.post('<?php echo Core::model('extra', 'core')->generateUrl('works', 'pending_tasks'); ?>&add-time=true&idTask='+idTask+'&hours='+hours+'&minutes='+minutes, 'ajax=true', function(a){
				success: {
					var data = $.parseJSON(a);
					console.log(a)
					if(data.status){
					// APUNTAR VARIABLE AL CUADRO DE TEXTO DE TIME
					textTime = '#textTime'+id;
					//CAMBIAR VALOR AL ACTUAL
					$(textTime).val(data.newTime);
					// LANZAR MENSAJE
					swal.fire(data.message, "", "success");
					}else{
						swal.fire("Error!", data.message, "error");
					}
				}
			})
		}
	}
  // GUARDA EL TEXTO DE UNA TAREA
  function saveTextWork(wID, wText){
    // El texto no puede estar vacio
    if (wID.length != 0) {
    	$.post('ajax.php?saveTextWork', 'wID=' + wID + '&wText=' + wText, function(a) {
    		success: {
    			alert(a)
    		}
    	});
    }else{
    	swal.fire('El texto no puede estar vacio','','info')
    }
  }
  var threads = [{}]
  function initClock(obj = null){
  	idTask = obj.data('id');
  	// Si ya esta registrada esta instancia
  	if(threads[idTask] != null){
  		// Si el cronometro esta en ejecución
  		if(threads[idTask] == 'play'){
  				// Pausar
  				threads[idTask] = 'pause';
  				saveStopWatch(obj)
  				// Cambiar icono
  				clockTime = "#stopClock" + idTask
  				$(clockTime).html('<i class="material-icons">play_arrow</i>')
  			}
  			// Si el cronometro esta pausado
  			else{
  				threads[idTask] = 'play';
  				updateClock(obj);
  				// Cambiar icono
  				clockTime = "#stopClock" + idTask
  				$(clockTime).html('<i class="material-icons">pause</i>')
  			}
  		}
  	// Sino, registrala e inicia el cronometro
  	else{
  		// Registrar instancia
  		threads[idTask] = 'play';
  		// Actualiza vista
  		updateClock(obj)
    	// Guarda tiempo del cronometro
    	saveStopWatch(obj)
    	// Cambiar icono
    	clockTime = "#stopClock" + idTask
    	$(clockTime).html('<i class="material-icons">pause</i>')
    }
  }
  function updateClock(obj = null){
  	// Si existe la instancia y está en ejecución
  	if(threads[(obj.data('id'))] != null && threads[obj.data('id')] == 'play') {
	  	// Mostrar tiempo
	  	obj.data('init_time', (obj.data('init_time') + 1))
	  	obj.html(secondsToString(obj.data('init_time')))
	  	// Repetir
	  	setTimeout(() => {
	  		updateClock(obj)
	  	}, 1000);
	  }
	}
	function secondsToString(seconds = 0, full = false) {
		var hour = Math.floor(seconds / 3600);
		hour = (hour < 10)? '0' + hour : hour;
		var minute = Math.floor((seconds / 60) % 60);
		minute = (minute < 10)? '0' + minute : minute;
		var second = seconds % 60;
		second = (second < 10)? '0' + second : second;

		if(full){
			return hour + ' : ' + minute + ' : ' + second;
		}
		return minute + ':' + second;
	}
	function saveStopWatch(obj = null){
		let idTask = obj.data('id')
		let timeClock = obj.data('init_time')
		$.post('<?php echo Core::model('extra', 'core')->generateUrl('works', 'pending_tasks'); ?>&add-stopWatch=true&idTask='+idTask+'&timer='+timeClock, 'ajax=true', function(a) {
			success:
			{
				console.log('Guardado')
			}
		})
  	// Si existe la instancia y está en ejecución
  	if(threads[(obj.data('id'))] != null && threads[obj.data('id')] == 'play') {
  		setTimeout(() => {
  			saveStopWatch(obj)
  		}, 5000);
  	}
  }
  function deleteClockTime(idclock = null){
  	swal.fire({
  		title:"¿Deseas reiniciar el cronometro?",
  		icon: 'question',
  		showDenyButton: true,
  		denyButtonText: 'Cancelar',
  		confirmButtonText: 'Reiniciar',
  		showLoaderOnConfirm: true,
  	}).then((result) => {
  		if(result.isConfirmed){
  			$.post('<?php echo Core::model('extra', 'core')->generateUrl('works', 'pending_tasks'); ?>&add-stopWatch=true&idTask='+idclock+'&timer=0', 'ajax=true', function(a) {
  				success:
  				{
  					if(a)
  					{
  						$("#clockTime"+idclock).html('0:00:00')
  					}
  				}
  			})
  		}
  	})
  }
  /**
   * Abre modal para agregar tiempo y inicializa sus parametros
   * @param  {int} 				idTask    ID de la tarea
   * @param  {timeTotal}	timeTotal Cantidad de segundos total trabajados
   * @return {}
   */
  function openModal_addTime(idTask = null, timeTotal = 0){
		/* Actualiza */
		// ID de tarea
		$("#modal_time_sendform").attr('data-idtask', idTask)
		// Info del ID de tarea
		$("#modal_time_idinfo").html('#' + idTask)
		// Segundos trabajados
		$("#modal_time_resultinfo").data('time-total', timeTotal)
		// Horas y minutos trabajados
		$("#modal_time_resultinfo h5 strong").html(secondsToString(timeTotal, true))

		// Abre modal
		$('#addtime').modal('open');
  }

  function openModal_updateDescription(idTask = 0, description = ""){
  	let elem = $('#update-description');let instance = M.Modal.getInstance(elem)
  	if($("#modal_add-description").data('idtask') == null)
  	{
  		/* Actualiza */
			// ID de tarea
			$("#modal_add-description").attr('data-idtask', idTask)
			$("#modal_add-description_description").html(decodeURIComponent(description))

			// Inicializa editor SCEditor
			if(generateSCEditor('modal_add-description_description')){
				// Abre modal
				instance.open()
			}
			// Info del ID de tarea
		}
	}
  /**
   * Actualiza información de resultado total en horas y minutos
   * @return {[type]} [description]
   */
  function update_resultInfo(){
		let hours   = $("#modal_time_hours").val()
		let minutes = $("#modal_time_minutes").val()
		let total   = (hours * 60 * 60) + (minutes * 60)
		total = total + $("#modal_time_resultinfo").data('time-total')
		$('#modal_time_resultinfo h5 strong').html(secondsToString(total, true))
  }

  function updateDescription(tag = ""){
  	// Establecer ID de Task
  	idTask = $("#modal_add-description").data('idtask')
  	tag = document.getElementById(tag)
  	text = sceditor.instance(tag).val()
  	// El texto no puede estar vacio
    $.post('<?php echo Core::model('extra', 'core')->generateUrl('works', 'pending_tasks'); ?>&saveDescription', '&text=' + text + '&idTask=' + idTask + '&ajax=true', function(a) {
    		success: {
    			alert(a)
    		}
  	});
  }

</script>
