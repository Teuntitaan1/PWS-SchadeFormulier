<?php
if (isset($_POST['Send'])) {
    $ToiletID = $_POST["ToiletID"];
    header("location: index.php?ToiletID=$ToiletID&Done=True");
}
else {
    header("location: index.php?ToiletID=0G&Done=False");
}
