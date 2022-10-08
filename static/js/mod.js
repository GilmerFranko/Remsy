// PRIMERA letra en MAYÚSCULA
String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}
// PRIMERA letra en MINÚSCULA
String.prototype.strtolower = function() {
    return this.charAt(0).toLowerCase() + this.slice(1);
}

// ALTERNAR CLASE
$('.content.alter').click(function() {
    if ($(this).hasClass('truncate')) {
        $(this).removeClass('truncate');
    } else {
        $(this).addClass('truncate');
    }
});

var mod = {
    reports: {
        delete: function(id = null) {
            if (confirm('La denuncia #' + id + ' va a ser eliminada')) {
                window.location = global.url + '/index.php?app=mod&section=reports&do=delete&id=' + id;
            }
        },
    },
    forms: {
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
            var pageUrl = global.url + '/index.php?app=mod&section=' + section.strtolower() + 's' + area + search + '&page=' + id;
            $.post(pageUrl, 'ajax=true', function(a) {
                success: {
                    if (a.charAt(0) == '1') {
                        // Ocultamos formulario de edición
                        //mod.forms.get(section, '', true);
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