<?php
class InitDatabase
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "BOOKING_APPOINTMENT";

    private $conn = null;

    public function __construct()
    {
        /**
         * The very first connection to initialize the database schema.
         * Query content is sourced from DB.SQL
         */
        $db_schema_query = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Model/DB.SQL");

        $init_conn = new mysqli($this->servername, $this->username, $this->password);
        $init_conn->multi_query($db_schema_query);
        $init_conn->close();

        /**
         * After database initialized, connect to the database.
         */
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    }

    public function addAccount($fullname, $mail, $password, $role)
    {
        // Check if account exists or not;
        if ($this->conn->query("SELECT * FROM users WHERE email = '$mail'")->num_rows > 0)
            return;

        $hash_pwd = hash('sha512', $password);
        $sql = "INSERT INTO users (fullName, email, password,role) VALUES ('$fullname', '$mail', '$hash_pwd','$role')";
        $result = $this->conn->query($sql);
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}

// Initialize schema (and drop old one)
$init_db = new InitDatabase();

// Add a few doctors
$init_db->addAccount('Dr. Kien', 'kien.le123@hcmut.edu.vn', hash('sha512', 'byebyebyebyebye'), 1);
$init_db->addAccount('Dr. Jackson', 'jack@gmail.com', hash('sha512', '12345678'), 1);
$init_db->addAccount('Dr. Steve', 'khoa.lesteve@hcmut.edu.com', hash('sha512', '12345678'), 1);

// Add a few patients
$init_db->addAccount('Duong Van Hao', 'dvhao@gmail.com', hash('sha512', '12345678'), 0);
$init_db->addAccount('Lai Van Minh', 'minh@gmail.com', hash('sha512', '12345678'), 0);
$init_db->addAccount('Lam Phuong', 'phuong@saigonair.com', hash('sha512', '12345678'), 0);

$init_db->closeConnection();