<?php 
session_start();
require_once 'dbhandler.php';

if(!isset($_POST['searchedPerson'])){
    header("Location: ../index.php");
    exit();
}

$searchedPerson = $_POST['searchedPerson'];
$sortOrder = $_POST['sortOrder'];

$results = searchPerson($searchedPerson, $sortOrder);

$_SESSION['searchResults'] = $results;
header("Location: ../index.php");