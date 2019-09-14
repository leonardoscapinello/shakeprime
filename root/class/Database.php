<?php
$connection_buffer = file_get_contents(DIRNAME . "../properties/database.xml");
$connection_xml = simplexml_load_string($connection_buffer);
$connection = XML2Array($connection_xml);
$connection = array(
    $connection_xml->getName() => $connection
);

class Database
{

    var $pdo;
    public $server;
    public $server_port;
    public $user;
    public $password;
    public $password_encryption;
    public $database;
    public $db_model;
    private $dbh;
    private $error;
    private $stmt;

    public function __construct()
    {
        global $connection;
        $this->server = $connection['connection']['server'];
        $this->server_port = $connection['connection']['port'];
        $this->user = $connection['connection']['user'];
        $this->password_encryption = $connection['connection']['password_encryption'];
        switch ($this->password_encryption) {
            case "base64":
                $this->password_encryption = base64_decode($this->password_encryption);
                break;
        }

        $this->password = $connection['connection']['password'];
        $this->database = $connection['connection']['database'];
        $this->db_model = $connection['connection']['db_model'];
        if ($this->server_port !== "") {
            $this->server = $this->server . ":" . $this->server_port;
        }

        $dsn = $this->db_model . ":host=" . $this->server . ";dbname=" . $this->database;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }


    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;

                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;

                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;

                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    public function resultset()
    {
        $this->execute();
        $result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->close();
        return $result;

    }

    public function resultsetObject()
    {
        $this->execute();
        $result = $this->stmt->fetch(PDO::FETCH_OBJ);
        $this->close();
        return $result;
    }

    /*
        public function resultsetClass($class)
        {
            $this->execute();
            $result = $this->stmt->fetch(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
            $this->close();
            return $result;
        }
    */
    public function execute()
    {
        $execute = $this->stmt->execute();
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        $this->execute();
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    /**
     * Transactions allow multiple changes to a database all in one batch.
     */
    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->dbh->commit();
    }

    public function cancelTransaction()
    {
        return $this->dbh->rollBack();
    }

    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }

    public function close($close_connection = false)
    {
        $this->stmt->closeCursor();
        if ($close_connection) $this->dbh = null;
    }

}


?>