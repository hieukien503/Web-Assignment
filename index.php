<?php

/** Enable PHP error reporting */
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<?php
/**
 * Run this script only once. 
 * When done, comment out this script.
 */
if (isset($_SESSION['initDB'])) {
    if ($_SESSION['initDB']) {
        include_once("Model/initDB.php");
        $_SESSION['initDB'] = false;
    }
}

?>

<?php
$page = isset($_GET['page']) ? $_GET['page'] : "home";
include_once("./View/$page.php");
?>