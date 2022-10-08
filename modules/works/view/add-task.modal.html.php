<div class="modal fade in" id="trailerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);width:95%;max-width:600px;margin:0;border-radius:5px;overflow:hidden;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agrega nueva tarea</b>    </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute;top:0;right:0;padding:16px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          <textarea class="form-control" id="work" placeholder="Describa la tarea" style="height:100px!important;margin-bottom:20px;"></textarea>
        </div>
        <div>
          <input type="text" min="0" class="form-control" name="description" id="description" placeholder="Descripcion opcional" >
        </div>
      </div>
      <div class="modal-footer">
        <input id="numGroup" type="number" name="numGroup" value="<?php echo $lastGroup ?>" val>
        <div type="button" class="btn btn-secondary" style="background:#dddddd;" data-dismiss="modal" aria-label="Close">
          Cancelar
        </div>
        <a href="javascript:addWork();"type="button" class="btn btn-success" id="">
          Enviar
        </a>
      </div>
    </div>
  </div>
</div>
