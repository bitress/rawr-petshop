<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$hostname = "localhost";
$username = "root";
$password = "@c1y2a0n1n0e2";
$database = "pol_fessitup";

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con){
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

include_once 'functions.php';

const WEBSITE_DOMAIN = 'https://demo.itscyanne.xyz/ShopOn-It/';
