<?php
class contact extends controller {
    public function default(){
        $this->view('client', [
            'title' => "Liên hệ",
            'page' => "contact"
        ]);
    }
}