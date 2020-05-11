<?php


class db_config {
    protected $servername = 'tek-mmmi-db0a.tek.c.sdu.dk';
    protected $username = 'si3_2019_group_6';
    protected $password = 'iti4autgr6';
    protected $dbname = 'si3_2019_group_6_db';

}

/*
 class DB_Config
{

    //declaring variables
    private $dbhost;
    private $dbname;
    private $dbuser;
    private $dbpassword;

    //Function to connect to the database
    public function connect()
    {
        //database parameters    
        $this->dbhost = 'tek-mmmi-db0a.tek.c.sdu.dk';
        $this->dbname = "si3_2019_group_6_db";
        $this->dbuser = "si3_2019_group_6";
        $this->dbpassword = "iti4autgr6";
        //connect to the database using given parameters
        try {
            $dsn = "pgsql:host=" . $this->dbhost . ";dbname=" . $this->dbname;
            $pdo = new PDO($dsn, $this->dbuser, $this->dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }
        // give an error message if connection failed
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
*/