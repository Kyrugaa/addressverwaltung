<?php 
session_start();

require_once 'includes/dbhandler.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $person_id = $_POST['person_id'];
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

    updatePerson($person_id, $salutation, $firstname, $lastname, $email, $mobile_number, $phone_number, $homepage, $street, $house_number, $postal_code, $city);

    header("Location: index.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit();
}

$person_id = $_GET['id'];
$person = getSpecificPerson($person_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bearbeiten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1 class="display-4">Bearbeiten</h1><hr>
                <form action="editPerson.php" method="POST">
                    <input type="hidden" name="person_id" value="<?php echo $person_id; ?>">
                    <div class="mb-3">
                        <label for="salutation" class="form-label">Anrede</label>
                        <select class="form-select" id="salutation" name="salutation" required>
                            <option value="Herr" <?php if($person['salutation'] == 'Herr') echo 'selected'; ?>>Herr</option>
                            <option value="Frau" <?php if($person['salutation'] == 'Frau') echo 'selected'; ?>>Frau</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Vorname</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $person['firstname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Nachname</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $person['lastname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-Mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $person['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile_number" class="form-label">Handynummer</label>
                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php echo $person['mobile_number']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Telefonnummer</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $person['phone_number']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="homepage" class="form-label">Homepage</label>
                        <input type="text" class="form-control" id="homepage" name="homepage" value="<?php echo $person['homepage']; ?>">
                    </div>
                    <h6 class="display-6">Adresse</h6>
                    <div class="mb-3">
                        <label for="street" class="form-label">Straße</label>
                        <input type="text" class="form-control" id="street" name="street" value="<?php echo $person['street']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="house_number" class="form-label">Hausnummer</label>
                        <input type="text" class="form-control" id="house_number" name="house_number" value="<?php echo $person['house_number']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">Postleitzahl</label>
                        <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo $person['postal_code']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Stadt</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?php echo $person['city']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit-person">Speichern</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

