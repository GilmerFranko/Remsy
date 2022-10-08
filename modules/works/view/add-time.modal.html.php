<!--MODAL AGREGAR + TIEMPO-->
<div class="modal" id="addtime" style="width: 400px">
  <div class="modal-dialog" role="document" style="width:95%;max-width:600px;margin:0;border-radius:5px;overflow:hidden;">
    <div class="modal-content">
      <div class="modal-header" style="display: flex;justify-content: space-between;">
        <h5 class="modal-title" id="exampleModalLabel">Actualiza los segundos operados</h5>
        <div id="modal_time_idinfo">#</div>
      </div>
      <div class="modal-body" style="display: flex">
      	<div style="width: 50%">
      		<div>
      			Horas: <input id="modal_time_hours" type="number" onclick="update_resultInfo()">
      		</div>
      		<div>
      			Minutos: <input id="modal_time_minutes" type="number" onclick="update_resultInfo()">
      		</div>
      	</div>
      	<div id="modal_time_resultinfo" style="width: 50%;display: flex;align-items: center;justify-content: center;" data-time-total="">
      		<h5><strong></strong></h5>
      	</div>
      </div>
      <div class="modal-footer">
        <!--<div type="button" class="modal-close btn waves-effect waves-light dark" style="background:#dddddd;" data-dismiss="modal" aria-label="Close">
          Cancelar
        </div>-->
        <div type="button" class="modal-close btn waves-effect waves-light blue" id="modal_time_sendform"
        data-idtask="" onclick="addTime($(this).data('idtask'), ($('#modal_time_hours').val() >= 0 ? $('#modal_time_hours').val() : 0), ($('#modal_time_minutes').val() >= 0 ? $('#modal_time_minutes').val() : 0))">
          Agregar
        </div>
      </div>
    </div>
  </div>
</div>

