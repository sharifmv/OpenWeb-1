<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Liam
 * Date: 5/13/13
 * Time: 12:53 PM
 * To change this template use File | Settings | File Templates.
 */

define('LINK', './');
require LINK . "OpenWeb/OpenWeb.class.php";
$ow = OpenWeb::Invoke();
$assignments = array(
    "hello"     =>      "This is how it works.",
    "subtext"   =>      "Well, the basic stuff anyway."
);
echo $ow->start("hello", $assignments);