<?php 
session_start();
require_once 'dbhandler.php';

if(isset($_POST['submit-person'])){
    $salutation = $_POST['salutation'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];
    $phone_number = $_POST['phone_number'];
    $homepage = $_POST['homepage'];
    $street = $_POST['street'];
    $house_number = $_POST['house_number'];
    $postal_code = $_POST['postal_code'];
    $city = $_POST['city'];

    safePerson($salutation, $firstname, $lastname, $email, $mobile_number, $phone_number, $homepage, $street, $house_number, $postal_code, $city);
} else {
    header("Location: ../index.php?error=notallowed");
    exit();
}