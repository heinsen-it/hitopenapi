<?php
namespace hitopenapi\app\core;
class routes {

    private ?array $_allowed;

    public function __construct() {

        $this->_allowed = null;

    }


    public function add(array $path):void{
        $this->_allowed[$path[0]][] = $path;
    }


    public function setroutes():void{

    }

}