<?php

require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/myclasses/classes.php';

use repository\DbRepository;
use service\AuthService;
use service\MainService;
use service\registrationService;

$registrationService = new RegistrationService();
$authService = new AuthService();
$mainService = new MainService();
$dbRespository = new DbRepository();
?>