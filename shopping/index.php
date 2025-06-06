<?php 
session_start();

// echo password_hash("123456789", PASSWORD_DEFAULT);
require_once "mvc/server.php";
$app = new App();