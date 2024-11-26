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

        $sql = "INSERT INTO addresses(personId, street, house_number, postal_code, city) VALUES (?, ?, ?, ?, ?)";
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
    $sql = "SELECT persons.*, addresses.id as address_id, addresses.street, addresses.house_number, addresses.postal_code, addresses.city 
            FROM persons 
            INNER JOIN addresses ON persons.id = addresses.personId";
    $result = $conn->query($sql);
    $persons = array();
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            $personId = $row['id'];
            if (!isset($persons[$personId])) {
                $persons[$personId] = [
                    'id' => $row['id'],
                    'salutation' => $row['salutation'],
                    'firstname' => $row['firstname'],
                    'lastname' => $row['lastname'],
                    'email' => $row['email'],
                    'mobile_number' => $row['mobile_number'],
                    'phone_number' => $row['phone_number'],
                    'homepage' => $row['homepage'],
                    'addresses' => []
                ];
            }
            $persons[$personId]['addresses'][] = [
                'id' => $row['address_id'],
                'street' => $row['street'],
                'house_number' => $row['house_number'],
                'postal_code' => $row['postal_code'],
                'city' => $row['city']
            ];
        }
    }
    close_connection($conn);
    return array_values($persons);
}

function getSpecificPerson($person_id) {
    $conn = getConnection();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM persons INNER JOIN addresses ON persons.id = addresses.personId WHERE persons.id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $person_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        return null;
    }

    $person = $result->fetch_assoc();
    close_connection($conn);
    return $person;
}

function updatePerson($personId, $salutation, $firstname, $lastname, $email, $mobile_number, $phone_number, $homepage) {
    $conn = getConnection();
    $sql = "UPDATE persons SET salutation = ?, firstname = ?, lastname = ?, email = ?, mobile_number = ?, phone_number = ?, homepage = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $salutation, $firstname, $lastname, $email, $mobile_number, $phone_number, $homepage, $personId);
    $stmt->execute();
    close_connection($conn);
}

function deletePerson($person_id) {
    try {
        $conn = getConnection();
        
        // Delete from addresses table
        $sql = "DELETE FROM addresses WHERE personId = ?";
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

function searchPerson($searchedPerson, $sortOrder){
    $conn = getConnection();

    $orderBy = "firstname ASC";
    switch ($sortOrder) {
        case 'firstname_desc':
            $orderBy = "firstname DESC";
            break;
        case 'lastname_asc':
            $orderBy = "lastname ASC";
            break;
        case 'lastname_desc':
            $orderBy = "lastname DESC";
            break;
    }

    $sql = "SELECT persons.*, addresses.* 
            FROM persons 
            INNER JOIN addresses ON persons.id = addresses.personId 
            WHERE persons.firstname LIKE ? 
            ORDER BY $orderBy";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%$searchedPerson%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    $persons = array();
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            $persons[] = $row;
        }
    }
    close_connection($conn);
    return $persons;
}

function getAddressesByPersonId($person_id) {
    $conn = getConnection();
    $sql = "SELECT * FROM addresses WHERE personId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $person_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $addresses = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $addresses[] = $row;
        }
    }
    close_connection($conn);
    return $addresses;
}

function updateAddress($addressId, $street, $house_number, $postal_code, $city) {
    $conn = getConnection();
    $sql = "UPDATE addresses SET street = ?, house_number = ?, postal_code = ?, city = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $street, $house_number, $postal_code, $city, $addressId);
    $stmt->execute();
    close_connection($conn);
}