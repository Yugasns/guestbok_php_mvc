
<html><head><meta charset="utf-8"></head></html>
<?
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define("HOST", 'localhost');
define("USER", 'dshtolin_s677c08');
define("PASS", 'JPV21FaCAIoyPSm55wxrux1yaxIpIQGR');
define("DB", 'dshtolin_sitetest');

/*
$OTLAMP_MYSQL_HOST = "localhost";
$OTLAMP_MYSQL_DB = "dshtolin_sitetest";
$OTLAMP_MYSQL_USER = "dshtolin_s677c08";
$OTLAMP_MYSQL_PASS = "JPV21FaCAIoyPSm55wxrux1yaxIpIQGR";
*/

class gb_sql
{
    private $mysqli;
    public $name;
    public $message;
    public $date;
    public $data; /*Хранение всех сообщений*/
    
    function __construct() /*Подключаемся к БД при создании класса*/
        {
            $this->mysqli = new mysqli(HOST,USER,PASS,DB);            
        }
    
    public function print_data() /*Вывод всех сообщений*/
        {
            echo "<table>
  <tr>
    <th>Пользователь</th>
    <th>Сообщение</th>
     <th>Дата</th>
  </tr>";
            $this->data = $this->mysqli->query('SELECT * FROM gb_message');
                while( $row = $this->data->fetch_assoc()  )
                {
                    
                    printf(" %s %s (%s) \n", $row['name'], $row['message'], $row['date']);
                }
    
        }/*Конец Вывод всех сообщений*/
        
    public function insert_data($name, $message, $date) /*Добавление новых сообщений*/
    {
        $this->name = $name;
        $this->message = $message;
        $this->date = $date;
        
        $this->mysqli->query("INSERT INTO gb_message VALUES ('$name','$message','$date')");
    }/*Конец Добавление новых сообщений*/
    
} /*Класс gb_sql*/


/*Работа через класс*/

$myClass = new gb_sql();
$myClass->insert_data('Ivan', 'Hello everyboby', date("d.m.y"));
$myClass->print_data();

/*Конец Работа через класс*/


/*Начало Функцион кода*/
/*$con = mysqli_connect(HOST,USER,PASS,DB);

$name = "Petya2 ";
$message = "Hi";
$date = date("d.m.y");  
echo $date.$name.$message;
$insert = "INSERT INTO gb_message VALUES (NULL, '$name', '$message', '$date')";
$result = mysqli_query($con, $insert);

$select = mysqli_query($con,'SELECT * FROM gb_message' );
while( $row = mysqli_fetch_assoc($select) ){
    printf(" %s %s (%s) \n", $row['name'], $row['message'], $row['date']);
}*/ //Конец Функцион кода


?>