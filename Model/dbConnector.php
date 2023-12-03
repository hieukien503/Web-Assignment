<?php
class DatabaseConnector
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    private $conn;

    public function __construct()
    {
        /**
         * Default setting of out Database model.
         * It will automatically connect to our default database.
         */
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "1234";
        $this->dbname = "BOOKING_APPOINTMENT";
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    }

    public function connect($servername, $username, $password, $database)
    {
        $this->disconnect();

        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $database;

        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    }

    public function query($query)
    {
        $result = $this->conn->query($query);

        return $result;
    }

    public function disconnect()
    {
        unset($this->servername);
        unset($this->username);
        unset($this->password);
        unset($this->dbname);
        $this->conn->close();
    }
}

$DB_CONNECTOR = new DatabaseConnector();