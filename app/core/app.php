<?php
namespace hitopenapi\app\core;

use hitopenapi\app\exception;
class app {

    /**
     * @var string $_rqmethod ist die Requestmethode mit der die API angesprochen wird
     */
  private ?string $_reqmethod;

    /**
     * @var string|null $_reqpath bildet den Pfad ab, der abgerufen werden soll
     */
  private ?string $_reqpath;

    /**
     * @var request $_request ist das Objekt der Klasse der Request
     */
  private request $_request;
    /**
     * @var response $_response ist das Objekt der Klasse Response
     */
  private response $_response;

  private ?array $_error;

  function __construct() {
     // Setzen der Standardvariablen
     $this->_reqmethod = NULL;
     $this->_reqpath = NULL;
     $this->_error = NULL;
     $this->_request = new request();
     $this->_response = new response();

  }

  public function init(){
     try {
       $this->_request->verify($this->_reqpath, $this->_reqmethod);
     } catch (exception\requestexception $e) {

     }

  }

    /**
     * @param string $requestmethod
     * @return void
     */
  public function setrequest(string $requestmethod):void{
      $this->_rqmethod = $requestmethod;
  }

    /**
     * @return string
     */
  public function getrequest():string{
      return $this->_rqmethod;
  }


  private function seterror(string $message):void{

  }


  private function geterror():string{

  }



}