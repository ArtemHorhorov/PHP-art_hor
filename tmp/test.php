<?php
require_once 'configs/config.php';

global $dbRespository;

var_dump($dbRespository->userExists('t@t.ru'));