// PRIMERA letra en MAYÚSCULA
String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}
// PRIMERA letra en MINÚSCULA
String.prototype.strtolower = function() {
    return this.charAt(0).toLowerCase() + this.slice(1);
}


function setCheckbox(value, input) {
    $('input:checkbox').prop('checked', value);
    $('input[type=checkbox]').prop('checked', value);
    //
    return false;
}

// AGREGAR CAMPO
function addInput(section) {
    var value = parseInt($('#btnAddInput' + section).attr('cant')) + 1;

    $('#btnAddInput' + section).attr('cant', value);
    input = '<input placeholder="Os amo 😛" type="text"  id="reply[]" name="reply[]" id="reply' + value + '" data-cant="' + value + '" />';
    $('#botReplies').append(input);
    //$('#botRepliesActions').prepend(remove);
}

// ALTERNAR CLASE
$('.content.alter').click(function() {
    if ($(this).hasClass('truncate')) {
        $(this).removeClass('truncate');
    } else {
        $(this).addClass('truncate');
    }
});



/* ADMINISTRACIÓN */
var admin = {
    groups: {
        saveForm: function(id) {

            var permissions = new Array();
            $('input[name="permission[' + id + '][]"]:checked').each(function() {
                permissions.push($(this).val());
            });

            var action = isNaN(id) == false ? 'edit' : 'new';
            //
            $('.groupNewEdit').css('pointer-events', 'none').css('opacity', '0.5');
            //
            $.post(global.url + '/index.php?app=admin&section=groups&do=' + action, 'id=' + id + '&title=' + $('#groupTitle' + id).val() + '&colour=' + $('#groupColour' + id).val() + '&permissions=' + permissions + '&max_messages=' + $('#groupMaxMessages' + id).val() + '&max_shout_images=' + $('#groupMaxShoutImages' + id).val() + '&ajax=true', function(a) {
                success: {
                    if (a.charAt(0) == '1') {
                        $('#btnEditGroup').slideUp('fast');
                        $('#newGroupForm').slideUp('slow');
                        $('#btnNewGroup').slideDown('fast');
                        $('#onceGroup').slideDown('slow').html('');
                        // ACTUALIZAMOS LA PÁGINA
                        //window.location.reload();
                    }
                    // MOSTRAMOS EL CONTENEDOR
                    $('.groupNewEdit').css('pointer-events', 'all').css('opacity', '1');
                    $('#contentGroups').slideDown('slow').css('pointer-events', 'all').css('opacity', '1');
                    // MOSTRAMOS EL MENSAJE
                    swal.fire('',a.substring(2),'');
                }
            });
        },
        delete: function(id) {
            if (confirm('El rango va a ser eliminado')) {
                $.get(global.url + '/index.php?app=admin&section=groups&area=delete', 'id=' + id + '&ajax=true', function(a) {
                    success: {
                        if (a.charAt(0) == '1') {
                            $('#Group_' + id).fadeOut('slow').remove();
                        }
                        // MOSTRAMOS EL MENSAJE
                        swal.fire('',a.substring(2),'');
                    }
                });
            }
        },
    },
    bots: {
        delete: function(id, type = '', word = '') {
            if (word > 0) {
                word = '&word=' + word;
            }

            if (confirm('La ' + (type == 'word' ? 'palabra ' : 'respuesta ') + id + ' va a ser eliminada')) {
                window.location = global.url + '/index.php?app=admin&section=bots&area=action&do=delete&type=' + type + word + '&id=' + id;
            }
        },
    },
    censors: {
        delete: function(id = null) {
            if (confirm('La censura #' + id + ' va a ser eliminada')) {
                window.location = global.url + '/index.php?app=admin&section=censors&area=action&do=delete&id=' + id;
            }
        },
    },
    contacts: {
        delete: function(id = null) {
            if (confirm('El contacto #' + id + ' va a ser eliminado')) {
                window.location = global.url + '/index.php?app=admin&section=contacts&do=delete&id=' + id;
            }
        },
    },
    photos: {
        delete: function(id = null) {
            if (confirm('La foto #' + id + ' va a ser eliminada')) {
                window.location = global.url + '/index.php?app=admin&section=photos&area=action&do=delete&id=' + id;
            }
        },
    },
    bulkEmails: {
        delete: function(id = null) {
            if (confirm('El correo #' + id + ' va a ser eliminado')) {
                window.location = global.url + '/index.php?app=admin&section=bulkemails&area=action&do=delete&id=' + id;
            }
        },
        send: function(id = null) {
            if (confirm('Se va a enviar el correo #' + id )) {
                window.location = global.url + '/index.php?app=admin&section=bulkemails&area=action&do=send&id=' + id;
            }
        },

    },
    forms: {
        get: function(section, id, revert) {
            if (revert != true) {
                $('#content' + section + 's').css('pointer-events', 'none').css('opacity', '0.5');
                //
                $.post(global.url + '/index.php?app=admin&section=' + section.strtolower() + 's&action=form', 'id=' + id + '&ajax=true', function(a) {
                    success: {
                        if (a.charAt(0) == '1') {
                            $('#btnEdit' + section).slideDown('fast');
                            $('#content' + section + 's').slideUp('slow');
                            $('#btnNew' + section).slideUp('fast');
                            $('#new' + section + 'Form').slideUp('slow');
                            $('#once' + section).html('').append(a.substring(2)).slideDown('slow');
                        } else {
                            swal.fire('',a.substring(2),'');
                        }
                    }
                });
            } else {
                $('#new' + section + 'Form').slideUp('slow');
                $('#once' + section).html('').slideUp('slow');
                $('#btnEdit' + section).slideUp('fast');
                $('#content' + section + 's').slideDown('slow').css('pointer-events', 'all').css('opacity', '1');
                $('#btnNew' + section).slideDown('slow');
            }
        },
        save: function(section, id, reload) {
            // DEFINIR ARRAY PARA LA PETICIÓN
            var array = '';
            var val = '';
            // RECORREMOS INPUTS
            $('input[name="' + section.strtolower() + '[' + id + '][]"]').each(function() {
                // PREDEFINIDOS
                val = $(this).val();
                // CONDICIONES
                if ($(this).attr('type') == 'checkbox') {
                    val = $(this).is(':checked') ? '1' : '0';
                }
                // CONTINUAMOS CON LA CADENA ARRAY
                array += '&' + $(this).attr('data-key') + '=' + val;
            });
            // RECORREMOS TEXTAREAS
            $('textarea[name="' + section.strtolower() + '[' + id + '][]"]').each(function() {
                array += '&' + $(this).attr('data-key') + '=' + $(this).val();
            });
            // DEFINIR ACCIÓN
            //var action = isNaN(id) == false ? 'edit' : 'new';
            var action = id > 0 ? 'edit' : 'new';
            // TRANSPARENTAR EL CONTENEDOR
            $('section').css('pointer-events', 'none').css('opacity', '0.5');
            // ENVIAR LA PETICIÓN AJAX
            $.post(global.url + '/index.php?app=admin&section=' + section.strtolower() + 's&do=' + action, 'id=' + id + array + '&ajax=true', function(a) {
                success: {
                    if (a.charAt(0) == '1') {
                        admin.forms.get(section, '', true);
                        // CARGAR EL CONTENEDOR ACTUALIZADO
                        var page = action == 'edit' ? global.page : 1;
                        admin.forms.page(section, page);
                        // VACIAR EL FORMULARIO
                        $('#form-' + section + 's').each(function() {
                            this.reset();
                        });
                        // ACTUALIZAR LA PÁGINA
                        if (reload == true) { window.location.reload(); }
                    }
                    // HABILITAMOS EL CONTENEDOR
                    $('section').css('pointer-events', 'all').css('opacity', '1');
                    // MOSTRAMOS EL MENSAJE
                    swal.fire('',a.substring(2),'');
                }
            });
        },
        page: function(section, id, area = '', search = '') {
            $('#content' + section + 's').css('pointer-events', 'none').css('opacity', '0.5');
            //
            if (area != '') {
                area = '&area=' + area;
            }
            if (search != '' || search > 0) {
                search = '&search=' + search;
            }
            // DEFINE URL DE PETICION
            var pageUrl = global.url + '/index.php?app=admin&section=' + section.strtolower() + 's' + area + search + '&page=' + id;
            $.post(pageUrl, 'ajax=true', function(a) {
                success: {
                    if (a.charAt(0) == '1') {
                        // Ocultamos formulario de edición
                        admin.forms.get(section, '', true);
                        // Cambiamos la página
                        $('#content' + section + 's').html('').append(a.substring(3)).slideDown('slow').css('pointer-events', 'all').css('opacity', '1');
                        // Definimos la página actual
                        global.page = id;
                        // Definimos la URL actual
                        window.history.pushState(null, null, pageUrl);
                    } else {
                        swal.fire('',a.substring(2),'');
                    }
                }
            });
        },
    },
}