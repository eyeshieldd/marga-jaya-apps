<?php


class Mandor extends Portal_admin{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index(){
        parent::display('index');
    }
    
}