
<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>Schadeformulier toilet</title>
    </head>

    <body>


        <!--Evidence form-->
        <form action="./FileUpload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="Evidence" accept="image/*">

            <input type="submit" name="Send" value="Verstuur">
        </form>

        <?php
        require dirname(__DIR__, 2)."/Shared.php";
        ini_set('display_errors', 1); // kan weggecomment worden
            if(isset($_POST["Send"])){

                $FileDir = dirname(__DIR__, 2)."/Files/";

                $FileType = pathinfo($_FILES["Evidence"]["name"],PATHINFO_EXTENSION);

                $EvidenceName = GenerateUUID().$FileType;

                move_uploaded_file($_FILES["Evidence"]["tmp_name"], $FileDir.$EvidenceName);
            }
        ?>

    </body>

</html>
