<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadeformulier toilet-Toilet selecteren</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <?php include "../Shared_Vars.php" ?>
    <h1>Schadeformulier ...</h1>
    <h3>Kies je toilet:</h3>

    <ul>
    <?php
        if (isset($ToiletList)) {
            foreach($ToiletList as $ID => $ToiletID)
            { echo "<li><a href='index.php?ToiletID=$ID&Done=False'>$ToiletID</a></li>"; }
        }
        ?>
    </ul>

</body>

</html>