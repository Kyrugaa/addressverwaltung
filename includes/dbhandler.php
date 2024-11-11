<?php 

function getConnection(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "adressverwaltung";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function close_connection ($conn){
    try {
        if (isset($conn)) {
            $conn->close();
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        throw $e;
    }
}

function safePerson($salutation, $firstname, $lastname, $email, $mobile_number, $phone_number, $homepage, $street, $house_number, $postal_code, $city){
    $conn = getConnection();
    $sql = "INSERT INTO persons(salutation, firstname, lastname, email, mobile_number, phone_number, homepage) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $salutation, $firstname, $lastname, $email, $mobile_number, $phone_number, $homepage);
    $stmt->execute();

    $person_id = $conn->insert_id;

    $sql = "INSERT INTO addresses(person_id, street, house_number, postal_code, city) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $person_id, $street, $house_number, $postal_code, $city);
    $stmt->execute();

    close_connection($conn);
    header("Location: ../index.php");
    exit();
}

function getPersons(){
    $conn = getConnection();
    $sql = "SELECT * FROM persons INNER JOIN addresses ON persons.id = addresses.person_id";
    $result = $conn->query($sql);
    $persons = array();
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            $persons[] = $row;
        }
    }
    close_connection($conn);
    return $persons;
}

