<?php

/**
 * Sample Code
 */

define('LINK', './');
require LINK . "OpenWeb/OpenWeb.class.php";
$ow = OpenWeb::Invoke();
$assignments = array(
    "hello"     =>      "This is how it works.",
    "subtext"   =>      "Well, the basic stuff anyway."
);
echo $ow->start("hello", $assignments);