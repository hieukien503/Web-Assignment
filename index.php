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
// include_once("Model/initDB.php");
?>

<?php
$page = isset($_GET['page']) ? $_GET['page'] : "home";
include_once("./View/$page.php");
?>