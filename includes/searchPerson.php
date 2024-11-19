<?php 
session_start();
require_once 'dbhandler.php';

if(!isset($_POST['searchedPerson'])){
    header("Location: ../index.php");
    exit();
}

$searchedPerson = $_POST['searchedPerson'];

searchPerson($searchedPerson);

echo $searchedPerson;

