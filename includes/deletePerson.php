<?php 
session_start();
include 'dbhandler.php';

if (isset($_GET['id'])) {
    $person_id = $_GET['id'];
    deletePerson($person_id);
    header("Location: ../index.php");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}