<?php
// SQL Connectie
$GLOBALS["Connection"] = new mysqli("localhost", "39506", "Bte0k", "db_39506");
if($GLOBALS["Connection"]->connect_error) { die("Connection Failed" . $GLOBALS["Connection"]->connect_error);}