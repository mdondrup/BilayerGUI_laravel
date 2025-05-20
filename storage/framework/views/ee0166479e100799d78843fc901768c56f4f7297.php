<?php
session_start();
//echo($respuesta);

foreach ($respuesta as $key => $value) {

  $_SESSION[$key] = $value;
}
 ?>
<?php /**PATH /home/nmrlipid/databank.nmrlipids.fi/databank/laravel/resources/views/new_advanced_search/updatecompare.blade.php ENDPATH**/ ?>