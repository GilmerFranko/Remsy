function previewVideo() {
    var preview = document.querySelector('#video'); // Selecciona el video
    var file = document.querySelector('#videoFile').files[0]; // Selecciona el input archivo
    var reader = new FileReader();

    reader.onloadend = function() {

        if (/^video\//i.test(file.type)) {
            preview.src = reader.result;
        } else {
            swal.fire('','Formato de v&iacute;deo incorrecto','');
        }
    }
    // SI OCURRE UN ERROR
    reader.onerror = function() {
        swal.fire('','Error al comprobar v&iacute;deo','');
    }

    // SI HAY ARCHIVO
    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
    }
}

function previewFile(id = 0, msg = '') {
    var preview = document.querySelector('#img' + id); // Selecciona la imagen
    var file = document.querySelector('#file' + id).files[0]; // Selecciona el input archivo
    var reader = new FileReader();

    reader.onloadend = function() {
        // Comprueba que sea un tipo de imagen valido
        if (/^image\//i.test(file.type)) {
            preview.src = reader.result;
            preview.setAttribute('data-caption', file.name);
            swal.fire('',msg != '' ? msg : file.name + ' agregada','');
        } else {
            swal.fire('','Formato de imagen incorrecto','');
        }
    }

    // SI OCURRE UN ERROR
    reader.onerror = function() {
        swal.fire('','Error al comprobar imagen','');
    }

    // SI HAY ARCHIVO
    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
    }
}

function deleteImage(id = 0) {
    // Vuelve a colocar la imagen anterior
    document.querySelector('#img' + id).src = global.images + '/new-image-shout.png';

    // Vacia el campo de archivo de la imagen
    document.querySelector('#file' + id).files[0].value = '';
}

function removeImage(id = 0) {

    //var value = parseInt($('#btnAddInputShout').attr('cant')) - 1;

    //$('#btnAddInputShout').attr('cant', value);

    $('#btnAddInputShout').removeClass('disabled');

    // Vuelve a colocar la imagen anterior
    document.querySelector('#imgFile' + id).remove();
}


// AGREGAR IMAGEN SHOUT
function addShoutImageInput() {
    var value = parseInt($('#btnAddInputShout').attr('cant')) + 1;

    $('#btnAddInputShout').attr('cant', value);
    var input = '<div style="display:none;" class="col s6 m4" id="imgFile' + value + '"><div class="card" id="card' + value + '"><div class="card-image"><img id="img' + value + '" class="materialboxed" src="' + global.url + '/static/images/new-image-shout.png"></div><div class="card-action"><a href="javascript:removeImage(' + value + ');" class="waves-effect waves-light btn red darken-3 w50" title="Eliminar"><i class="material-icons">delete_forever</i></a><div class="btn file-field waves-effect waves-light blue darken-3 w50"><i class="material-icons">edit</i><input name="images[]" id="file' + value + '" type="file" accept="image/jpeg, image/png" onchange="previewFile(' + value + ')"></div></div></div></div>';
    $('#shoutImages').append(input);

    $('#imgFile' + value).delay(10).fadeIn();

    // CUANTAS IMAGENES HAY
    var cant = $('#shoutImages div.col').length;
    if (cant >= 6) {
        $('#btnAddInputShout').addClass('disabled');
    } else {
        $('#btnAddInputShout').removeClass('disabled');
    }
}
