<?php

namespace GenildoMartins\BuildQuery;

use \PDO;
use \PDOException;
use PDOStatement;

class DB
{    
    private $pdo;
    private $table;
    private $join;
    private $foundRows;
    

    public function __construct(string $table, string $join='')
    {
        $this->table = $table;
        $this->join = $join;
        $this->setInstance();      
    }

    private function setInstance()
    {
        try {            

            $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $this->pdo = new PDO(
                'mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME').';port='.getenv('DB_PORT'),getenv('DB_USER'),getenv('DB_PASS'),$options
            );

        } catch(PDOException $e){

            die('<p>Database connection is failed.</p>');
        }
            
    }

    public function execute(string $query, array $values=[])
    {
        try {

            $stmt = $this->pdo->prepare($query);
            $stmt->execute($values);
            $this->foundRows = $this->pdo->query('SELECT FOUND_ROWS()')->fetchColumn();

            return $stmt;

        } catch(PDOException $e){

            (getenv('DEBUG') == 'true') ? die($e->getMessage()) : die('Error: Invalid query.');
        }
        
    }  

   
    public function select(string $fields='*', string $where='', array $values=[], string $order='', $limit='')
    {        
        $query = 'SELECT sql_calc_found_rows '.$fields.' FROM '.$this->table. ' '.$this->join;
        if (strlen($where)) $query.=' WHERE '.$where;        
        if (strlen($order)) $query.= ' ORDER BY '.$order;
        if (strlen($limit)) $query.= ' LIMIT '.$limit;
                
        return $this->execute($query, $values);
    }

  


    public function getFoundRows()
    {
        return $this->foundRows;
    }
   
}
