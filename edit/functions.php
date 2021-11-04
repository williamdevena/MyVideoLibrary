<?php
    function convert_string($str)
    {
        $str = str_replace("'", "\'", $str);
        $str = str_replace('"', '\"', $str);
        return "'" . $str . "'";
    }
?>