<?php
/**
 * Created by PhpStorm.
 * User: Hider
 * Date: 2017/12/6
 * Time: 22:34
 */

require ("./lib/init.php");
$post = $_POST;
print_r($post);
include (ROOT."/view/add.html");