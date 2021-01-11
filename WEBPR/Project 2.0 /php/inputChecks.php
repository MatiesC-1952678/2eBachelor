<?php

/**
 * Checks if the strlen which is given is smaller than the min or bigger than the max
 * strlen = the strlen that needs to be checked
 * min = min value that the strlen can have
 * max = max value that the strlen can have
 * errorMessage = the error message that will be printed to the user if the conditions are broken
 */
function checkMinMax(int $strlen, int $min = 1, int $max = 200, $errorMessage = "Parameter not correctly entered.") {
    if ($strlen < $min) {
        header("location: ../error.php?error=".urlencode($errorMessage));
        die();
    } if ($strlen > $max) {
        header("location: ../error.php?error=".urlencode($errorMessage));
        die();
    }
}

/**
 * Checks if an email is not formatted correctly
 * email = email to be checked
 */
function checkEmail(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("location: ../error.php?error=".urlencode("Your email was not formatted correctly. Go back and retry."));
        die();
    }
}

/**
 *  Checks if a phone number is not formatted correctly (only numbers)
 *  phone = the phone number that has to be checked
 */
function checkPhone(string $phone) {
    if (!preg_match("/[0-9]/",$phone)) {
        header("location: ../error.php?error=".urlencode("Your phone number does not only contain numbers. Go back and retry."));
        die();
    }
}

/**
 *  Checks if the date is formatted correctly
 *  date = date to be checked
 *  error = the error message that will be displayed
 */
function dateFormatted($date, $error) {
    if (!preg_match("/^\d{4}\-\d{2}\-\d{2}$/", $date)) {
        header("location: ../error.php?error=".urlencode($error));
        die();
    }
}

/**
 *  Checks if the time is formatted correctly
 *  time = time to be checked
 *  error = the error message that will be displayed
 */
function timeFormatted($time, $error) {
    if (!preg_match("/^([0-1]?\d|2[0-3])(?::([0-5]?\d))?(?::([0-5]?\d))?$/", $time)) {
        header("location: ../error.php?error=".urlencode($error));
        die();
    }
}

/**
 *  Checks if the first date is larger than the second
 * first = first date
 * second = second date
 * error = the error message that will be displayed
 */
function biggerThenTimeDate($first, $second, $error) {
    if(strtotime($first) > strtotime($second)){
        header("location: ../error.php?error=".urlencode($error));
        die();
    }
}

/**
 * Checks if the var entered is set 
 * var = the var to be checked
 * error = the error message that will be displayed
 */
function issetCorrect($var, $error) {
    if(!isset($var)){
        header("location: ../error.php?error=".urlencode($error));
        die();
    }
}

?>