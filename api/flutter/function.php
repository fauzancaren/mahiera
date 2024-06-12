<?php

function EncryptedPassword($pass)
{
    $str1 = " ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890?!@#$%^&*()_+|;:,'.-`~";
    $str2 = "?!@#$%^&*()_+|;:,'.-`~1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ";
    $DecryptedText = "";
    for ($x = 1; $x <= strlen($pass); $x++) {

        $ori = substr($pass, $x - 1, 1);
        $lngPos  = strpos($str1, $ori);
        $DecryptedChr = substr($str2, $lngPos, 1);

        //echo substr($pass, $x, 1)."<br>";
        if ($lngPos > 0) {
            $DecryptedText = $DecryptedText . $DecryptedChr;
        } else {
            $DecryptedText = substr($pass, $x, 1);
        }
    }
    return $DecryptedText;
}
function DecryptedPassword($pass)
{
    $str2 = " ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890?!@#$%^&*()_+|;:,'.-`~";
    $str1 = "?!@#$%^&*()_+|;:,'.-`~1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ";
    $DecryptedText = "";
    for ($x = 1; $x <= strlen($pass); $x++) {

        $ori = substr($pass, $x - 1, 1);
        $lngPos  = strpos($str1, $ori);
        $DecryptedChr = substr($str2, $lngPos, 1);

        //echo substr($pass, $x, 1)."<br>";
        if ($lngPos > 0) {
            $DecryptedText = $DecryptedText . $DecryptedChr;
        } else {
            $DecryptedText = substr($pass, $x, 1);
        }
    }
    return $DecryptedText;
}
