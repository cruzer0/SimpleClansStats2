<?php
function addcolors($string) {
    $colors = Array(
        "g" => "<span class=\"c0-font\">",
        "1" => "<span class=\"c1-font\">",
        "2" => "<span class=\"c2-font\">",
        "3" => "<span class=\"c3-font\">",
        "4" => "<span class=\"c4-font\">",
        "5" => "<span class=\"c5-font\">",
        "6" => "<span class=\"c6-font\">",
        "7" => "<span class=\"c7-font\">",
        "8" => "<span class=\"c8-font\">",
        "9" => "<span class=\"c9-font\">",
        "a" => "<span class=\"ca-font\">",
        "b" => "<span class=\"cb-font\">",
        "c" => "<span class=\"cc-font\">",
        "d" => "<span class=\"cd-font\">",
        "e" => "<span class=\"ce-font\">",
        "f" => "<span class=\"cf-font\">",
        "l" => "<span class=\"cl-font\">",
        "m" => "<span class=\"cm-font\">",
        "n" => "<span class=\"cn-font\">",
        "o" => "<span class=\"co-font\">",
        "k" => "<span class=\"ck-font\">"
    );
    
    $string = str_replace("§0", "§g", $string);
    $motdarr = explode("§", $string);
    $spans = 0;
    $colored = "";

    foreach ($motdarr as $row) {
        if (!isset($isset)) {
            $isset = "isset";
            $colored .= $row;
        } elseif (empty($row)) {
            
        } elseif (strtolower(substr($row, 0, 1)) == "r") {
            while ($spans > 0) {
                $colored .= "</span>";
                $spans--;
            }
        } else {
            $colorcode = strtolower(substr($row, 0, 1));
            if (preg_match("/^[0-9a-g]$/i", $colorcode)) {
                while ($spans > 0) {
                    $colored .= "</span>";
                    $spans--;
                }
            }
            $colored .= $colors[$colorcode];
            $colored .= substr($row, 1);
            $spans++;
        }
    }
    while ($spans > 0) {
        $colored .= "</span>";
        $spans--;
    }
    return $colored;
}
?>
