<?php
ini_set('display_errors', 1);
class controller
{
    public $data_sql;
    public $data_com;
    
    public function ControllerData() /*Получение данных из модели скл*/
    {
        
        $this->data_sql = new gb_mysql(); /*Экземпляр класса gb_mysql*/
        $outMassve = $this->data_sql->getData(); /*Получение массива сообщений с комментариями */
        return $outMassve; /*Возвращаем полученный массив*/
    }
    
   public function ControllerAddMessage($name,$message) /*Метод контроллера для добавления сообщений в БД*/
    {
        $this->data_sql->AddMessage($name, $message);
    }
    
   public function ControllerDeleteMessage($idMessage) /*Метод контроллера для удалений сообщений в БД*/
    {
        $this->data_sql->deleteMessage($idMessage);
    }
    
    public function ControllerDeleteComment($idComment)/*Метод контроллера для удалений комментариев в БД*/
    {
        $this->data_sql->deleteComment($idComment);
    }
    
   public function ControllerAddComment($idMessage, $name, $comment) /*Метода контроллера для добавления комментария */
    {
        $this->data_sql->addComment($idMessage, $name, $comment);
    }
    
    public function ControllerUpdateMessage($id, $message) /*Метод контроллера для редактирования сообщений в БД*/
    {
        $this->data_sql->updateMessage($id, $message);
    }
    
    public function ControllerUpdateComment($id, $message) /*Метод контроллера для редактирования комментариев в БД*/
    {
        $this->data_sql->updateComment($id, $message);
    }
    
}
?>