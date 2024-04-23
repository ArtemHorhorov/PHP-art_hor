<?php
namespace service;

require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/configs/config.php';

session_start();

use myclasses\HttpResponse;

class RegistrationService extends HttpResponse
{
    public function startRegistration($username, $email, $password)
    {
        global $dbRespository;
        if ($username == null || $email == null || $password == null) {
            return $this->createHttpResponse(500, "no data to reg", null);
        }
        $result = $dbRespository->addUser($username, $email, $password);
        if ($result) {
            $_SESSION['logged'] = true;
            $_SESSION['id'] = $result;
            $_SESSION['name'] = $username;
            $_SESSION['email'] = $email;
            return $this->createHttpResponse(200, null, $result);
        } else {
            return $this->createHttpResponse(500, "failed to reg", null);
        }
    }
}