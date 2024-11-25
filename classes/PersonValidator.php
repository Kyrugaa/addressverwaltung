<?php

class PersonValidator {
    public static function validate($data) {
        $errors = [];

        // Validate person fields
        if (empty($data['salutation']) || empty($data['firstname']) || empty($data['lastname']) || empty($data['email']) || empty($data['mobile_number']) || empty($data['phone_number'])) {
            $errors['emptyfields'] = 'Bitte alle Felder ausfüllen.';
        }
        if (!preg_match("/^[a-zA-Z]*$/", $data['firstname']) || !preg_match("/^[a-zA-Z]*$/", $data['lastname'])) {
            $errors['invalidname'] = 'Ungültiger Name.';
        }
        if (preg_match('/(.)\\1{3,}/', $data['firstname'])) {
            $errors['invalidFirstName'] = 'Ungültiger Vorname.';
        }
        if (preg_match('/(.)\\1{3,}/', $data['lastname'])) {
            $errors['invalidLastName'] = 'Ungültiger Nachname.';
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['invalid'] = 'Ungültige E-Mail.';
        }
        if (strlen($data['firstname']) < 2) {
            $errors['firstnameTooShort'] = 'Vorname zu kurz.';
        }
        if (strlen($data['lastname']) < 2) {
            $errors['lastnameTooShort'] = 'Nachname zu kurz.';
        }
        if (!preg_match("/^[0-9]*$/", $data['mobile_number']) || !preg_match("/^[0-9]*$/", $data['phone_number'])) {
            $errors['invalidnumber'] = 'Ungültige Nummer.';
        }

        // Validate address fields
        foreach ($data['addresses']['street'] as $index => $street) {
            if (empty($street) || empty($data['addresses']['house_number'][$index]) || empty($data['addresses']['postal_code'][$index]) || empty($data['addresses']['city'][$index])) {
                $errors['emptyaddressfields'] = 'Bitte alle Adressfelder ausfüllen.';
            }
            if (!preg_match("/^[0-9]*$/", $data['addresses']['postal_code'][$index])) {
                $errors['invalidpostalcode'] = 'Ungültige Postleitzahl.';
            }
            if (!preg_match("/^[a-zA-ZäöüÄÖÜß\s]*$/", $data['addresses']['city'][$index])) {
                $errors['invalidcity'] = 'Ungültige Stadt.';
            }
        }

        return $errors;
    }
}