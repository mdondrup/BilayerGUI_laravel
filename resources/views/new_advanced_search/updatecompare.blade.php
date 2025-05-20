<?php
session_start();
//echo($respuesta);

foreach ($respuesta as $key => $value) {

  $_SESSION[$key] = $value;
}
 ?>
