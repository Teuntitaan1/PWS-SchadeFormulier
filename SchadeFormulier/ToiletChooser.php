<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadeformulier toilet-Toilet selecteren</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <?php require  dirname(__DIR__, 1). '/Shared.php'; // ToiletID list ?>
    <h1>Schadeformulier ...</h1>
    <h3>Kies je toilet:</h3>

    <ul>
    <?php
        foreach($ToiletList as $ID => $ToiletID)
        { echo "<li><a href='./index.php?ToiletID=$ID&Done=False'>$ToiletID</a></li>"; }
        ?>
    </ul>

</body>

</html>