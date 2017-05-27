<?php
class my_view /*Класс для представления данных*/
{
    public $controller; /*данные для контроллера*/
    public $data;/*Данные массива сообщений с комментариями*/
    public $delete_message_id; /*Ид сообщения для удаления*/
    public $editMessageId; /*Ид сообщения для редактирования*/

    
    public function __construct()
    {
        $this->controller = new controller; /*Инициализация класса контроллер*/
        $this->data = $this->controller-> ControllerData(); /*Получим данные массива сообщений с комментариями*/
    }
    
    
    public  function init()
    {
        
        if (isset($_POST["del_x"])) /*id пришло для удаления сообщения*/
        {
            $delete_message_id = (int) $_POST["id"];
            $this->controller->ControllerDeleteMessage($delete_message_id); /*Удаляем сообщение*/
            
        }
        
        if (isset($_POST["delComm_x"])) /*Удаляем комментарий*/
        {
            $idComment = (int) $_POST["id"];
            $this->controller->ControllerDeleteComment($idComment);
        }

        if (isset($_POST["send"]))/*Пришли имя и сообщения для добавления в БД*/
        {
            $nameMessage = $_POST["name"];
            $dataMessage = $_POST["message"];
            echo $nameMessage, "  ", $dataMessage;
            $this->controller->ControllerAddMessage($nameMessage, $dataMessage);/*Добавляем сообщение*/
            
            
         }

        if (isset($_POST["send_comment"])) /*Пришли данные для добавления комментария */
        {
            $idMessage = $_POST["id"];
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $this->controller->ControllerAddComment($idMessage, $name, $comment);
            
            echo "Вы нажали";
        }
        
        if (isset($_POST["editmessage"])) /*Если нажали на кнопку редактировать и отправили данные*/
        {
            $idMessage = $_POST["id"]; /*ид сообщения для редактирования*/
            $dataMessage = $_POST["message"]; /*Отредактированное сообщение*/
            echo "Message is update";
            $this->controller->ControllerUpdateMessage($idMessage, $dataMessage);
            
        }
        
        if (isset($_POST["editcomment"])) /*Если нажали на кнопку редактировать комментарий и отправили данные*/
        {
            $idMessage = $_POST["id"]; /*ид комментария для редактирования*/
            $dataMessage = $_POST["message"]; /*Отредактированный комментарий*/
            $this->controller->ControllerUpdateComment($idMessage, $dataMessage);
        
        }

        echo "<h1 style='text-align:center'>Guest book</h1>";   
       

        if ($this->data == null) /*Если ли сообщения в гостевой книги*/
        {
            echo "<div class=c><div class=com>"; /*Вывод нет сообщения*/
            echo "В гостевой книги нет сообщений";
            echo "</div>";
        }
        else 
        {/*Есть сообщения в гостевой книги*/
            
            foreach ($this->data as $id => $dataMessage)
            {
                /*Скрипт для каждой кнопки для редактирования сообщений скрыть/раскрыть*/
                $scriptMessage = "<script>
                  $(document).ready(function()
                  {  
                    $('#myb$id').click(function ()
                    {
                        var d = document;  
                        var a = d.getElementById('div_form$id').style.display; 
                        d.getElementById('div_form$id').style.display = (a == 'none')?'block':'none';
                    });                                
                  });
                  </script>";
                echo $scriptMessage;
                 /*Вывод всех сообщения*/
                echo "<div class=sms>";
                echo "<p>Name: ".$dataMessage["name"]."<br> Message: ".$dataMessage["message"]. " <br>Date: ". $dataMessage["date"]; /*Вывод всех сообщений*/
                echo "<div id='div_form$id' style='display:none;' class= ''>
                <form method='POST'>"; /*Скрытая форма для редактирования сообщения*/
                echo "<input type='image' name='del' img src='del.png' width='15'>  "; /*Картинка для удаления сообщения*/  
                echo "<input type='hidden'name='id' value='".$id."'>";
                echo "<input name= 'message' value='".$dataMessage["message"]."'>";
                echo "<input type='submit' name='editmessage'></form></div>";
                echo "<button id='myb$id'><img src='edit.png' width='15'>Редактировать</button></div>";/*Картинка для редактирования сообщения*/
               
                                          
                if ($dataMessage["comments"] == 0) /*Форма для отрисовки ввода комментария*/
                {
                    echo " <div class=comment>";
                    echo "<form method='Post' action='index.php' >"; /*Создание формы для добавления комментария*/
                    echo "<input type='hidden'name='id' value='".$id."'>";
                    echo "<input type='text' name='name' value='' required></br>";/*Поле для имени*/
                    echo "<input type='text' name='comment' value='' required>"; /*Поле для комментария*/
                    echo "<input class='btn-style'type='submit' id ='edit' name='send_comment' value='Комментировать'>"; /*Кнопка для отправки комментария*/
                    echo "</form></div>";
                    
                    /*Форма для добавления комментария к сообщению*/
                }
                else
                {
                    foreach ($dataMessage["comments"] as $idComments=>$key) /*Вывод всех комментарий к сообщению*/
                    {
                        $scriptComment = "<script>
                        $(document).ready(function()
                            {
                                $('#myc$idComments').click(function ()
                                 {
                                    var d = document;
                                    var a = d.getElementById('div_Com_form$idComments').style.display;
                                    d.getElementById('div_Com_form$idComments').style.display = (a == 'none')?'block':'none';
                                });
                            });
                        </script>";
                        /*Скрипт для каждой кнопки для редактирования комментариев скрыть/раскрыть*/
                        echo $scriptComment;
                        echo "<div class=com>";
                        echo "<form method='Post' action='index.php'>";/*Форма для отрисовки ввода комментария*/
                        echo "This is comment : <br> Name-> ".$key["commName"]."<br id='".$idComments."'>Comment -> ".$key["comm"]."<br>".$key["commDate"];
                        echo "<input type='hidden' my_field = '' name='id' value='".$idComments."'>";
                        echo "<div id='div_Com_form$idComments' style='display:none;' class= ''>
                        <form method='POST'>"; /*Скрытая форма для редактирования сообщения*/
                        echo "<input type='hidden'name='id' value='".$idComments."'>";
                        echo "<input name= 'message' value='".$key["comm"]."'>";
                        echo "<input type='image' name='delComm' img src='del.png' width='15'>"; /*Картинка для удаления сообщения*/
                        echo "<input type='submit' name='editcomment'></form></div>";
                        
                        //echo "<input type='image' id = 'edit' name='editComm' img src='edit.png' width='15'></form>";
                        echo "<button id='myc$idComments'><img src='edit.png' width='15'>Редактировать</button></div></div>";/*Картинка для редактирования сообщения*/
                       
                     }
                     /*Форма для добавления комментария к сообщению */
                     echo "<div class=comment>";
                     echo "<form method='post' action='index.php' >"; /*Создание формы для добавления комментария*/
                     echo "<input type='hidden'name='id' value='".$id."'>";
                     echo "<input type='text' name='name' value='' required></br>";/*Поле для имени*/
                     echo "<input type='text' name='comment' value='' required>"; /*Поле для комментария*/
                     echo "<input class='btn-style'type='submit' name='send_comment' value='Комментировать'>"; /*Кнопка для отправки комментария*/
                     echo "</form></div>";
                }                
             }
            
        }/*Есть сообщения в гостевой книги*/
        
        /*Форма для добавления сообщений*/
        echo "<div class=c><div class=cn><b>";
        echo "<p>Добавить новое сообщение</p>";
        echo "<form method='POST' action='index.php' >"; /*Создание формы для добавления сообщений*/
        echo "<input type='text' name='name' value='' required></br>";/*Поле для имени*/
        echo "<input type='text' name='message' value='' required>"; /*Поле для сообщения*/
        echo "<input type='submit' name='send' value='Отправить'>"; /*Кнопка для отправки сообщения*/
        echo "</form></div>";
        /*Конец Форма для добавления сообщений*/
    }
}
?>
