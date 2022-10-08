<?php defined('SUPERNATURAL') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\site\view\contact.html.php       \
 * @package     One V                                     \
 * @author      Gilmer <gilmerfranko@hotmail.com>        |
 * @copyright   (c) 2020 Gilmer Franco                  /
 *                                                       /
 *=======================================================
 *
 * @Description Vista de contacto
 *
 *
*/

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600);

body { font-family: 'Open Sans', sans-serif; }

form {
  position: relative;
  margin: 20px auto;
  width: 300px;
}

h3 {
  font-size: 16px;
  font-weight: 600;
  color: rgba(0,0,0,0.8)
}

.submit__generated {
  display: inline-block;
  
  span {
    display: inline-block;
    width: 35px;
    height: 35px;
    vertical-align: center;
    line-height: 35px;
    font-weight: bold;
    font-size: 16px;
    color: rgba(0,0,0,0.9);
    text-align: center;
    letter-spacing: 1px;
    text-transform: uppercase;  
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 4px;
  }
  
  &.valid:after,
  &.unvalid:after {
    font-family: FontAwesome;
    font-size: 18px;
    margin-left: 10px;
  }
  &.valid {
    &:after {
      content: "\f00c";
      color: #2ecc71;
    }
    .submit__input {
      border: 1px solid #2ecc71;
      color: #2ecc71 !important;
    }
  }
  &.unvalid {
    &:after {
      content: "\f00d";
      color: #e74c3c;
    }
    .submit__input {
      border: 1px solid #e74c3c;
      color: #e74c3c;
    }
  }

  .submit__input {
    position: relative;
    outline: 0;
    height: 35px;
    width: 35px;
    border-radius: 4px;
    border: 1px solid #42A0DD;
    color: #42A0DD;
    text-align: center;
    font-weight: bold;
    font-size: 16px;
    top: -2px;
  }
}




i.fa-refresh {
  margin: 4px 0 0px 5px;
  padding: 5px;
  font-size: 18px;
  color: rgba(0,0,0,0.2);
  cursor: pointer;
  transform-origin: center center;
  transition: transform 0.2s ease-out, color 0.2s ease-out;
  &:hover {
    color: rgba(0,0,0,0.4);
    transform: rotate(180deg);
  }
}

span.submit__error,
span.submit__error--empty {
  color: #e74c3c;
  position: absolute;
  margin-top: 0px;
  margin-left: 100px;
}





.submit {
  display: block;
  font-weight: bold;
  font-size: 16px;
  color: #fff;
  letter-spacing: 1px;
  text-transform: uppercase;
  outline: none;
  border: 0;
  background-color: #26a69a;
  background-clip: padding-box;
  border-radius: 3px;
  opacity: 1;
  transition: transform 0.2s ease-out, opacity 0.2s ease-out;

  &:hover {
    /*background-color: #3498db;*/
  }
  &:active,
  &.enter-press,
  &.overlay {
    margin: 55px 0 46px 0;
    box-shadow: none;
    background-color: gray;
  }
}


    .submit__overlay {
        height: 100px;
        width: 100%;
        background-color: rgba(255,255,255,0.8);
        position: absolute;
        margin-top: -50px;
        margin-left: -5px;
    }








.low-opa { opacity: 0.4; }
.fadeOut {
  opacity: 0;
  transform: translateY(10px);
}
.fadeIn {
  opacity: 1 !important;
  transform: translateY(0px) !important;
}
.form-fields,
.form-success {
  transition: all 0.2s ease-out;
}
.form-success {
  opacity: 0;
  transform: translateY(-10px);
  margin-top: 20px;
}
</style>
<section id="<?php echo $page['code']; ?>">
    <div class="row">
        <article class="col s12 m6 offset-m3">
            <blockquote class="flow-text">Utiliza este formulario para ponerte en contacto con el administrador del sitio. <strong>Nadie m&aacute;s leer&aacute; el mensaje.</strong></blockquote>
            <form id="sendform" method="POST" action="">
                <input type="hidden" name="member_id" value="<?php echo $session->memberData['member_id']; ?>">
                <?php if($session->is_member == false) { ?>
                <div class="input-field">
                    <i class="material-icons prefix">perm_identity</i>
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" value="<?php echo Core::model('extra', 'core')->getInputValue('name', 'post', $session->memberData['name']); ?>" required>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">email</i>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo Core::model('extra', 'core')->getInputValue('email', 'post', $session->memberData['email']); ?>" required>
                </div>
            <?php } ?>
                <div class="input-field">
                    <i class="material-icons prefix">title</i>
                    <label for="title">T&iacute;tulo corto del mensaje</label>
                    <input type="text" name="title" id="title" value="<?php echo Core::model('extra', 'core')->getInputValue('title', 'post'); ?>" required>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">mode_edit</i>
                    <label for="content">Escribe aqu&iacute; tu Mensaje</label>
                    <textarea name="content" id="content" rows="10" class="materialize-textarea"  length="1000" required><?php echo Core::model('extra', 'core')->getInputValue('content', 'post'); ?></textarea>
                </div>
                <div class="captcha" align="center">
                    <label class="submit__control">
                        <h3>Resuelve la suma / Solve the sum</h3>
                        <div class="submit__generated">

                        </div>
                        <i class="fa fa-refresh"></i>
                        <span class="submit__error hide">Incorrect value</span>
                        <span class="submit__error--empty hide">Required field cannot be left blank</span>
                    </label>
                    <br>
                    <button class="submit overlay btn" type="submit" name=""><i class="material-icons right notranslate" onclick="">send</i>Enviar</button>
                    <div class="submit__overlay"></div>
                    <div class="buttonsend">
                    <input id="otroemail" type="text" name="otroemail" style="display: none;">
                    <input id="opinion" type="text" name="opinion" style="display: none;">
                    <input id="asunto" type="text" name="asunto" style="display: none;" value="contact">
                    </div>
                </div>
            </form>
        </article>
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    var a, b, c,
    submitContent,
    captcha,
    locked,
    validSubmit = false,
    timeoutHandle;

  // Generating a simple sum (a + b) to make with a result (c)
function generateCaptcha(){
  a = Math.ceil(Math.random() * 10);
  b = Math.ceil(Math.random() * 10);
  c = a + b;
  submitContent = '<span>' + a + '</span> + <span>' + b + '</span>' +
    ' = <input class="submit__input" type="text" maxlength="2" size="2" required />';
  $('.submit__generated').html(submitContent);

  init();
}


// Check the value 'c' and the input value.
function checkCaptcha(){
  if(captcha === c){
    // Pop the blue valid icon
    $('.submit__generated')
      .removeClass('unvalid')
      .addClass('valid');
    $('.submit').removeClass('overlay');
    $('.submit__overlay').fadeOut('fast');

    $('.submit__error').addClass('hide');
    $('.submit__error--empty').addClass('hide');
    validSubmit = true;
  }
  else {
    if(captcha === ''){
      $('.submit__error').addClass('hide');
      $('.submit__error--empty').removeClass('hide');
    }
    else {
      $('.submit__error').removeClass('hide');
      $('.submit__error--empty').addClass('hide');
    }
    // Pop the red unvalid icon
    $('.submit__generated')
      .removeClass('valid')
      .addClass('unvalid');
    $('.submit').addClass('overlay');
    $('.submit__overlay').fadeIn('fast');
    validSubmit = false;
  }
  return validSubmit;
}

function unlock(){ locked = false; }


// Refresh button click - Reset the captcha
$('.submit__control i.fa-refresh').on('click', function(){
  if (!locked) {
    locked = true;
    setTimeout(unlock, 500);
    generateCaptcha();
    setTimeout(checkCaptcha, 0);
  }
});


// init the action handlers - mostly useful when 'c' is refreshed
function init(){
  $('form').on('submit', function(e){
    e.preventDefault();
    if($('.submit__generated').hasClass('valid')){
      // var formValues = [];
      captcha = $('.submit__input').val();
      if(captcha !== ''){
        captcha = Number(captcha);
      }

      checkCaptcha();

      if(validSubmit === true){
        validSubmit = false;
        // Temporary direct 'success' simulation
        submitted();
      }
    }
    else {
      return false;
    }
  });


  // Captcha input result handler
  $('.submit__input').on('propertychange change keyup input paste', function(){
    // Prevent the execution on the first number of the string if it's a 'multiple number string'
    // (i.e: execution on the '1' of '12')
    window.clearTimeout(timeoutHandle);
    timeoutHandle = window.setTimeout(function(){
      captcha = $('.submit__input').val();
      if(captcha !== ''){
        captcha = Number(captcha);
      }
      checkCaptcha();
    },150);
  });


  // Add the ':active' state CSS when 'enter' is pressed
  $('body')
    .on('keydown', function(e) {
      if (e.which === 13) {
        if($('.submit-form').hasClass('overlay')){
          checkCaptcha();
        } else {
          $('.submit-form').addClass('enter-press');
        }
      }
    })
    .on('keyup', function(e){
      if (e.which === 13) {
        $('.submit-form').removeClass('enter-press');
      }
    });


  // Refresh button click - Reset the captcha
  $('.submit-control i.fa-refresh').on('click', function(){
    if (!locked) {
      locked = true;
      setTimeout(unlock, 500);
      generateCaptcha();
      setTimeout(checkCaptcha, 0);
    }
  });


  // Submit white overlay click
  $('.submit-form-overlay').on('click', function(){
    checkCaptcha();
  });
}

generateCaptcha();
//EJECUTA CUANDO TODO PASA EL CAPTCHA
function submitted(){
  if ($("#opinion").val()=="" && $("#otroemail").val()==""){
      $(".buttonsend").html("<input id='buttonsend' type='text' name='"+$("#asunto").val()+"' style='display:hide;'/>");
      $("form").submit();
    }else{
      alert("No hemos podido comprobar que eres humano, Porfaor intentalo denuevo.");
      location.reload();
    }
}
</script>
<!-- / Body -->
<!-- Footer -->
<?php require Core::view('footer', 'core');?>
<!-- / Footer -->
