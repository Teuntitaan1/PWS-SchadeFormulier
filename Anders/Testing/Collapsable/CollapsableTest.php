<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadesysteem-Overzicht</title>
    <script src="script.js"></script>
</head>
<body>

<div id="Results">
    <?php
        echo "<div class='Entry'>";
            echo "<button onclick='SwitchState(0)'>Test</button>";
            echo "<div id='Entry0' class='ExpandedContent'>";
                echo "
                      <p>Datum: </p>
                      <p>Toilet: </p>
                      <p>Bron: </p>
                      <p>Omschrijving: </p>
                      <p>Betrouwbaarheid:</p>
                ";
            echo "</div>";
        echo "</div>";
    ?>
</div>
</body>
</html>
