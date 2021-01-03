<?php

/**
 * Throws an exception if the strlen which is given is smaller than the min or bigger than the max
 * strlen = the strlen that needs to be checked
 * min = min value that the strlen can have
 * max = max value that the strlen can have
 * errorMessage = the error message that will be printed to the user if the conditions are broken
 */
function checkMinMax(int $strlen, int $min = 1, int $max = 200, $errorMessage = "Parameter not correctly entered.") {
    if ($strlen < $min)
        throw new Exception($errorMessage);
    if ($strlen > $max)
        throw new Exception($errorMessage);
}

/**
 * Throws an exception if an email is not formatted correctly
 * email = email to be checked
 */
function checkEmail(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        throw new Exception("Your email was not formatted correctly.");
}

/**
 *  Throws an exception if a phone number is not formatted correctly (only numbers)
 *  phone = the phone number that has to be checked
 */
function checkPhone(string $phone) {
    if (!preg_match("/[0-9]/",$phone)) 
        throw new Exception("Your phone number does not only contain numbers.");
}




?>