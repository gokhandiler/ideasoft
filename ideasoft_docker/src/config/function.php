<?php 
function json_char($data)
{
    $bugchar = array("\u00fc","\u011f","\u0131","\u015f","\u00e7","\u00f6","\u00dc","\u011e","\u0130","\u015e","\u00c7","\u00d6");
    $trchar = array("ü","ğ","ı","ş","ç","ö","Ü","Ğ","İ","Ş","Ç","Ö");
    $fixchar = str_replace($bugchar, $trchar, json_encode($data));
    return $fixchar;
}
?>