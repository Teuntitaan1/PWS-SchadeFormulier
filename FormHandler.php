<?php
if (isset($_POST['Send'])) {

    // TODO algehele backend, stuurt de gebruiker nu gewoon terug naar de beginpagina
    $ToiletID = $_POST["ToiletID"];
    header("location: index.php?ToiletID=$ToiletID&Done=True");
}
else {
    header("location: index.php");
}
exit();