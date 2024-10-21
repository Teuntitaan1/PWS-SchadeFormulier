<?php
// SQL Connectie
$Connection = new mysqli("localhost", "39506", "Bte0k", "db_39506");
if($Connection->connect_error) { die("Connection Failed" . $Connection->connect_error);}