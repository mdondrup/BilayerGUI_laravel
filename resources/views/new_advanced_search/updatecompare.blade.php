<?php
session_start();

foreach ($respuesta as $key => $value) {

  $_SESSION[$key] = $value;
}
 ?>
