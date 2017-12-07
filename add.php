<?php
/**
 * Created by PhpStorm.
 * User: Hider
 * Date: 2017/12/6
 * Time: 22:34
 */

require ("./lib/init.php");
if (empty($_POST))
{
include (ROOT."/view/add.html");
}else{
$employee['empNo'] = trim($_POST['empNo']);
$employee['empName'] = trim($_POST['empName']);
$employee['empAge'] = trim($_POST['empAge']);
$employee['depName'] = trim($_POST['depName']);
$employee['empsex'] = trim($_POST['empsex']);
$employee['empAddress'] = trim($_POST['empAddress']);
$employee['empPhone'] = trim($_POST['empPhone']);
$employee['engpro'] = trim($_POST['engpro']);
$employee['marsta'] = trim($_POST['marsta']);
$employee['working'] = trim($_POST['working']);

mExec('employee',$employee);
}
