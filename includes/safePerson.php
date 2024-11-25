<?php 
session_start();
require_once 'dbhandler.php';
require_once '../classes/PersonValidator.php';

var_dump($_POST);

if (isset($_POST['submit-person'])) {
    $data = [
        'salutation' => $_POST['salutation'],
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'email' => $_POST['email'],
        'mobile_number' => $_POST['mobile_number'],
        'phone_number' => $_POST['phone_number'],
        'homepage' => $_POST['homepage'],
        'addresses' => [
        'street' => $_POST['street'],
        'house_number' => $_POST['house_number'],
        'postal_code' => $_POST['postal_code'],
        'city' => $_POST['city']
        ]
    ];

    $errors = PersonValidator::validate($data);

    if (!empty($errors)) {
        $query = http_build_query(['error' => $errors]);

        header("Location: ../index.php?$query");
        exit();
    }

    try {
        safePerson($data['salutation'], $data['firstname'], $data['lastname'], $data['email'], $data['mobile_number'], $data['phone_number'], $data['homepage'], $data['addresses']);
    } catch (Exception $e) {
        header("Location: ../index.php?error=sqlerror");
        exit();
    }
}