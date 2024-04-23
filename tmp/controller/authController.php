<?php
require_once '../configs/config.php';

$email = $_POST['email'];
$password = $_POST['password'];

if ($_POST['func'] == 'logout')
{
    echo logout();
}

if ($_POST['func'] == 'login')
{
    echo login($email, md5($password));
}

function logout()
{
    global $authService;
    return $authService->logout();
}

function login($email, $password)
{
    global $authService;
    return $authService->login($email, $password);
}



