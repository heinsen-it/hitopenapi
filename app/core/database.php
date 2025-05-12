<?php
namespace hitopenapi\app\core;
use DB;
use mysqli;
use nested;
use none;
use query;
class database extends \mysqli{

    private mysqli|null $link = null;
    public $filter;
    static database|null $inst = null;
    public static int $counter = 0;
    private string $_dbprefix = '';


    /**
     * @param string $DB_HOST
     * @param string $DB_USER
     * @param string $DB_PASS
     * @param string $DB_NAME
     */
    public function __construct(string $DB_HOST,string $DB_USER,string $DB_PASS,string $DB_NAME) {
        try {
            $this->link = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
            $this->link->set_charset("utf8");
           } catch (\Exception $e) {
               die('Unable to connect to database:'.$e->getMessage());
          }
    }

    /**
     *
     */
    public function __destruct() {
        if ($this->link) {
            $this->disconnect();
        }
    }


    public function log_db_errors(?string $error,?string $query):void{

    }


    /**
     * Funktion zum Ausführen von Querys
     * @access public
     * @param string
     * @return string
     * @return array
     * @return bool
     *
     */
    public function query(string $query,int $resultmode = NULL):bool
    {
        $full_query = $this->link->query($query);
        if ($this->link->error) {
            $this->log_db_errors($this->link->error, $query);
            return false;
        } else {
            return true;
        }
    }


    /**
     * Prüft ob Tabelle Existiert
     * @access public
     * @param string
     * @return bool
     *
     */
    public function table_exists(string $name):bool
    {
        self::$counter++;
        $check = $this->link->query("SELECT 1 FROM $name");
        if ($check !== false) {
            if ($check->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }




    /**
     * Insert Funktion zum Eintragen von neuen Daten
     * @access public
     * @param string table name
     * @param array table column => column value
     * @return bool
     */
    public function insert(string $table, array $variables = array()):bool
    {
        self::$counter++;
        //Make sure the array isn't empty
        if (empty($variables)) {
            return false;
        }

        $sql = "INSERT INTO " . $table;
        $fields = array();
        $values = array();
        foreach ($variables as $field => $value) {
            $fields[] = $this->filter($field);
            $values[] = "'" . $value . "'";
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '(' . implode(', ', $values) . ')';

        $sql .= $fields . ' VALUES ' . $values;
        $query = $this->link->query($sql);

        if ($this->link->error) {
            $this->log_db_errors($this->link->error, $sql);
            return false;
        } else {
            return true;
        }
    }


    /**
     * Insert Funktion für mehrere Einträge
     * @access public
     * @param string table name
     * @param array table columns
     * @param nested array records
     * @return bool
     * @return int number of records inserted
     *
     */
    public function insert_multi(string $table,array $columns = array(),array $records = array()):bool|int
    {
        self::$counter++;
        if (empty($columns) || empty($records)) {
            return false;
        }
        $number_columns = count($columns);
        $added = 0;
        $sql = "INSERT INTO " . $table;
        $fields = array();
        foreach ($columns as $field) {
            $fields[] = '`' . $field . '`';
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = array();
        foreach ($records as $record) {
            if (count($record) == $number_columns) {
                $values[] = '(\'' . implode('\', \'', array_values($record)) . '\')';
                $added++;
            }
        }
        $values = implode(', ', $values);
        $sql .= $fields . ' VALUES ' . $values;
        $query = $this->link->query($sql);
        if ($this->link->error) {
            $this->log_db_errors($this->link->error, $sql);
            return false;
        } else {
            return $added;
        }
    }



}