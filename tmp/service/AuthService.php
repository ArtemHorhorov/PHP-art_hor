<?php

namespace service;

use myclasses\HttpResponse;

require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/configs/config.php';

session_start();

class AuthService extends HttpResponse
{
    public function logout()
    {
        session_destroy();
        return $this->createHttpResponse(200,null,null);
    }

    public function login($email, $password)
    {
        global $dbRespository;
        $result = $dbRespository->getUser($email, $password);
        if ($result)
        {
            $_SESSION['logged'] = true;
            $_SESSION['id'] = $result['id'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['name'] = $result['name'];
            return $this->createHttpResponse(200,null, Array($result['name'], $result['email']));
        }
        else
        {
            return $this->createHttpResponse(500,'cant auth',null);
        }
    }
}