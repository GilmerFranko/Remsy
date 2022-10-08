/**
 *-------------------------------------------------------/
 * @file        static/js/custom.js                      \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Archivo relacionado con acciones generales
 *
 *
 * NOTA: archivo posiblemente particionado en un futuro
 */

/** OCULTAR NAVEGACIÓN AL BAJAR, MOSTRAR AL SUBIR **/
var prevPosition = window.pageYOffset;
$(window).scroll(function() {
  var nowPosition = window.pageYOffset;
  if (prevPosition > nowPosition) {
    $('.nav-fixed').css('top', '0');
  } else {
    $('.nav-fixed').css('top', '-56px');
  }
  prevPosition = nowPosition;
});

/** INICIALIZAR TODOS LOS MODALES MATERIALIZE */
(function ($) {
    $(function () {

        //initialize all modals
        $('.modal').modal();

        //now you can open modal from code
        //$('#modal1').modal('open');

        //or by click on trigger
        //$('.trigger-modal').modal();

    }); // end of document ready
})(jQuery); // end of jQuery name space

/** ./OCULTAR NAVEGACIÓN AL BAJAR, MOSTRAR AL SUBIR **/

// PREDEFINIR VARIABLE NOTICIAS
var news = getCookie('news').split(',');
/*if (typeof newsHTML !== 'undefined') {
    var news = getCookie('news').split(',');
    var arrayNews = JSON.parse(newsHTML);
    var htmlNews = '';
    var newC = 0;
    if (arrayNews != 'undefined') {
        //htmlNews += '<div class="new card-panel blue lighten-4 blue-text text-darken-4 flow-text center-align carousel carousel-slider center" style="margin-bottom: 0;">';
        arrayNews.forEach(function(object) {
            if (news.indexOf(object.id) == -1) {
                htmlNews += '<a class="carousel-item grey darken-3 white-text" id="new' + object.id + '" href="#textNew' + newC + '"><p id="textNew' + newC + '" class="flow-text w90">' + object.content + '<button class="waves-effect btn-flat close" onclick="closeNew(' + object.id + ');"><i class="material-icons">close</i></button></p></a>';
                ++newC;
            }
        });
        //htmlNews += '</div>';

        // Comprobar si hay alguna noticia que mostrar
        if (newC > 0) {
            // Crear contenido en HTML
            $('header').append(htmlNews).css('margin-top', '-7px');
            // Pre-ajustar el tamaño
            $('.new.carousel.carousel-slider').css('height', 'auto');
            // Ocultar contenido en HTML
            $('header .new').hide();

            // Mostrar contenido en HTML
            $('header .new').slideDown(1000, function() {
                // Auto-ajustar el tamaño al contenido
                $('.new.carousel.carousel-slider').css('height', ($('#textNew0').height() + 20));
            });
        }
    }
}*/

var stop = false; // PARAR CARGA DE NOTICIAS

/** EJECUTAR CUANDO EL DOCUMENTO ESTÉ LISTO **/
//document.addEventListener('DOMContentLoaded', function() {
$(document).ready(function() {

    // EVITAR TRADUCIR ICONOS, NOMBRES, PAGINACIÓN, ETC.
    $('i.material-icons, .shout-like, .shout-comment, .pagination').addClass('notranslate');

    /** NOTICIAS **/
    /*$('.new.carousel.carousel-slider').carousel({
        fullWidth: true,
        //indicators: true
        noWrap: true, // No volver al principio al finalizar
        onCycleTo: function(idNew) {
            idNew = idNew.toString();
            idNew = idNew.substring(idNew.length - 1, idNew.length);
            $('.new.carousel.carousel-slider').css('height', ($('#textNew' + idNew).height() + 20));
        },
    });*/

    // REAJUSTAR TAMAÑO NOTICIA AL HACER CLIC (Por si acaso)
    /*$('.new .carousel-item').click(function() {
        $('.new.carousel.carousel-slider').css('height', ($($(this).attr('href')).height() + 20));
    });*/

    // OCULTAR LOADER
    $('.preloader-background').delay(1).fadeOut('slow');
    $('.preloader-wrapper')
        .delay(1)
        .fadeOut();

    $('.autodisabled').click(function() {
        $(this).addClass('disabled');
    });

    // INICIAR SIDENAV
    $('.sidenav').sidenav({
        menuWidth: 300, // Default is 300
        edge: 'left', // Choose the horizontal origin
        closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
        draggable: true, // Choose whether you can drag to open on touch screens
        preventScrolling: true,
    });
    // DROPDOWN (BOTON DESPLEGABLE)
    $('.dropdown-trigger').dropdown({
        //autoTrigger: true,
        coverTrigger: false,
        //hover: true,
    });
    // BOTON FLOTANTE
    $('.fixed-action-btn').floatingActionButton();
    // COLLAPSIBLE
    $('.collapsible').collapsible({
        accordion: true,
    });
    // MATERIALBOX (MOSTRAR IMAGEN PANTALLA COMPLETA)
    $('.materialboxed').materialbox();

    /**
     * PAGINAS
     *
     */

    if (global.page_c == 'homeMember') {
        $('.carousel').carousel({
        fullWidth: true,
        numVisible: 4,
        //indicators: true
        noWrap: true, // No volver al principio al finalizar
        onCycleTo: function(idNew) {
            //idNew = idNew.toString();
            //idNew = idNew.substring(idNew.length - 1, idNew.length);
            //$('.new.carousel.carousel-slider').css('height', ($('#textNew' + idNew).height() + 20));
        },
    });
    }

    // REGISTRO

    if (global.page_c == 'membersRegister') {
        $('.modal').modal();
        $('#btnModalAge').click();

        $('#btnAge').click(function() {
            if($('#indeterminate-checkbox').prop('checked') == false )
            {
                window.location.href = 'https://www.google.com/search?q=dibujos';
            }
        });
    }

    if (global.page_c == 'memberLogin') {
        $('.modal').modal();
    }

    /**
     *
     * SHOUTS
     *
     */

});


/**
 *
 * FUNCIONES EXTRA
 *
 */

// IR HACIA URL
function goToUrl(url) {
    window.location.href = url;
}


// OBTENER COOKIES
function getCookie(key = 'uuid') {
    var name = key + '=';
    var sep = document.cookie.split(';');
    for (var i = 0; i < sep.length; i++) {
        var k = sep[i];
        while (k.charAt(0) == ' ') k = k.substring(1);
        if (k.indexOf(name) == 0) return k.substring(name.length, k.length);
    }
    return '';
}

// GENERAR ENLACE DE DESCARGA DIRECTA Y COPIARLO AL NAVEGADOR
function getDirectLink() {
    // CAMBIAR ENLACE DE LA DESCARGA
    var link = global.url + '/index.php?app=shouts&section=download&shout=' + shoutID + '&img=' + shoutImg + '&token=' + token + '&session=' + session;
    var inputTemp = $('<input id="directLink" type="text">').val(link).appendTo('#modalBuy').select();
    var copied = document.execCommand('copy');
    if (copied == true) {
        swal.fire('','Enlace copiado al portapapeles','');
    }
    $('#directLink').remove();
}

// INICIA EL SCRAPPING
function initScrap(index){
  btnLoad = "#btnLoad" + index;
  btnMain = "#btnMain" + index;
  textLoad = "#textLoad" + index;
  nameGroup = "#nameGroup" + index;

  // QUITA EL TEXTO CARGAR Y EL ID DEL GRUPO
  $(textLoad).text('');
  $(nameGroup).text('');
  $(nameGroup).text('Actualizando Posts, Por favor espere...');
  // MUESTRA LOADING
  $(btnLoad).addClass('active small');
  $(btnLoad).show();

  var count = 0;
  var time = 3000;
  var tbreak = 0;
  var countInit = 0;
  var history = Array;

  /*var interval = setInterval(function() {
    $.post(global.url + '/index.php?app=posts&section=links-tar&returnPostsGroup='+ index, 'ajax=true', function(a) {
    success:
    {

        if (count == 0) {
          // CANTIDAD INICIAL
          countInit = a;
        }
        // CANTIDAD TOTAL DE POSTS AÑADIOS
        totalPosts = a - countInit;

        $(nameGroup).text('Actualizando Posts, Por favor espere... Posts actualizados: '+ totalPosts);
        console.log(a);

        // SI PARECE QUE TERMINO EL SRCRAPING
        if(count >1 && history[count-1] == a){
          tbreak++;
        }else{
          tbreak = 0;
        }
        // FINALIZAR BUCLE
        if(tbreak == 20){
          $(nameGroup).text('Actualizado. Posts añadidos: '+ totalPosts);
          clearInterval(interval);
          time = 10000000;
          $(btnLoad).removeClass('active small');
          $(btnMain).removeClass('red');
          $(btnMain).addClass('green');
          $(textLoad).text('Actualizar');
          $(btnLoad).delay(1).fadeOut();
        }
        count++;
        history[count] = a;
      }
    });
  }, time);*/

  // INICIA EL SRAPING
  $.post(global.url + '/index.php?app=posts&section=links-tar&group='+ index, 'ajax=true', function(a) {
    success:
    {
      $(nameGroup).text('Actualizado');
      $(btnLoad).removeClass('active small');
      $(btnMain).removeClass('red');
      $(btnMain).addClass('green');
      $(textLoad).text('Actualizar');
      $(btnLoad).delay(1).fadeOut();
    }
  }).fail(function(error) {
    $(nameGroup).text('Actualizado');
    $(btnLoad).removeClass('active small');
    $(btnMain).removeClass('red');
    $(btnMain).addClass('black');
    $(textLoad).text('Actualizar');
    $(btnLoad).delay(1).fadeOut();
  });

}
//* REVISION */
function generateSCEditor(tag = "")
{
  fetch(global.url+'/static/sceditor/bbcode.objects.json')
  .then(response => {
   return response.json();
  })
  .then(bbcodes => {
    console.log(bbcodes);
    bb = {
    styles: {
        "stylename": null,
        "another-style-name": ["value1", "value2"]
    },
    tags: {
        "tag": '<br>',
        "another-tag": {
            "attribute1": '<br>',
            "attribute2": ["value1", "value2"]
        }
    },
    isSelfClosing: true,
    isInline: true,
    isHtmlInline: undefined,
    allowedChildren: null,
    allowsEmpty: false,
    excludeClosing: false,
    skipLastLineBreak: false,
    strictMatch: false,

    breakBefore: false,
    breakStart: false,
    breakEnd: false,
    breakAfter: false,

    format: 'string|function',
    html: 'string|function',

    quoteType: sceditor.BBCodeParser.QuoteType.auto
}
    sceditor.formats.bbcode.set("br",bb)
    var textarea = document.getElementById(tag);
    sceditor.create(textarea, {
      format: 'bbcode',
      icons: 'monocons',
      style: 'https://cdn.jsdelivr.net/sceditor/1.5.1/jquery.sceditor.default.min.css',
      emoticonsRoot: global.url + '/static/sceditor/'
    });
  })
  return true;
}
function destroySCEditor(tag = "")
{

  var textarea = document.getElementById(tag);
  hola = sceditor.instance(textarea).destroy()
  return true
}
