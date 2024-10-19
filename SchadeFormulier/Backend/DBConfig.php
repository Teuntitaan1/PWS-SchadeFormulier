<?php

// kut server is localhost, alleen testbaar op school ::()()_I+)IJ+)nrfgp-[iwerbng-[ipwerbntgpijkwqr4tneg
$ServerName = "localhost";
$Username = "39506";
$Password = "Bte0k";
$DatabaseName = "db_39506";

$connection = new mysqli($ServerName, $Username, $Password, $DatabaseName);

if ($connection->connect_error) {

    die("Connection Failed" . $connection->connect_error);
}
echo "Test";

