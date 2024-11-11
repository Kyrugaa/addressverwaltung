<?php
class PersonValidator {
    public static function validate($data) {
        $errors = [];

        if (empty($data['salutation']) || empty($data['firstname']) || empty($data['lastname']) || empty($data['email']) || empty($data['mobile_number']) || empty($data['phone_number']) || empty($data['street']) || empty($data['house_number']) || empty($data['postal_code']) || empty($data['city'])) {
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
        if (!preg_match("/^[0-9]*$/", $data['postal_code'])) {
            $errors['invalidpostalcode'] = 'Ungültige Postleitzahl.';
        }
        if (!preg_match("/^[a-zA-Z]*$/", $data['city'])) {
            $errors['invalidcity'] = 'Ungültige Stadt.';
        }

        return $errors;
    }
}