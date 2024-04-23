<?php

require_once '../configs/config.php';

$username = $_POST["username"];
$email = $_POST["email"];
$password = md5($_POST["password"]);

function startRegistration($username, $email, $password)
{
    global $registrationService;
    return $registrationService->startRegistration($username, $email, $password);
}

echo startRegistration($username, $email, $password);

?>