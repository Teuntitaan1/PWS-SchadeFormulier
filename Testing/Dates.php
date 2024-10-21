<?php
$CurrentDate = new DateTime();
echo $CurrentDate->format("m/d/y H:i:s");
echo "<br>";
// Enum is: Y, M, W, D, H
$CurrentDate->sub(new DateInterval("PT1H"));
echo $CurrentDate->format("m/d/y H:i:s");