<?php 
session_start();
require_once 'includes/dbhandler.php';

$persons = getPersons();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adressverwaltung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1 class="display-4">Adressverwaltung</h1><hr>
                <form action="includes/safePerson.php" method="POST">
                    <h6 class="display-6">Person</h6>
                    <?php
                        if (isset($_GET['error'])) {
                            echo "<div class='alert alert-danger'>";
                            foreach ($_GET['error'] as $error) {
                                echo htmlspecialchars($error) . "<br>";
                            }
                            echo "</div>";
                        }
                    ?>
                    <div class="mb-3">
                        <label for="salutation" class="form-label">Anrede</label>
                        <select class="form-select" id="salutation" name="salutation" required>
                            <option value="Herr">Herr</option>
                            <option value="Frau">Frau</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Vorname</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Nachname</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-Mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile_number" class="form-label">Handynummer</label>
                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Telefonnummer</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="homepage" class="form-label">Homepage</label>
                        <input type="text" class="form-control" id="homepage" name="homepage">
                    </div>
                    <h6 class="display-6">Adresse</h6>
                    <div class="mb-3">
                        <label for="street" class="form-label">Straße</label>
                        <input type="text" class="form-control" id="street" name="street" required>
                    </div>
                    <div class="mb-3">
                        <label for="house_number" class="form-label">Hausnummer</label>
                        <input type="text" class="form-control" id="house_number" name="house_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">PLZ</label>
                        <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Stadt</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit-person">Speichern</button>
                </form>
            </div>

            <!-- Rechte Seite -->
            <div class="col-md-6">
                <h1 class="display-4">Gespeicherte Adressen</h1><hr>
                <ul class="list-group">
                    <?php foreach ($persons as $person): ?>
                        <li class="list-group-item">
                        <h5><?php echo htmlspecialchars($person['firstname'] . ' ' . $person['lastname']); ?></h5>
                        <p>Anrede: <?php echo htmlspecialchars($person['salutation']); ?></p>
                            <p>Telefonnummer: <?php echo htmlspecialchars($person['phone_number']); ?></p>
                            <p>Handynummer: <?php echo htmlspecialchars($person['mobile_number']) ?></p>
                            <p>E-Mail: <?php echo htmlspecialchars($person['email']) ?></p>
                            <?php 
                            if(!empty($person['homepage'])){ ?>
                            <p>Homepage: <?php echo htmlspecialchars($person['homepage']); ?></p>
                            <?php
                            }
                            ?>
                            <p>Strasse: <?php echo htmlspecialchars($person['street'] . ' ' . $person['house_number']) ?></p>
                            <p>PLZ: <?php echo htmlspecialchars($person['postal_code']) ?></p>
                            <p>Stadt: <?php echo htmlspecialchars($person['city']) ?></p>


                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>