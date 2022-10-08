<!--MODAL AGREGAR + TIEMPO-->

<div class="modal" id="update-description" style="position: absolute; top: 20%;">
	<div class="modal-dialog" role="document" style="">
		<div class="modal-content">
			<div class="modal-header" style="">
				<h5 class="modal-title" id="exampleModalLabel" onclick="">Actualiza esta descripci&oacute;n</h5>
			</div>
			<div class="modal-body">

				<textarea id="modal_add-description_description" style="height:300px;"></textarea>

				<label>
					<input name="history_files" type="radio" value="0"/>
					<span>Archivos modificados</span>
				</label>
				<label>
					<input name="history_files" type="radio" value="0"/>
					<span>Consultas SQL</span>
				</label>
				<label>
					<input name="history_files" type="radio" value="0"/>
					<span>Archivos modificados</span>
				</label>
			</div>

			<div class="modal-footer">
        <div type="button" class="modal-close btn waves-effect waves-light dark" data-dismiss="modal" aria-label="Close" onclick="$('#modal_add-description').removeAttr('data-idtask')">
          Cancelar
        </div>
        <div id="modal_add-description" type="button" class="modal-close btn waves-effect waves-light blue" onclick="updateDescription('modal_add-description_description')">
        	Guardar
        </div>
      </div>
    </div>
  </div>
</div>
