<?php if(isset($_GET['emessage']) OR isset($_GET['smessage'])){ 
  $message = isset($_GET['emessage']) ? $_GET['emessage'] : $_GET['smessage'];
  ?>
  <div class="p-4 mb-4 text-md text-white rounded-lg bg-yellow-600 border" role="alert">
     <?php  echo $message ?>
  </div>
  <?php } ?>