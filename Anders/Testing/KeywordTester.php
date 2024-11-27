<?php
$Keywords = "Appel, Piemel";
// Keywords om op te filteren, als er keywords zijn, voeg ze toe, anders niet
$Keywords = explode(",", $Keywords);

$KeywordPart = "" . implode("`Beschrijving` LIKE '%".$Keywords[$x]."%'", $Keywords) . "";
if($Keywords[0] != "") {
    $KeywordPart = "";
    for ($x = 0; $x < count($Keywords); $x++) {
        $KeywordPart.= " `Beschrijving` LIKE '%".$Keywords[$x]."%'";
        if (isset($Keywords[$x + 1])) {
            $KeywordPart .= " OR";
        }
    }
}
echo $KeywordPart;
