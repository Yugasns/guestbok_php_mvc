
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <LINK href="style.css" rel="stylesheet" type="text/css">
</head>

<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require_once 'models/gb_mysql.php'; /*подключаем модель скл*/
require_once 'controller.php'; /*подключаем контроллер*/
require_once 'view.php'; /*подключаем вид*/

/*Инициализация гостевой книги*/
$start = new my_view; /*экземпляр класс*/
$start->init(); /*инициализация модели вид*/
/*Конец Инициализация гостевой книги*/

?>
