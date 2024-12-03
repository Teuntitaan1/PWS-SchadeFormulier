<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadeformulier toilet-Toilet selecteren</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
<?php require  dirname(__DIR__, 1). '/Shared.php'; // ToiletID list ?>
<div id="Header">
    <h1 id="Title">@Schadeformulier ...</h1>
    <h3 id="Subtext">Kies je toilet:</h3>
</div>

<ul id="ToiletList">
    <?php
    foreach($ToiletList as $ID => $ToiletID)
    { echo "<li class='ToiletIDEntry'><a href='./index.php?ToiletID=$ID&Done=False'>Het $ToiletID.</a></li>"; }
    ?>
</ul>

<div id="Footer">Teun Weijdener & Nathan Esman</div>

</body>

</html>