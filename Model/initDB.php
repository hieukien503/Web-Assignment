<?php
class InitDatabase
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "BOOKING_APPOINTMENT";

    public $conn = null;
    private $lock_init = false;

    public function __construct()
    {
        /**
         * The very first connection to initialize the database schema.
         * Query content is sourced from DB.SQL
         */
        $db_schema_query = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Model/DB.SQL");

        $init_conn = new mysqli($this->servername, $this->username, $this->password);

        $duplicate_db = $init_conn->query("SHOW DATABASES LIKE '$this->dbname'");
        if ($duplicate_db->num_rows > 0) {
            // If the database is already existed, the initialization should stop
            $this->lock_init = true;
            $init_conn->close();
            return;
        }

        $init_conn->multi_query($db_schema_query);
        $init_conn->close();
        sleep(1);

        /**
         * After database initialized, connect to the database.
         */
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    }

    public function addAccount($fullname, $mail, $password, $role)
    {
        if ($this->lock_init == true)  return;

        // Check if account exists or not;
        if ($this->conn->query("SELECT * FROM users WHERE email = '$mail'")->num_rows > 0)
            return;
        $hashed_password = hash('sha512', $password);
        $sql = "INSERT INTO Users (fullName, email, password,role) VALUES ('$fullname', '$mail', '$hashed_password','$role')";
        $result = $this->conn->query($sql);
    }

    public function closeConnection()
    {
        if ($this->lock_init == true)  return;

        $this->conn->close();
    }
}

// Initialize schema (and drop old one)
$init_db = new InitDatabase();

// Add a few doctors
$init_db->addAccount('Dr. Khuong', 'nguyenkhuong8321@gmail.com', '12345678', 1);
$init_db->addAccount('Dr. Khoa', 'vietnamkhoale@gmail.com', '12345678', 1);

// Add a few patients
$init_db->addAccount('Le Trong Kien', 'trongkienbadblood@gmail.com', '12345678', 0);
$init_db->addAccount('Doan Hong Hieu Kien', 'kiendeptrai1875@gmail.com', '12345678', 0);

$init_db->closeConnection();
