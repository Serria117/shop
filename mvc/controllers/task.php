<?php
class task extends controller{
    public $task;
    public function __construct()
    {
        $this->task = $this->model('taskModel');
    }
    function default()
    {
        $this->task;
        $this->view("client", [
            'page' => 'task',
            'title' => 'task',
            'taskList' => $this->task->getTask()
        ]);
    }
    
}
?>