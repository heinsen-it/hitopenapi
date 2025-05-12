<?php
namespace hitopenapi\app\core;

use hitopenapi\app\exception\requestexception;

class request {

    private ?array $_allowedMethods;

    private ?array $_path;

    private routes $_routes;


    function __construct() {
        $this->_path = null;
        $this->_allowedMethods = ["get", "post", "put", "delete"];
        $this->_routes = new routes();
        $this->_routes->setroutes();


    }


    public function verify(string $path, string $method):void{
        if(!in_array($method, $this->_allowedMethods)){
            throw new requestexception("Request method not allowed");
        }
        if(!$this->_routes->allowedRoute($path)){
            throw new requestexception("Request route not allowed");
        }

    }



    private function getpaths():void{
        $path = isset($_GET['url']) ? rtrim($_GET['url'], '/') : NULL;
        $path = urlencode($path ?? '');
        $path = urldecode(htmlspecialchars($path));
        $this->_path = explode('/', $path);
    }


    public function setAllowedMethods(array $allowedMethods):void{
        $this->_allowedMethods = $allowedMethods;
    }

    public function getAllowedMethods():array{
        return $this->_allowedMethods;
    }




}
