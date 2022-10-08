<?php

/**
   °══════════°═════════════════════════════════════°
   ║ @file    ║ modules/works/view/messages.html.php║
   °═════════════════════════════════════°
   °══════════°═══════════════════════════════°
   ║ @version ║v1.0                           ║
   °══════════°═══════════════════════════════°
   °══════════°═══════════════════════════════°
   ║ @author  ║Gilmer gilmerfranko@hotmail.com║
   °══════════°═══════════════════════════════°
   °══════════°═══════════════════════════════°
   ║ @copyrig ║(c) 2020 Gilmer Franco         ║
   °══════════°═══════════════════════════════°
   °══════════════°═══════════════════════════°
   ║ @Description ║(c) 2020 Gilmer Franco     ║
   °══════════════°═══════════════════════════°
**/


require Core::view('head', 'core');

?>
<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->
<style type="text/css">
.message{
  width: 60%;
  /*background: linear-gradient(90deg, rgba(1, 16, 29, 0.8) 0%, rgba(27, 1, 29, 0.8) 50%,#17011d 100%);
  color: var(--main-tc);*/
  padding: 10px 10px;
  /*border-image-source: linear-gradient(to left, #18011d  22%, #545454 44%,#020f1d 70%);*/
  border-radius: 16px;
  transition: all .2s;
}

.card-message.right{
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
  align-content: flex-end;
}
.message-content{
  overflow-wrap: anywhere;
}
.message:hover{
  transition: all .2s;
  box-shadow: 0px 0px 1px 1px white;
  background: linear-gradient(90deg, rgba(1, 16, 29, 0.8) 0%, rgba(27, 1, 29, 0.8) 50%,#17011d 100%);
  border-radius: 24px;
  color: white;
}
.message-name{
  /* border-top: solid 1px; */
}
.message-id{
  display: flex;
  justify-content: flex-end;
}
.mine-message{
  /*background: linear-gradient(90deg, rgb(1, 16, 29, 1) 0%, rgba(27, 1, 29, 1) 50%,rgba(23, 1, 29, 0.2) 100%);*/
}

</style>
<section class="content">
  <div class="center">
  <?php for ($i = $cnt; $i>1; $i--): ?>
    <div class="card-message <?php if($message[$i]['sender_name']=='Gilmer Franko') echo ''; ?>">
      <div class="message <?php if($message[$i]['sender_name']!='Gilmer Franko') echo 'mine-message'; ?> card">
        <div class="message-name row card-title">
          <div class="col">
            <strong><a href="#"><?php echo $message[$i]["sender_name"]; ?></a></strong> dijo:
          </div>
        </div>
        <div class="message-content row">
          <div class="col">
            <?php echo (isset($message[$i]["content"])) ? htmlentities($message[$i]["content"]) : ''; ?>
          </div>
        </div>
        <br>
        <div class="message-time row">
          <div class="col-8">
            <strong><?php echo date('d/m/Y H:m:s',intval($message[$i]["timestamp_ms"]/1000)); ?></strong>
          </div>
          <div class="col-4 message-id">
           <i>#<?php echo $i; ?></i>
         </div>
        </div>
        <div class="row">
          <div class="col">

          </div>
        </div>
      </div>
    </div>
    <br>
    <br>
<?php endfor; ?>
  </div>
</section>

<?php require Core::view('footer', 'core'); ?>
