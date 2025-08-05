<?php

abstract class AbstractPage{
    protected $data = [];

    public function __construct(){
        $this->execute();
        $this->show();
    }

    public function show(){
        $template = $this->templateName;
        $data = $this->data;
        include_once(SYSTEM . 'View/' . $template . '.tpl.php');
    }
}