<?php
error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
/*Данные для авторизации*/
define("HOST", 'localhost');
define("USER", 'dshtolin_s677c08');
define("PASS", 'JPV21FaCAIoyPSm55wxrux1yaxIpIQGR');
define("DB", 'dshtolin_sitetest');


class gb_mysql
{
    public $my_sqli; /*экземпляр класса mysqli*/
    public $comments; /*массив комментариев*/
    public $send_object; /*массив отправляемых сообщений с комментариями*/
       
   public function __construct() /*Подключаемся к БД при создании класса*/
    {
        $this->my_sqli = new mysqli(HOST,USER,PASS,DB);
        if (mysqli_connect_errno()) /*Проверка соеденения*/
        {
            printf("Соеденение не установлено: %s\n", mysqli_connect_error());
            exit();
        }
     }
    
   public function getMessages() /*Получаем массив сообщений*/
    {
       $arr = array();
       $message =  $this->my_sqli->query("SELECT * FROM gb_message");
       if ($message->num_rows > 0)
       {
           while($rows = $message->fetch_array())
           {
               $arr[$rows[0]]['name'] = $rows[1];
               $arr[$rows[0]]['message'] = $rows[2];
               $arr[$rows[0]]['date'] = $rows[3];
           }
           return $arr; /*Возвращаем все сообщения*/
       }
   }/*Конец Получаем массив сообщени */
    
   public function getComments($messid) /*Получить комментарий к сообщению*/
    {
        $comments = $this->my_sqli->query("SELECT * FROM gb_comments WHERE messid = '$messid' ");/*запрос для комментария*/
        if ($comments->num_rows > 0) 
        {
            while($rows = $comments->fetch_array())
            {
                $arr[$rows[0]]['messid'] = $rows[1];
                $arr[$rows[0]]['name'] = $rows[2];
                $arr[$rows[0]]['comm'] = $rows[3];  
                $arr[$rows[0]]['date'] = $rows[4];
            }
            return $arr;
        }
    } /*Конец Получить комментарий к сообщению*/
    
   public function getData() /*Метод для отправки массива с комментариями в контроллер*/
    {
        $massive_mes = $this->getMessages(); /*Массив сообщений*/
        $this->send_object; /*Формируемый массив сообщений с комментариями*/
        
        if (!is_null($massive_mes)) /*Проверить массив на пустоту*/
        {
            foreach ($massive_mes as $key=>$dataMessages) /*Получаем ассоциативный массив сообщений*/
            {
                $this->send_object[$key]["name"] = $dataMessages["name"];
                $this->send_object[$key]["message"] = $dataMessages["message"];
                $this->send_object[$key]["date"] = $dataMessages["date"];
                $comments = $this->getComments($key); /*Массив комментариев к сообщению*/
                if ($comments != 0) /*Проверка на пустой массив комментариев?*/
                     {
                         foreach ($comments as $commentKey => $dataComments) /*Обход всех комментариев к сообщению */
                             {
                                 $this->send_object[$key]["comments"][$commentKey]["commName"] = $dataComments["name"];/*Добавляем имя комментатора в массив сообщений*/
                                 $this->send_object[$key]["comments"][$commentKey]["comm"] = $dataComments["comm"];/*Добавляем комментарий в массив сообщений*/
                                 $this->send_object[$key]["comments"][$commentKey]["commDate"] = $dataComments["date"];/*Добавляем дату комментария в массив сообщений*/
                              }
                     }
                 else /*Если нет комментария в БД*/
                     {
                         $this->send_object[$key]["comments"] = 0;
                     }
            }
            return $this->send_object; /*Возвращаем массив данных сообщений и к ним комментариев*/
        }
    }/*Конец Метод для отправки массива с комментариями в контроллер*/
    
   public function addMessage($name, $message) /*Добавим сообщение в бд*/
    {
       $acceptName = (string) $name;
       $acceptMessage = (string) $message;
       $acceptName = $this->my_sqli->real_escape_string(htmlentities ($name)); /*Валидация данных - имя*/
       $acceptMessage = $this->my_sqli->real_escape_string(htmlentities ($message)); /*Валидация данных - имя*/
        //$acceptName = htmlentities($name); /*Валидация данных - имя*/
        if ($name != null && $message != null)
        {
            $date = date("Y-m-d H:i:s"); /*Текущая дата и время*/
            $queryDataMessage = "INSERT INTO gb_message VALUES ('NULL','$acceptName','$acceptMessage', '$date')"; /*Запрос на добавление сообщения*/
            $runQueryDataMessage = $this->my_sqli->query($queryDataMessage);
            if ($runQueryDataMessage)
            {
                echo "Message added";
                header("Location:".$_SERVER["REQUEST_URI"]); /*Перезагрузим страницу*/
                //$runQueryDataMessage->close();
            }
        }
    } /*Конец Добавим сообщение в бд*/
    
   public function deleteMessage($idMessage) /*Метод для удаления сообщений с его комментариями*/
    {
        $idMessage = (int) $idMessage;
        $queryDeleteMessage = "DELETE FROM gb_message WHERE id='$idMessage'"; /*Удаление сообщения по его id*/
        $queryDeleteComments = "DELETE FROM gb_comments WHERE messid='$idMessage'" /*Удаление комментариев к сообщению по messid*/;
        $result_message = $this->my_sqli->query($queryDeleteMessage);/*Удаляем сообщение*/
        
        if ($result_comments = $this->my_sqli->query($queryDeleteComments))/*Удаляем комментарии*/
            {
                $result_message = $this->my_sqli->query($queryDeleteMessage);/*Удаляем сообщение*/
                header("Location:".$_SERVER["REQUEST_URI"]); /*Перезагрузим страницу*/
                
            }
        else 
             {
                printf("Ошибка: %s\n", $mysqli->error);
             }
             
     } /*Конец Метод для удаления сообщений с его комментариями*/
   
   public function deleteComment($idComment) /*Метод для удаления комментария*/
   {
       $idComment = (int) $idComment;
       $queryDeleteComments = "DELETE FROM gb_comments WHERE id=$idComment" /*Удаление комментарий*/;
       $this->my_sqli->query($queryDeleteComments); 
       header("Location:".$_SERVER["REQUEST_URI"]); /*Перезагрузим страницу*/
       
   }/*Конец Метод для удаления комментария*/
    
   public function addComment($idMessage, $name, $comment) /*Метода для добавления комментария */
    {
        $acceptidMessage = (string) $idMessage;
        $acceptName = (string) $name;
        $acceptComment = (string) $comment;
        $date = date("Y-m-d H:i:s"); /*Текущая дата и время*/
        
        $acceptidMessage = htmlentities($this->my_sqli->real_escape_string($acceptidMessage)); /*Валидация данных - Ид*/
        $acceptName = htmlentities($this->my_sqli->real_escape_string($name)); /*Валидация данных - имя*/
        $acceptComment = htmlentities($this->my_sqli->real_escape_string($acceptComment)); /*Валидация данных - Комментарий*/
        
        $queryAddComment = "INSERT INTO gb_comments VALUES ('NULL', '$acceptidMessage','$acceptName','$acceptComment','$date')";
        $this->my_sqli->query($queryAddComment); /*Добавляем комментарий*/
        header("Location:".$_SERVER["REQUEST_URI"]); /*Перезагрузим страницу*/
    }/*Конец Метода для добавления комментария */
    
   public function updateMessage($id, $message) /*Метод для редактирования сообщений*/
    {
        $id = htmlentities((int) $id);
        $message = htmlentities((string) $message);
        $queryUpdateMessage = "UPDATE `gb_message` SET `message`='".$message."' WHERE id = ".$id;
        $this->my_sqli->query($queryUpdateMessage); /*Выполняем Запрос на редактирование сообщения*/
        header("Location:".$_SERVER["REQUEST_URI"]); /*Перезагрузим страницу*/
    }/*Конец Метод для редактирования сообщений*/
    
    public function updateComment($id, $comment)/*Метод для редактирования комментария*/
    {
        $id = htmlentities((int) $id); /*Ид коммента*/
        $comment = htmlentities((string) $comment); /*Комментарий*/
        $queryUpdateComment = "UPDATE `gb_comments` SET `comment`='".$comment."' WHERE id = ".$id;
        $this->my_sqli->query($queryUpdateComment); /*Выполяем Запрос на редактирование комментраия*/
        header("Location:".$_SERVER["REQUEST_URI"]); /*Перезагрузим страницу*/
        
    }/*Конец Метод для редактирования комментария*/
    
} /*Конец класса gb_mysql*/
?>