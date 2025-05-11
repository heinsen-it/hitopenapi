<?php
namespace hitopenapi\app\core;

class response {

    function __construct() {


    }




    // Antwortfunktionen
  public  function respondWithSuccess(?array $data) {
        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
        exit;
    }

  public  function respondWithError(string $message, int $statusCode = 400) {
        http_response_code($statusCode);
        echo json_encode([
            'success' => false,
            'error' => $message
        ]);
        exit;
    }





}