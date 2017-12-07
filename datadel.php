<?php
/**
 * Created by PhpStorm.
 * User: Hider
 * Date: 2017/12/7
 * Time: 20:19
 */
$empNo = $_GET['empNo'];
require ("./lib/init.php");

$sql = 'DELETE FROM `employee` WHERE  empNo= '.$empNo;
$rs = mQuery($sql);
header('Location:index.php');


