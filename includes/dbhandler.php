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

function safePerson($salutation, $firstname, $lastname, $email, $mobile_number, $phone_number, $homepage, $addresses){
    try {
        $conn = getConnection();
        $conn->begin_transaction();

        $sql = "INSERT INTO persons(salutation, firstname, lastname, email, mobile_number, phone_number, homepage) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $salutation, $firstname, $lastname, $email, $mobile_number, $phone_number, $homepage);
        $stmt->execute();

        $person_id = $conn->insert_id;

        $sql = "INSERT INTO addresses(person_id, street, house_number, postal_code, city) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        foreach ($addresses['street'] as $index => $street) {
            $house_number = $addresses['house_number'][$index];
            $postal_code = $addresses['postal_code'][$index];
            $city = $addresses['city'][$index];
            $stmt->bind_param("issss", $person_id, $street, $house_number, $postal_code, $city);
            $stmt->execute();
        }

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Error: " . $e->getMessage());
        throw $e;
    } finally {
        close_connection($conn);
        header("Location: ../index.php");
        exit();
    }
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

function getSpecificPerson($person_id) {
    $conn = getConnection();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM persons INNER JOIN addresses ON persons.id = addresses.person_id WHERE persons.id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $person_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "No records found for person_id: " . htmlspecialchars($person_id);
        return null;
    }

    $person = $result->fetch_assoc();
    if (!$person) {
        echo "Fetch failed.";
        return null;
    }

    close_connection($conn);
    return $person;
}

function updatePerson($person_id, $salutation, $firstname, $lastname, $email, $mobile_number, $phone_number, $homepage, $street, $house_number, $postal_code, $city) {
    try {
        $conn = getConnection();
        
        $sql = "UPDATE persons SET salutation = ?, firstname = ?, lastname = ?, email = ?, mobile_number = ?, phone_number = ?, homepage = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $salutation, $firstname, $lastname, $email, $mobile_number, $phone_number, $homepage, $person_id);
        $stmt->execute();
        
        $sql = "UPDATE addresses SET street = ?, house_number = ?, postal_code = ?, city = ? WHERE person_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $street, $house_number, $postal_code, $city, $person_id);
        $stmt->execute();
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        throw $e;
    } finally {
        close_connection($conn);
    }
}

function deletePerson($person_id) {
    try {
        $conn = getConnection();
        
        // Delete from addresses table
        $sql = "DELETE FROM addresses WHERE person_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $person_id);
        $stmt->execute();
        
        // Delete from persons table
        $sql = "DELETE FROM persons WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $person_id);
        $stmt->execute();
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        throw $e;
    } finally {
        close_connection($conn);
    }
}

function searchPerson($searchedPerson){
    $conn = getConnection();

    $sql = "SELECT * FROM persons WHERE firstname LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchedPerson);
    $stmt->execute();
    $result = $stmt->get_result();
    $persons = array();
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            $persons[] = $row;
        }
    }
    close_connection($conn);
    echo json_encode($persons);
    return $persons;
}