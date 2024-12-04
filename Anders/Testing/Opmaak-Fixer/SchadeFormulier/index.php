<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Schadeformulier toilet</title>
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js"></script>
</head>

<body>
<?php
require  dirname(__DIR__, 1).'/Shared.php';
if (!(ValidToiletID($_GET["ToiletID"]))) { header("location: ToiletChooser.php"); exit(); }
?>
<div id="Header">
    <h1 id="Title">@Schadeformulier GHL</h1>
    <h2 id="Toilet"><?php echo $ToiletList[$_GET["ToiletID"]]; ?></h2>
</div>
<?php if($_GET["Done"] != "True") {echo "<p id='OtherPageLink'>Niet het goede toilet? Pas het toilet <a href='ToiletChooser.php'>hier</a> aan.</p>";} ?>

<!--Evidence form-->
<form action="./DBHandler.php" method="post" enctype="multipart/form-data" style="display:  <?php if ($_GET["Done"] == "True") {echo "none";} else {echo "block";} ?>">

    <div id="HiddenDiv">
        <input type="hidden" name="ToiletID" value=<?php echo $_GET["ToiletID"]; ?>>
        <input type="hidden" name="Source" value="Formulier">
        <input type="hidden" name="Validity" value="Eerlijk">
        <input type="file" name="Evidence" id="EvidenceInput" accept="image/*" onchange="CheckFileUpload()" style="display: none;">
    </div>

    <br>

    <div id="FileInputDiv">
        <label for="EvidenceInput" onclick="() => {OpenFileInput();}"><img id="EvidenceButton" src="./Files/CamIcon.svg" alt=""/></label>
        <img id="EvidenceCheckmark" src="./Files/Checkmark.svg" alt="" style="opacity: 0;"/>
    </div>


    <div id="DescriptionDiv">
        <label for="Description">Incidentomschrijving:</label>
        <br>
        <textarea id="Description" name="Description" placeholder="Wat is er precies gebeurd?" cols="100" rows="15">Ik heb in het <?php echo $ToiletList[$_GET["ToiletID"]]; ?> gezien dat..</textarea>
    </div>

    <div id="SubmitDiv"><input type="submit" name="Send" value="Verstuur" id="SubmitButton" style="display:  <?php if ($_GET["Done"] == "True") {echo "none";} else {echo "block";} ?>"></div>
</form>

<?php if ($_GET["Done"] == "True") {echo "<div id='ThanksMessageDiv'><p id='ThanksMessage'>Bedankt voor het invullen :) We gaan meteen aan de bak! Nog een schadeformulier invullen? Klik <a href='./index.php?ToiletID=".$_GET["ToiletID"]."&Done=False'>hier</a>.</p></div>";} ?>

<div id="Footer">Teun Weijdener & Nathan Esman</div>
</body>
</html>
