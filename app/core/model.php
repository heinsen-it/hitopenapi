<?php
namespace hitopenapi\app\core;

class model
{

    protected database $_db;

    public function __construct()
    {
        $this->_db = new database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

}