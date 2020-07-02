<?php


class Input_stock extends Portal_admin{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index(){
        parent::display('index');
    }
    
}